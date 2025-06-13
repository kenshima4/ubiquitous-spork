<?php
namespace Php\Controller;

use Php\Gateway\BookingGateway as BookingGateway;

class BookingController {
    private $requestMethod;
    private $bookingGateway;

    private $ids;
    private $unitId;
    private $rate;
    private $arrivalDate;
    private $departureDate;
    private $available;
    private $guests;

    public function __construct($requestMethod)
    {
        $this->requestMethod = $requestMethod;
        $this->bookingGateway = new BookingGateway();
        $this->ids = [
            "Unit 1" => -2147483637,
            "Unit 2" => -2147483456
        ];
    }

    public function processRequest()
    {
        $requestMethod = $this->requestMethod;
        if ($requestMethod === "POST"){
            
            $response = $this->ingestPayload();
            if ($response['status_code_header'] === 'HTTP/1.1 201 CREATED'){
                $response = $this->fetchRates($response['body']);
            }
        }else{
            $response = $this->notFoundResponse();
        }
        
        return $response;
        
    }

    public function ingestPayload()
    {
        $input = (array) json_decode(file_get_contents('php://input'), true);

        
        if (! $this->validatePayload($input)) {
            return $this->unprocessableEntityResponse();
        }

        // Transform data
        return $this->transformPayload($input);
    }
    
    public function validatePayload($input)
    {
        $valid =true;
        $unitName = $input['Unit Name'];
        if (!isset($unitName, $input['Arrival'], $input['Departure'], $input['Occupants'], $input['Ages'])){
            $valid = false;
        }
        if (!key_exists($unitName, $this->ids)){
            $valid = false;
        }
        $arrivalDate = \DateTime::createFromFormat('Y-m-d', $input['Arrival']);
        $departureDate = \DateTime::createFromFormat('Y-m-d', $input['Departure']);
        // Check date formats
        if (!$arrivalDate || !$departureDate) {
            $valid = false;
        }

        if (!$this->all($input['Ages'], 'is_int')){
            $valid = false;
        }
        return $valid;
    }

    public function all($elems, $predicate) {
        foreach ($elems as $elem) {
            if (!call_user_func($predicate, $elem)) {
                return false;
            }
        }

        return true;
    }

    public function transformPayload($input)
    {
        $this->arrivalDate = $input['Arrival'];
        $this->departureDate = $input['Departure'];
        // Convert ages to guest format
    $this->guests = array_map(function ($age) {
            return [
                'Age Group' => ($age >= 18) ? 'Adult' : 'Child'
            ];
        }, $input['Ages']);

        // Map Unit Name to hardcoded test ID 
        $this->unitId = $this->ids[$input['Unit Name']];
        
        $response['status_code_header'] = 'HTTP/1.1 201 CREATED';
        $response['body'] = json_encode([
            'Unit Type ID' => $this->unitId,
            'Arrival' => $this->arrivalDate,
            'Departure' => $this->departureDate,
            'Guests' => $this->guests
        ]);
        return $response;
    }

    public function fetchRates($dataToSend){
        // Call remote API through the Gateway
        $result = $this->bookingGateway->fetchRates($dataToSend);
        if ($result === null){
            return $this->notFoundResponse();
        }

        $this->rate = $result['data']['Total Charge'] ?? 0;
        $this->available = ($result['data']['Rooms'] ?? 0) > 0;
        
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode([
            'unit_name' => $this->getNameFromId($this->unitId), // Return original unit name
            'rate' => $this->rate,
            'available' => $this->available,
            'arrival' => $this->arrivalDate,
            'departure' => $this->departureDate
        ]);
        return $response;
    }

    public function getNameFromId($id){
        $key = array_search($id, $this->ids);
        if($key === false)
        {
            return null;
        }
        else
        {
            return $key;
        }
        
    }

    public function unprocessableEntityResponse()
    {
        return [
            'status_code_header' => 'HTTP/1.1 422 Unprocessable Entity',
            'body' => json_encode(['error' => 'Invalid input'])
        ];
    }

    public function notFoundResponse()
    {
        return [
            'status_code_header' => 'HTTP/1.1 404 Not Found',
            'body' => null
        ];
    }
}




