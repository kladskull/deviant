<?php
/**
 * Created by PhpStorm.
 * User: mcurry
 * Date: 9/7/17
 * Time: 11:52 AM
 *
 * Todo: This all needs a home, preferably in appropriate classes.
 */

function is_logged_in()
{
    if (isset($_SESSION['logged_in'])) {
        return true;
    }

    return false;
}

function is_admin()
{
    if (is_logged_in()) {
        if (isset($_SESSION['user_record'])) {
            if (isset($_SESSION['user_record']['admin'])) {
                if ($_SESSION['user_record']['admin'] == true) {
                    return true;
                }
            }
        }

    }
    return false;
}

function email_exists($email)
{
    // get the user record
    $record = DB::queryFirstRow('SELECT * FROM ' . TB_USER . ' WHERE email_address=%s LIMIT 1;', $email);
    if ($record !== null) {
        return true;
    }

    return false;
}

function current_user_exists()
{
    if (isset($_SESSION['user_record'])) {
        // get the user record
        $record = DB::queryFirstRow('SELECT * FROM ' . TB_USER . ' WHERE id=%i LIMIT 1;', $_SESSION['user_record']['id']);
        if ($record !== null) {
            if ($record['locked'] == 1) {
                return false;
            }
            return true;
        }
    }
    return false;
}

function logout()
{
    if (is_logged_in()) {
        // kill it all
        session_destroy();

        // unset cookies
        if (isset($_SERVER['HTTP_COOKIE'])) {
            $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
            foreach ($cookies as $cookie) {
                $parts = explode('=', $cookie);
                $name = trim($parts[0]);
                setcookie($name, '', time() - 3600);
                setcookie($name, '', time() - 3600, '/');
            }
        }

        // send to home page
        redirect('/');
    }
}

/*
//xss mitigation functions
function xss_safe($data, $encoding = 'UTF-8')
{
    return htmlspecialchars($data, ENT_QUOTES | ENT_HTML401, $encoding);
}

function x_echo($text)
{
    echo xss_safe($text);
}
*/