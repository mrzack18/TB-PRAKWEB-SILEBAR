<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuctionController;

// Guest routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/auctions', [AuctionController::class, 'index'])->name('auctions.index');
Route::get('/auctions/{auction}', [AuctionController::class, 'show'])->name('auctions.show');
Route::view('/how-it-works', 'pages.how-it-works')->name('how-it-works');

// Auth routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Admin routes
Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);

    Route::get('/verifications', [\App\Http\Controllers\Admin\AuctionVerificationController::class, 'index'])->name('verifications.index');
    Route::patch('/verifications/{auction}/approve', [\App\Http\Controllers\Admin\AuctionVerificationController::class, 'approve'])->name('verifications.approve');
    Route::patch('/verifications/{auction}/reject', [\App\Http\Controllers\Admin\AuctionVerificationController::class, 'reject'])->name('verifications.reject');

    Route::get('/payments', [\App\Http\Controllers\Admin\PaymentVerificationController::class, 'index'])->name('payments.index');
    Route::patch('/payments/{transaction}/verify', [\App\Http\Controllers\Admin\PaymentVerificationController::class, 'verify'])->name('payments.verify');

    Route::get('/reports', [\App\Http\Controllers\Admin\ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/export', [\App\Http\Controllers\Admin\ReportController::class, 'export'])->name('reports.export');
});

// Seller routes
Route::prefix('seller')->name('seller.')->middleware('role:seller')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Seller\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('auctions', \App\Http\Controllers\Seller\AuctionController::class);
    Route::patch('/auctions/{auction}/end-early', [\App\Http\Controllers\Seller\AuctionController::class, 'endEarly'])->name('auctions.endEarly');
    Route::resource('transactions', \App\Http\Controllers\Seller\TransactionController::class);
    Route::patch('/transactions/{transaction}/shipping-status', [\App\Http\Controllers\Seller\TransactionController::class, 'updateShippingStatus'])->name('seller.transactions.shipping.update');
    Route::get('/shipping', [\App\Http\Controllers\Seller\ShippingController::class, 'index'])->name('shipping.index');
    Route::patch('/shipping/{transaction}/update', [\App\Http\Controllers\Seller\ShippingController::class, 'update'])->name('shipping.update');
});

// Buyer routes
Route::prefix('buyer')->name('buyer.')->middleware('role:buyer')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Buyer\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/auctions/followed', [\App\Http\Controllers\Buyer\AuctionController::class, 'followed'])->name('auctions.followed');
    Route::post('/auctions/{auction}/follow', [\App\Http\Controllers\Buyer\AuctionController::class, 'follow'])->name('auctions.follow');
    Route::resource('transactions', \App\Http\Controllers\Buyer\TransactionController::class);
});

// Bid route (available to authenticated users)
Route::post('/auctions/{auction}/bids', [\App\Http\Controllers\BidController::class, 'store'])->middleware('auth')->name('bids.store');

// Payment routes
Route::prefix('payments')->middleware('auth')->group(function () {
    Route::get('/', [\App\Http\Controllers\PaymentController::class, 'index'])->name('payments.index');
    Route::get('/{transaction}', [\App\Http\Controllers\PaymentController::class, 'show'])->name('payments.show');
    Route::post('/{auction}/create', [\App\Http\Controllers\PaymentController::class, 'create'])->name('payments.create');
    Route::post('/{transaction}/process', [\App\Http\Controllers\PaymentController::class, 'processPayment'])->name('payments.process');
    Route::patch('/{transaction}/verify', [\App\Http\Controllers\PaymentController::class, 'verifyPayment'])->name('payments.verify');
});

// Notification routes
Route::prefix('notifications')->middleware('auth')->group(function () {
    Route::get('/', [\App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::patch('/{notification}/read', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::patch('/read-all', [\App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
    Route::get('/unread-count', [\App\Http\Controllers\NotificationController::class, 'unreadCount'])->name('notifications.unreadCount');
});

// Test route for real-time notifications
Route::post('/test-notification', [\App\Http\Controllers\TestNotificationController::class, 'sendTestNotification'])->middleware('auth')->name('test.notification');