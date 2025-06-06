<?php
namespace Src\Controller;

use Src\Gateway\BookingGateway;

class BookingController {
    private $requestMethod;
    private $bookingGateway;

    public function __construct($requestMethod)
    {
        $this->requestMethod = $requestMethod;
        $this->bookingGateway = new BookingGateway();
    }

    public function processRequest()
    {

        switch ($this->requestMethod) {
            case 'POST':
                $response = $this->ingestPayload();
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

    private function ingestPayload()
    {
        $input = (array) json_decode(file_get_contents('php://input'), true);

        
        if (! $this->validatePayload($input)) {
            return $this->unprocessableEntityResponse();
        }

        // Transform data
        $transformed = $this->transformPayload($input);

        // Call remote API through the Gateway
        $result = $this->bookingGateway->fetchRates($transformed);
 

        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode([
            'unit_name' => $input['Unit Name'], // Return original unit name
            'rate' => $result['data']['Total Charge'] ?? 0,
            'available' => ($result['data']['Rooms'] ?? 0) > 0,
            'arrival' => $input['Arrival'],
            'departure' => $input['Departure']
        ]);
        return $response;
    }

    private function validatePayload($input)
    {
        return isset($input['Unit Name'], $input['Arrival'], $input['Departure'], $input['Occupants'], $input['Ages']);
    }

    private function transformPayload($input)
    {
        // Log raw inputs
  

        $arrivalDate = \DateTime::createFromFormat('Y-m-d', $input['Arrival']);
        $departureDate = \DateTime::createFromFormat('Y-m-d', $input['Departure']);

        if (!$arrivalDate || !$departureDate) {
            throw new \Exception("Invalid date format. Please use d/m/Y.");
        }

        $arrival = $arrivalDate->format('Y-m-d');
        $departure = $departureDate->format('Y-m-d');

        // Convert ages to guest format
        $guests = array_map(function ($age) {
            return [
                'Age Group' => ($age >= 13) ? 'Adult' : 'Child'
            ];
        }, $input['Ages']);

        // Map Unit Name to hardcoded test ID 
        if ($input['Unit Name'] === 'Unit 1') {
            $unitTypeId = -2147483637;
        } elseif ($input['Unit Name'] === 'Unit 2') {
            $unitTypeId = -2147483456;
        } else {
            
            $unitTypeId = null; //
        }

        return [
            'Unit Type ID' => $unitTypeId,
            'Arrival' => $arrival,
            'Departure' => $departure,
            'Guests' => $guests
        ];
    }


    private function unprocessableEntityResponse()
    {
        return [
            'status_code_header' => 'HTTP/1.1 422 Unprocessable Entity',
            'body' => json_encode(['error' => 'Invalid input'])
        ];
    }

    private function notFoundResponse()
    {
        return [
            'status_code_header' => 'HTTP/1.1 404 Not Found',
            'body' => null
        ];
    }
}
