<?php
require_once '../../vendor/autoload.php';
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

// test code, should output:
// api://default
// when you run $ php bootstrap.php
echo getenv('TESTENV');