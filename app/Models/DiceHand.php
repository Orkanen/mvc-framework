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
//use Fian\Dice\DiceGraphic;
/**
 * Class Dice.
 */
class DiceHand
{
    public array $dices;
    private int $sum = 0;
    private int $rollSum = 0;
    private int $amount = 1;

    public function __construct(int $die = 1)
    {
        $this->amount = $die;
        for ($i = 0; $i <= $this->amount; $i++) {
            $this->dices[$i] = new DiceGraphic();
        }
    }

    public function createDice(int $die = 0)
    {
        $this->amount = $die;
        for ($i = 0; $i <= $this->amount; $i++) {
            $this->dices[$i] = new DiceGraphic();
        }
    }

    public function roll()
    {
        //this!!
        $this->sum = 0;
        for ($i = 0; $i <= $this->amount; $i++) {
            $this->sum += $this->dices[$i]->roll();
        }
        $this->rollSum += $this->sum;
    }

    public function getDice(array $options)
    {
        //echo(json_encode($options));
        for ($i = 0; $i < 5;) {
            $temp = $options[$i];
            //echo($temp);
            if ($temp != null) {
                //echo($this->dices[$temp]);
                $this->dices[$temp]->roll();
            }
            $i += 1;
        }
    }

    public function getLastRoll(): string
    {
        $res = "";
        for ($i = 0; $i <= $this->amount; $i++) {
            $res .= $this->dices[$i]->getLastRoll() . ", ";
        }

        return $res . " = " . $this->sum;
    }

    public function getSum(): int
    {
        return $this->sum;
    }

    public function getRollSum(): int
    {
        return $this->rollSum;
    }

    public function setRollSum()
    {
        $this->rollSum = 0;
    }

/*
    public function getDiceHand(): string
    {
        $res = "";
        for ($i = 0; $i <= $this->amount; $i++) {
            $res .= $this->dices[$i] . ", ";
        }
        return $res;
    }
*/
    public function printRoll(): string
    {
        $res = "<p class='dice-utf8'>";
        for ($i = 0; $i <= $this->amount; $i++) {
            $res .= "<i class=" . $this->dices[$i]->graphic() . "></i>";
        }

        return $res . "</p>";
    }
}
