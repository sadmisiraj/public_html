<?php

use App\Http\Controllers\Admin\PayoutLogController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\HomeController;
use App\Http\Controllers\Api\V1\PaymentController;
use App\Http\Controllers\Api\V1\PayoutController;
use App\Http\Controllers\Api\V1\ProfileController;
use App\Http\Controllers\Api\V1\SupportTicketController;
use App\Http\Controllers\Api\V1\TwoFASecurityController;
use App\Http\Controllers\Api\V1\VerificationController;
use App\Models\ContentDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\KycController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('payout/{code}', [PayoutLogController::class, 'payout'])->name('payout');


Route::get('language/{id?}', [HomeController::class,'language']);
Route::get('app/config', [HomeController::class,'appConfig']);
Route::get('app/steps', [HomeController::class,'appSteps']);
Route::get('/register/form', [AuthController::class,'registerUserForm']);
Route::post('/register', [AuthController::class,'registerUser']);
Route::post('/login', [AuthController::class,'loginUser']);
Route::post('/recovery-pass/get-email', [AuthController::class,'getEmailForRecoverPass']);
Route::post('/recovery-pass/get-code', [AuthController::class,'getCodeForRecoverPass']);
Route::post('/update-pass', [AuthController::class,'updatePass']);


Route::middleware(['auth:sanctum'])->group(function () {
    Route::middleware('userCheckApi')->group(function () {
        Route::get('/plan', [HomeController::class,'planList']);
        Route::post('plan-buy/wallet', [HomeController::class,'planBuyWallet']);

        Route::get('invest-history', [HomeController::class,'investHistory']);
        Route::get('fund-history', [HomeController::class,'fundHistory']);
        Route::get('fund-history/search', [HomeController::class,'fundHistorySearch']);
        Route::post('money-transfer/post', [HomeController::class,'moneyTransferPost']);
        Route::get('transaction', [HomeController::class,'transaction']);
        Route::get('transaction/search', [HomeController::class,'transactionSearch']);
        
        // Support Ticket
        Route::get('support-ticket/list', [SupportTicketController::class,'ticketList']);
        Route::post('support-ticket/create', [SupportTicketController::class,'ticketCreate']);
        Route::get('support-ticket/view/{id}', [SupportTicketController::class,'ticketView']);
        Route::get('support-ticket/download/{id}', [SupportTicketController::class,'ticketDownlaod'])->name('api.ticket.download');
        Route::post('support-ticket/reply', [SupportTicketController::class,'ticketReply']);

        // Payment
        Route::get('payment', [PaymentController::class,'paymentGateways']);
        Route::post('plan-buy', [PaymentController::class,'planBuy']);
        Route::post('manual/payment/submit/{trx_id?}', [PaymentController::class,'manualPayment']);
        Route::post('payment/done', [PaymentController::class,'paymentDone']);
        Route::get('payment-webview', [PaymentController::class, 'paymentWebview']);
        Route::post('card/payment', [PaymentController::class,'cardPayment']);
        Route::post('deposit', [PaymentController::class, 'deposit']);

        // Referral bonus routes
        Route::get('referral-bonus', [HomeController::class,'referralBonus']);
        Route::get('referral-bonus/search', [HomeController::class,'referralBonusSearch']);
        
        // Badges route
        Route::get('badge', [HomeController::class,'badge']);
        
        // Referral route
        Route::get('referral', [HomeController::class,'referral']);
        
        // User profile
        Route::get('profile', [ProfileController::class,'profile']);
        Route::post('profile/image/upload', [ProfileController::class,'profileImageUpload']);
        Route::post('profile/information/update', [ProfileController::class,'profileInfoUpdate']);
        Route::post('profile/password/update', [ProfileController::class,'profilePassUpdate']);
        Route::post('profile/identity-verification/submit', [ProfileController::class,'KycVerificationSubmit']);

        // 2FA Security
        Route::get('2FA-security', [TwoFASecurityController::class,'twoFASecurity']);
        Route::post('2FA-security/enable', [TwoFASecurityController::class,'twoFASecurityEnable']);
        Route::post('2FA-security/disable', [TwoFASecurityController::class,'twoFASecurityDisable']);
        Route::post('twoStep/re-generate', [TwoFASecurityController::class, 'twoStepRegenerate']);

        // Dashboard
        Route::get('dashboard', [HomeController::class,'dashboard']);
        Route::get('pusher/config', [HomeController::class,'pusherConfig']);

        // KYC
        Route::get('kyc',[KycController::class,'index']);
        Route::post('kyc/submit',[KycController::class,'KycVerificationSubmit']);
        Route::get('user-kyc', [KycController::class, 'userKyc']);
        Route::get('payout-history', [HomeController::class,'payoutHistory']);
        Route::get('payout-history/search', [HomeController::class,'payoutHistorySearch']);

        // Bank Details for Payment
        Route::get('user-bank-details', [PaymentController::class, 'getUserBankDetails']);

        // Only payout routes need KYC verification
        Route::middleware('apiKycCheck')->group(function () {
            // Payout routes
            Route::get('payout-method/{id?}', [PayoutController::class, 'payoutMethod']);
            Route::post('payout', [PayoutController::class,'payout']);
            Route::post('payout/get-bank/list', [PayoutController::class,'payoutGetBankList']);
            Route::post('payout/get-bank/from', [PayoutController::class,'payoutGetBankFrom']);
            Route::post('payout/paystack/submit/{trx_id}', [PayoutController::class,'payoutPaystackSubmit']);
            Route::post('payout/flutterwave/submit/{trx_id}', [PayoutController::class,'payoutFlutterwaveSubmit']);
            Route::post('payout/submit/confirm/{trx_id}', [PayoutController::class,'payoutSubmit']);
        });
    });

    Route::post('/twoFA-Verify', [VerificationController::class,'twoFAverify']);
    Route::post('/mail-verify', [VerificationController::class,'mailVerify']);
    Route::post('/sms-verify', [VerificationController::class,'smsVerify']);
    Route::get('/resend-code', [VerificationController::class,'resendCode']);
});
