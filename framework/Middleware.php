<?php declare(strict_types=1); // strict mode

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

namespace Deviant\Framework;

/**
 * Middleware Class
 *
 * This class handles, loads and executes any middleware the
 * framework requires.
 *
 * @category   Framework
 * @package    DeviantFramework
 * @author     Mike Curry <mikecurry74@gmail.com>
 * @license    [MIT license](http://opensource.org/licenses/MIT)
 * @since      File available since Release 0.0.1
 */
class Middleware
{
    public function __construct()
    {
        $this->trimRequests();
        $this->removeUniquePostId();
    }

    // TODO: check for maintenance mode
    // TODO: validate post sizes
    // TODO: trust proxies

    protected function trimRequests()
    {
        $skip_vars = [
            'inputPassword',
            'confirmPassword'
        ];

        // Allow skipping variables such as password
        if (isset($_POST)) {
            foreach ($_POST as $key => $data) {

                if (!in_array($key, $skip_vars)) {
                    $_POST[$key] = trim($data);
                }

                // change empty strings to null
                if (empty($_POST[$key])) {
                    $_POST[$key] = null;
                }
            }
        }

        // Allow skipping variables such as password
        if (isset($_GET)) {
            foreach ($_GET as $key => $data) {

                if (!in_array($key, $skip_vars)) {
                    $_GET[$key] = trim($data);
                }

                // change empty strings to null
                if (empty($_GET[$key])) {
                    $_GET[$key] = null;
                }
            }

        }
    }

    // middleware - page access requirements
    public function require(string $requirement)
    {
        switch ($requirement) {
            case 'admin':
            case 'auth':
                if (!Auth::isLoggedIn()) {
                    $_SESSION['err'] = 401;
                    Http::redirect('/errors');
                }
                break;

            default:
                break;
        }
    }

    private function removeUniquePostId(): void
    {
        $formUniqueName = hash('sha256',
            getenv('APP_SECRET') . session_id());

        if (isset($_POST)) {
            if (isset($_POST[$formUniqueName])) {
                $inputUnique = $_POST[$formUniqueName];

                foreach ($_POST as $key => $data) {
                    if (substr($key, 0, 5) == 'input') {
                        $newKey = str_replace($inputUnique, '', $key);
                        $_POST[$newKey] = $data;
                        unset($_POST[$key]);
                    }
                }

                unset($_POST[$formUniqueName]);
            }
        }

        if (isset($_GET)) {
            if (isset($_GET[$formUniqueName])) {
                $inputUnique = $_GET[$formUniqueName];

                foreach ($_GET as $key => $data) {
                    if (substr($key, 0, 5) == 'input') {
                        $newKey = str_replace($inputUnique, '', $key);
                        $_GET[$newKey] = $data;
                        unset($_GET[$key]);
                    }
                }

                unset($_GET[$formUniqueName]);
            }
        }
    }
}