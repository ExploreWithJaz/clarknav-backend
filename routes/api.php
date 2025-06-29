<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BugReportController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\LocationSearchController;
use App\Http\Controllers\NavigationHistoryController;
use App\Http\Controllers\RouteUsageController;
use App\Http\Controllers\CustomRouteController;
use App\Http\Controllers\UserController;

// Auth routes
Route::group(['prefix' => 'auth'], function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api');
    Route::get('get-identity', [AuthController::class, 'getIdentity'])->middleware('auth:api');
    Route::put('update-credentials/{id}', [AuthController::class, 'updateCredentials'])->middleware('auth:api');
    Route::post('refresh', [AuthController::class, 'refresh']);

    Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('reset-password', [AuthController::class, 'resetPassword']);
    Route::get('verify-email/{token}', [AuthController::class, 'verifyEmail']);
    Route::post('resend-verification', [AuthController::class, 'resendVerification']);
});


Route::middleware(['auth:api', 'checkAdmin'])->group(function () {
    Route::get('users', [UserController::class, 'index']);
    Route::get('users/{id}', [UserController::class, 'show']);
    Route::put('users/{id}', [UserController::class, 'update']);
    Route::delete('users/{id}', [UserController::class, 'destroy']);
});

// Bug Reports routes
Route::post('bug-reports', [BugReportController::class, 'store']);
Route::middleware(['auth:api', 'checkAdmin'])->group(function () {
    Route::get('bug-reports', [BugReportController::class, 'index']);
    Route::get('bug-reports/{id}', [BugReportController::class, 'show']);
    Route::put('bug-reports/{id}', [BugReportController::class, 'update']);
    Route::delete('bug-reports/{id}', [BugReportController::class, 'destroy']);
});

// Feedback routes
Route::post('feedback', [FeedbackController::class, 'store']);
Route::middleware(['auth:api', 'checkAdmin'])->group(function () {
    Route::get('feedback', [FeedbackController::class, 'index']);
    Route::get('feedback/{id}', [FeedbackController::class, 'show']);
    Route::put('feedback/{id}', [FeedbackController::class, 'update']);
    Route::delete('feedback/{id}', [FeedbackController::class, 'destroy']);
});

// Location Searches routes
Route::post('location-searches', [LocationSearchController::class, 'store']);
Route::middleware(['auth:api', 'checkAdmin'])->group(function () {
    Route::get('location-searches', [LocationSearchController::class, 'index']);
    Route::get('location-searches/{id}', [LocationSearchController::class, 'show']);
    Route::put('location-searches/{id}', [LocationSearchController::class, 'update']);
    Route::delete('location-searches/{id}', [LocationSearchController::class, 'destroy']);
});

// Navigation Histories routes
// Route::post('navigation-histories', [NavigationHistoryController::class, 'store']);
// Route::get('navigation-histories', [NavigationHistoryController::class, 'index']);
// Route::delete('navigation-histories/{id}', [NavigationHistoryController::class, 'destroy']);
Route::middleware(['auth:api', 'checkUser'])->group(function () {
    Route::post('navigation-histories', [NavigationHistoryController::class, 'store']);
    Route::get('navigation-histories', [NavigationHistoryController::class, 'index']);
    Route::delete('navigation-histories/{id}', [NavigationHistoryController::class, 'destroy']);
});

// Route Usages routes
Route::post('route-usages', [RouteUsageController::class, 'store']);
Route::middleware(['auth:api', 'checkAdmin'])->group(function () {
    Route::get('route-usages', [RouteUsageController::class, 'index']);
    Route::get('route-usages/{id}', [RouteUsageController::class, 'show']);
    Route::put('route-usages/{id}', [RouteUsageController::class, 'update']);
    Route::delete('route-usages/{id}', [RouteUsageController::class, 'destroy']);
});

// Custom Routes routes
Route::middleware(['auth:api', 'checkUser'])->group(function () {
    Route::get('custom-routes', [CustomRouteController::class, 'index']);
    Route::post('custom-routes', [CustomRouteController::class, 'store']);
    Route::get('custom-routes/{id}', [CustomRouteController::class, 'show']);
    Route::put('custom-routes/{id}', [CustomRouteController::class, 'update']);
    Route::delete('custom-routes/{id}', [CustomRouteController::class, 'destroy']);
});