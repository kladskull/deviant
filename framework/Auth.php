<?php
/**
 * Created by PhpStorm.
 * User: mcurry
 * Date: 9/29/17
 * Time: 3:42 PM
 */

class Auth
{
    public
    static function isLoggedIn(): bool
    {
        if (!empty($_SESSION['logged_in']) && true === $_SESSION['logged_in']) {
            return true;
        }

        return false;
    }

    public static function login(string $emailAddress, string $password): array
    {
        $result = [
            'success' => false,
            'message' => '',
        ];

        // TODO: MIDDLEWARE - TRIM VARIABLES!!

        // done allow anything out of specifications
        if (strlen($emailAddress) > 150) {
            return $result;
        }

        // done allow anything out of specifications
        if (empty($password) || strlen($password) > 255) {
            return $result;
        }

        // ensure we have a proper email address
        if (!Validate::emailAddress($emailAddress)) {
            return $result;
        }

        // update the attempts for this account
        $attempts = Cache::get('attempts_' . $emailAddress, 0);
        Cache::set('attempts_' . $emailAddress, ++$attempts, 600);

        // check attempts
        if ($attempts <= 6) {
            // get the user record
            $passwordHash = null;
            $locked = true;
            $record = DB::queryFirstRow('SELECT `id`, `locked`, `password` FROM `user` WHERE `email_address`=%s LIMIT 1;',
                $emailAddress);
            if ($record !== null) {
                $passwordHash = $record['password'];
                $locked = $record['locked'];
            }

            // can we proceed?
            $error_message = 'Invalid email address or password';
            if (password_verify($password, $passwordHash)) {

                // is the account locked?
                if (!$locked) {
                    // set session variables
                    $_SESSION['logged_in'] = true;
                    $_SESSION['user_id'] = $record['id'];

                    // clean up
                    $result['success'] = true;
                    $error_message = '';

                    // mitigate session high-jacking
                    session_regenerate_id();
                } else {
                    // don't do anything we don't do for a wrong
                    // password/account - we're locked out, and
                    // we don't want to let anyone know its a
                    // real account.
                    session_destroy();
                }

            } else {
                // unset everything
                session_destroy();
            }

        } else {
            // too many attempts, let them know
            $error_message = 'Too many invalid attempts, try again later';
        }

        // clean-up and set message
        $result['message'] = $error_message;

        return $result;
    }

    public static function logout(): bool
    {
        if (self::isLoggedIn()) {
            // kill it all
            session_destroy();
            session_regenerate_id();

            // unset cookies
            if (!empty($_SERVER['HTTP_COOKIE'])) {
                $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
                foreach ($cookies as $cookie) {
                    $parts = explode('=', $cookie);
                    $name = trim($parts[0]);
                    setcookie($name, '', time() - 3600);
                    setcookie($name, '', time() - 3600, '/');
                }
            }

            // send to home page
            Http::redirect('/');
        }

        return true;
    }

    public static function isAdmin()
    {
        if (self::isLoggedIn()) {
            if (!empty($_SESSION['user_id'])) {
                $user = new User();
                $user->load((int)$_SESSION['user_id']);
                if (true == $user->admin) {
                    return true;
                }
            }
        }

        return false;
    }

}