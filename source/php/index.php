<?php
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$requestMethod = $_SERVER["REQUEST_METHOD"];

$allowedUris = array('/','/php/booking');

// if uri not in allowed uris return a 404 Not Found
if (!in_array($uri, $allowedUris)){
    header("HTTP/1.1 404 Not Found");
    exit;
    
}

// Handle frontend route
if ($requestMethod === 'GET' && $uri === "/") {
    require __DIR__ . '/../frontend/frontend.php';
    
    exit;
}

// pass the request method and user ID to the PersonController and process the HTTP request:
if ($requestMethod === 'POST' && $uri === "/php/booking") {
    require __DIR__ . '/bootstrap.php';
    require __DIR__ . '/Controller/BookingController.php';

    $controller = new Src\Controller\BookingController($requestMethod);
    
    $response = $controller->processRequest();

    echo json_encode($response);
    exit;
}





