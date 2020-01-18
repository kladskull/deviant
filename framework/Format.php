<?php declare(strict_types=1); // strict mode

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

namespace Deviant\Framework;

/**
 * Format Class
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
class Format
{
    public static function makeInt(string $string): int
    {
        return (int)preg_replace("[^A-Za-z0-9]/u", '', $string);
    }

    public static function stripNonAlphaNumeric(string $string): string
    {
        return preg_replace("/[^[:alnum:]]/u", '', $string);
    }
}