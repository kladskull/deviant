<?php declare(strict_types=1); // strict mode
/**
 * Created by PhpStorm.
 * User: mcurry
 * Date: 9/6/17
 * Time: 8:53 PM
 */
// preserve attempts & redirect them to logout...
class LogoutController
{
    public function __construct()
    {

    }

    public function get() {
        // don't allow GET logouts, we want POSTS only
        Http::redirect('/error');
    }

    public function post() {
        Auth::logout();
    }
}
