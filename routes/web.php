<?php

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

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Authenticate;

use App\Http\Controllers\AccountsController;
use App\Http\Controllers\TransferFundsController;

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware('auth')->group(function () {
	
	Route::get('/account/index', [AccountsController::class, 'index'])->name('account-index');
	Route::post('/account/created',  [AccountsController::class, 'created'])->name('created');
	Route::get('/account/deposit', [AccountsController::class, 'deposit'])->name('deposit');
	Route::post('/account/deposited', [AccountsController::class, 'deposited'])->name('deposited');
	Route::get('/account/withdraw', [AccountsController::class, 'withdraw'])->name('withdraw');
	Route::post('/account/withdrawn', [AccountsController::class, 'withdrawn'])->name('withdrawn');
	Route::get('/account/overdraft/update', [AccountsController::class, 'updateOverdraftLimit'])->name('update');
	Route::post('/account/overdraft/updated',[AccountsController::class,'updatedOverdraftLimit'])->name('updated');
	Route::post('/account/closed',[AccountsController::class,'closed'])->name('closed');
	
	Route::get('/transfer/start', [TransferFundsController::class,'index'])->name('transfers-index');
	Route::post('/transfer/end', [TransferFundsController::class,'transfer'])->name('transfers-submitted');
}
