<?php

use App\Http\Controllers\Admin\AdminSettingController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PublicDashboardController;
use App\Http\Controllers\FilterController;
use App\Http\Controllers\MatchController;
use App\Http\Controllers\UserRequestController;
use App\Http\Controllers\UserSettingController;
use App\Http\Controllers\ProfileVerificationController;
use App\Http\Controllers\Admin\AdminVerificationController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ReportsController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\ProfileReportController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\SubscriptionController;
use Laravel\Cashier\Http\Controllers\WebhookController;
use App\Http\Controllers\Admin\PaymentManagementController;
use App\Http\Controllers\Admin\SubscriptionManagementController;
use App\Http\Controllers\Admin\NotificationController;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use App\Notifications\AdminTestNotification;

Route::get('/test-admin-notification', function () {

    $admin = User::where('role', 'admin')->first();

    $admin->notify(
        new AdminTestNotification(
            'This is a dummy admin notification for testing.'
        )
    );

    return 'Dummy notification sent successfully!';
});

Route::middleware('auth')->group(function () {

    Route::get(
        '/admin/notifications',
        [NotificationController::class, 'index']
    )->name('admin.notifications');

    Route::post(
        '/admin/notifications/read/{id}',
        [NotificationController::class, 'markAsRead']
    )->name('admin.notifications.read');

    Route::post(
        '/admin/notifications/read-all',
        [NotificationController::class, 'markAllAsRead']
    )->name('admin.notifications.readAll');

    Route::delete(
        '/admin/notifications/delete/{id}',
        [NotificationController::class, 'destroy']
    )->name('admin.notifications.delete');

});

Route::middleware(['auth'])->group(function () {

    Route::get('/plans', [SubscriptionController::class, 'plans'])
        ->name('plans');

    Route::get('/checkout/{id}', [SubscriptionController::class, 'checkout'])
        ->name('checkout');

    Route::get('/subscription-success', [SubscriptionController::class, 'success'])
        ->name('subscription.success');

    Route::post('/subscription-cancel', [SubscriptionController::class, 'cancel'])
        ->name('subscription.cancel');

    Route::post('/free-plan/{plan}', [SubscriptionController::class, 'activateFreePlan'])
        ->name('free.subscribe');

    Route::get('/upgrade-preview/{id}', [SubscriptionController::class, 'upgradePreview'])
        ->name('plan.upgrade');

    Route::get(
        '/subscription/refund-preview',
        [SubscriptionController::class, 'getRefundPreview']
    )->name('subscription.refund.preview');

    Route::post(
        '/subscription/preview/{plan}',
        [SubscriptionController::class, 'previewUpgrade']
    )
        ->name('subscription.preview');

    Route::get(
        '/upgrade/{id}',
        [SubscriptionController::class, 'upgradeCheckout']
    )->name('upgrade.checkout');
});

Route::middleware('auth')->group(function () {

    Route::post('/rating/store', [RatingController::class, 'store'])
        ->name('rating.store');

    Route::post('/rating/skip', [RatingController::class, 'skip'])
        ->name('rating.skip');

    Route::post('/rating/cancel', [RatingController::class, 'cancel'])
        ->name('rating.cancel');

});



Route::prefix('admin')->middleware(['admin.session', 'admin'])->group(function () {
    Route::get('/settings/display', [AdminSettingController::class, 'index'])
        ->name('admin.settings.display');

    Route::post('/settings/display', [AdminSettingController::class, 'update'])
        ->name('admin.settings.update');

    Route::post('/upload', [AdminSettingController::class, 'handleUpload'])->name('upload.handle');

    Route::get(
        '/payments',
        [PaymentManagementController::class, 'index']
    )->name('admin.payments');

    Route::post(
        '/subscription/cancel/{id}',
        [SubscriptionManagementController::class, 'cancel']
    )->name('admin.subscription.cancel');
});


Route::middleware(['admin.session', 'admin'])->prefix('admin')->group(function () {

    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    Route::get(
        '/verifications',
        [AdminVerificationController::class, 'index']
    )->name('admin.verifications');

    Route::post(
        '/user/{id}/ban',
        [UserController::class, 'ban']
    )->name('admin.user.ban');

    Route::post(
        '/user/{id}/unban',
        [UserController::class, 'unban']
    )->name('admin.user.unban');

    Route::get(
        '/subscriptions',
        [SubscriptionManagementController::class, 'index']
    )->name('admin.subscriptions');

    Route::get('/reports', [ReportsController::class, 'index'])
        ->name('admin.reports');

    Route::get('/reports/{id}', [ReportsController::class, 'show'])
        ->name('admin.reports.show');

    Route::post('/reports/{report}/resolve', [ReportsController::class, 'resolve'])->name('admin.reports.resolve');

    Route::get('reports/{reportId}/destroy', [ReportsController::class, 'destroy'])->name('admin.reports.destroy');

    Route::post(
        '/verification/approve/{id}',
        [AdminVerificationController::class, 'approve']
    )->name('admin.verification.approve');

    Route::post(
        '/verification/reject/{id}',
        [AdminVerificationController::class, 'reject']
    )->name('admin.verification.reject');

    Route::get('/view-document/{id}', [AdminVerificationController::class, 'viewDocument'])
        ->name('admin.view-document');

    Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
    // routes/web.php
    Route::get('profile/{profile}', [UserController::class, 'show'])
        ->name('admin.users.show');

    Route::post('/profile/change-role/{user}', [UserController::class, 'makeAdmin'])->name('admin.profile.changerole');
    Route::post('/profile/demote-role/{user}', [UserController::class, 'demoteAdmin'])->name('admin.profile.demote');

    Route::get('/admin/settings', [SettingsController::class, 'index'])->name('admin.settings');

});

