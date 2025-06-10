<?php
namespace Src\Gateway;

class BookingGateway {

    private $url;

    public function __construct()
    {
        $this->url = getenv("URL") ?: "External URL Not Found";
    }

    public function fetchRates($payload)
    {
        $ch = curl_init($this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
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
