<?php
use PHPUnit\Framework\TestCase;

class BootstrapTest extends TestCase
{
    public function testEnvIsLoaded()
    {
        require_once __DIR__ . '/../Php/bootstrap.php'; //NOSONAR
        $this->assertArrayHasKey('EXTERNALAPI', $_ENV);
    }
}
