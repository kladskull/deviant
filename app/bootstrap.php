<?php declare(strict_types=1); // strict mode

// TODO: Base on environment
// error reporting & security
error_reporting(E_ALL | E_STRICT);

use Symfony\Component\Dotenv\Dotenv;

// vendor
include '../vendor/autoload.php';

// load environment data
$dot_env = new Dotenv();
$dot_env->load('../.env');

// vendor config
include '../config/csrf_config.php';

// config
include '../config/php.php';
include '../config/app.php';
include '../config/database.php';

// pre-loads
include '../framework/Kernel.php';

// framework
include '../framework/Auth.php';
include '../framework/Base.php';
include '../framework/Cache.php';
include '../framework/Controller.php';
include '../framework/Headers.php';
include '../framework/Http.php';
include '../framework/HttpKernel.php';
include '../framework/Middleware.php';
include '../framework/Validate.php';
include '../framework/View.php';

// load Models
$iterator = new DirectoryIterator(__DIR__ . '/../app/models/');
foreach ($iterator as $file_info) {
    if ($file_info->isFile() && $file_info->getFilename() !== 'bootstrap.php') {
        include __DIR__ . '/../app/models/' . $file_info->getFilename();
    }
}
