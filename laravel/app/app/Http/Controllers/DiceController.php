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
        session(['die' => serialize($die),
            'dice' => serialize($dice),
            'diceHand' => serialize($diceHand)
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
      //$previousRoll = $diceHand->getSum();
      $diceHand->roll();
      $previousRoll = $diceHand->getRollSum();
      $validated = $diceHand->getSum();
      if($previousRoll > 21) {
          $previousRoll = "You Lose";
          $diceHand->setRollSum();
      }

      session()->put('die', serialize($die));
      session()->put('dice', serialize($dice));
      session()->put('diceHand', serialize($diceHand));
      session()->save();

      return view('dice', [
          'message' => $validated,
          'previousRoll' => $previousRoll ?? null
      ]);
    }
}
