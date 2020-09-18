<?php

namespace WeStacks\TeleBot\Methods\Stickers;

use WeStacks\TeleBot\Helpers\TypeCaster;
use WeStacks\TeleBot\Interfaces\TelegramMethod;

class DeleteStickerFromSetMethod extends TelegramMethod
{
    protected function request()
    {
        return [
            'type'      => 'POST',
            'url'       => "https://api.telegram.org/bot{$this->token}/deleteStickerFromSet",
            'send'      => $this->send(),
            'expect'    => 'boolean'
        ];
    }

    private function send()
    {
        $parameters = [
            'sticker'                   => 'string'
        ];

        $object = TypeCaster::castValues($this->arguments[0] ?? [], $parameters);
        return [ 'json' => TypeCaster::stripArrays($object) ];
    }
}