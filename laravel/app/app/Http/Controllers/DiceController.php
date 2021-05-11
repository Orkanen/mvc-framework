<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Dice;
use App\Models\DiceHand;
use App\Models\DiceGraphic;
use App\Models\Game;
use App\Models\Rounds;

class DiceController extends Controller
{
    /**
     * Display a message.
     *
     * @param  string  $message
     * @return \Illuminate\View\View
     */
    public function index()
    {
        //session()->forget('key', 'die', 'dice', 'diceHand');
        $die = new Dice();
        $dice = new DiceGraphic();
        $diceHand = new DiceHand(1);
        $game = new Game();
        session(['die' => serialize($die),
            'dice' => serialize($dice),
            'diceHand' => serialize($diceHand),
            'game' => serialize($game)
        ]);
        return view('dice', [
            'message' => $message ?? "0"
        ]);
    }

    public function postIndex(Request $request)
    {
      $die = unserialize(session()->pull('die'));
      $dice = unserialize(session()->pull('dice'));
      $diceHand = unserialize(session()->pull('diceHand'));
      $game = unserialize(session()->pull('game'));
      //$previousRoll = $diceHand->getSum();
      if ($request->amount == "stop") {
          $game->curRoll($diceHand->getRollSum());
          $robotRolled = $game->roboSum();
          if ($robotRolled < 22 && $robotRolled > $diceHand->getRollSum()) {
              $previousRoll = "You Lose";
              $game->score(0, 1);
          } else {
              $previousRoll = "You Win";
              $game->score(1, 0);
          }
          $game->addRound();
          $diceHand->setRollSum();
      } else {
          if ($request->amount == "dice1") {
              $diceHand->createDice();
          } else {
              $diceHand->createDice(1);
          }
          $diceHand->roll();
          $previousRoll = $diceHand->getRollSum();
          $validated = $diceHand->getSum();

          if ($previousRoll > 21) {
              $previousRoll = "You Lose";
              $game->score(0, 1);
              $diceHand->setRollSum();
              $game->addRound();
          } elseif ($previousRoll == 21) {
              $previousRoll = "You Win";
              $game->score(1, 0);
              $diceHand->setRollSum();
              $game->addRound();
          }
      }
      $currentScore = $game->score(0, 0);
      $gamePlayed = $game->rolledGame();

      session()->put('die', serialize($die));
      session()->put('dice', serialize($dice));
      session()->put('diceHand', serialize($diceHand));
      session()->put('game', serialize($game));
      session()->save();

      $roundsDb = Rounds::find(1);
      if ($roundsDb == null) {
          $roundsDb = Rounds::where('id', 1)->updateOrCreate([
              'rounds' => "1",
              'score' => $currentScore,
          ]);
      } else {
          $roundsDb->rounds = "1";
          $roundsDb->score = $currentScore;
      }
      $roundsDb->save();

      return view('dice', [
          'message' => $validated ?? null,
          'previousRoll' => $previousRoll ?? null,
          'roboRoll' => $robotRolled ?? null,
          'gamePlayed' => $gamePlayed ?? null,
          'currentScore' => $currentScore ?? null
      ]);
    }

    public function highScore() {

        $rounds = Rounds::find(1);

        return view('message', [
            'message' => $rounds->score,
        ]);
    }
}
