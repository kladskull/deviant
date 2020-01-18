<?php declare(strict_types=1); // strict mode

// credentials
DB::$host = $_ENV['DB_HOST'];
DB::$dbName = $_ENV['DB_DATABASE'];
DB::$port = $_ENV['DB_PORT'];
DB::$user = $_ENV['DB_USERNAME'];
DB::$password = $_ENV['DB_PASSWORD'];
DB::$encoding = $_ENV['DB_UTF8'];
DB::$error_handler = false;
DB::$nonsql_error_handler = false;
DB::$throw_exception_on_error = false;
