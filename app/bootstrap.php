<?php declare(strict_types=1); // strict mode

// TODO: Base error reporting on 'ENVIRONMENT' const (development,production)
// error reporting & security
error_reporting(E_ALL | E_STRICT);

use Symfony\Component\Dotenv\Dotenv;

// vendor & pre-loaders
include __DIR__ . '/../vendor/autoload.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

// include some key framework files
include __DIR__ . '/../framework/Loader.php';
include __DIR__ . '/../framework/Kernel.php';

// load environment data
$dot_env = new Dotenv();
$dot_env->load(__DIR__ . '/../.env');

// create a log channel
$log = new Logger('deviant');
$log->pushHandler(new StreamHandler(__DIR__ . '/log/app-' . getenv('ENVIRONMENT') . '.log', Logger::WARNING));

// add the log to the registry
Monolog\Registry::addLogger($log);

// include configs
Loader::includeDirectory(__DIR__ . '/../config/', []);

// include underlying framework
Loader::includeDirectory(__DIR__ . '/../framework/', [
    'Kernel.php',
    'Loader.php',
]);

// load Models
Loader::includeDirectory(__DIR__ . '/../app/models/', []);
