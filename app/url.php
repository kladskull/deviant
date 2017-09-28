<?php
/**
 * Created by PhpStorm.
 * User: mcurry
 * Date: 9/4/17
 * Time: 11:03 PM
 */

// This ensures that there is only alphanumeric text
// in the requested page URL http://site.com/[filter here]
function filter_page_request($text)
{
    // remove characters we do not support
    return preg_replace('/[^A-Za-z0-9 ]/', '', $text);
}

function redirect($url)
{
    header('Status: 302');
    header('Location: ' . $url);
    exit(0);
}

function redirect_404()
{
    header('HTTP/1.0 404 Not Found');
    echo '<h1>404 Not Found</h1>';
    echo '<p>The page that you have requested could not be found.</p>';
    exit(0);
}
