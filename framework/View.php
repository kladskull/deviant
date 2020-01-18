<?php declare(strict_types=1); // strict mode

/** vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

namespace Deviant\Framework;

use Smarty;

/**
 * View Class
 *
 * All view objects inherit this class. This contains all of the
 * underlying mechanics that provide the end result to the HTTP user.
 * This includes Smarty functionality and view presentation.
 *
 * @category   Framework
 * @package    DeviantFramework
 * @author     Mike Curry <mikecurry74@gmail.com>
 * @license    [MIT license](http://opensource.org/licenses/MIT)
 * @since      File available since Release 0.0.1
 */
class View
{
    public $smarty;
    protected $_base_path;
    protected $_currentUser = null;

    public function __construct()
    {
        // get some parameters
        // TODO: Make Kernel a Singleton!
        $kernel = new Kernel();
        $this->_base_path = $kernel->basePath();
        $this->_currentUser = $kernel->currentUser;

        $this->initSmarty();
        $this->setViewVariableDefaults();
    }

    protected function initSmarty()
    {
        // Smarty & configuration
        $this->smarty = new Smarty();
        $this->smarty->template_dir = $this->_base_path . '/app/templates/';
        $this->smarty->compile_dir = $this->_base_path . '/app/templates/templates_c';
        $this->smarty->config_dir = $this->_base_path . '/app/templates/config/';
        $this->smarty->cache_dir = $this->_base_path . '/app/templates/cache/';
    }

    protected function setViewVariableDefaults()
    {
        $this->smarty->assign('currentUser', $this->_currentUser);
        $this->smarty->assign('loggedIn', Auth::isLoggedIn());
        $this->smarty->assign('admin', Auth::isAdmin());
    }
}