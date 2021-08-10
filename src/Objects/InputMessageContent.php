<?php

namespace WeStacks\TeleBot\Objects;

use WeStacks\TeleBot\Exception\TeleBotObjectException;
use WeStacks\TeleBot\Interfaces\TelegramObject;
use WeStacks\TeleBot\Objects\InputMessageContent\InputContactMessageContent;
use WeStacks\TeleBot\Objects\InputMessageContent\InputLocationMessageContent;
use WeStacks\TeleBot\Objects\InputMessageContent\InputTextMessageContent;
use WeStacks\TeleBot\Objects\InputMessageContent\InputVenueMessageContent;

/**
 * This object represents the content of a message to be sent as a result of an inline query. Telegram clients currently support the following 4 types: InputTextMessageContent, InputLocationMessageContent, InputVenueMessageContent, InputContactMessageContent.
 */
abstract class InputMessageContent extends TelegramObject
{
    private static $types = [
        'message_text' => InputTextMessageContent::class,
        'address' => InputVenueMessageContent::class,
        'latitude' => InputLocationMessageContent::class,
        'phone_number' => InputContactMessageContent::class,
    ];

    public static function create($object)
    {
        $object = (array) $object;

        foreach (static::$types as $type => $class) {
            if (!isset($object[$type])) continue;
            return new $class($object);
        }

        throw TeleBotObjectException::uncastableType(static::class, gettype($object));
    }
}
