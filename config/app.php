<?php
/**
 * Created by PhpStorm.
 * User: mcurry
 * Date: 9/4/17
 * Time: 11:23 PM
 */

use Symfony\Component\Dotenv\Dotenv;

// load environment data
$dot_env = new Dotenv();
$dot_env->load('../.env');

// Character set
ini_set('default_charset', 'UTF-8');

// Date & Time
date_default_timezone_set('UTC');

// session settings
ini_set('session.gc_maxlifetime', 3600); // Keep for 1 day
//ini_set('session.save_handler', 'memcache'); // Use memcache for session data
//ini_set('session.save_path', MemcacheHelper::serverList()); // Memcache server info
ini_set('session.name', 'ID'); // removing 'PHP' from cookie name
ini_set('session.use_only_cookies', 1);
ini_set('session.use_cookies', 1);
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 1);

// smarty
define('SMARTY_TEMPLATE_DIR', '../app/templates/');
define('SMARTY_COMPILE_DIR', '../app/templates/templates_c/');
define('SMARTY_CONFIG_DIR', '../app/templates/config/');
define('SMARTY_CACHE_DIR', '../app/templates/cache/');
