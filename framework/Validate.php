<?php
/**
 * Created by PhpStorm.
 * User: mcurry
 * Date: 9/29/17
 * Time: 3:28 PM
 */

class Validate
{
    public static function emailAddress(string $emailAddress): bool
    {
        // ensure we have a valid email address
        if (strlen($emailAddress) > 150 ||
            !filter_var($emailAddress, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        return true;
    }
}