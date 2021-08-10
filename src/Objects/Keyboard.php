<?php

namespace WeStacks\TeleBot\Objects;

use WeStacks\TeleBot\Exception\TeleBotObjectException;
use WeStacks\TeleBot\Interfaces\TelegramObject;
use WeStacks\TeleBot\Objects\Keyboard\ForceReply;
use WeStacks\TeleBot\Objects\Keyboard\InlineKeyboardMarkup;
use WeStacks\TeleBot\Objects\Keyboard\ReplyKeyboardMarkup;
use WeStacks\TeleBot\Objects\Keyboard\ReplyKeyboardRemove;

/**
 * This object represents the keyboard / reply markup of the message to be sent. It should be one of: InlineKeyboardMarkup, ReplyKeyboardMarkup, ReplyKeyboardRemove, ForceReply.
 */
abstract class Keyboard extends TelegramObject
{
    private static $types = [
        'inline_keyboard' => InlineKeyboardMarkup::class,
        'keyboard' => ReplyKeyboardMarkup::class,
        'remove_keyboard' => ReplyKeyboardRemove::class,
        'force_reply' => ForceReply::class,
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
