<?php
require __DIR__ . '/../composer/vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../..');
$dotenv->load();

// test code, should output:
// api://default
// when you run $ php bootstrap.php
// error_log($_ENV['UNITTYPEID1']);

