<?php declare(strict_types=1); // strict mode

/**
 * Created by PhpStorm.
 * User: mcurry
 * Date: 9/5/17
 * Time: 7:05 PM
 */
class ErrorsController extends Controller
{
    public function __construct()
    {
        // call parent
        parent::__construct();

    }

    private function displayError()
    {
        $this->view->smarty->display('404.tpl');
    }

    public function get()
    {
        $this->displayError();
    }

    public function post()
    {
        $this->displayError();
    }

    public function put()
    {
        $this->displayError();
    }

    public function delete()
    {
        $this->displayError();
    }

}
