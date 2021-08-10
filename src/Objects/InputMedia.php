<?php

namespace WeStacks\TeleBot\Objects;

use WeStacks\TeleBot\Exception\TeleBotObjectException;
use WeStacks\TeleBot\Interfaces\TelegramObject;
use WeStacks\TeleBot\Objects\InputMedia\InputMediaAnimation;
use WeStacks\TeleBot\Objects\InputMedia\InputMediaAudio;
use WeStacks\TeleBot\Objects\InputMedia\InputMediaDocument;
use WeStacks\TeleBot\Objects\InputMedia\InputMediaPhoto;
use WeStacks\TeleBot\Objects\InputMedia\InputMediaVideo;

/**
 * This object represents the content of a media message to be sent. It should be one of: InputMediaAnimation, InputMediaDocument, InputMediaAudio, InputMediaPhoto, InputMediaVideo.
 */
abstract class InputMedia extends TelegramObject
{
    private static $types = [
        'photo' => InputMediaPhoto::class,
        'video' => InputMediaVideo::class,
        'animation' => InputMediaAnimation::class,
        'audio' => InputMediaAudio::class,
        'document' => InputMediaDocument::class,
    ];

    public static function create($object)
    {
        $object = (array) $object;
        $type = $object['type'] ?? null;
        $class = static::$types[$type] ?? null;

        if ($class) {
            return new $class($object);
        }

        throw TeleBotObjectException::uncastableType(static::class, gettype($object));
    }
}
