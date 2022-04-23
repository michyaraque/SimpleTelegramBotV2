<?php

namespace Telegram\Traits;

use Telegram\Updates;

trait Hears {

    /**
     * It checks if the user's message contains a certain word or phrase, and if it does, it executes a
     * callback function
     * 
     * @param string|array word The word you want to listen for.
     * @param callable data The callback function that will be executed when the bot hears the word.
     */
    public static function hears(string|array $word, callable $data): void {

        if(is_array($word)) {

            $capitals_data = [
                'lowercase' => 'strtolower',
                'uppercase' => 'strtoupper'
            ];

            $default_values = [
                'text' => 'default',
                'capital' => 'lowercase'
            ];

            $parameters = array_merge($default_values, $word);

            $text = call_user_func_array(
                $capitals_data[$parameters['capital']], 
                [Updates::text()]
            );

            if(str_contains($parameters['text'], $text)) {
                if($data) {
                    exit($data(new self, $parameters['text']));
                }    
            }
            
        }

        if(!is_array($word)) {

            if(preg_match('/\/(?<String_Matched>[^\/]+)\//', $word, $matched)) {
                preg_match("/{$matched['String_Matched']}/", Updates::text(), $matched_text);
                if(!empty($matched_text[1]) && strlen($matched_text[1]) >= 1) {
                    if($data) {
                        exit($data(new self, $matched_text[1]));
                    }  
                }
            }
    
            if(str_contains(Updates::text(), $word)) {
                if($data) {
                    exit($data(new self, $word));
                }            
            }
        }
        
    }
}