<?php
/**
 * Created by PhpStorm.
 * User: xiehuanjin
 * Date: 2019/1/12
 * Time: 17:13
 */

namespace Twinkle\Log;


class Request
{
    private static $instance = null;

    private function __construct()
    {
    }

    public static function singleton()
    {
        if (self::$instance == null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getRequestId()
    {
        static $requestId = '';

        if (!empty($requestId)) {
            return $requestId;
        }

        if (!empty($_SERVER['HTTP_REQUEST_ID'])) {
            return $_SERVER['HTTP_REQUEST_ID'];
        } elseif (function_exists('session_create_id')) {
            $hash = session_create_id();
        } else {
            $data = uniqid('', true);
            $data .= isset($_SERVER['REQUEST_TIME']) ? $_SERVER['REQUEST_TIME'] : '';
            $data .= isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
            $data .= isset($_SERVER['LOCAL_ADDR']) ? $_SERVER['LOCAL_ADDR'] : '';
            $data .= isset($_SERVER['LOCAL_PORT']) ? $_SERVER['LOCAL_PORT'] : '';
            $data .= isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
            $data .= isset($_SERVER['REMOTE_PORT']) ? $_SERVER['REMOTE_PORT'] : '';
            $hash = hash('ripemd128', md5($data));
        }

        $hash = strtoupper($hash);

        return $requestId = substr($hash, 0, 8) . '-' . substr($hash, 8, 4) . '-' . substr($hash, 12, 4) . '-' . substr($hash, 16, 4) . '-' . substr($hash, 20, 12);
    }

}