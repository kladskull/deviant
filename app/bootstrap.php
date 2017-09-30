<?php declare(strict_types=1); // strict mode

// error reporting & security
error_reporting(E_ALL | E_STRICT);

/*
TODO: The following will be implemented by environment in the future.
# supress php errors
php_flag display_startup_errors off
php_flag display_errors off
php_flag html_errors off
php_value docref_root 0
php_value docref_ext 0

# enable PHP error logging
php_flag  log_errors on
php_value error_log  app/logs/[environment]-date-time.log
*/

// vendor
include '../vendor/autoload.php';

// config
include '../config/php_config.php';
include '../config/app.php';
include '../config/csrf_config.php';
include '../config/database.php';

// framework
include '../framework/Auth.php';
include '../framework/Base.php';
include '../framework/Cache.php';
include '../framework/Controller.php';
include '../framework/Kernel.php';
include '../framework/Headers.php';
include '../framework/HttpKernel.php';
include '../framework/Middleware.php';
include '../framework/View.php';
include '../framework/Validate.php';
include '../framework/Http.php';

// load Models
$iterator = new DirectoryIterator(__DIR__ . '/../app/models/');
foreach ($iterator as $file_info) {
    if ($file_info->isFile() && $file_info->getFilename() !== 'bootstrap.php') {
        include __DIR__ . '/../app/models/' . $file_info->getFilename();
    }
}
