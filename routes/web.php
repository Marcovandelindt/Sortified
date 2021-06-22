<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if (!Auth::user()) {
        return redirect()->route('login');
    } else {
        return redirect()->route('home');
    }
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Auth::routes();

Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {
    Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
    Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
    Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
    Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);

    # Health routes
    Route::get('/health', [App\Http\Controllers\Health\HealthController::class, 'index'])->name('health.index');
    Route::get('/health/statistics', [App\Http\Controllers\Health\HealthStatisticsController::class, 'index'])->name('health.statistics');

    # Food and Drinks routes
    Route::get('/food-and-drinks', [App\Http\Controllers\FoodAndDrinks\FoodAndDrinksController::class, 'index'])->name('food.drinks');

    # Music routes
    Route::get('/music', [App\Http\Controllers\Music\MusicController::class, 'index'])->name('music.index');

    # Crypto routes
    Route::get('/crypto', [App\Http\Controllers\Crypto\CryptoController::class, 'index'])->name('crypto.index');

    # Journal routes
    Route::get('/journals', [App\Http\Controllers\Journals\JournalController::class, 'index'])->name('journals.index');

    # Books routes
    Route::get('/books', [App\Http\Controllers\Books\BooksController::class, 'index'])->name('books.index');

    # Games routes
    Route::get('/games', [App\Http\Controllers\Games\GamesController::class, 'index'])->name('games.index');

    # Calendar routes
    Route::get('/calendar', [App\Http\Controllers\Calendar\CalendarController::class, 'index'])->name('calendar.index');

    # Setting routes
    Route::get('/settings', [App\Http\Controllers\Settings\SettingController::class, 'index'])->name('settings.index');

    # Fitbit routes
    Route::get('/fitbit', [App\Http\Controllers\Fitbit\FitbitController::class, 'index'])->name('fitbit.index');
    Route::get('/fitbit/request-access-token', [App\Http\Controllers\Fitbit\FitbitRequestAccessTokenController::class, 'request'])->name('fitbit.access_token');

    # Manual actions
    Route::get('/health/update-walking-data', [App\Http\Controllers\Fitbit\FitbitController::class, 'updateWalkingData'])->name('walking.update');
    Route::get('/food-and-drinks/update-food', [App\Http\Controllers\Fitbit\FitbitController::class, 'updateFood'])->name('food.update');
    Route::get('/food-and-drinks/update-water', [App\Http\Controllers\Fitbit\FitbitController::class, 'updateWater'])->name('water.update');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('{page}', ['as' => 'page.index', 'uses' => 'App\Http\Controllers\PageController@index']);
});

