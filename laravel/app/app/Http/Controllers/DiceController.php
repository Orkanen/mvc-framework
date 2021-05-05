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
        session()->forget('key', 'die', 'dice', 'diceHand');
        $die = new Dice();
        $dice = new DiceGraphic();
        $diceHand = new DiceHand(1);
        session(['die' => $die,
            'dice' => $dice,
            'diceHand' => $diceHand
        ]);
        return view('dice', [
            'message' => $message ?? "0"
        ]);
    }

    public function postIndex(Request $request)
    {
      $die = session('die');
      $dice = session('dice');
      $diceHand = session('diceHand');
      $previousRoll = $request->session()->all();
      //$previousRoll = $diceHand->getLastRoll();
      $diceHand->roll();

      $validated = $request->title + $diceHand->getSum();
      return view('dice', [
          'message' => $validated,
          'previousRoll' => $previousRoll ?? null
      ]);
    }
}
