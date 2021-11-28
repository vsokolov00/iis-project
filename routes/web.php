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

Route::get('/auction/${id}', [App\Http\Controllers\AuctionController::class, 'index'])->name('auctionDetail');
Route::post('/auction/bid', [App\Http\Controllers\AuctionController::class, 'bid'])->name('makeBid');
Route::get('/auction/${id}/register', [App\Http\Controllers\AuctionController::class, 'register'])->name('registerToAuction');
Route::get('/auction/time', [App\Http\Controllers\AuctionController::class, 'time'])->name('getTime');

Route::get('/user/auctions', [App\Http\Controllers\UserAuctionsController::class, 'index'])->name('userAuctions');
Route::post('/user/auctions', [App\Http\Controllers\UserAuctionsController::class, 'updateAuction'])->name('userAuctions');
Route::get('/user/auctions/won', [App\Http\Controllers\UserAuctionsController::class, 'wonAuctions'])->name('wonAuctions');

Route::get('/auctions/approval', [App\Http\Controllers\AuctionApprovalController::class, 'index'])->name('auctionApproval');
Route::post('/auctions/approval', [App\Http\Controllers\AuctionApprovalController::class, 'updateAuction'])->name('auctionApproval');
Route::get('/auctions/approved-by-you', [App\Http\Controllers\AuctionApprovalController::class, 'approvedByYou'])->name('approvedByYou');
Route::post('/auctions/approved-by-you', [App\Http\Controllers\AuctionApprovalController::class, 'handleNewRegisteredUser'])->name('approvedByYou');
Route::post('/auction/approve', [App\Http\Controllers\AuctionApprovalController::class, 'approveAuction'])->name('approveAuction');
Route::post('/auctions/invalidate', [App\Http\Controllers\AuctionApprovalController::class, 'invalidateAuction'])->name('invalidateAuction');

Route::get('auctions/selling', [App\Http\Controllers\AllAuctionsController::class, 'sellingAuctions'])->name('sellingAuctions');
Route::get('auctions/buying', [App\Http\Controllers\AllAuctionsController::class, 'buyingAuctions'])->name('buyingAuctions');
Route::get('auctions/closest', [App\Http\Controllers\AllAuctionsController::class, 'closestAuctions'])->name('closestAuctions');
Route::get('auctions/active', [App\Http\Controllers\AllAuctionsController::class, 'activeAuctions'])->name('activeAuctions');
Route::get('auctions/i-bid-on', [App\Http\Controllers\AllAuctionsController::class, 'userTakesPartIn'])->name('userTakesPartIn');

Route::get('auction/{id}/status/price', [App\Http\Controllers\PriceController::class, 'index'])->name('auctionPrice');

Route::get('users', [App\Http\Controllers\UserListController::class, 'index'])->name('userList');
Route::post('users', [App\Http\Controllers\UserListController::class, 'triggerToggle'])->name('userList');
Route::delete('users', [App\Http\Controllers\UserListController::class, 'deleteUser'])->name('deleteUser');

Route::get('images/{filename}', [App\Http\Controllers\ImageDisplayController::class, 'displayImage'])->name('image.displayImage');
