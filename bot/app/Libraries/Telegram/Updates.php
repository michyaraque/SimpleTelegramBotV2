<?php

namespace Telegram;

use Enums\UpdateType;
use Libraries\Lang;

class Updates extends UpdateType {

    /**
     * @var object|null
     */
    private static ?object $updates = null;
    
    /**
     * @param object $updates
     * 
     * @return void
     */
    public static function set(object $updates): void {
        self::$updates = $updates;
    }

    /**
     * @return object
     */
    public static function get(): object {
        return self::$updates;
    }

    /**
     * @return string|null
     */
    public static function getUpdateType(): ?string {

        if (isset(self::$updates->inline_query)) {
            return self::INLINE_QUERY;
        }

        if (isset(self::$updates->callback_query)) {
            return self::CALLBACK_QUERY;
        }

        if (isset(self::$updates->edited_message)) {
            return self::EDITED_MESSAGE;
        }

        if (isset(self::$updates->message->reply_to_message)) {
            return self::REPLY;
        }
        
        if (isset(self::$updates->message->text)) {
            return self::MESSAGE;
        }

        if (isset(self::$updates->message->photo)) {
            return self::PHOTO;
        }

        if (isset(self::$updates->message->video)) {
            return self::VIDEO;
        }

        if (isset(self::$updates->message->audio)) {
            return self::AUDIO;
        }

        if (isset(self::$updates->message->voice)) {
            return self::VOICE;
        }

        if (isset(self::$updates->message->contact)) {
            return self::CONTACT;
        }

        if (isset(self::$updates->message->location)) {
            return self::LOCATION;
        }


        if (isset(self::$updates->message->animation)) {
            return self::ANIMATION;
        }

        if (isset(self::$updates->message->sticker)) {
            return self::STICKER;
        }

        if (isset(self::$updates->message->document)) {
            return self::DOCUMENT;
        }

        if (isset(self::$updates->channel_post)) {
            return self::CHANNEL_POST;
        }

        return false;
    }

    /**
     * @return string
     */
    public static function isMessageFromBot(): string {

        $type = self::getUpdateType();

        if ($type == self::CALLBACK_QUERY) {
            return @self::$updates->callback_query->from->is_bot;
        }
        if ($type == self::CHANNEL_POST) {
            return @self::$updates->channel_post->from->is_bot;
        }
        if ($type == self::EDITED_MESSAGE) {
            return @self::$updates->edited_message->from->is_bot;
        }
        if ($type == self::MESSAGE) {
            return @self::$updates->message->from->is_bot;
        }

        return '';
    }

    /**
     * @param callable|null $function
     * 
     * @return string
     */
    public static function text(?callable $function = null): ?string {
        
        $type = self::getUpdateType();

        if ($type == self::CHANNEL_POST) {
            
            if(is_callable($function)) {
                return call_user_func($function, self::$updates->channel_post->text);
            }

            return self::$updates->channel_post->text;
        }
        if ($type == self::EDITED_MESSAGE) {

            if(is_callable($function)) {
                return call_user_func($function, self::$updates->edited_message->text);
            }

            return self::$updates->edited_message->text;
        }

        if(is_callable($function)) {
            return call_user_func($function, self::$updates->message->text);
        }

        return self::$updates->message->text ?? null;
    }

    /**
     * @return string
     */
    public static function firstName(): string {

        $type = self::getUpdateType();

        if ($type == self::CALLBACK_QUERY) {
            return @self::$updates->callback_query->from->first_name;
        }
        if ($type == self::CHANNEL_POST) {
            return @self::$updates->channel_post->from->first_name;
        }
        if ($type == self::EDITED_MESSAGE) {
            return @self::$updates->edited_message->from->first_name;
        }

        return @self::$updates->message->from->first_name;
    }

    /**
     * @return string
     */
    public static function lastName(): string {

        $type = self::getUpdateType();

        if ($type == self::CALLBACK_QUERY) {
            return @self::$updates->callback_query->from->last_name;
        }
        if ($type == self::CHANNEL_POST) {
            return @self::$updates->channel_post->from->last_name;
        }
        if ($type == self::EDITED_MESSAGE) {
            return @self::$updates->edited_message->from->last_name;
        }
        if ($type == self::MESSAGE) {
            return @self::$updates->message->from->last_name;
        }

        return '';
    }

