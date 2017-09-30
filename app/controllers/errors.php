<?php declare(strict_types=1); // strict mode

/**
 * Created by PhpStorm.
 * User: mcurry
 * Date: 9/5/17
 * Time: 7:05 PM
 */
class ErrorsController extends Controller
{
    protected $error = 0;

    public function __construct()
    {
        // call parent
        parent::__construct();

        $this->error = 404;
        if (isset($_SESSION['err'])) {
            $this->error = $_SESSION['err'];
            unset($_SESSION['err']);
        }
    }

    private function displayError()
    {
        switch ($this->error) {
            case 401:
                $this->view->smarty->display('401.tpl');
                break;

            case 404:
                $this->view->smarty->display('404.tpl');
                break;

            default:
                $this->view->smarty->display('404.tpl');
                break;
        }
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
