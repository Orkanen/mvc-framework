<?php

declare(strict_types=1);

namespace Fian\Controller;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

/*

class ControllerDebugTest extends TestCase
{

    public function testCreateTheControllerClass()
    {
        $controller = new Debug();
        $this->assertInstanceOf("\Fian\Controller\Debug", $controller);
    }


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
