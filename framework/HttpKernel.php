<?php declare(strict_types=1); // strict mode

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

namespace Deviant\Framework;

/**
 * Http Kernel Class
 *
 * This is the Kernel for the Web. It inherits Kernel. This
 * is used to process any web/http requests, execute any
 * middleware and then fire off the required controller.
 *
 * @category   Framework
 * @package    DeviantFramework
 * @author     Mike Curry <mikecurry74@gmail.com>
 * @license    [MIT license](http://opensource.org/licenses/MIT)
 * @since      File available since Release 0.0.1
 */
class HttpKernel extends Kernel
{
    protected $_method = null;
    protected $_controller = null;
    protected $_controller_file_name = null;
    protected $_function_name = null;
    protected $_request = [];
    protected $_ssl_enabled = false;
    protected $_response = [];
    protected $_headers = null;
    protected $_requestVars = [];

    public function __construct()
    {
        parent::__construct();

        // initialize CSRF protection

        session_start();

        $this->_ssl_enabled = Http::isSSL();
        $this->_headers = new Headers();
        $this->addHeaders();
        $this->getControllerRequest();

        // TODO: process middleware

        // TODO: get the controller, collect the requests and run it
        $this->runController();
    }

    protected function runController()
    {
        $objectName = 'Deviant\\Controllers\\'.ucfirst($this->_controller) . 'Controller';
        $controllerObject = new $objectName;

        $controllerObject->requestVars = $this->_requestVars;

        // for menu control
        $currentMenuItem = '/' . $this->_controller;
        if ($currentMenuItem === '/index') {
            $currentMenuItem = '/';
        }
        $controllerObject->view->smarty->assign('currentPage', $currentMenuItem);

        // for unique page id's
        $controllerObject->view->smarty->assign('form_unique_name',
            hash('sha256', getenv('APP_SECRET') . session_id())
        );

        $controllerObject->view->smarty->assign('form_unique_id',
            hash('sha256', getenv('APP_SECRET') . uniqid())
        );

        $controllerObject->view->smarty->assign('GOOGLE_PLACES_API_KEY', getenv('GOOGLE_PLACES_API_KEY'));

        // start it
        $action = strtolower($this->_method);
        if (is_callable([$controllerObject, $action])) {
            $controllerObject->$action();
        } else {
            die('Controller/method not found: ' . $this->_controller . '->' . $action);
        }
    }

    private function addHeaders(): bool
    {
        if ($this->_ssl_enabled) {
            $this->_headers->addHeaders([
                'Strict-Transport-Security' => 'max-age=16070400; includeSubDomains',
                'X-Frame-Options' => 'DENY',
                'Frame-Options' => 'DENY',
                'X-XSS-Protection' => '1; mode=block',
                'X-Content-Type-Options' => 'nosniff',
            ]);
        }

        return true;
    }

    protected function getControllerRequest(): bool
    {
        $this->_controller = 'index';
        $success = false;
        $request_url = [];
        if (!empty($_SERVER['REDIRECT_URL'])) {
            $request_url = explode('/', $_SERVER['REDIRECT_URL']);
        }

        // get requested controller
        $this->_controller_file_name = $this->basePath() . '/app/controllers/IndexController.php';
        if (count($request_url) > 1) {
            // filter out anything but alphanumeric, '-', and '_' for the controller
            $this->_controller = preg_replace('/[^a-zA-Z0-9\-_]/', '', trim($request_url[1]));

            // do not allow '.php', redirect to 404 if we see it
            if (!empty($_SERVER['REQUEST_URI']) &&
                false !== strpos(strtolower($_SERVER['REQUEST_URI']), '.php')) {
                $this->_controller = 'errors';
            } else {
                if (!empty($_SERVER['REDIRECT_URL']) &&
                    false !== strpos(strtolower($_SERVER['REDIRECT_URL']), '.php')) {
                    $this->_controller = 'errors';
                }
            }

            $this->_requestVars = $request_url;

            // check path
            $file_name = $this->basePath() . '/app/controllers/' . $this->_controller . '.php';
            if (file_exists($file_name)) {
                $this->_controller_file_name = $file_name;
            } else {
                $this->_controller = 'errors';
                $this->_controller_file_name = $this->basePath() . 'app/controllers/ErrorsController.php';
            }
        }

        // store the request variables
        $this->_request = $request_url;

        // store the http method
        $this->_method = trim(strtoupper($_SERVER['REQUEST_METHOD']));

        // set to default
        if (null == $this->_controller) {
            $this->_controller_file_name = __DIR__ . '/controllers/IndexController.php';
        }

        return $success;
    }
}