<?php

use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PartnerController;

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
    return redirect()->route('login');
});

Route::get('/checkouts/{checkout}', [CheckoutController::class, 'show'])->name('checkouts');
Route::post('/checkouts/{checkout}', [CheckoutController::class, 'update'])->name('checkouts.update');

require __DIR__.'/auth.php';

Auth::routes();

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('products', ProductController::class);
    Route::resource('registrations', RegistrationController::class);
    Route::post('registrations/status/{registration}', [RegistrationController::class, 'status'])->name('registrations.update-status');
    Route::resource('users', UserController::class);
    Route::resource('partners', PartnerController::class);
    Route::get('invoices', [FinancialController::class, 'index'])->name('invoices.index');
    Route::get('invoices/export', [FinancialController::class, 'export'])->name('invoices.export');
    Route::post('invoices/import', [FinancialController::class, 'import'])->name('invoices.import');
});
