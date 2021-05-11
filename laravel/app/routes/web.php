<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HelloWorldController;
use App\Http\Controllers\YatzyView;
use App\Http\Controllers\DiceController;
use App\Http\Controllers\PizzaController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|

Route::get('/', function () {
    return view('');
});
*/

// Added for mos example code
Route::get('/hello-world', function () {
    echo "Hello World";
});
Route::get('/', function () {
    return view('message', [
        'message' => "Hello World from within a view"
    ]);
});
Route::get('/hello', [HelloWorldController::class, 'hello']);
Route::get('/hello/{message}', [HelloWorldController::class, 'hello']);

Route::get('/yatzy', [YatzyView::class, 'index']);
Route::get('/yatzy/destroy', [YatzyView::class, 'destroy']);
Route::get('/yatzy/firstRoll', [YatzyView::class, 'firstRoll']);
Route::post('/yatzy/firstRoll', [YatzyView::class, 'reRoll']);

Route::get('/dice', [DiceController::class, 'index']);
//Route::get('/dice/{message}', [DiceController::class, 'index']);
Route::post('/dice/roll', [DiceController::class, 'postIndex']);
Route::get('/dice/score', [DiceController::class, 'highScore']);

Route::get('/pizzas', [PizzaController::class, 'index']);
Route::get('/pizzas/create', [PizzaController::class, 'create']);
Route::get('/pizzas/{id}', [PizzaController::class, 'show']);
