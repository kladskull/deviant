<?php
/**
 * Created by PhpStorm.
 * User: mcurry
 * Date: 9/4/17
 * Time: 10:57 PM
 */

function is_ssl()
{
    if (isset($_SERVER['HTTPS'])) {
        if ('on' == strtolower($_SERVER['HTTPS']) ||
            '1' == $_SERVER['HTTPS']) {
            return true;
        }
    } else if (isset($_SERVER['SERVER_PORT']) &&
        '443' == $_SERVER['SERVER_PORT']) {
        return true;
    }

    return false;
}