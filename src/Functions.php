<?php

if (!function_exists('logger')) {
    function logger($msg)
    {
        // create a log channel
        $log = new \Monolog\Logger('cnvex');
        $log->pushHandler(new \Monolog\Handler\StreamHandler(__DIR__ . '/logs/debug.log', Logger::DEBUG));
        $log->debug($msg);
    }
}
