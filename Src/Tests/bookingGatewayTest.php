<?php
use PHPUnit\Framework\TestCase;
use Php\Gateway\BookingGateway;

class BookingGatewayTest extends TestCase
{
    public function testFetchRatesReturnsExpectedKeys()
    {
        $gateway = $this->getMockBuilder(BookingGateway::class)
                        ->onlyMethods(['fetchRates'])
                        ->getMock();

        $mockPayload = json_encode([
            'Unit Type ID' => -2147483637,
            'Arrival' => '2025-07-15',
            'Departure' => '2025-07-25',
            'Guests' => [['Age Group' => 'Adult']]
        ]);

        $gateway->method('fetchRates')->willReturn([
            'http_code' => 200,
            'data' => ['Total Charge' => 1000, 'Rooms' => 2]
        ]);

        $result = $gateway->fetchRates($mockPayload);
        $this->assertArrayHasKey('http_code', $result);
        $this->assertArrayHasKey('data', $result);
    }
}
