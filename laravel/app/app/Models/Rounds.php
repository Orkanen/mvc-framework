<?php

namespace App\Models;

//use function Mos\Functions\{
//    destroySession,
//    redirectTo,
//    renderView,
//    renderTwigView,
//    sendResponse,
//    url
//};

/**
 * Class Dice.
 */
class Rounds
{
    private array $dices;
    private int $sum = 0;
    private string $roundHand = "";
    private int $roundsDone = 0;

    public function __construct()
    {
        $this->dices[0] = new Dice();
    }

    public function roboRoll()
    {
        $this->sum += $this->dices[0]->roll();
    }

    public function curRoll(int $human = 0)
    {
        for ($this->sum; $this->sum <= $human;) {
            $this->sum += $this->dices[0]->roll();
        };
    }

    public function roboSum()
    {
        return $this->sum;
    }

    public function addRound(int $adding = 0)
    {
        $this->roundsDone += $adding;
    }

    public function addRoundHand(string $adding = "")
    {
        $this->roundHand .= $adding;
    }

    public function getRoundHand()
    {
        return $this->roundHand;
    }

    public function rolledRounds()
    {
        return $this->roundsDone;
    }
}