Route::middleware(['auth'])->group(function () {

    Route::get(
        '/profile/verification',
        [ProfileVerificationController::class, 'verification']
    )->name('profile.verification');

    Route::post(
        '/profile/verification',
        [ProfileVerificationController::class, 'submitVerification']
    )->name('profile.verification.submit');

});

Route::post('/settings/check-password', [UserSettingController::class, 'checkPassword'])
    ->name('settings.checkPassword')
    ->middleware('auth');

Route::middleware(['auth'])->group(function () {
    Route::get('/settings', [UserSettingController::class, 'index'])->name('settings');
    Route::post('/settings/update', [UserSettingController::class, 'update'])->name('settings.update');
    Route::post('/settings/password', [UserSettingController::class, 'updatePassword'])->name('settings.password');
    Route::post('/settings/delete', [UserSettingController::class, 'destroy'])->name('settings.delete');
});


Route::middleware('auth')->group(function () {

    Route::get('/requests', [UserRequestController::class, 'index'])->name('request.index');
    Route::get('/requests/sent', [UserRequestController::class, 'viewrequests'])->name('request.view');

    Route::post('/request/send/{profile}', [UserRequestController::class, 'send'])->name('request.send');
    Route::post('/request/{id}/accept', [UserRequestController::class, 'accept'])->name('request.accept');
    Route::post('/request/{id}/reject', [UserRequestController::class, 'reject'])->name('request.reject');
    Route::post('/request/{id}/cancel', [UserRequestController::class, 'cancel'])->name('request.cancel');
    Route::post('/request/block/{requestId}', [UserRequestController::class, 'block'])->name('request.block');
    Route::post('/request/remove/{requestId}', [UserRequestController::class, 'remove'])->name('request.remove');

    Route::post('/notifications/{id}/read', function ($id) {

        $notification = auth()->user()->notifications()->findOrFail($id);

        $notification->markAsRead();

        return redirect($notification->data['url'] ?? route('notifications'));

    })->name('notifications.read');


    Route::get('/notifications', function () {
        return view('notifications.index', [
            'notifications' => auth()->user()->notifications
        ]);
    })->name('notifications');
});


Route::get('/matches', [MatchController::class, 'index'])
    ->middleware('auth')
    ->name('matches.show');

Route::get('/', [PublicDashboardController::class, 'index'])->name('/');

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

// Profile creation (after registration)
Route::middleware('auth')->group(function () {
    Route::get('/create', [ProfileController::class, 'create'])->name('profile.create');
    Route::post('/store', [ProfileController::class, 'store'])->name('profile.store');
    Route::get('/search', [ProfileController::class, 'search'])->name('profile.search');
    Route::get('/index', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile/change-activation', [ProfileController::class, 'changeActivation'])->name('profile.changeactivation');
    Route::get('/show/{id}/{page}', [ProfileController::class, 'show'])->name('user.show');
    Route::get('/my-profile', [ProfileController::class, 'myProfile'])->name('profile.myprofile');
    Route::post('/save-result', [FilterController::class, 'saveresult'])->name('filter.save');
    Route::patch('/filter/{filter}/remove/{field}', [FilterController::class, 'removeField'])
        ->name('filter.removeField');
    Route::get('/profile/delete', [ProfileController::class, 'deleteform'])->name('profile.deleteform');
    Route::get('/profile/{id}/report', [ReportController::class, 'create'])->name('profile.report');
    Route::post('/profile/{id}/report', [ReportController::class, 'store'])->name('profile.report.store');
    Route::get('/get-states/{country}', [ProfileController::class, 'getStates']);
    Route::get('/get-cities/{state}', [ProfileController::class, 'getCities']);
    Route::get('/submit', [ProfileController::class, 'submit'])->name('submit');
    Route::delete('/filter/{id}/soft-delete', [ProfileController::class, 'softDeleteFilter'])
        ->name('filter.softDelete');


    Route::get('/submit', [ProfileController::class, 'submit'])->name('submit');
    Route::get('/about-us', [DashboardController::class, 'about'])->name('about');

    Route::get('/testimonial/create', [TestimonialController::class, 'create'])->name('testimonial.create');

    Route::post('/testimonial/store', [TestimonialController::class, 'store'])->name('testimonial.store');


    // Restore a soft-deleted filter
    Route::post('/filter/{id}/restore', [ProfileController::class, 'restore'])->name('filter.restore');

    // Save search/filter (optional, if you already have a method)
    Route::post('/filter/save', [ProfileController::class, 'save'])->name('filter.save');

    // Profile management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/delete', [ProfileController::class, 'destroyProfile'])->name('profile.delete');
});


require __DIR__ . '/auth.php';