<?php

use App\Http\Controllers\Auth\LoginController as UserLoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\DepositController;
use App\Http\Controllers\User\PayoutController;
use App\Http\Controllers\ManualRecaptchaController;
use App\Http\Controllers\khaltiPaymentController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InAppNotificationController;
use App\Http\Controllers\User\SupportTicketController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\User\VerificationController;
use App\Http\Controllers\User\KycVerificationController;
use App\Http\Controllers\TwoFaSecurityController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\User\PayoutOtpController;
use App\Http\Controllers\User\MoneyTransferOtpController;
use App\Http\Controllers\User\GoldCoinController;
use App\Http\Controllers\Admin\RgpTransactionController as AdminRgpTransactionController;
use App\Http\Controllers\User\RgpTransactionController as UserRgpTransactionController;


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


$basicControl = basicControl();
Route::get('language/{locale?}', [FrontendController::class, 'language'])->name('language');


Route::get('payment-webview/{trx_id}', [\App\Http\Controllers\Api\V1\PaymentController::class, 'paymentView'])->name('paymentView');

Route::get('preview/page', [\App\Http\Controllers\PreviewController::class, 'preview'])->name('preview.page')->middleware('preview');

Route::get('maintenance-mode', function () {
    if (!basicControl()->is_maintenance_mode) {
        return redirect(route('page'));
    }
    $data['maintenanceMode'] = \App\Models\MaintenanceMode::first();
    return view(template() . 'maintenance', $data);
})->name('maintenance');

Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPassword'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset')->middleware('guest');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.reset.update');

Route::get('instruction/page', function () {
    // Get sponsor from query parameter if available
    $sponsor = request()->get('sponsor');
    
    if ($sponsor) {
        // If sponsor is provided, redirect to register with sponsor
        return redirect()->route('register.sponsor', ['sponsor' => $sponsor]);
    }
    
    // Otherwise, just redirect to register page
    return redirect()->route('register');
})->name('instructionPage');

