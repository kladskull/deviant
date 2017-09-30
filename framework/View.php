<?php
/**
 * Created by PhpStorm.
 * User: mcurry
 * Date: 9/29/17
 * Time: 2:23 PM
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