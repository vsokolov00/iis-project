<?php

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

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/auction/new', [App\Http\Controllers\CreateAuctionFormController::class, 'index'])->name('newAuction');
Route::post('/auction/new', [App\Http\Controllers\CreateAuctionFormController::class, 'create'])->name('newAuction');

Route::get('profile', [App\Http\Controllers\EditUserController::class, 'index'])->name('profile');
Route::post('profile', [App\Http\Controllers\EditUserController::class, 'updateProfile'])->name('profile');

Route::get('/user/auctions', [App\Http\Controllers\UserAuctionsController::class, 'index'])->name('userAuctions');
Route::post('/user/auctions', [App\Http\Controllers\UserAuctionsController::class, 'updateAuction'])->name('userAuctions');

Route::get('allAuctions', [App\Http\Controllers\AllAuctionsController::class, 'index'])->name('allAuctions');
