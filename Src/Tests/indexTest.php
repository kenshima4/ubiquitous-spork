<?php
use PHPUnit\Framework\TestCase;

class IndexTest extends TestCase
{
    public function testIndexReturns404ForUnknownUri()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/unknown';
        ob_start();
        include_once __DIR__ . '/../../source/php/index.php'; //NOSONAR
        $output = ob_get_clean();
        $this->assertEmpty($output); // 404 header, no output
    }
}
