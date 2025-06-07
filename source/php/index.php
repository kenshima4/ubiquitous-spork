<?php
require_once __DIR__ . '/../composer/vendor/autoload.php';

require_once "bootstrap.php";



use Src\Controller\BookingController;

// header("Access-Control-Allow-Origin: http:localhost/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
// $uri = explode( '/', $uri );






// all of our endpoints start with /person
// everything else results in a 404 Not Found
if ($uri !== '/php/booking' ) {

    
    header("HTTP/1.1 404 Not Found");
    exit();
}

// // the user id is, of course, optional and must be a number:
// $unitTypeId = null;
// if (isset($uri[2])) {
//     $unitTypeId = (int) $uri[2];
// }

$requestMethod = $_SERVER["REQUEST_METHOD"];
$unitTypeId = getenv("UNITTYPEID1");

$unitTypeId = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $uri === '/php/booking') {

    // pass the request method and user ID to the PersonController and process the HTTP request:
    $controller = new BookingController($requestMethod, $unitTypeId);


    $controller->processRequest();
   
}

