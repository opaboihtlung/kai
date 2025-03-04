<?php


use App\Http\Controllers\Api\AppealController;
use App\Http\Controllers\Api\AttendanceController;
use App\Http\Controllers\Api\DeviceController;
use App\Http\Controllers\Api\MobileHomeController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\OfficeController;
use App\Http\Controllers\Api\OtpController;
use App\Http\Controllers\Api\PageController;

use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\LeaveController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;





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

Route::group(['prefix' => 'otp'], function () {
    Route::post('send', [OtpController::class, 'sendOtp']);
    Route::post('verify', [OtpController::class, 'verifyOtp']);
});
Route::group(['prefix' => 'page'], function () {
    Route::get('privacy', [PageController::class, 'privacy']);
    Route::get('term', [PageController::class, 'term']);
});

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('index', [MobileHomeController::class, 'index']);
    Route::post('fcm/token', [MobileHomeController::class, 'updateToken']);

    // Route::group(['prefix' => 'office'], function () {
    //     Route::post('signin', [OfficeController::class, 'signin']);
    //     Route::put('{model}/signout', [OfficeController::class, 'signout']);
    // });

    Route::group(['prefix' => 'office'], function () {
        Route::post('signin', [OfficeController::class, 'signin']);

        // Apply throttle middleware (3000 requests per minute)
        Route::put('{model}/signout', [OfficeController::class, 'signout'])
            ->middleware('throttle:3000,1');
    });

    Route::group(['prefix' => 'device'], function () {
        Route::post('request', [DeviceController::class, 'registerNewDevice']);
    });

    Route::group(['prefix' => 'profile'], function () {
        Route::get('', [ProfileController::class, 'index']);
        Route::get('devices', [ProfileController::class, 'devices']);
    });

    Route::group(['prefix' => 'attendance'], function () {
        Route::get('index', [AttendanceController::class, 'index']);
        Route::get('{model}/show', [AttendanceController::class, 'show']);
    });

    Route::group(['prefix' => 'notification'], function () {
        Route::get('index', [NotificationController::class, 'index']);
        Route::get('{model}/show', [NotificationController::class, 'show']);
    });
    Route::group(['prefix' => 'appeal'], function () {
        Route::get('index', [AppealController::class, 'index']);
        Route::post('appeal_onDuty', [AppealController::class, 'appeal_onDuty']);
        Route::post('{model}/appeal_lateReason',[AppealController::class, 'appeal_lateReason']);
        Route::post('{model}/appeal_leftEarly',[AppealController::class, 'appeal_leftEarly']);

    });


});
Route::group(['prefix' => 'registration'], function () {
    Route::get('create', [RegisterController::class, 'create']);
    Route::post('', [RegisterController::class, 'register']);
    Route::post('login', [RegisterController::class, 'login']);
    Route::delete('logout', [RegisterController::class, 'logout'])->middleware('auth:sanctum');
});

//API for E-leave Portal
Route::post('/leaves', [LeaveController::class, 'store']);

