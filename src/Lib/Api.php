<?php

namespace App\Lib;

use Cake\Core\Configure;
use App\Lib\Log\AppLog;
use Cake\Network\Session;
use Cake\Network\Exception\InternalErrorException;
use Cake\Routing\Router;

/**
 * Call API
 * 
 * @package Lib
 * @created 2014-11-24
 * @version 1.0
 * @author thailvn
 * @copyright Oceanize INC
 */
class Api {

    public static $errors = array();

    /**
     * Get api Url
     *       
     * @author thailvn
     * @param string $url     
     * @return string URL    
     */
    public static function getUrl($url) {
        foreach (Configure::read('API.rewriteUrl') as $pattern => $replace) {
            preg_match($pattern, $url, $matches);
            if ($matches) {
                return $replace;
            }
        }
        return $url;
    }

    /**
     * Call API
     *   
     * @author thailvn
     * @param string $url     
     * @param array $requestData Request data     
     * @param boolean $json True if json request or False   
     * @param object $defaultResult if response defaultResult if response empty   
     * @return object API response  
     */
    public static function call($url, $requestData = array(), $json = false, $defaultResult = false) {
        $url = Configure::read('API.Host') . static::getUrl($url);
        try {
            AppLog::info("START API: {$url}", __METHOD__, $requestData);
            $ch = curl_init();
            $headers = array("Content-Type:multipart/form-data");
            if (!isset($requestData['unauthorize'])) {
                $session = Router::getRequest(true)->session();
                $auth = $session->read('Auth');
                if (!empty($auth['User']['token'])) {
                    $headers[] = "User-Id:" . $auth['User']['id'];
                    $headers[] = "Authorization:" . $auth['User']['token'];
                }
            }
            if ($json === true) {
                $headers[] = 'Content-Type:application/json';
                $requestData = json_encode($requestData);
            }
            $posts = array();
            if (!empty($requestData)) {
                foreach ($requestData as $key => $value) {
                    if (is_scalar($value) || $value instanceof \CurlFile) {
                        $posts[$key] = $value;
                    }
                }
            }
            $posts['from_admin'] = 1;
            $posts['api_auth_date'] = strtotime(gmdate("M d Y H:i:s", strtotime(date('Y/m/d H:i:s'))));
            $posts['api_auth_key'] = hash('md5', Configure::read('API.secretKey') . $posts['api_auth_date']);
            $options = array(
                CURLOPT_URL => $url,
                CURLOPT_HEADER => false,
                CURLOPT_POST => true,
                CURLOPT_HTTPHEADER => $headers,
                CURLOPT_POSTFIELDS => $posts,
                CURLOPT_RETURNTRANSFER => true,
//                CURLOPT_SAFE_UPLOAD => false,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_TIMEOUT => Configure::read('API.Timeout'),
                CURLOPT_USERAGENT => env('HTTP_USER_AGENT'),
            );
            curl_setopt_array($ch, $options);
            $jsonResponse = curl_exec($ch);
            $errno = curl_errno($ch);
            if (empty($errno)) {
                curl_close($ch);
                $result = json_decode($jsonResponse, true);
                if ($result['status'] === 500) {
                    AppLog::info("SERVER INFO", __METHOD__, $_SERVER);
                    AppLog::info("END API: {$url}", __METHOD__, $result);
                    if (isset($result['error']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                        static::$errors = static::parseError($result['error']);
                        return $result;
                    }
                    throw new InternalErrorException("API error", $result['status']);
                } else if ($result['status'] === 403) {
                    AppLog::info("END API: {$url}", __METHOD__, $result);
                    throw new ForbiddenException("Forbidden", $result['status']);
                } else if ($result['status'] === 401) {
                    static::$errors = static::parseError($result['error']);
                    if ($defaultResult) {
                        $result = $defaultResult;
                    }
                    return $result;
                } else if ($result['status'] === 400) {
                    static::$errors = static::parseError($result['error']);
                    if ($defaultResult) {
                        $result = $defaultResult;
                    }
                    return $result;
                }
                if ($result['status'] === 401) {
                    header('Location: /logout');
                    die;
                }
                return !empty($result['body']) ? $result['body'] : array();
            }
            $error = curl_error($ch);
            curl_close($ch);
            AppLog::warning($error, __METHOD__);
            throw new InternalErrorException($error, $errno);
        } catch (\Exception $e) {
            AppLog::warning(sprintf("API Exception\n"
                            . " - Message : %s\n"
                            . " - Code : %s\n"
                            . " - File : %s\n"
                            . " - Line : %d\n"
                            . " - Stack trace : \n"
                            . "%s", $e->getMessage(), $e->getCode(), $e->getFile(), $e->getLine(), $e->getTraceAsString()), __METHOD__, $requestData);
            throw new InternalErrorException($e->getMessage());
        }
    }
    
    /**
     * Get api error 
     *         
     * @author thailvn        
     * @return array    
     */
    public static function getError() {
        return static::$errors;
    }

    /**
     * Check API error or not
     * 
     * @return boolean
     */
    public static function hasError() {
        return !empty(static::$errors);
    }

    /**
     * Parse array errors to cms's format
     *    
     * @author thailvn  
     * @param array $apiErrors API error       
     * @return array    
     */
    public static function parseError($apiErrors = array()) {
        if (empty($apiErrors)) {
            return false;
        }
        $result = array();
        foreach ($apiErrors as $error) {
            if (isset($error['field'])) {
                $result[$error['field']] = array(
                    $error['code'] => $error['message']
                );
            }
        }
        return $result;
    }

}
