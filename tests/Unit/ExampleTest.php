<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

use App\Models\Dice;
use App\Models\DiceHand;
use App\Models\DiceGraphic;
use App\Models\Game;
use App\Models\Rounds;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_example()
    {
    	$dice = new Dice();
    	$dice->roll();
        $this->assertGreaterThan(0, $dice->getLastRoll());
    }

        public function test_example2()
    {
    	$orange = "3";
        $this->assertEquals($orange, "3");
    }
}
