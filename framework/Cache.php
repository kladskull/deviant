<?php
/**
 * Created by PhpStorm.
 * User: mcurry
 * Date: 9/28/17
 * Time: 3:30 PM
 */

class Cache
{
    public static function get($key, $default_value = null)
    {
        $return_value = null;
        $record = DB::queryFullColumns('SELECT `value`, `expires` FROM `cache` WHERE `key`=%s LIMIT 1;', $key);
        if (!empty($record[0])) {
            // only return data if not expired (or no expiry)
            if (time(0) < $record[0]['cache.expires'] || 0 == $record[0]['cache.expires']) {
                $return_value = $record[0]['cache.value'];
            }
        }

        // if we don't have anything, return a default value if we have one
        if (null == $return_value && null !== $default_value) {
            // return a default?
            $return_value = $default_value;
        }

        return $return_value;
    }

    public static function set($key, $value, $expires = 0)
    {
        // never expire
        if ($expires < 31536000 && 0 !== $expires) {
            // if less than 1 year, add it to time(0)
            if (is_int($expires)) {
                $expires = time(0) + $expires;
            } else {
                throw new Exception('Expiry is not an integer');
            }
        }

        // update the record
        DB::insertUpdate('cache', [
            'key' => $key,
            'value' => $value,
            'expires' => $expires,
        ]);
    }
}