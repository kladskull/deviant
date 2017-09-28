<?php
/**
 * Created by PhpStorm.
 * User: mcurry
 * Date: 9/6/17
 * Time: 9:02 PM
 */

$error_message = '';

// get the user record count
$record = DB::queryFirstRow('SELECT count(1) AS admin_created FROM ' . TB_USER . ' LIMIT 1;');
if ($record['admin_created']) {
    $_SESSION['no_register'] = true;
    redirect('/login');
}

// have a post?
if (!isset($_POST['inputEmail'])) {
    // just showed up...

} else {
    // only proceed if all fields are set
    if (isset($_POST['inputEmail']) &&
        isset($_POST['inputPassword']) &&
        isset($_POST['confirmPassword'])) {

        // get data
        $email = strtolower(trim($_POST['inputEmail']));
        $password = $_POST['inputPassword'];
        $confirm_password = $_POST['confirmPassword'];

        $email_valid = false;
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $email_valid = true;
        } else {
            $error_message = 'Invalid email address';
        }

        if (email_exists($email)) {
            $error_message = 'Invalid email address';
        }

        $password_valid = false;
        if (strlen($confirm_password) < 8) {
            $error_message = 'Minimum password length is 8';
        }

        $password_valid = false;
        if ($password !== $confirm_password) {
            $error_message = 'Passwords do not match';
        }

        // everything is alright!
        if (strlen($error_message) == 0) {
            DB::insert(TB_USER, [
                'email_address' => $email,
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'user_guid' => hash('sha512', uniqid('HSV', true) . '-' . random_bytes(32) . '-' . openssl_random_pseudo_bytes(64) . '-' . random_int(PHP_INT_MIN, PHP_INT_MAX)),
                'date_created' => new DateTime('now'),
                'locked' => false,
                'signature' => 'SIGN', //todo: hash email+gui+date_created with HSM
                'admin' => true,
            ]);

            // regenerate the session id
            session_regenerate_id();

            // clean-up
            unset($_POST['inputEmail']);
            unset($_POST['inputPassword']);
            unset($_POST['confirmPassword']);

            // redirect user to login
            $_SESSION['registered_account'] = true;
            redirect('/login');
        }
    } else {
        $error_message = 'Please fill out all of the fields';
    }
}

// show login page
if (strlen($error_message)) {
    $smarty->assign('errorMessage', $error_message);
}
$smarty->display('register.tpl');
