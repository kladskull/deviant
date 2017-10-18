<?php declare(strict_types=1); // strict mode

/**
 * Created by PhpStorm.
 * User: mcurry
 * Date: 9/6/17
 * Time: 9:02 PM
 */
class LoginController extends Controller
{
    public function __construct()
    {
        // call parent
        parent::__construct();
    }

    // responds to an HTTP-GET request
    public function get()
    {
        //TODO: this can be a Middleware
        // redirect them to home if they're logged in
        if (Auth::isLoggedIn()) {
            Http::redirect('/');
        }

        $notify_message = '';
        $error_message = '';

        // TODO: THIS CAN ALSO BE MIDDLEWARE?
        // show a message for admin registration
        if (isset($_SESSION['registered_account'])) {
            if ($_SESSION['registered_account'] === true) {
                $notify_message = 'Your account was created, you can now sign-in';
                unset($_SESSION['registered_account']);
            }
        }

        // show a message for sign-up
        if (isset($_SESSION['created_account'])) {
            if ($_SESSION['created_account'] === true) {
                $notify_message = 'Your account was created, please see an administrator for access.';
                unset($_SESSION['created_account']);
            }
        }

        // display an error message
        if (isset($_SESSION['no_register'])) {
            if ($_SESSION['no_register'] == true) {
                $error_message = 'An administrator has already registered';
                unset($_SESSION['no_register']);
            }
        }

        // set any view variables
        if (!empty($notify_message)) {
            $this->view->smarty->assign('notifyMessage', $notify_message);
        }
        if (!empty($error_message)) {
            $this->view->smarty->assign('notifyMessage', $error_message);
        }

        // show the page
        $this->view->smarty->display('login.tpl');
    }

    // responds to an HTTP-GET request
    public function post()
    {
        if (!isset($_POST['inputEmail'])) {
            HttpResponse::redirect('/');
            exit(0);
        }
        
        // get credentials
        $email_address = '';
        if (isset($_POST['inputEmail'])) {
            $email_address = $_POST['inputEmail'];
        }

        $password = '';
        if (isset($_POST['inputPassword'])) {
            $password = $_POST['inputPassword'];
        }

        // clean-up
        unset($_POST['inputEmail']);

        // attempt to log them in
        $response = Auth::login($email_address, $password);

        // respond to login attempt
        if ($response['success']) {
            // send them to the home page
            Http::redirect('/');
        } else {
            // update the view with results
            if (strlen($response['message'])) {
                if (false == $response) {
                    $this->view->smarty->assign('errorMessage', $response['message']);
                } else {
                    $this->view->smarty->assign('notifyMessage', $response['message']);
                }
            }

            // show login
            $this->view->smarty->display('login.tpl');
        }
    }
}
