<?php

use App\Http\Controllers\Web\WebController;
use Illuminate\Support\Facades\Route;


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

Route::get('/reset-password', function () {
    return view('reset-password');
});

Route::post('/reset-password', [WebController::class, 'resetPassword'])->name('reset.password');
