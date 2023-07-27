<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
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

Auth::routes();
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::prefix('user')->middleware('auth')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('user');
    Route::get('/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::patch('/update/{user}', [UserController::class, 'update'])->name('user.update');
});

Route::prefix('account')->middleware('auth')->group(function () {
    Route::get('/{account}', [AccountController::class, 'show'])->name('account.show');
    Route::get('/', [AccountController::class, 'create'])->name('account.create');
    Route::post('/', [AccountController::class, 'store'])->name('account.store');
    Route::get('/edit/{account}', [AccountController::class, 'edit'])->name('account.edit');
    Route::patch('/{account}', [AccountController::class, 'update'])->name('account.update');
    Route::delete('/{account}', [AccountController::class, 'destroy'])->name('account.destroy');
});

Route::prefix('transaction')->middleware('auth')->group(function () {
    Route::get('/', [TransactionController::class, 'index'])->name('transaction.index');
    Route::get('/create', [TransactionController::class, 'create'])->name('transaction.create');
    Route::get('/{transaction}', [TransactionController::class, 'show'])->name('transaction.show');
    Route::get('/edit/{transaction}', [TransactionController::class, 'edit'])->name('transaction.edit');
    Route::post('/', [TransactionController::class, 'store'])->name('transaction.store');
    Route::patch('/{transaction}', [TransactionController::class, 'update'])->name('transaction.update');
    Route::delete('/{transaction}', [TransactionController::class, 'destroy'])->name('transaction.destroy');
});

Route::prefix('currency')->middleware('auth')->group(function () {
    Route::get('/', [CurrencyController::class, 'index'])->name('currency.index');
    Route::patch('/{user}', [CurrencyController::class, 'update'])->name('currency.update');
//    Route::get('/create', [TransactionController::class, 'create'])->name('transaction.create');
//    Route::get('/{transaction}', [TransactionController::class, 'show'])->name('transaction.show');
//    Route::get('/edit/{transaction}', [TransactionController::class, 'edit'])->name('transaction.edit');
//    Route::post('/', [TransactionController::class, 'store'])->name('transaction.store');
});
