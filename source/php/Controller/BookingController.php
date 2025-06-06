<?php
namespace Src\Controller;

use Src\Gateways\BookingGateway;

class BookingController {
    private $url = getenv('URL');
    private $requestMethod;
    private $userId;
    private $bookingGateway;

    public function __construct($requestMethod, $userId)
    {
        
        $this->requestMethod = $requestMethod;
        $this->userId = $userId;
        
        $this->bookingGateway = new BookingGateway($this->url);
    }

    public function processRequest()
    {
        switch ($this->requestMethod) {
            case 'POST':
                $response = $this->ingestPayload();
                // $response = $this->createUserFromRequest();
                break;
            default:
                $response = $this->notFoundResponse();
                break;
        }
        header($response['status_code_header']);
        if ($response['body']) {
            echo $response['body'];
        }
    }

    function debugToConsole($data) {
        $output = $data;
        if (is_array($output))
            $output = implode(',', $output);

        echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
    }

    private function ingestPayload()
    {
        $result = (array) json_decode(file_get_contents('php://input'), TRUE);

        $this->debugToConsole($result);
        // $result = $this->personGateway->findAll();
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    

    private function createUserFromRequest()
    {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        
        if (! $this->validatePerson($input)) {
            return $this->unprocessableEntityResponse();
        }

        $this->bookingGateway->insert($input);
        $response['status_code_header'] = 'HTTP/1.1 201 Created';
        $response['body'] = null;
        return $response;
    }

    

    private function validatePerson($input)
    {
        // if (! isset($input['firstname'])) {
        //     return false;
        // }
        // if (! isset($input['lastname'])) {
        //     return false;
        // }
        // return true;
    }

    private function unprocessableEntityResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 422 Unprocessable Entity';
        $response['body'] = json_encode([
            'error' => 'Invalid input'
        ]);
        return $response;
    }

    private function notFoundResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['body'] = null;
        return $response;
    }
}