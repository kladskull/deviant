<?php declare(strict_types=1); // strict mode

namespace Deviant;

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

// include configs
include __DIR__ . '/../config/database.php';
include __DIR__ . '/../config/menu.php';
include __DIR__ . '/../config/php_config.php';

// create a log channel
$log = new Logger('app');
$log->pushHandler(new StreamHandler(__DIR__ . '/../app/log/app-' . $_ENV['ENVIRONMENT'] . '.log',
    Logger::WARNING));

// Add to registry
Registry::addLogger($log, 'app');
