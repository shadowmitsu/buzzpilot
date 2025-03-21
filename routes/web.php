<?php

use App\Http\Controllers\CategoryServiceController;
use App\Http\Controllers\ChaiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PaymentAccountController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TransactionDepositController;
use App\Http\Controllers\TransactionServiceController;
use App\Http\Controllers\UserDepositController;
use App\Http\Controllers\UserTransactionController;
use App\Http\Controllers\WebsiteSettingController;
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
    return view('auth.login');
});

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register.page');
Route::post('/register', [RegisterController::class, 'register'])->name('register.process');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.process');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/import-services', [ServiceController::class, 'importServices'])->name('importServices');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/users/transactions', [UserTransactionController::class, 'index'])->name('users.transactions.index');
    Route::get('/users/transactions/create', [UserTransactionController::class, 'create'])->name('users.transactions.create');
    Route::post('/users/transactions/store', [UserTransactionController::class, 'storeTransaction'])->name('users.transactions.storeTransaction');

    Route::get('/users/deposit', [UserDepositController::class, 'index'])->name('user.deposit.index');
    Route::get('/users/deposit/channels', [UserDepositController::class, 'channels'])->name('user.deposit.channels');
    Route::get('/users/deposit/{a}/create', [UserDepositController::class, 'create'])->name('user.deposit.create');
    Route::get('/users/deposit/{a}/detail', [UserDepositController::class, 'detail'])->name('user.deposit.detail');
    Route::post('/users/deposit/store', [UserDepositController::class, 'storeDeposit'])->name('user.deposit.storeDeposit');
    
    Route::get('/get-payment-account/{paymentId}', function($paymentId) {
        $account = \App\Models\PaymentAccount::where('payment_id', $paymentId)
            ->where('is_active', 1)
            ->first();
    
        return response()->json([
            'account' => $account
        ]);
    });

    
    Route::get('/get-services/{a}', [UserTransactionController::class, 'getServicesByCategory'])->name('users.transactions.getServicesByCategory');
    Route::middleware(['role:superadmin'])->group(function () {
        Route::get('/service-categories', [CategoryServiceController::class, 'index'])->name('service_categories.index');
        Route::post('/category-services/bulk-delete', [CategoryServiceController::class, 'bulkDelete'])->name('category-services.bulk-delete');
        Route::post('/category-services/delete/{id}', [CategoryServiceController::class, 'delete'])->name('category-services.delete');
        Route::post('/category-services/toggle-status/{id}', [CategoryServiceController::class, 'toggleStatus'])->name('category-services.toggle-status');


        Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
        Route::get('/services/{a}/detail', [ServiceController::class, 'detail'])->name('services.detail');
        Route::put('/services/{id}', [ServiceController::class, 'update'])->name('services.update');

        Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
        Route::post('/payments/store', [PaymentController::class, 'store'])->name('payments.store');
        Route::put('/payments/{a}/update', [PaymentController::class, 'update'])->name('payments.update');
        Route::delete('/payments/{a}/destroy', [PaymentController::class, 'destroy'])->name('payments.destroy');


        Route::get('/payment-accounts', [PaymentAccountController::class, 'index'])->name('payment_accounts.index');
        Route::post('/payment-accounts/store', [PaymentAccountController::class, 'store'])->name('payment_accounts.store');
        Route::put('/payment-accounts/{a}/update', [PaymentAccountController::class, 'update'])->name('payment_accounts.update');
        Route::delete('/payment-accounts/{a}/destroy', [PaymentAccountController::class, 'destroy'])->name('payment_accounts.destroy');

        Route::get('/transaction/deposits', [TransactionDepositController::class, 'index'])->name('transactions.deposits.index');
        Route::patch('/transaction/deposits/{a}/approve', [TransactionDepositController::class, 'approve'])->name('transactions.deposits.approve');
        Route::patch('/transaction/deposits/{a}/rejected', [TransactionDepositController::class, 'rejected'])->name('transactions.deposits.rejected');
        
        Route::get('/transaction/services', [TransactionServiceController::class, 'index'])->name('transactions.services.index');

        Route::get('website-settings', [WebsiteSettingController::class, 'index'])->name('website-settings.index');
        Route::post('website-settings/save', [WebsiteSettingController::class, 'saveOrUpdate'])->name('website-settings.saveOrUpdate');

        Route::get('/chai', function(){
            return view('ai.index');
        });
        Route::post('/chai/generate', [ChaiController::class, 'generate'])->name('chai.generate');
    });
});



// Route::middleware(['role:operator'])->group(function () {
//     Route::get('/operator/dashboard', function () {
//         return view('operator.dashboard');
//     });
// });

// Route::middleware(['role:user'])->group(function () {
//     Route::get('/user/dashboard', function () {
//         return view('user.dashboard');
//     });
// });