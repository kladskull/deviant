<?php

// error reporting & security
error_reporting(E_ALL | E_STRICT);

include 'config/includes.php';

// secure?
if (is_ssl()) {
    ssl_headers();
}
