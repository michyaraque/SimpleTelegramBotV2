<?php

namespace Telegram\Traits;

trait Help {

    /**
     * It checks if the command exists, and if it does, it runs the callback function.
     * 
     * @param string value The command you want to use.
     * @param callable data The data that is passed to the command.
     */
    public static function help(callable $data) {
        if(self::getCommand('help')) {
            if($data) {
                exit($data(new self, self::getTextParams()));
            }
        }
    }
}