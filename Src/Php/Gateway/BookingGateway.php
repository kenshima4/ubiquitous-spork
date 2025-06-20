<?php
namespace Php\Gateway;

require_once __DIR__ . '/../bootstrap.php'; //NOSONAR

class BookingGateway {

    private $url;

    public function __construct()
    {
        $this->url = $_ENV["EXTERNALAPI"] ? : "External URL Not Found";
    }

    public function fetchRates($payload)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_errno($ch)) {
            return ['error' => curl_error($ch)];
        }

        curl_close($ch);

        return [
            'http_code' => $httpCode,
            'data' => json_decode($response, true)
        ];
    }
}
