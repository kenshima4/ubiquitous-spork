<?php
use Src\Utils\Utils;

// Route all non-existent files to index.php
if (php_sapi_name() == 'cli-server') {
    $url  = parse_url($_SERVER['REQUEST_URI']);

    $file = __DIR__ . $url['path'];
    

    error_log($url);
    error_log($file);
    if (is_file($file)) {
        return false; // serve the file directly
    }
}

require __DIR__ . '/index.php';