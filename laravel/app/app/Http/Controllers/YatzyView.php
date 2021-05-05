<?php
/*
namespace Fian\Http\Controllers;

use Psr\Http\Message\ResponseInterface;

use function Fian\Functions\renderTwigView;
*/

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
/*
use function Fian\Http\Functions\{
    destroySession,
    renderView,
    url,
    getRoutePath,
    objectCreator,
    yatzy,
    gameOver
};
*/
use App\Models\Dice;
use App\Models\DiceHand;
use App\Models\DiceGraphic;
use App\Models\Rounds;

function objectCreator()
{
    $die = new Dice();
    $dice = new DiceGraphic();
    $diceHand = new DiceHand(4);
    $_SESSION['diceHand'] = serialize($diceHand);
    $_SESSION['die'] = serialize($die);
    $_SESSION['dice'] = serialize($dice);
    if (!isset($_SESSION['rounds'])) {
        $rounds = new Rounds();
        $_SESSION['rounds'] = serialize($rounds);
    }
}

function yatzy($givenOption = "none", $reRollDice = null): void
{
    $gDie = unserialize($_SESSION['die']);
    $gDice = unserialize($_SESSION['dice']);
    $diceHand = unserialize($_SESSION['diceHand']);

    if ($givenOption == "roll") {
        $diceHand->roll();
        $_SESSION["testing"] = $diceHand->printRoll();
    } else if ($givenOption == "none") {
        $diceHand->getDice($reRollDice);
        $_SESSION["testing2"] = $diceHand->printRoll();
    }

    $_SESSION["diceHand"] = serialize($diceHand);
    $_SESSION["dice"] = serialize($gDice);
    $_SESSION["die"] = serialize($gDie);
}

function gameOver()
{
    unserialize($_SESSION['die']);
    unserialize($_SESSION['dice']);
    $diceHand = unserialize($_SESSION['diceHand']);
    $rounds = unserialize($_SESSION['rounds']);
    if ($rounds->rolledRounds() < 6) {
        $rounds->addRound(1);
        $rounds->addRoundHand($diceHand->printRoll());
    }
    $sum = $rounds->rolledRounds();
    $_SESSION['rounds'] = serialize($rounds);
    return $sum;
}

class YatzyView extends Controller
{
    #use ControllerTrait;

    public function index()
    {
        $data = null;
        $url = url("/yatzy/firstRoll");
        if (isset($_SESSION["gameCounter"]) && $_SESSION["gameCounter"] == 4) {
            $url = url("/yatzy/firstRoll");
            $url2 = url("/yatzy/destroy");
            $gameOver = gameOver();
            if ($gameOver > 5) {
                $rounds = unserialize($_SESSION['rounds']);
                $diceRolls = $rounds->getRoundHand();
                $data = [
                    "header" => "Yatzy page",
                    "message" => "Game Over",
                    "dice" => $diceRolls,
                    "form" => "<a href=$url2>New Game</a>",
                    "url" => $url
                ];
            }
        } else {
            $data = [
                "header" => "Yatzy page",
                "message" => "YATZY!.",
                "rollDice" => "<a href=$url>Roll</a>",
                "message" => "Test message"
            ];
        }

        return view("yatzy", $data);
    }

    public function firstRoll()
    {

        $_SESSION["gameCounter"] = 1;
        objectCreator();
        //$objectHold = $_SESSION['diceHand'];
        //$_SESSION["diceHand"] = $diceHand;
        $tempHolder = "roll";
        yatzy($tempHolder);

        $form = "<input type='checkbox' name='amount1' value='0'> Roll Dice 1<br>
                <input type='checkbox' name='amount2' value='1'> Roll Dice 2<br>
                <input type='checkbox' name='amount3' value='2'> Roll Dice 3<br>
                <input type='checkbox' name='amount4' value='3'> Roll Dice 4<br>
                <input type='checkbox' name='amount5' value='4'> Roll Dice 5<br>
                <input type='submit' name='submit' value='Roll'/>";

        $hold = "<input type='submit' name='reset' value='Hold'/>";

        $url = url("/yatzy/roll");

        $data = [
            "header" => "Yatzy page",
            "message" => "A ROLL WAS MADE",
            "dice" => $_SESSION["testing"],
            "form" => $form,
            "hold" => $hold,
            "url" => $url
        ];

        return view("yatzy", $data);
        //return $this->redirect(url("/yatzy"));
    }

    public function reRoll(): ResponseInterface
    {
        $_SESSION["gameCounter"] += 1;
        $holdStatus = $_POST["reset"] ?? null;
        if ($holdStatus == "Hold") {
            $_SESSION["gameCounter"] = 4;
        }

        $dice1 = $_POST["amount1"] ?? null;
        $dice2 = $_POST["amount2"] ?? null;
        $dice3 = $_POST["amount3"] ?? null;
        $dice4 = $_POST["amount4"] ?? null;
        $dice5 = $_POST["amount5"] ?? null;
        $reRollDice = [$dice1, $dice2, $dice3, $dice4, $dice5];

        $tempHolder = "none";

        yatzy($tempHolder, $reRollDice);
        $url = url("/yatzy/roll");
        $form = "<input type='checkbox' name='amount1' value='0'> Roll Dice 1<br>
                <input type='checkbox' name='amount2' value='1'> Roll Dice 2<br>
                <input type='checkbox' name='amount3' value='2'> Roll Dice 3<br>
                <input type='checkbox' name='amount4' value='3'> Roll Dice 4<br>
                <input type='checkbox' name='amount5' value='4'> Roll Dice 5<br>
                <input type='submit' name='submit' value='Roll'>";

        $hold = "<input type='submit' name='reset' value='Hold'/>";

        $data = [
            "header" => "Yatzy page",
            "message" => "Re-rolled",
            "dice" => $_SESSION["testing2"],
            "form" => $form,
            "hold" => $hold,
            "url" => $url
        ];
        if ($_SESSION["gameCounter"] == 4) {
            $url = url("/yatzy/firstRoll");
            $url2 = url("/yatzy/destroy");
            $gameOver = gameOver();
            if ($gameOver > 5) {
                $rounds = unserialize($_SESSION['rounds']);
                $diceRolls = $rounds->getRoundHand();
                $data = [
                    "header" => "Yatzy page",
                    "message" => "Game Over",
                    "dice" => $diceRolls,
                    "form" => "<a href=$url2>New Game</a>",
                    "url" => $url
                ];
            } else {
                $data = [
                    "header" => "Yatzy page",
                    "message" => "Game Over",
                    "dice" => $gameOver,
                    "form" => "<a href=$url>Roll</a>",
                    "url" => $url
                ];
            }
        }


        $body = renderView("layout/yatzy.php", $data);
        return $this->response($body);
    }

    public function destroy(): ResponseInterface
    {
        destroySession();
        return $this->redirect(url("/yatzy"));
    }
}
