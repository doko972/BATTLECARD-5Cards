<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::prefix('admin')->name('admin.')->group(function () {

    //Get Camps datas
    Route::get('/camps', 'App\Http\Controllers\CampController@index')->name('camp.index');

    //Show Camp by Id
    Route::get('/camps/show/{id}', 'App\Http\Controllers\CampController@show')->name('camp.show');

    //Get Camps by Id
    Route::get('/camps/create', 'App\Http\Controllers\CampController@create')->name('camp.create');

    //Edit Camp by Id
    Route::get('/camps/edit/{id}', 'App\Http\Controllers\CampController@edit')->name('camp.edit');

    //Save new Camp
    Route::post('/camps/store', 'App\Http\Controllers\CampController@store')->name('camp.store');

    //Update One Camp
    Route::put('/camps/update/{camp}', 'App\Http\Controllers\CampController@update')->name('camp.update');

    //Update One Camp Speedly
    Route::put('/camps/speed/{camp}', 'App\Http\Controllers\CampController@updateSpeed')->name('camp.update.speed');

    //Delete Camp
    Route::delete('/camps/delete/{camp}', 'App\Http\Controllers\CampController@delete')->name('camp.delete');

});
Route::prefix('admin')->name('admin.')->group(function () {

    //Get Cards datas
    Route::get('/cards', 'App\Http\Controllers\CardController@index')->name('card.index');

    //Show Card by Id
    Route::get('/cards/show/{id}', 'App\Http\Controllers\CardController@show')->name('card.show');

    //Get Cards by Id
    Route::get('/cards/create', 'App\Http\Controllers\CardController@create')->name('card.create');

    //Edit Card by Id
    Route::get('/cards/edit/{id}', 'App\Http\Controllers\CardController@edit')->name('card.edit');

    //Save new Card
    Route::post('/cards/store', 'App\Http\Controllers\CardController@store')->name('card.store');

    //Update One Card
    Route::put('/cards/update/{card}', 'App\Http\Controllers\CardController@update')->name('card.update');

    //Update One Card Speedly
    Route::put('/cards/speed/{card}', 'App\Http\Controllers\CardController@updateSpeed')->name('card.update.speed');

    //Delete Card
    Route::delete('/cards/delete/{card}', 'App\Http\Controllers\CardController@delete')->name('card.delete');

});
Route::prefix('admin')->name('admin.')->group(function () {

    //Get Games datas
    Route::get('/games', 'App\Http\Controllers\GameController@index')->name('game.index');

    //Show Game by Id
    Route::get('/games/show/{id}', 'App\Http\Controllers\GameController@show')->name('game.show');

    //Get Games by Id
    Route::get('/games/create', 'App\Http\Controllers\GameController@create')->name('game.create');

    //Edit Game by Id
    Route::get('/games/edit/{id}', 'App\Http\Controllers\GameController@edit')->name('game.edit');

    //Save new Game
    Route::post('/games/store', 'App\Http\Controllers\GameController@store')->name('game.store');

    //Update One Game
    Route::put('/games/update/{game}', 'App\Http\Controllers\GameController@update')->name('game.update');

    //Update One Game Speedly
    Route::put('/games/speed/{game}', 'App\Http\Controllers\GameController@updateSpeed')->name('game.update.speed');

    //Delete Game
    Route::delete('/games/delete/{game}', 'App\Http\Controllers\GameController@delete')->name('game.delete');

    Route::post('/games/{id}/join', 'App\Http\Controllers\GameController@join')->name('game.join');
    Route::get('/games/{id}/play', 'App\Http\Controllers\GameController@play')->name('game.play');
    Route::get('/games/{id}/spectate', 'App\Http\Controllers\GameController@spectate')->name('game.spectate');

});
Route::prefix('admin')->name('admin.')->group(function () {

    //Get Gamedecks datas
    Route::get('/gamedecks', 'App\Http\Controllers\GamedeckController@index')->name('gamedeck.index');

    //Show Gamedeck by Id
    Route::get('/gamedecks/show/{id}', 'App\Http\Controllers\GamedeckController@show')->name('gamedeck.show');

    //Get Gamedecks by Id
    Route::get('/gamedecks/create', 'App\Http\Controllers\GamedeckController@create')->name('gamedeck.create');

    //Edit Gamedeck by Id
    Route::get('/gamedecks/edit/{id}', 'App\Http\Controllers\GamedeckController@edit')->name('gamedeck.edit');

    //Save new Gamedeck
    Route::post('/gamedecks/store', 'App\Http\Controllers\GamedeckController@store')->name('gamedeck.store');

    //Update One Gamedeck
    Route::put('/gamedecks/update/{gamedeck}', 'App\Http\Controllers\GamedeckController@update')->name('gamedeck.update');

    //Update One Gamedeck Speedly
    Route::put('/gamedecks/speed/{gamedeck}', 'App\Http\Controllers\GamedeckController@updateSpeed')->name('gamedeck.update.speed');

    //Delete Gamedeck
    Route::delete('/gamedecks/delete/{gamedeck}', 'App\Http\Controllers\GamedeckController@delete')->name('gamedeck.delete');

    Route::get('/deck-builder', 'App\Http\Controllers\GamedeckController@deckBuilder')->name('gamedeck.deck-builder');
});