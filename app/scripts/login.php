<?php
/**
 * Created by PhpStorm.
 * User: mcurry
 * Date: 9/6/17
 * Time: 9:02 PM
 */

// start login attempts at 0
if (!isset($_SESSION['attempts'])) {
    $_SESSION['attempts'] = 0;
}

// redirect them to home
if (isset($_SESSION['logged_in'])) {
    redirect('/');
    exit(0);
}

$notify_message = '';
if (isset($_SESSION['registered_account'])) {
    if ($_SESSION['registered_account'] === true) {
        $notify_message = 'Your account was created, you can now sign-in';
        unset($_SESSION['registered_account']);
    }
}

$notify_message = '';
if (isset($_SESSION['created_account'])) {
    if ($_SESSION['created_account'] === true) {
        $notify_message = 'Your account was created, please see an administrator for access.';
        unset($_SESSION['created_account']);
    }
}

$error_message = '';
if (isset($_SESSION['no_register'])) {
    if ($_SESSION['no_register'] == true) {
        $error_message = 'An administrator has already registered';
        unset($_SESSION['no_register']);
    }
}

// have a post?
if (!isset($_POST['inputEmail'])) {
    // just showed up...

} else {
    if ($_SESSION['attempts'] < 5) {

        // get credentials
        $email_address = '';
        if (isset($_POST['inputEmail'])) {
            $email_address = $_POST['inputEmail'];
        }

        if (!filter_var($email_address, FILTER_VALIDATE_EMAIL)) {
            $email_address = '***';
        }

        $password = '';
        if (isset($_POST['inputPassword'])) {
            $password = $_POST['inputPassword'];
        }

        // get the user record
        $record = DB::queryFirstRow('select * from ' . TB_USER . ' where email_address=%s limit 1;', $email_address);
        if ($record == null) {
            // create junk
            $record = [
                'email_address' => hash('sha512', random_bytes(64)) . 'x',
                'password' => hash('sha512', random_bytes(64)) . 'x',
            ];
        }

        // can we proceed?
        if (password_verify($password, $record['password'])) {

            // is the account locked?
            if (!$record['locked']) {
                // regenerate a session id to mitigate session high-jacking
                session_regenerate_id();

                // set session variables
                $_SESSION['logged_in'] = true;
                $_SESSION['user_record'] = $record;
                unset($_SESSION['attempts']);
                unset($_SESSION['last_attempt']);
                unset($_POST['inputEmail']);

                // Good to go?
                redirect('/');
                exit(0);
            } else {
                // do not show anything different from the normal
                // as we do not want to give any hint at all that the
                // account is locked.
                $error_message = 'Invalid email address or password';
            }
        } else {
            // give the user a message
            $error_message = 'Invalid email address or password';

            // update error message
            $_SESSION['attempts']++;
            $_SESSION['last_attempt'] = time(0);

            // unset everything
            unset($_SESSION['logged_in']);
            unset($_SESSION['user_record']);
        }
    } else {
        // give the abuser a time-out
        $error_message = 'Too many invalid attempts, try again later';
        if (abs(time(0) - $_SESSION['last_attempt']) > 300) {
            unset($_SESSION['attempts']);
            unset($_SESSION['last_attempt']);
        }
    }

    // clean-up
    unset($_POST['inputEmail']);
}

if (strlen($notify_message)) {
    $smarty->assign('notifyMessage', $notify_message);
}

if (strlen($error_message)) {
    $smarty->assign('errorMessage', $error_message);
}

// show login page
$smarty->display('login.tpl');
