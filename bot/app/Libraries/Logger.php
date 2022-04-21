<?php

namespace Libraries;

class Logger {

    public static $input_update_id = '';

    /**
     * @param string $file_name
     * @param mixed $content
     * 
     * @return void
     */
    public static function setLog(string $file_name, $content): void {

        $file_path = realpath(dirname(__FILE__, 3)) . "/storage/logs";
        $complete_file_path = $file_path . DIRECTORY_SEPARATOR .  $file_name . ".log";

        if(!file_exists($complete_file_path)){
            mkdir(dirname($complete_file_path), 0700, true);
        } 

        $output = json_decode($content, true);

        if(!empty($output['update_id']) && $output['update_id'] !== self::$input_update_id && $file_name == 'input') {
            self::$input_update_id = $output['update_id'];
            file_put_contents($complete_file_path, "\n" . json_encode($output, JSON_PRETTY_PRINT) . "\n", FILE_APPEND);
        } elseif ($file_name == 'output') {
            file_put_contents($complete_file_path, "\n" . json_encode($output, JSON_PRETTY_PRINT) . "\n", FILE_APPEND);
        } else {
            file_put_contents($complete_file_path, "\n" . $content . "\n", FILE_APPEND);
        }
        
    }  
}