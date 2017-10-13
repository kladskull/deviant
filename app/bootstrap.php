<?php declare(strict_types=1); // strict mode

// TODO: Base on environment
// error reporting & security
error_reporting(E_ALL | E_STRICT);

use Symfony\Component\Dotenv\Dotenv;

// vendor
include __DIR__ . '/../vendor/autoload.php';

// load environment data
$dot_env = new Dotenv();
$dot_env->load(__DIR__ . '/../.env');

// vendor config
include '../config/csrf_config.php';

// config
include __DIR__ . '/../config/php_config.php';
include __DIR__ . '/../config/csrf_config.php';
include __DIR__ . '/../config/database.php';

// pre-loads
include __DIR__ . '/../framework/Kernel.php';

// framework
include __DIR__ . '/../framework/Auth.php';
include __DIR__ . '/../framework/Base.php';
include __DIR__ . '/../framework/Cache.php';
include __DIR__ . '/../framework/Controller.php';
include __DIR__ . '/../framework/Headers.php';
include __DIR__ . '/../framework/Http.php';
include __DIR__ . '/../framework/HttpKernel.php';
include __DIR__ . '/../framework/Middleware.php';
include __DIR__ . '/../framework/Validate.php';
include __DIR__ . '/../framework/View.php';


// load Models
$iterator = new DirectoryIterator(__DIR__ . '/../app/models/');
foreach ($iterator as $file_info) {
    if ($file_info->isFile() && $file_info->getFilename() !== 'bootstrap.php') {
        include __DIR__ . '/../app/models/' . $file_info->getFilename();
    }
}
