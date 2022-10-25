<?php

class Config {

    public static $config = [
    ];

    public static function setAll($config) {
        foreach ($config as $key => $value) {
            self::set($key, $value);
        }
    }

    public static function set($key, $value) {
        self::$config[$key] = $value;
    }

    public static function get($key, $default = null) {
        if (isset(self::$config[$key])) {
            return self::$config[$key];
        } else {
            return $default;
        }
    }
}

Config::setAll($config);
unset($config);