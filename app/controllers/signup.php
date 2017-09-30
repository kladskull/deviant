<?php declare(strict_types=1); // strict mode

/**
 * Created by PhpStorm.
 * User: mcurry
 * Date: 9/6/17
 * Time: 9:02 PM
 */
class SignupController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function get()
    {
        // show sign-up page
        $this->view->smarty->display('signup.tpl');
    }

    public function post()
    {
        $emailAddress = '';
        if (isset($_POST['inputEmail'])) {
            $emailAddress = trim(strtolower($_POST['inputEmail']));

            // clean-up
            unset($_POST['inputEmail']);

            if (!Validate::emailAddress($emailAddress)) {
                $error_message = 'Invalid email address';
                $emailAddress = '';
            }
        }

        $password = '';
        if (isset($_POST['inputPassword']) &&
            strlen($_POST['inputPassword']) >= 10) {
            $password = $_POST['inputPassword'];

            // clean-up
            unset($_POST['inputPassword']);
        } else {
            $error_message = 'Minimum password length is 10';
        }

        $confirm_password = '';
        if (isset($_POST['confirmPassword'])) {
            $confirm_password = $_POST['confirmPassword'];

            // clean-up
            unset($_POST['confirmPassword']);
        }

        // are they the same?
        if ($password !== $confirm_password) {
            $error_message = 'Passwords do not match';
        }

        // proceed if no error messages
        if (empty($error_message)) {

            // if it already exists, send them an email
            // and continue.. we should pretend it worked.
            if (User::emailExists($emailAddress)) {
                // TODO: Send an email and let them know they're still a member
            }

            // create a new user
            $user = new User();
            $user->email_address = $emailAddress;
            $user->password = password_hash($password, PASSWORD_DEFAULT);

            // first user will be granted administration privileges. This
            // may change going forward.
            if ($user->count() <= 0) {
                $user->admin = 1;
            }

            $user->create();

            // regenerate the session id
            session_regenerate_id();

            // redirect user to login
            $_SESSION['created_account'] = true;
            Http::redirect('/login');
        }

        // show sign-up page
        if (!empty($error_message)) {
            $this->view->smarty->assign('errorMessage', $error_message);
        }
        $this->view->smarty->display('signup.tpl');

    }

}
