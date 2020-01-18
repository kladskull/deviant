<?php declare(strict_types=1); // strict mode

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

namespace Deviant\Framework;

use Monolog\Registry;

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
    public $view;
    protected $middleware;
    protected $logger = null;

    public $requestVars = [];
    public $menuArray = [];

    public function __construct()
    {
        $this->view = new View();
        $this->middleware = new Middleware();

        // get menu items
        $this->view->smarty->assign('menuItems', require '../config/menu.php');

        // get logger instance
        $this->_logger = Registry::getInstance('app');
    }
}