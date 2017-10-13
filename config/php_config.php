<?php
/**
 * Created by PhpStorm.
 * User: mcurry
 * Date: 9/29/17
 * Time: 3:22 PM
 */

// Character set
ini_set('default_charset', 'UTF-8');

// Date & Time
date_default_timezone_set('UTC');

// session settings
ini_set('session.gc_maxlifetime', '3600'); // Keep for 1 day
ini_set('session.name', 'ID'); // removing 'PHP' from cookie name
ini_set('session.use_only_cookies', '1');
ini_set('session.use_cookies', '1');
ini_set('session.cookie_httponly', '1');
ini_set('session.cookie_secure', '1');
