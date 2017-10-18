<?php declare(strict_types=1); // strict mode

/**
 * Created by PhpStorm.
 * User: mcurry
 * Date: 9/5/17
 * Time: 7:05 PM
 */
class ApiController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        // require an authenticated user
        $this->middleware->require('auth');
    }

    public function get()
    {
        // get all users
        $apiKeys = Api::getAllUsersKeys(Auth::getLoggedInUserId());
        $this->view->smarty->assign('apiKeys', $apiKeys);

        // display template
        $this->view->smarty->display('api.tpl');
    }

    public function post()
    {

    }

}
