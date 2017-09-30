<?php declare(strict_types=1); // strict mode

/**
 * Created by PhpStorm.
 * User: mcurry
 * Date: 9/28/17
 * Time: 9:49 PM
 */
class Controller
{
    protected $view;
    protected $middleware;

    public function __construct()
    {
        $this->view = new View();
        $this->middleware = new Middleware();
    }

}