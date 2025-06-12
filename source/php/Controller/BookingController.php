<?php
namespace Src\Controller;


require_once __DIR__ . '/../Gateway/BookingGateway.php';

use PSpell\Dictionary;
use Src\Gateway\BookingGateway as BookingGateway;

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
        switch ($this->requestMethod) {
            case 'POST':
                $response = $this->ingestPayload();
                if ($response['status_code_header'] === 'HTTP/1.1 201 CREATED'){
                    $response = $this->fetchRates($response['body']);
                }
                
                break;
            default:
                $response = $this->notFoundResponse();
                break;
                
        }
        return $response;
        
    }

    private function ingestPayload()
    {
        $input = (array) json_decode(file_get_contents('php://input'), true);

        
        if (! $this->validatePayload($input)) {
            return $this->unprocessableEntityResponse();
        }

        // Transform data
        $transformed = $this->transformPayload($input);
        return $transformed;
    }
    
    private function validatePayload($input)
    {
        
        if (!isset($input['Unit Name'], $input['Arrival'], $input['Departure'], $input['Occupants'], $input['Ages'])){
            return false;
        }
        if (!key_exists($input['Unit Name'], $this->ids)){
            return false;
        }
        $arrivalDate = \DateTime::createFromFormat('Y-m-d', $input['Arrival']);
        $departureDate = \DateTime::createFromFormat('Y-m-d', $input['Departure']);
        // Check date formats
        if (!$arrivalDate || !$departureDate) {
            return false;
        }

        if (!$this->all($input['Ages'], 'is_int')){
            return false;
        }
        return true;
    }

    private function all($elems, $predicate) {
        foreach ($elems as $elem) {
            if (!call_user_func($predicate, $elem)) {
            return false;
            }
        }

        return true;
    }

    private function transformPayload($input)
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

    private function fetchRates($dataToSend){
        // Call remote API through the Gateway
        $result = $this->bookingGateway->fetchRates($dataToSend);
        if ($result === null){
            return $this->notFoundResponse();
        }
        
        error_log("data result----->");
        error_log(json_encode($result['data']));

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

    private function getNameFromId($id){
        $key = array_search($id, $this->ids);
        if($key === FALSE)
        {
            return null;
        }
        else
        {
            return $key;
        }
        
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
