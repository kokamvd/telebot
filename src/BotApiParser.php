<?php

namespace WeStacks\TeleBot;

use DOMDocument;
use DOMElement;
use Soundasleep\Html2Text;

final class BotApiParser
{
    private array $methods = [];
    private array $objects = [];

    private DOMDocument $doc;

    public function __construct()
    {
        $this->doc = new DOMDocument();
        $this->doc->loadHTMLFile("https://core.telegram.org/bots/api");
        $this->load();
    }

    private function load()
    {
        /** @var DOMElement */
        $body = $this->doc->getElementsByTagName('body')[0];
        $headers = $body->getElementsByTagName('h4');

        /** @var DOMElement */
        foreach ($headers as $h4) {

            if ($this->isObject($h4)) {
                $this->addObject($h4);
            }

            else if ($this->isMethod($h4)) {
                $this->addMethod($h4);
            }
        }
    }

    private function isObject(DOMElement $h4)
    {
        return preg_match("/^[A-Z][a-zA-Z]*$/mx", $h4->textContent);
    }

    private function addObject(DOMElement $h4)
    {
        $description = [];
        $attributes = [];
        $element = $h4;

        while (($element = $element?->nextElementSibling) && in_array($element->tagName, ['p', 'ul', 'ol', 'blockquote'])) {
            $description[] = $this->parseHTML($element->ownerDocument->saveHTML($element));
        }

        $description = implode(PHP_EOL.PHP_EOL, $description);

        if ($element->tagName == 'table') {
            $attributes = $this->getTableData($element);
        }

        $this->objects[$h4->textContent] = compact('description', 'attributes');
    }

    public function generate()
    {
        foreach ($this->methods as $name => $options) {
            $params = collect($options['parameters'])->map(function ($data) {
                return "        '{$data[0]}' => '{$data[1]}'";
            })->toArray();

            $data = file_get_contents(__DIR__.'/../stubs/Method.stub');
            $data = str_replace("{{ class }}", $options['name'], $data);
            $data = str_replace("{{ method }}", $name, $data);
            $data = str_replace("{{ parameters }}", implode(','.PHP_EOL, $params), $data);

            echo __DIR__."/New/Methods/".$options['name'].".php".PHP_EOL;

            file_put_contents(
                __DIR__."/New/Methods/".$options['name'].".php",
                $data
            );
        }
    }

    private function isMethod(DOMElement $h4)
    {
        return preg_match("/^[a-z][a-zA-Z]*$/mx", $h4->textContent);
    }

    private function addMethod(DOMElement $h4)
    {
        $description = [];
        $parameters = [];
        $element = $h4;

        while (($element = $element?->nextElementSibling) && in_array($element?->tagName, ['p', 'ul', 'ol', 'blockquote'])) {
            $description[] = $this->parseHTML($element->ownerDocument->saveHTML($element));
        }

        $description = implode(PHP_EOL.PHP_EOL, $description);

        $name = ucfirst($h4->textContent).'Method';


        if ($element->tagName == 'table') {
            $parameters = $this->getTableData($element);
        }

        $this->methods[$h4->textContent] = compact('name', 'description', 'parameters');
    }

    private function parseHTML(string $html)
    {
        return Html2Text::convert($html, [
            'ignore_errors' => true
        ]);
    }

    private function getTableData(DOMElement $table)
    {
        /** @var DOMElement */
        foreach ($table->getElementsByTagName('tbody')[0]->getElementsByTagName('tr') as $node) {
            $data[] = collect($node->getElementsByTagName('td'))
                ->map(function ($node) {
                    $md = $this->parseHTML($node->ownerDocument->saveHTML($node));

                    if (preg_match("/(Array of )?\[([A-Z][a-zA-Z]*)\]\(#[a-z]*\)/m", $md, $matches)) {
                        $md = $matches[1] == 'Array of ' ?
                            ["WeStacks\\TeleBot\\Objects\\{$matches[2]}"] :
                            "WeStacks\\TeleBot\\Objects\\{$matches[1]}";
                    }

                    return $md;
                })
                ->toArray();
        }
        return $data;
    }
}