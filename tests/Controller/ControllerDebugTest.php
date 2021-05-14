<?php

declare(strict_types=1);

namespace Fian\Controller;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

/**
 * Test cases for the controller Debug.
 */
class ControllerDebugTest extends TestCase
{
    /**
     * Try to create the controller class.
     */
    public function testCreateTheControllerClass()
    {
        $controller = new Debug();
        $this->assertInstanceOf("\Fian\Controller\Debug", $controller);
    }

    /**
     * Check that the controller returns a response.
     */
    public function testControllerReturnsResponse()
    {
        $controller = new Debug();
        //$testDummy = 1;

        $exp = "\Psr\Http\Message\ResponseInterface";
        $res = $controller();
        $this->assertInstanceOf($exp, $res);
        //$this->assertEquals(1, $testDummy);
    }
}
