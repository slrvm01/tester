<?php

namespace system\components;

/**
 * Class Utils
 * Useful functions
 * @package system\components
 */
class Utils
{
    public static function upperCamelCase($string)
    {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));
    }

    public static function lowerCamelCase($string)
    {
        return lcfirst(self::upperCamelCase($string));
    }

    public static function array_keys_exists(array $keys, array $arr) {
        return !array_diff_key(array_flip($keys), $arr);
    }
}