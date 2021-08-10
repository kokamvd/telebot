<?php

namespace WeStacks\TeleBot\Objects\Passport;

use WeStacks\TeleBot\Exception\TeleBotObjectException;
use WeStacks\TeleBot\Interfaces\TelegramObject;
use WeStacks\TeleBot\Objects\Passport\PassportElementError\PassportElementErrorDataField;
use WeStacks\TeleBot\Objects\Passport\PassportElementError\PassportElementErrorFile;
use WeStacks\TeleBot\Objects\Passport\PassportElementError\PassportElementErrorFiles;
use WeStacks\TeleBot\Objects\Passport\PassportElementError\PassportElementErrorFrontSide;
use WeStacks\TeleBot\Objects\Passport\PassportElementError\PassportElementErrorReverseSide;
use WeStacks\TeleBot\Objects\Passport\PassportElementError\PassportElementErrorSelfie;
use WeStacks\TeleBot\Objects\Passport\PassportElementError\PassportElementErrorTranslationFile;
use WeStacks\TeleBot\Objects\Passport\PassportElementError\PassportElementErrorTranslationFiles;
use WeStacks\TeleBot\Objects\Passport\PassportElementError\PassportElementErrorUnspecified;

/**
 * This object represents an error in the Telegram Passport element which was submitted that should be resolved by the user. It should be one of: PassportElementErrorDataField, PassportElementErrorFrontSide, PassportElementErrorReverseSide, PassportElementErrorSelfie, PassportElementErrorFile, PassportElementErrorFiles, PassportElementErrorTranslationFile, PassportElementErrorTranslationFiles, PassportElementErrorUnspecified.
 */
abstract class PassportElementError extends TelegramObject
{
    private static $types = [
        'data' => PassportElementErrorDataField::class,
        'front_side' => PassportElementErrorFrontSide::class,
        'reverse_side' => PassportElementErrorReverseSide::class,
        'selfie' => PassportElementErrorSelfie::class,
        'file' => PassportElementErrorFile::class,
        'files' => PassportElementErrorFiles::class,
        'translation_file' => PassportElementErrorTranslationFile::class,
        'translation_files' => PassportElementErrorTranslationFiles::class,
        'unspecified' => PassportElementErrorUnspecified::class,
    ];

    public static function create($object)
    {
        $object = (array) $object;
        $type = $object['source'] ?? null;
        $class = static::$types[$type] ?? null;

        if ($class) {
            return new $class($object);
        }

        throw TeleBotObjectException::uncastableType(static::class, gettype($object));
    }
}
