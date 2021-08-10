<?php

namespace WeStacks\TeleBot\Objects;

use WeStacks\TeleBot\Exception\TeleBotObjectException;
use WeStacks\TeleBot\Interfaces\TelegramObject;
use WeStacks\TeleBot\Objects\BotCommandScope\BotCommandScopeAllChatAdministrators;
use WeStacks\TeleBot\Objects\BotCommandScope\BotCommandScopeAllGroupChats;
use WeStacks\TeleBot\Objects\BotCommandScope\BotCommandScopeAllPrivateChats;
use WeStacks\TeleBot\Objects\BotCommandScope\BotCommandScopeChat;
use WeStacks\TeleBot\Objects\BotCommandScope\BotCommandScopeChatAdministrators;
use WeStacks\TeleBot\Objects\BotCommandScope\BotCommandScopeChatMember;
use WeStacks\TeleBot\Objects\BotCommandScope\BotCommandScopeDefault;

/**
 * This object represents the scope to which bot commands are applied. Currently, the following 7 scopes are supported: BotCommandScopeDefault, BotCommandScopeAllPrivateChats, BotCommandScopeAllGroupChats, BotCommandScopeAllChatAdministrators, BotCommandScopeChat, BotCommandScopeChatAdministrators, BotCommandScopeChatMember
 */
abstract class BotCommandScope extends TelegramObject
{
    private static $types = [
        'default' => BotCommandScopeDefault::class,
        'all_private_chats' => BotCommandScopeAllPrivateChats::class,
        'all_group_chats' => BotCommandScopeAllGroupChats::class,
        'all_chat_administrators' => BotCommandScopeAllChatAdministrators::class,
        'chat' => BotCommandScopeChat::class,
        'chat_administrators' => BotCommandScopeChatAdministrators::class,
        'chat_member' => BotCommandScopeChatMember::class,
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
