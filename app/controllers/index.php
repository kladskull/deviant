<?php declare(strict_types=1); // strict mode

/**
 * Created by PhpStorm.
 * User: mcurry
 * Date: 9/5/17
 * Time: 7:05 PM
 */
class IndexController extends Controller
{
    public function __construct()
    {
        // call parent
        parent::__construct();
        //$this->middleware('auth');
    }

    // responds to an HTTP-GET request
    public function get()
    {
        $this->view->smarty->display('index.tpl');
    }
}
