<?php

use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\TpvController;
use App\Http\Controllers\PreUserController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PageController;

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

Route::get('/terminos-y-condiciones', [PageController::class, 'terminos'])->name('terminos-y-condiciones');
Route::get('/politica-de-privacidad', [PageController::class, 'politica'])->name('politica-de-privacidad');

Route::get('/preusers/{user}', [PreUserController::class, 'show'])->name('preusers.show');
Route::post('/preusers/{user}', [PreUserController::class, 'update'])->name('preusers.update');

Route::get('/checkouts/{checkout}', [CheckoutController::class, 'show'])->name('checkouts');
Route::post('/checkouts/{checkout}', [CheckoutController::class, 'update'])->name('checkouts.update');

// TPV
Route::post('tpv/notify/{checkout}', [TpvController::class, 'notify'])->name('tpv.notify');
Route::get('tpv/success/{checkout}', [TpvController::class, 'success'])->name('tpv.success');
Route::get('tpv/error/{checkout}', [TpvController::class, 'error'])->name('tpv.error');

// Calendar
Route::get('/calendar/{product}', [CalendarController::class, 'show'])->name('calendar.show');

Auth::routes();

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('products', ProductController::class);
    Route::resource('registrations', RegistrationController::class);
    Route::post('registrations/status/{registration}', [RegistrationController::class, 'status'])->name('registrations.update-status');
    Route::resource('users', UserController::class);
    Route::resource('partners', PartnerController::class);
    Route::get('invoices', [InvoiceController::class, 'index'])->name('invoices.index');
    Route::get('invoices/export', [InvoiceController::class, 'export'])->name('invoices.export');
    Route::post('invoices/import', [InvoiceController::class, 'import'])->name('invoices.import');
});
