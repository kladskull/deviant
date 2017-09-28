<?php
/**
 * Created by PhpStorm.
 * User: mcurry
 * Date: 9/4/17
 * Time: 11:25 PM
 */

function ssl_headers()
{
    // security headers
    header('Strict-Transport-Security: max-age=16070400; includeSubDomains');
    header('X-Frame-Options: DENY');
    header('Frame-Options: DENY');
    header('X-XSS-Protection: 1; mode=block');
    header('X-Content-Type-Options: nosniff');
}
