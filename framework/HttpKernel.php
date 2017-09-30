<?php declare(strict_types=1); // strict mode

/**
 * Created by PhpStorm.
 * User: mcurry
 * Date: 9/28/17
 * Time: 8:26 PM
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

    public function __construct()
    {
        parent::__construct();

        // initialize CSRF protection
        csrfProtector::init();

        $this->_ssl_enabled = $this->is_ssl();
        $this->_headers = new Headers();
        $this->addHeaders();
        $this->getControllerRequest();

        // TODO: process middleware

        // TODO: get the controller, collect the requests and let'er rip

        $this->runController();
    }

    protected function runController()
    {
        // include the controller
        require $this->_controller_file_name;
        $objectName = ucfirst($this->_controller) . 'Controller';
        $controllerObject = new $objectName();

        // start it
        $action = strtolower($this->_method);
        if (is_callable([$controllerObject, $action])) {
            $controllerObject->$action();
        } else {
            die('Controller/method not found: ' . $this->_controller . '->' . $action);
        }
    }

    private function getFunctionName()
    {
        $func_name = '';

        switch ($this->_method) {
            case 'GET':
                $func_name = 'get';
                break;
            case 'POST':
                $func_name = 'post';
                break;
            case 'PUT':
                $func_name = 'put';
                break;
            case 'DELETE':
                $func_name = 'delete';
                break;
            default:
                break;
        }

        return $func_name;
    }

    private function addHeaders(): bool
    {
        if ($this->is_ssl()) {
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

    public function is_ssl(): bool
    {
        if (isset($_SERVER['HTTPS'])) {
            if ('on' == strtolower($_SERVER['HTTPS']) ||
                '1' == $_SERVER['HTTPS']) {
                return true;
            }
        } else if (isset($_SERVER['SERVER_PORT']) &&
            '443' == $_SERVER['SERVER_PORT']) {
            return true;
        }
        return false;
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
        $this->_controller_file_name = $this->basePath() . '/app/controllers/index.php';
        if (count($request_url) > 1) {
            // filter out anything but alphanumeric, '-', and '_' for the controller
            $this->_controller = preg_replace('/[^a-zA-Z0-9\-_]/', '', trim($request_url[1]));

            // do not allow '.php', redirect to 404 if we see it
            if (!empty($_SERVER['REQUEST_URI']) &&
                false !== strpos(strtolower($_SERVER['REQUEST_URI']), '.php')) {
                $this->_controller = 'errors';
            } else if (!empty($_SERVER['REDIRECT_URL']) &&
                false !== strpos(strtolower($_SERVER['REDIRECT_URL']), '.php')) {
                $this->_controller = 'errors';
            }

            // todo: get subcontroller name

            // todo: get variables

            // check path
            $file_name = $this->basePath() . '/app/controllers/' . $this->_controller . '.php';
            if (file_exists($file_name)) {
                $this->_controller_file_name = $file_name;
            } else {
                $this->_controller = 'errors';
                $this->_controller_file_name = $this->basePath() . 'app/controllers/errors.php';
            }
        }

        // store the request variables
        $this->_request = $request_url;

        // store the http method
        $this->_method = trim(strtoupper($_SERVER['REQUEST_METHOD']));

        // set to default
        if (null == $this->_controller) {
            $this->_controller_file_name = __DIR__ . '/controllers/index.php';
        }

        return $success;
    }

}