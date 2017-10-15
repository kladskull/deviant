<?php declare(strict_types=1); // strict mode

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Base Controller Class
 *
 * This class is inherited by all Application controllers to
 * add any required underlying functionality.
 *
 * @category   Framework
 * @package    DeviantFramework
 * @author     Mike Curry <mikecurry74@gmail.com>
 * @license    [MIT license](http://opensource.org/licenses/MIT)
 * @since      File available since Release 0.0.1
 */
class Controller
{
    protected $view;
    protected $middleware;
    protected $logger = null;

    public function __construct()
    {
        $this->view = new View();
        $this->middleware = new Middleware();

        // get logger instance
        $this->_logger = Monolog\Registry::getInstance('app');
    }

}