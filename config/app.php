<?php declare(strict_types=1); // strict mode
/**
 * Created by PhpStorm.
 * User: mcurry
 * Date: 9/4/17
 * Time: 11:23 PM
 */

use Symfony\Component\Dotenv\Dotenv;

// load environment data
$dot_env = new Dotenv();
$dot_env->load('../.env');
