<?php declare(strict_types=1); // strict mode

// TODO: Base error reporting on 'ENVIRONMENT' const (development,production)
// error reporting & security
error_reporting(E_ALL | E_STRICT);

use Symfony\Component\Dotenv\Dotenv;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Registry;

// vendor & pre-loaders
include __DIR__ . '/../vendor/autoload.php';

// load environment data
$dot_env = new Dotenv();
$dot_env->load(__DIR__ . '/../.env');

// include Kernel and pre-loader
include __DIR__ . '/../framework/Loader.php';
include __DIR__ . '/../framework/Kernel.php';

// include configs
Loader::includeDirectory(__DIR__ . '/../config/');

// create a log channel
$log = new Logger('app');
$log->pushHandler(new StreamHandler(__DIR__ . '/../app/log/app-' . getenv('ENVIRONMENT') . '.log',
    Logger::WARNING));

// Add to registry
Registry::addLogger($log, 'app');

// include underlying framework
Loader::includeDirectory(__DIR__ . '/../framework/', [
    'Kernel.php',
    'Loader.php',
]);

// load Models
Loader::includeDirectory(__DIR__ . '/../app/models/');
