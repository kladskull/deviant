<?php declare(strict_types=1); // strict mode

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

namespace Deviant\Framework;

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
        $tokens = explode('@', $emailAddress);
        if (count($tokens) < 2) {
            return false;
        }

        if (strlen($tokens[0]) > 64) {
            return false;
        }

        if (strlen($tokens[1]) > 255) {
            return false;
        }

        // ensure we have a valid email address
        if (!filter_var($emailAddress, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        return true;
    }

    public static function recordId(int $recordId): bool
    {
        if (!filter_var($recordId, FILTER_VALIDATE_INT) || $recordId < 1) {
            return false;
        }

        return true;
    }
}