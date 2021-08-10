<?php

namespace WeStacks\TeleBot\Objects;

use WeStacks\TeleBot\Interfaces\TelegramObject;

/**
 * This object represents a service message about a voice chat ended in the chat.
 *
 * @property int    $duration       Voice chat duration; in seconds
 */
class VoiceChatEnded extends TelegramObject
{
    protected $relations = [
        'duration' => 'integer',
    ];
}
