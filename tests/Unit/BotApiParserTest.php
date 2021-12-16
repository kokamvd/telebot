<?php

namespace WeStacks\TeleBot\Tests\Unit;

use PHPUnit\Framework\TestCase;
use WeStacks\TeleBot\BotApiParser;

class BotApiParserTest extends TestCase
{
    public function testCanParseDocs()
    {
        $docs = new BotApiParser;
        $docs->generate();
    }
}
