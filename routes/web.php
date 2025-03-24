<?php

use App\Http\Controllers\CategoryServiceController;
use App\Http\Controllers\ChaiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DigitalPlatformController;
use App\Http\Controllers\IntercationTypeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OriginalServiceController;
use App\Http\Controllers\PaymentAccountController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PrimaryServiceController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TransactionDepositController;
use App\Http\Controllers\TransactionServiceController;
use App\Http\Controllers\UserDepositController;
use App\Http\Controllers\UserTicketController;
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

Route::get('/tripay/channel', [DashboardController::class, 'getPaymentChannels']);
Route::get('/verify-email/{token}', [RegisterController::class, 'verifyEmail'])->name('verify.email');
Route::get('/forgot-password', [LoginController::class, 'forgotPassword'])->name('forgotPassword');
Route::post('/resend-verification', [RegisterController::class, 'resendVerification'])->name('resend.verification');
Route::post('/forgot-password', [LoginController::class, 'sendForgotPasswordEmail'])->name('forgot.password.email');

Route::get('/reset-password', [LoginController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [LoginController::class, 'resetPassword'])->name('password.update');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/users/transactions', [UserTransactionController::class, 'index'])->name('users.transactions.index');
    Route::get('/users/transactions/create', [UserTransactionController::class, 'create'])->name('users.transactions.create');
    Route::get('/users/transactions/create/mass', [UserTransactionController::class, 'massCreate'])->name('users.transactions.massCreate');
    Route::post('/users/transactions/store', [UserTransactionController::class, 'storeTransaction'])->name('users.transactions.storeTransaction');
    Route::post('/users/transactions/mass/store', [UserTransactionController::class, 'storeTransactionMass'])->name('users.transactions.storeTransactionMass');

    Route::get('/users/deposit', [UserDepositController::class, 'index'])->name('user.deposit.index');
    Route::get('/users/deposit/channels', [UserDepositController::class, 'channels'])->name('user.deposit.channels');
    Route::get('/users/deposit/{a}/create', [UserDepositController::class, 'create'])->name('user.deposit.create');
    Route::get('/users/deposit/{a}/detail', [UserDepositController::class, 'detail'])->name('user.deposit.detail');
    Route::post('/users/deposit/store', [UserDepositController::class, 'storeDeposit'])->name('user.deposit.storeDeposit');
    Route::get('/get-services/{platformId}/{interactionId}', [UserTransactionController::class, 'getServices']);

    Route::get('/users/tickets', [UserTicketController::class, 'index'])->name('users.ticket');
    Route::post('/users/tickets/store', [UserTicketController::class, 'store'])->name('users.ticket.store');
    Route::get('/users/tickets/{a}/detail', [UserTicketController::class, 'detail'])->name('users.ticket.detail');
    Route::post('/users/tickets/{a}/send/message', [UserTicketController::class, 'sendMessage'])->name('users.ticket.sendmessage');
    
    Route::get('/chai', function(){
        return view('ai.index');
    })->name('ai.generate');
    Route::post('/chai/generate', [ChaiController::class, 'generate'])->name('chai.generate');

    
    Route::get('/get-services/{a}', [UserTransactionController::class, 'getServicesByCategory'])->name('users.transactions.getServicesByCategory');
    Route::middleware(['role:superadmin'])->group(function () {
        
        Route::prefix('digital-platforms')->group(function () {
            Route::get('/', [DigitalPlatformController::class, 'index'])->name('digital_platforms.index');
            Route::post('/store', [DigitalPlatformController::class, 'store'])->name('digital_platforms.store');
            Route::put('/{a}/update', [DigitalPlatformController::class, 'update'])->name('digital_platforms.update');
            Route::delete('/{a}/destroy', [DigitalPlatformController::class, 'destroy'])->name('digital_platforms.destroy');
        });
        
        Route::prefix('interaction-types')->group(function () {
            Route::post('/store', [IntercationTypeController::class, 'store'])->name('interaction_types.store');
            Route::put('/{a}/update', [IntercationTypeController::class, 'update'])->name('interaction_types.update');
            Route::delete('/{a}/destroy', [IntercationTypeController::class, 'destroy'])->name('interaction_types.destroy');
        });
        
        
        Route::prefix('original-services')->group(function () {
            Route::get('/', [OriginalServiceController::class, 'index'])->name('original_services.index');
            Route::get('/update-digital-platforms', [OriginalServiceController::class, 'updateOriginalPlatform'])->name('original_services.updateOriginalPlatform');
            Route::get('/update-interactions', [OriginalServiceController::class, 'updateOriginalInteraction'])->name('original_services.updateOriginalInteraction');
            Route::get('/{a}/assign-primary-service', [OriginalServiceController::class, 'assignPrimaryService'])->name('original_services.assignPrimaryService');
        });
        

        Route::prefix('primary-services')->group(function () {
            Route::get('/', [PrimaryServiceController::class, 'index'])->name('primary_services.index');
            Route::get('/{a}/detail', [PrimaryServiceController::class, 'detail'])->name('primary_services.detail');
            Route::put('/{a}/update', [PrimaryServiceController::class, 'update'])->name('primary_services.update');
        });
        
        Route::prefix('tickets')->group(function () {
            Route::get('/', [TicketController::class, 'index'])->name('tickets.index');
            Route::get('/{a}/detail', [TicketController::class, 'detail'])->name('tickets.detail');
            Route::post('/{a}/message/setore', [TicketController::class, 'sendMessage'])->name('tickets.sendmessage');
        });
        
        Route::prefix('transaction')->group(function () {
            Route::prefix('deposits')->group(function () {
                Route::get('/', [TransactionDepositController::class, 'index'])->name('transactions.deposits.index');
                Route::patch('/{a}/approve', [TransactionDepositController::class, 'approve'])->name('transactions.deposits.approve');
                Route::patch('/{a}/rejected', [TransactionDepositController::class, 'rejected'])->name('transactions.deposits.rejected');
            });
        
            Route::get('services', [TransactionServiceController::class, 'index'])->name('transactions.services.index');
        });
        
        Route::prefix('website-settings')->group(function () {
            Route::get('/', [WebsiteSettingController::class, 'index'])->name('website-settings.index');
            Route::post('/save', [WebsiteSettingController::class, 'saveOrUpdate'])->name('website-settings.saveOrUpdate');
        });
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