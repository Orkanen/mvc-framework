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
class Game
{
    private array $dices;
    private int $sum = 0;
    private string $roundHand = "";
    private int $gameDone = 0;
    private int $robotScore = 0;
    private int $humanScore = 0;

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
        $this->sum = 0;
        for ($this->sum; $this->sum <= $human;) {
            $this->sum += $this->dices[0]->roll();
        };
    }

    public function roboSum()
    {
        return $this->sum;
    }

    public function addRound(int $adding = 1)
    {
        $this->gameDone += $adding;
    }

    public function addRoundHand(string $adding = "")
    {
        $this->roundHand .= $adding;
    }

    public function getRoundHand()
    {
        return $this->roundHand;
    }

    public function rolledGame()
    {
        return $this->gameDone;
    }

    public function score($human = 0, $robot = 0)
    {
        $this->humanScore += $human;
        $this->robotScore += $robot;
        $final = ("Human Score: " . $this->humanScore .
        "/ Computer Score: " . $this->robotScore);
        return $final;
    }
}
