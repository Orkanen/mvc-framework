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
    public function index($message=null)
    {
        return view('dice', [
            'message' => $message ?? "0"
        ]);
    }

    public function postIndex(Request $request)
    {

      $die = new Dice();
      $dice = new DiceGraphic();
      $diceHand = new DiceHand(1);
      $diceHand->roll();

      $validated = $request->title + $diceHand->getSum();
      return view('dice', [
          'message' => $message ?? $validated
      ]);
    }
}
