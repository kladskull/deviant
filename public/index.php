<?php declare(strict_types=1); // strict mode

/**
 * PSF - A PHP Boilerplate framework
 *
 * @package  Psf
 * @author   Mike Curry <mikecurry74@gmail.com>
 * @license  MIT license, included with project
 */

// for performance metrics
define('APP_START_TIME', round(microtime(true) * 1000));

/*
 +---------------------------------------------------------------------+
 | Bootstrap the environment                                           |
 +---------------------------------------------------------------------+
 | This will prepare the environment and boot the framework so that it |
 | can be used.                                                        |
 +---------------------------------------------------------------------+
*/
include __DIR__ . '/../app/bootstrap.php';

/*
 +---------------------------------------------------------------------+
 | Run the desired script                                              |
 +---------------------------------------------------------------------+
 | We can now handle the incoming request. We'll request the page and  |
 | execute it and then output the data to the user. After the request  |
 | is prepared, it will exit and continue to the bottom of this        |
 | script.                                                             |
 +---------------------------------------------------------------------+
*/

$httpKernel = new HttpKernel();

// for performance metrics
define('APP_END_TIME', round(microtime(true) * 1000));

// out..
exit(0);