Route::group(['middleware' => ['maintenanceMode']], function () use ($basicControl) {
    Route::group(['middleware' => ['guest']], function () {
        Route::get('/login', [UserLoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [UserLoginController::class, 'login'])->name('login.submit');
        Route::post('/loginModal', [UserLoginController::class, 'loginModal'])->name('loginModal');
        Route::get('register/{sponsor?}/{position?}', [RegisterController::class, 'showRegistrationForm'])->name('register.sponsor');
        Route::post('check-referral-code', [RegisterController::class, 'checkReferralCode'])->name('check.referral.code');
    });

    Route::group(['middleware' => ['auth'], 'prefix' => 'user', 'as' => 'user.'], function () {

        Route::get('check', [VerificationController::class, 'check'])->name('check');
        Route::get('resend_code', [VerificationController::class, 'resendCode'])->name('resend.code');
        Route::post('mail-verify', [VerificationController::class, 'mailVerify'])->name('mail.verify');
        Route::post('sms-verify', [VerificationController::class, 'smsVerify'])->name('sms.verify');
        Route::post('twoFA-Verify', [VerificationController::class, 'twoFAverify'])->name('twoFA-Verify');

        Route::middleware('userCheck')->group(function () {
            Route::get('dashboard', [HomeController::class, 'index'])->name('dashboard');
            Route::get('profile', [HomeController::class, 'profile'])->name('profile');
            Route::post('profile-update', [HomeController::class, 'profileUpdate'])->name('profile.update');
            Route::post('profile-update/image', [HomeController::class, 'profileUpdateImage'])->name('profile.update.image');
            Route::post('update/password', [HomeController::class, 'updatePassword'])->name('updatePassword');
            
            Route::post('save-token', [HomeController::class, 'saveToken'])->name('save.token');
            Route::get('add-fund', [HomeController::class, 'addFund'])->name('addFund');
            Route::get('funds', [HomeController::class, 'fund'])->name('fund.index');

            // Support Ticket
            Route::group(['prefix' => 'ticket', 'as' => 'ticket.'], function () {
                Route::get('/{id?}', [SupportTicketController::class, 'index'])->name('list');
                Route::get('/create/ticket', [SupportTicketController::class, 'create'])->name('create');
                Route::post('/create', [SupportTicketController::class, 'store'])->name('store');
                Route::get('/view/{ticket}', [SupportTicketController::class, 'ticketView'])->name('view');
                Route::put('/reply/{ticket}', [SupportTicketController::class, 'reply'])->name('reply');
                Route::get('/download/{ticket}', [SupportTicketController::class, 'download'])->name('download');
                Route::post('close/{ticket}', [SupportTicketController::class, 'close'])->name('close');
            });

            Route::get('invest-history', [HomeController::class, 'investHistory'])->name('invest-history');
            Route::get('invest-history/invoice/{id}', [HomeController::class, 'downloadInvoice'])->name('invest-history.invoice');
            Route::post('/purchase-plan', [HomeController::class, 'purchasePlan'])->name('purchase-plan');
            Route::get('payment', [HomeController::class, 'payment'])->name('payment');
            Route::get('payment-check-amount', [PaymentController::class, 'checkAmount'])->name('payment.checkAmount');

            /* ====== Transaction Log =====*/
            Route::get('/transaction', [HomeController::class, 'transaction'])->name('transaction');
            Route::get('/daily-profit-transaction', [HomeController::class, 'dailyProfitTransaction'])->name('daily-profit-transaction');

            // money-transfer
            Route::middleware(['money.transfer.otp.verification'])->group(function () {
                Route::get('/money-transfer', [HomeController::class, 'moneyTransfer'])->name('money-transfer');
                Route::post('/money-transfer', [HomeController::class, 'moneyTransferConfirm'])->name('money.transfer');
            });

            // terminate investment
            Route::post('terminate/investment/{id}', [HomeController::class, 'terminate'])->name('terminate');
            
            //plan
            Route::get('/plan', [HomeController::class, 'planList'])->name('plan');
            
            // Gold Coin Purchase
            Route::get('/goldcoin', [GoldCoinController::class, 'index'])->name('goldcoin');
            Route::get('/goldcoin/details/{id}', [GoldCoinController::class, 'coinDetails'])->name('goldcoin.details');
            Route::post('/goldcoin/purchase', [GoldCoinController::class, 'purchaseGold'])->name('goldcoin.purchase');
            Route::get('/goldcoin/orders', [GoldCoinController::class, 'orders'])->name('goldcoin.orders');
            Route::get('/goldcoin/order/{trx_id}', [GoldCoinController::class, 'orderDetails'])->name('goldcoin.order.details');
            Route::get('/goldcoin/orders/export/csv/{status?}', [GoldCoinController::class, 'exportOrdersCSV'])->name('goldcoin.orders.export.csv');
            Route::get('/goldcoin/orders/export/pdf/{status?}', [GoldCoinController::class, 'exportOrdersPDF'])->name('goldcoin.orders.export.pdf');
            
            // referral bonus
            Route::get('/referral-bonus', [HomeController::class, 'referralBonus'])->name('referral.bonus');
            
            // badges
            Route::get('/badges', [HomeController::class, 'badges'])->name('badges');
            
            // referral
            Route::get('/referral', [HomeController::class, 'referral'])->name('referral');
            Route::post('get-referral-user', [HomeController::class, 'getReferralUser'])->name('myGetDirectReferralUser');

            // RGP Pair Matching
            Route::post('/match-rgp-pairs', [HomeController::class, 'matchRgpPairs'])->name('match.rgp.pairs');

            /* ===== Manage Two Step ===== */
            Route::get('two-step-security', [TwoFaSecurityController::class, 'twoStepSecurity'])->name('twostep.security');
            Route::post('twoStep-enable', [TwoFaSecurityController::class, 'twoStepEnable'])->name('twoStepEnable');
            Route::post('twoStep-disable', [TwoFaSecurityController::class, 'twoStepDisable'])->name('twoStepDisable');
            Route::post('twoStep/re-generate', [TwoFaSecurityController::class, 'twoStepRegenerate'])->name('twoStepRegenerate');

            /* ===== Push Notification ===== */
            Route::get('push-notification-show', [InAppNotificationController::class, 'show'])->name('push.notification.show');
            Route::get('push.notification.readAll', [InAppNotificationController::class, 'readAll'])->name('push.notification.readAll');
            Route::get('push-notification-readAt/{id}', [InAppNotificationController::class, 'readAt'])->name('push.notification.readAt');

            Route::get('verification/kyc', [KycVerificationController::class, 'kyc'])->name('verification.kyc');
            Route::get('verification/kyc-form/{id}', [KycVerificationController::class, 'kycForm'])->name('verification.kyc.form');
            Route::post('verification/kyc/submit', [KycVerificationController::class, 'verificationSubmit'])->name('kyc.verification.submit');
            Route::get('verification/kyc/history', [KycVerificationController::class, 'history'])->name('verification.kyc.history');
            Route::get('payout-list', [PayoutController::class, 'index'])->name('payout.index');

            // Payout OTP verification routes
            Route::get('payout-verification', [PayoutOtpController::class, 'showVerification'])->name('payout.otp.verification');
            Route::post('payout-verification', [PayoutOtpController::class, 'verifyOtp'])->name('payout.otp.verify');
            Route::get('payout-verification/sms', [PayoutOtpController::class, 'sendOtpViaSms'])->name('payout.otp.sms');
            Route::get('payout-verification/email', [PayoutOtpController::class, 'sendOtpViaEmail'])->name('payout.otp.email');

            // Money Transfer OTP verification routes
            Route::get('money-transfer-verification', [MoneyTransferOtpController::class, 'showVerification'])->name('money.transfer.otp.verification');
            Route::post('money-transfer-verification', [MoneyTransferOtpController::class, 'verifyOtp'])->name('money.transfer.otp.verify');
            Route::get('money-transfer-verification/sms', [MoneyTransferOtpController::class, 'sendOtpViaSms'])->name('money.transfer.otp.sms');
            Route::get('money-transfer-verification/email', [MoneyTransferOtpController::class, 'sendOtpViaEmail'])->name('money.transfer.otp.email');

            // Only payout routes need KYC and OTP verification
            Route::middleware(['kyc', 'payout.otp.verification'])->group(function () {
                Route::get('payout-search', [PayoutController::class, 'search'])->name('payout.search');
                Route::get('payout', [PayoutController::class, 'payout'])->name('payout');
                Route::get('payout-supported-currency', [PayoutController::class, 'payoutSupportedCurrency'])->name('payout.supported.currency');
                Route::get('payout-check-amount', [PayoutController::class, 'checkAmount'])->name('payout.checkAmount');
                Route::post('request-payout', [PayoutController::class, 'payoutRequest'])->name('payout.request');
                Route::match(['get', 'post'], 'confirm-payout/{trx_id}', [PayoutController::class, 'confirmPayout'])->name('payout.confirm');
                Route::post('confirm-payout/flutterwave/{trx_id}', [PayoutController::class, 'flutterwavePayout'])->name('payout.flutterwave');
                Route::post('confirm-payout/paystack/{trx_id}', [PayoutController::class, 'paystackPayout'])->name('payout.paystack');
                Route::get('payout-check-limit', [PayoutController::class, 'checkLimit'])->name('payout.checkLimit');
                Route::post('payout-bank-form', [PayoutController::class, 'getBankForm'])->name('payout.getBankForm');
                Route::post('payout-bank-list', [PayoutController::class, 'getBankList'])->name('payout.getBankList');
            });

            // RGP Transactions
            Route::get('rgp-transactions', [UserRgpTransactionController::class, 'index'])->name('rgp.transactions');
        });
    });

    // subscribe
    Route::post('/subscribe', [FrontendController::class, 'subscribe'])->name('subscribe');

    //contact
    Route::post('/contact', [FrontendController::class, 'contactSend'])->name('contact.send');

    // blogs

    Route::get('blogs', [FrontendController::class, 'blogs'])->name('blogs');
    Route::get('blog-details/{slug}', [FrontendController::class, 'blogDetails'])->name('blog.details');
    Route::get('/category/blog/{id}',[FrontendController::class,'categoryBlogs'])->name('category.blogs');

    Route::get('captcha', [ManualRecaptchaController::class, 'reCaptCha'])->name('captcha');

    /* Manage User Deposit */
    Route::get('supported-currency', [DepositController::class, 'supportedCurrency'])->name('supported.currency');
    Route::post('payment-request', [DepositController::class, 'paymentRequest'])->name('payment.request');
    Route::post('plan/payment-request', [PaymentController::class, 'payment'])->name('plan.payment.request');
    Route::get('deposit-check-amount', [DepositController::class, 'checkAmount'])->name('deposit.checkAmount');

    Route::get('payment-process/{trx_id}', [PaymentController::class, 'depositConfirm'])->name('payment.process');
    Route::post('addFundConfirm/{trx_id}', [PaymentController::class, 'fromSubmit'])->name('addFund.fromSubmit');
    Route::match(['get', 'post'], 'success', [PaymentController::class, 'success'])->name('success');
    Route::match(['get', 'post'], 'failed', [PaymentController::class, 'failed'])->name('failed');
    Route::match(['get', 'post'], 'payment/{code}/{trx?}/{type?}', [PaymentController::class, 'gatewayIpn'])->name('ipn');

    Route::post('khalti/payment/verify/{trx}', [\App\Http\Controllers\khaltiPaymentController::class, 'verifyPayment'])->name('khalti.verifyPayment');
    Route::post('khalti/payment/store', [khaltiPaymentController::class, 'storePayment'])->name('khalti.storePayment');

    // Temporary debug route
    Route::get('/debug-otp-settings-simple', function() {
        $basic = basicControl();
        return [
            'require_payout_otp' => (bool)$basic->require_payout_otp,
            'require_money_transfer_otp' => (bool)$basic->require_money_transfer_otp,
        ];
    });
    
    // Test route with money transfer OTP middleware
    Route::middleware(['money.transfer.otp.verification'])->get('/test-money-transfer-middleware', function() {
        return 'If you see this, the middleware did not redirect you, which means OTP verification is not required or has been completed.';
    });

    // Temporary debug route
    Route::get('/debug-session', function() {
        dd([
            'show_dashboard_popup' => session('show_dashboard_popup'),
            'all_session' => session()->all()
        ]);
    })->middleware('auth');

    Auth::routes();
    /*= Frontend Manage Controller =*/
    Route::get("/{slug?}", [FrontendController::class, 'page'])->name('page');

    Route::post('users/badge-update/{id}', [UsersController::class, 'badgeUpdate'])->name('users.badgeUpdate');
});

// Security Routes
Route::group(['prefix' => 'security', 'as' => 'admin.', 'middleware' => ['auth']], function () {
    Route::post('/user/{id}/dashboard-tile', [\App\Http\Controllers\Admin\UsersController::class, 'dashboardTileUpdate'])->name('user.dashboard_tile.update');
});

Route::middleware(['auth'])->group(function () {
    Route::get('user/goldcoin/order/{trx_id}/invoice', [\App\Http\Controllers\User\GoldCoinController::class, 'downloadInvoice'])->name('user.goldcoin.order.invoice');
    Route::get('user/payout/invoice/{trx_id}', [\App\Http\Controllers\User\PayoutController::class, 'downloadInvoice'])->name('user.payout.invoice');
});


