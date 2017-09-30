<?php declare(strict_types=1); // strict mode

// credentials
DB::$host = getenv('DB_HOST');
DB::$dbName = getenv('DB_DATABASE');
DB::$port = getenv('DB_PORT');
DB::$user = getenv('DB_USERNAME');
DB::$password = getenv('DB_PASSWORD');
DB::$encoding = getenv('utf8');
DB::$error_handler = false;
DB::$throw_exception_on_error = true;