    /**
     * @return string
     */
    public static function username(): ?string {

        $type = self::getUpdateType();

        if ($type == self::CALLBACK_QUERY) {
            return @self::$updates->callback_query->from->username;
        }
        if ($type == self::CHANNEL_POST) {
            return @self::$updates->channel_post->from->username;
        }
        if ($type == self::EDITED_MESSAGE) {
            return @self::$updates->edited_message->from->username;
        }

        return @self::$updates->message->from->username ?? null;
    }

    /**
     * @return string
     */
    public static function language(): string {
        
        $type = self::getUpdateType();

        if ($type == self::CALLBACK_QUERY) {
            return self::$updates->callback_query->from->language_code;
        }

        return self::$updates->message->from->language_code;
    }

    /**
     * If the update type is callback query, return the chat id of the message. If the update type is
     * channel post, return the chat id of the channel. If the update type is edited message, return
     * the chat id of the message. If the update type is inline query, return the id of the user. If
     * none of the above, return the chat id of the message.
     * 
     * @return int The chat id of the user who sent the message.
     */
    public static function chatId(): int {
        
        $type = self::getUpdateType();

        if ($type == self::CALLBACK_QUERY) {
            return @self::$updates->callback_query->message->chat->id;
        }
        if ($type == self::CHANNEL_POST) {
            return @self::$updates->channel_post->chat->id;
        }
        if ($type == self::EDITED_MESSAGE) {
            return @self::$updates->edited_message->chat->id;
        }
        if ($type == self::INLINE_QUERY) {
            return @self::$updates->inline_query->from->id;
        }

        return self::$updates->message->chat->id;
    }

    /**
     * If the update type is callback query, return the user id from the callback query. If the update
     * type is channel post, return the user id from the channel post. If the update type is edited
     * message, return the user id from the edited message. If none of the above, return the user id
     * from the message
     * 
     * @return ?int The user id of the user who sent the message.
     */
    public static function userId(): ?int {

        $type = self::getUpdateType();
        if ($type == self::CALLBACK_QUERY) {
            return self::$updates->callback_query->from->id;
        }
        if ($type == self::CHANNEL_POST) {
            return self::$updates->channel_post->from->id;
        }
        if ($type == self::EDITED_MESSAGE) {
            return @self::$updates->edited_message->from->id;
        }

        return self::$updates->message->from->id ?? null;
    }

    /**
     * If the update type is callback query, return the message id of the callback query. If the update
     * type is channel post, return the message id of the channel post. If the update type is edited
     * message, return the message id of the edited message. If none of the above, return the message
     * id of the message.
     * 
     * @return ?int The message id of the message that was sent.
     */
    public static function messageId(): ?int {

        $type = self::getUpdateType();
        
        if ($type == self::CALLBACK_QUERY) {
            return @self::$updates->callback_query->message->message_id;
        }
        if ($type == self::CHANNEL_POST) {
            return @self::$updates->channel_post->message_id;
        }
        if ($type == self::EDITED_MESSAGE) {
            return @self::$updates->edited_message->message_id;
        }

        return self::$updates->message->message_id;
    }

    /**
     * @return bool
     */
    public static function isMessageFromPrivateChat(): bool {
        if (self::$updates->message->chat->type == 'private') {
            return true;
        }

        return false;
    }

    /**
     * @return int|null
     */
    public static function callbackId(): ?int {
        if(!empty(self::$updates) && property_exists(self::$updates, self::CALLBACK_QUERY)) {
            return self::$updates->callback_query->id;
        }

        return null;
    }

    /**
     * @return string|null
     */
    public static function callbackData(): ?string {
        if(!empty(self::$updates) && property_exists(self::$updates, self::CALLBACK_QUERY)) {
            return self::$updates->callback_query->data;
        }

        return null;
    }

    /**
     * @param int|null $identifier
     * 
     * @return string|null
     */
    public static function photo(?int $identifier = null): ?string {
        if(!empty(self::$updates) && property_exists(self::$updates, self::MESSAGE)) {

            if(!isset($identifier)) {
                $identifier = '';
                return self::$updates->message->photo;
            } else {
                return self::$updates->message->photo[$identifier]->file_id;
            }
        }

        return null;
    }

}