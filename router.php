<?php

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$file = __DIR__ . '/Src' . $uri;

if (php_sapi_name() === 'cli-server' && is_file($file)) {
    return false; // Let PHP serve the actual file (HTML, CSS, JS)
}

// Route everything else to index.php
require_once __DIR__ . '/Src/Php/index.php'; //NOSONAR
