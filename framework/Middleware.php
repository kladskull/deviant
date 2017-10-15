<?php declare(strict_types=1); // strict mode

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

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
        //trimRequests()
    }

    // TODO: check for maintenance mode
    // TODO: validate post sizes
    // TODO: trust proxies

    protected function trimRequests()
    {
        // TODO: Allow skipping variables such as password
        if (isset($_POST)) {
            foreach ($_POST as $key => $data) {
                $_POST[$key] = trim($data);

                // change empty strings to null
                if (empty($_POST[$key])) {
                    $_POST[$key] = null;
                }
            }
        }

        // TODO: Allow skipping variables such as password
        if (isset($_GET)) {
            foreach ($_GET as $key => $data) {
                $_GET[$key] = trim($data);
            }

            // change empty strings to null
            if (empty($_GET[$key])) {
                $_GET[$key] = null;
            }
        }
    }

    // middleware - page access requirements
    public function require(string $requirement)
    {
        switch ($requirement) {
            case 'auth':
                if (!Auth::isLoggedIn()) {
                    $_SESSION['err'] = 401;
                    Http::redirect('/errors');
                }
                break;

            case 'admin':
                if (!Auth::isLoggedIn()) {
                    $_SESSION['err'] = 401;
                    Http::redirect('/errors');
                }
                break;

            default:
                break;
        }
    }
}