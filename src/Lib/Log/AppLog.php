<?php

namespace App\Lib\Log;
use Cake\Log\Log;

/**
 * Log for application
 * 
 * @package Lib
 * @created 2014-11-24
 * @version 1.0
 * @author thailvn
 * @copyright Oceanize INC
 */
class AppLog extends Log {

    /**
     * Write log info
     *     
     * @param string $message Message to write to log     
     * @param string $method Method     
     * @param object $data Data to write to log     
     * @param $scope See more class CakeLog     
     * @return void   
     */
    public static function info($message = '', $method = '', $data = array(), $scope = array()) {
        $message = static::message($message, $method, $data);
        parent::info($message, $scope);
    }

    /**
     * Write log warning
     *     
     * @param string $message Message to write to log     
     * @param string $method Method     
     * @param object $data Data to write to log     
     * @param $scope See more class CakeLog     
     * @return void   
     */
    public static function warning($message = '', $method = '', $data = array(), $scope = array()) {
        $message = static::message($message, $method, $data);
        parent::warning($message, $scope);
    }

    /**
     * Write log error
     *     
     * @param string $message Message to write to log     
     * @param string $method Method     
     * @param object $data Data to write to log     
     * @param $scope See more class CakeLog     
     * @return void   
     */
    public static function error($message = '', $method = '', $data = array(), $scope = array()) {
        $message = static::message($message, $method, $data);
        parent::error($message, $scope);
    }

    /**
     * Create log message
     *     
     * @param string $message Message to write to log     
     * @param string $method Method     
     * @param object $data Data to write to log        
     * @return string Log message  
     */
    public static function message($message = '', $method = '', $data = array()) {
        $message = "{$method} : {$message}";
        if (!empty($data)) {
            if (!is_scalar($data)) {
                $data = json_encode($data);
            }
            $message = ' ' . $message . $data;
        }
        return $message;
    }

}
