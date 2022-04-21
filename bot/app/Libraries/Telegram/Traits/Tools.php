<?php

namespace Telegram\Traits;

use Enums\UpdateType;
use Telegram\Updates;

trait Tools {

    /**
     * @param int $param_selector
     * 
     * @return array|string
     */
    public static function getTextParams(?int $param_selector = null) {
        $updates = Updates::get();
        if(isset($updates->{UpdateType::MESSAGE}->text)) {
            $parameters = explode(' ', $updates->{UpdateType::MESSAGE}->text);
            if(!empty($parameters[$param_selector])) {
                return $parameters[$param_selector];
            } elseif(!isset($param_selector)) {
                return $parameters;
            }
        }
    }

    /**
     * @param string $command
     * 
     * @return bool
     */
    public static function getCommand(string $command): bool {
        $updates = Updates::get();
        if(isset($updates->{UpdateType::MESSAGE}->text) && 
            isset($updates->{UpdateType::MESSAGE}->entities[0]) && 
            $updates->{UpdateType::MESSAGE}->entities[0]->type == 'bot_command' && 
            contains(strtolower($updates->{UpdateType::MESSAGE}->text), $command)
        ) {
            $command_updates = explode(' ', trim(strtolower($updates->{UpdateType::MESSAGE}->text)));
            return ('/' . $command == $command_updates[0] ? true : false);
        }
        
        return false;
    }

    /**
     * @param string|null $value
     * 
     * @return bool
     */
    public function getDeepLink(?string $value): bool {
        $updates = Updates::get();
        if(isset($updates->{UpdateType::MESSAGE}->text) && 
            contains($updates->{UpdateType::MESSAGE}->text, '/start') && 
            $updates->{UpdateType::MESSAGE}->entities[0]->type == 'bot_command') {

            if(substr($updates->{UpdateType::MESSAGE}->text, 7) === $value) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param object $from_data
     * @param int $code
     * @param callable $content
     * 
     * @return bool
     */
    public function getErrorCode(object $from_data, int $code, callable $content): bool {
        if($from_data->ok == false && !empty($from_data->error_code) && $from_data->error_code === $code) {
            $content();
            return true;
        }
        return false;
    }

    
    /**
     * @param mixed $id
     * 
     * @return int
     */
    public function getMessageId(object $id): int {
        $update = (object) $id;
        $message_id = $update->result->message_id;
        return $message_id;
    }

    /**
     * @param string $string
     * @param mixed $output
     * 
     * @return bool
     */
    public static function matchText(string $string, ?string &$output = ''): bool {
        if(preg_match("/$string/", Updates::text(), $output)) {
            return true;
        }
        return false;
    }

}