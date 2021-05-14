<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_example()
    {
    	$orange = "1";
        $this->assertEquals($orange, "1");
    }

        public function test_example2()
    {
    	$orange = "3";
        $this->assertEquals($orange, "3");
    }
}
