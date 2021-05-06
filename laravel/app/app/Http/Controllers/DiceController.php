<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Dice;
use App\Models\DiceHand;
use App\Models\DiceGraphic;
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
        $rounds = new Rounds();
        session(['die' => serialize($die),
            'dice' => serialize($dice),
            'diceHand' => serialize($diceHand),
            'rounds' => serialize($rounds)
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
      $rounds = unserialize(session()->pull('rounds'));
      //$previousRoll = $diceHand->getSum();
      if ($request->amount == "stop") {
          $rounds->curRoll($diceHand->getRollSum());
          $robotRolled = $rounds->roboSum();
          if ($robotRolled < 22 && $robotRolled > $diceHand->getRollSum()) {
              $previousRoll = "You Lose";
          } else {
              $previousRoll = "You Win";
          }
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
              $diceHand->setRollSum();
          } elseif ($previousRoll == 21) {
              $previousRoll = "You Win";
              $diceHand->setRollSum();
          }
      }

      session()->put('die', serialize($die));
      session()->put('dice', serialize($dice));
      session()->put('diceHand', serialize($diceHand));
      session()->put('rounds', serialize($rounds));
      session()->save();

      return view('dice', [
          'message' => $validated ?? null,
          'previousRoll' => $previousRoll ?? null,
          'roboRoll' => $robotRolled ?? null
      ]);
    }
}
