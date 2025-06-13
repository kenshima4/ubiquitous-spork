<?php
use PHPUnit\Framework\TestCase;
use Php\Controller\BookingController;

class BookingControllerTest extends TestCase
{
    public function testProcessRequestWithValidPostCreatesThenFetchesRates()
    {
        $controller = $this->getMockBuilder(BookingController::class)
            ->setConstructorArgs(['POST'])
            ->onlyMethods(['ingestPayload', 'fetchRates'])
            ->getMock();

        $mockBody = json_encode([
            'Unit Type ID' => -2147483637,
            'Arrival' => '2025-07-15',
            'Departure' => '2025-07-25',
            'Guests' => [['Age Group' => 'Adult']]
        ]);

        $controller->method('ingestPayload')->willReturn([
            'status_code_header' => 'HTTP/1.1 201 CREATED',
            'body' => $mockBody
        ]);

        $controller->method('fetchRates')->willReturn([
            'status_code_header' => 'HTTP/1.1 200 OK',
            'body' => json_encode([
                'unit_name' => 'Unit 1',
                'rate' => 100,
                'available' => true,
                'arrival' => '2025-07-15',
                'departure' => '2025-07-25'
            ])
        ]);

        $response = $controller->processRequest();
        $this->assertEquals('HTTP/1.1 200 OK', $response['status_code_header']);
    }

    public function testProcessRequestWithInvalidMethodReturns404()
    {
        $controller = new BookingController('GET');
        $response = $controller->processRequest();
        $this->assertEquals('HTTP/1.1 404 Not Found', $response['status_code_header']);
    }
}
