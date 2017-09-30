<?php
/**
 * Created by PhpStorm.
 * User: mcurry
 * Date: 9/29/17
 * Time: 4:45 PM
 */

class Http
{
    public static function redirect($url)
    {
        header('Status: 302');
        header('Location: ' . $url);
        exit(0);
    }
}