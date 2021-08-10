<?php

namespace WeStacks\TeleBot\Objects;

use WeStacks\TeleBot\Interfaces\TelegramObject;

/**
 * This object represents a service message about a voice chat scheduled in the chat.
 */
class VoiceChatScheduled extends TelegramObject
{
    protected $relations = [
        'start_date' => 'integer'
    ];
}
