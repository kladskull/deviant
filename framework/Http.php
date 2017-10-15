<?php declare(strict_types=1); // strict mode

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Http Class
 *
 * This class contains common HTTP utilities.
 *
 * @category   Framework
 * @package    DeviantFramework
 * @author     Mike Curry <mikecurry74@gmail.com>
 * @license    [MIT license](http://opensource.org/licenses/MIT)
 * @since      File available since Release 0.0.1
 */
class Http
{
    public static function redirect($url)
    {
        header('Status: 302');
        header('Location: ' . $url);
        exit(0);
    }
}