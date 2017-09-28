<?php

define('PAGE_START_TIME', round(microtime(true) * 1000));

include '../bootstrap.php';

//Initialise CSRFGuard library
csrfProtector::init();

// get page request to see what include file we need
$page = '';
if (current_user_exists() == false) {
    logout();
}

$page_request = [];
if (isset($_SERVER['REDIRECT_URL'])) {
    $page_request = explode('/', $_SERVER['REDIRECT_URL']);
}

// hide php
if (isset($_SERVER['REQUEST_URI'])) {
    if (false !== strpos(strtolower($_SERVER['REQUEST_URI']), '.php')) {
        redirect_404();
    }
} else if (isset($_SERVER['REDIRECT_URL'])) {
    if (false !== strpos(strtolower($_SERVER['REDIRECT_URL']), '.php')) {
        redirect_404();
    }
}

// get requested page, sanitize input
$page = 'index';
if (count($page_request) > 1 && !empty($page)) {
    $page = filter_url(strtolower(trim($page_request[1])));
}

/* add random data to response
$tag = "Addl:" . Utils::UniqueId();
$data = Utils::APIUniqueId();
header($tag . $data . Utils::generateRandomString());
*/

// Smarty & configuration
$smarty = new Smarty();
$smarty->template_dir = SMARTY_TEMPLATE_DIR;
$smarty->compile_dir = SMARTY_COMPILE_DIR;
$smarty->config_dir = SMARTY_CONFIG_DIR;
$smarty->cache_dir = SMARTY_CACHE_DIR;

// start the session
//session_start();

// redirect them to home
if (is_logged_in()) {
    $smarty->assign('loggedIn', true);
} else {
    $smarty->assign('loggedIn', false);
}

// redirect them to home
if (is_admin()) {
    $smarty->assign('admin', true);
} else {
    $smarty->assign('admin', false);
}

// does file exist? If so, include it
if (file_exists('../app/scripts/' . $page . '.php')) {
    include('../app/scripts/' . $page . '.php');
} else {
    redirect_404();
}

define('PAGE_END_TIME', round(microtime(true) * 1000));

$d = PAGE_END_TIME - PAGE_START_TIME;

echo '<!-- TTL: ', $d, ' -->';

// out..
exit(0);