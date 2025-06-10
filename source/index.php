<?php
require_once __DIR__ . '/composer/vendor/autoload.php';

require_once __DIR__ . "/php/bootstrap.php";

use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

use Src\Controller\BookingController;

// header("Access-Control-Allow-Origin: http:localhost/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
// $uri = explode( '/', $uri );

$allowedUris = [
    '/',
    '/php/booking',
];



// check allowed uris
// if uri not in allowed uris return a 404 Not Found
if (!in_array($uri, $allowedUris)){
    header("HTTP/1.1 404 Not Found");
    exit();
    
}

$requestMethod = $_SERVER["REQUEST_METHOD"];
$unitTypeId = getenv("UNITTYPEID1");

$unitTypeId = null;

if ($_SERVER['REQUEST_METHOD'] === 'GET' && $uri === '/') {
    error_log("in home page");
    header('Location: /frontend/frontend.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $uri === '/php/booking') {

    // pass the request method and user ID to the PersonController and process the HTTP request:
    $controller = new BookingController($requestMethod, $unitTypeId);


    $controller->processRequest();
   
}

