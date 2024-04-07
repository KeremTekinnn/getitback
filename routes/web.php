<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\RideController;
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
    $role = auth()->user()->role;
    return view($role . '.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/create', [RideController::class, 'create'])->name('ride.create');;
Route::post('/checkout', [RideController::class, 'checkout'])->name('checkout');;
Route::get('/success', [RideController::class, 'success'])->name('success');;

Route::get('/invoice/download/{ride}', [InvoiceController::class, 'download'])->name('invoice.download');
Route::get('/invoice/email/{ride}', [InvoiceController::class, 'sendInvoiceEmail'])->name('invoice.email');

require __DIR__.'/auth.php';
