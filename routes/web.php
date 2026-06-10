<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ListingController as AdminListingController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Admin\RatingController as AdminRatingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\IDVerificationController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RatingController;
use App\Models\Listing;
use Illuminate\Support\Facades\Route;

// ========== PUBLIC ROUTES ==========
Route::get('/', function () {
    $featuredListings = Listing::active()->with('user', 'photos')->latest()->limit(8)->get();

    return view('welcome', compact('featuredListings'));
})->name('landing');

Route::get('/listings/create', [ListingController::class, 'create'])->name('listings.create');
Route::get('/listings', [ListingController::class, 'index'])->name('listings.index');
Route::get('/listings/{listing}', [ListingController::class, 'show'])->name('listings.show');

// ========== AUTH ROUTES ==========
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::post('/listings/{listing}/favorite', [ListingController::class, 'toggleFavorite'])
    ->name('listings.favorite.toggle');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/email/verify', [EmailVerificationController::class, 'notice'])->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])->middleware(['signed'])->name('verification.verify');
    Route::post('/email/verification-notification', [EmailVerificationController::class, 'resend'])->middleware(['throttle:6,1'])->name('verification.send');

    Route::get('/id-verification', [IDVerificationController::class, 'show'])->name('id-verification.show');
    Route::post('/id-verification/upload', [IDVerificationController::class, 'upload'])->name('id-verification.upload');
    Route::post('/id-verification/resubmit', [IDVerificationController::class, 'resubmit'])->name('id-verification.resubmit');

    Route::post('/profile/update-photo', [ProfileController::class, 'updatePhoto'])->name('profile.update-photo');
    Route::delete('/profile/remove-photo', [ProfileController::class, 'removePhoto'])->name('profile.remove-photo');

});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    // REMOVED DUPLICATE payment/history and payment/receipt from here
});

// ========== VERIFIED STUDENT ONLY (ID Approved) ==========
Route::middleware(['auth', 'verified', 'verified.student'])->group(function () {
    Route::post('/listings', [ListingController::class, 'store'])->name('listings.store');
    Route::get('/listings/{listing}/edit', [ListingController::class, 'edit'])->name('listings.edit');
    Route::put('/listings/{listing}', [ListingController::class, 'update'])->name('listings.update');
    Route::delete('/listings/{listing}', [ListingController::class, 'destroy'])->name('listings.destroy');
    Route::post('/listings/{listing}/mark-as-sold', [ListingController::class, 'markAsSold'])->name('listings.markAsSold');

    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');

    // ========== TRANSACTION HISTORY ==========
    Route::get('/payment/history', [PaymentController::class, 'history'])->name('payment.history');
    Route::get('/payment/receipt/{payment}', [PaymentController::class, 'receipt'])->name('payment.receipt');

    // ========== PAYMENT ROUTES ==========
    Route::get('/payment/{listing}', [PaymentController::class, 'show'])->name('payment.show');
    Route::post('/payment/initialize/{listing}', [PaymentController::class, 'initialize'])->name('payment.initialize');
    Route::match(['get', 'post'], '/payment/test/{listing}', [PaymentController::class, 'testMode'])->name('payment.test');
    Route::get('/payment/callback/{reference}', [PaymentController::class, 'callback'])->name('payment.callback');
    Route::post('/payment/webhook', [PaymentController::class, 'webhook'])->name('payment.webhook');
    Route::get('/payment/return', [PaymentController::class, 'returnPage'])->name('payment.return');
    Route::get('/payment/history', [PaymentController::class, 'history'])->name('payment.history');
    Route::get('/payment/receipt/{payment}', [PaymentController::class, 'receipt'])->name('payment.receipt');

    // Messages
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{conversation}', [MessageController::class, 'show'])->name('messages.show');
    Route::get('/messages/start/{listing}', [MessageController::class, 'start'])->name('messages.start');
    Route::post('/messages/send/{conversation}', [MessageController::class, 'sendMessage'])->name('messages.send');
    Route::get('/messages/unread/count', [MessageController::class, 'unreadCount'])->name('messages.unread.count');

    // Favorites
    Route::post('/favorites/add/{listing}', [FavoriteController::class, 'add'])->name('favorites.add');
    Route::delete('/favorites/remove/{listing}', [FavoriteController::class, 'remove'])->name('favorites.remove');
    Route::post('/favorites/toggle/{listing}', [FavoriteController::class, 'toggle'])->name('favorites.toggle');

    // Ratings
    Route::get('/rating/create/{payment}', [RatingController::class, 'create'])->name('ratings.create');
    Route::post('/rating/store/{payment}', [RatingController::class, 'store'])->name('ratings.store');
    Route::get('/rating/edit/{rating}', [RatingController::class, 'edit'])->name('ratings.edit');
    Route::put('/rating/update/{rating}', [RatingController::class, 'update'])->name('ratings.update');
    Route::get('/ratings/user/{user}', [RatingController::class, 'userRatings'])->name('ratings.user');
});

// ========== ADMIN ROUTES ==========
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/chart-data/{days}', [DashboardController::class, 'chartData'])->name('chart-data');
    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::post('/users/{user}/toggle-suspend', [UserController::class, 'toggleSuspend'])->name('users.toggle-suspend');
    Route::post('/users/{user}/verify-seller', [UserController::class, 'verifySeller'])->name('users.verify-seller');
    Route::post('/users/{user}/make-admin', [UserController::class, 'makeAdmin'])->name('users.make-admin');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::get('/listings', [AdminListingController::class, 'index'])->name('listings');
    Route::post('/listings/{listing}/status', [AdminListingController::class, 'updateStatus'])->name('listings.status');
    Route::delete('/listings/{listing}', [AdminListingController::class, 'destroy'])->name('listings.destroy');
    Route::get('/payments', [AdminPaymentController::class, 'index'])->name('payments');
    Route::get('/ratings', [AdminRatingController::class, 'index'])->name('ratings');
    Route::post('/ratings/{rating}/approve', [AdminRatingController::class, 'approve'])->name('ratings.approve');
    Route::delete('/ratings/{rating}', [AdminRatingController::class, 'destroy'])->name('ratings.destroy');
    Route::post('/ratings/bulk-approve', [AdminRatingController::class, 'bulkApprove'])->name('ratings.bulk-approve');
    Route::post('/ratings/bulk-delete', [AdminRatingController::class, 'bulkDelete'])->name('ratings.bulk-delete');
    Route::get('/ratings/{rating}', [AdminRatingController::class, 'show'])->name('ratings.show');
    Route::get('/top-sellers', [AdminRatingController::class, 'topSellers'])->name('top-sellers');
    Route::get('/pending-ids', [UserController::class, 'pendingVerifications'])->name('pending-ids');
    Route::post('/users/{user}/approve-id', [UserController::class, 'approveId'])->name('users.approve-id');
    Route::post('/users/{user}/reject-id', [UserController::class, 'rejectId'])->name('users.reject-id');
});

require __DIR__.'/auth.php';
