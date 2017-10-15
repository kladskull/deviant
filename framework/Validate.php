<?php declare(strict_types=1); // strict mode

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Validation Class
 *
 * This class hopes to encapsulate all data validation/validators
 * required by the framework.
 *
 * @category   Framework
 * @package    DeviantFramework
 * @author     Mike Curry <mikecurry74@gmail.com>
 * @license    [MIT license](http://opensource.org/licenses/MIT)
 * @since      File available since Release 0.0.1
 */
class Validate
{
    public static function emailAddress(string $emailAddress): bool
    {
        // ensure we have a valid email address
        if (strlen($emailAddress) > 150 ||
            !filter_var($emailAddress, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        return true;
    }
}