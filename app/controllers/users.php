<?php declare(strict_types=1); // strict mode

/**
 * Created by PhpStorm.
 * User: mcurry
 * Date: 9/5/17
 * Time: 7:05 PM
 */
class UsersController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        // require an authenticated user
        $this->middleware->require('auth');

        // require an administrator
        $this->middleware->require('admin');
    }

    public function get()
    {
        // get all users
        $users = User::getUserList();
        $this->view->smarty->assign('users', $users);

        // display string
        $this->view->smarty->display('users.tpl');
    }

    public function post()
    {
        if (isset($_POST['lock'])) {
            $lock = $_POST['lock'];

            // clean-up
            unset($_POST['lock']);

            // parse it out
            $lock_data = explode('-', $lock);
            if (count($lock_data) > 1) {
                $action = $lock_data[0];
                $id = (int)$lock_data[1];

                $lock = 1;
                if ($action !== 'lock') {
                    $lock = 0;
                }

                // TODO: Make this a User function
                // modify the record
                $user = new User();
                $user->load($id);
                $user->locked = $lock;
                $user->save();
            }
        }

        if (isset($_POST['admin'])) {
            // get data
            $admin_data = explode('-', $_POST['admin']);

            // clean-up
            unset($_POST['admin']);

            if (count($admin_data) > 1) {
                $action = $admin_data[0];
                $id = (int)$admin_data[1];

                $admin = 0;
                if ($action == 'admin') {
                    $admin = 1;
                }

                // TODO: Make this a User function
                // modify the record
                $user = new User();
                $user->load($id);
                $user->admin = $admin;
                $user->save();
            }

        }

        // reload the page
        $this->get();
    }

}
