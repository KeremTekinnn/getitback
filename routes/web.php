<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RideController;
use App\Http\Controllers\InvoiceController;

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

Route::get('/ride-create', [RideController::class, 'create'])->name('ride.create');
Route::post('/ride-create', [RideController::class, 'store'])->name('ride.store');
Route::post('/ride/get-ride-information', [RideController::class, 'getRideInformation'])->name('ride.get_ride_information');
Route::get('/ride-payment', [RideController::class, 'createPayment'])->name('ride.payment');

Route::get('/invoice/download/{ride}', [InvoiceController::class, 'download'])->name('invoice.download');
Route::get('/invoice/email/{ride}', [InvoiceController::class, 'sendInvoiceEmail'])->name('invoice.email');

require __DIR__.'/auth.php';
