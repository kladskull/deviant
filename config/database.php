<?php

// credentials
DB::$host = getenv('DB_HOST');
DB::$dbName = getenv('DB_DATABASE');
DB::$port = getenv('DB_PORT');
DB::$user = getenv('DB_USERNAME');
DB::$password = getenv('DB_PASSWORD');
DB::$encoding = getenv('utf8');

// tables
define('TB_USER', 'user');
define('TB_BLADES', 'blades');
define('TB_PROVISIONING', 'provisioning');
