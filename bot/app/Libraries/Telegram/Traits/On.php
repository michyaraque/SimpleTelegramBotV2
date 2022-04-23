<?php

namespace Telegram\Traits;

use Enums\UpdateType;
use Telegram\Updates;


trait On {
    /**
     * It checks if the update type is the same as the one you passed in the first parameter, and if it
     * is, it calls the function you passed in the second parameter.
     * 
     * @param string type The type of update you want to listen for.
     * @param callable data The data that is sent to the server.
     */
    public static function on(string|array $type, callable $data) {
        if(is_array($type) && in_array(Updates::getUpdateType(), $type) || 
            Updates::getUpdateType() == $type
        ) {
            if($data) {
                exit($data(new self));
            }
        }
    }
}