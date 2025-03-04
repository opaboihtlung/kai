<?php
use Illuminate\Http\Request;
use App\Exports\LateAttendanceExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Api\AppealController;
use App\Http\Controllers\AppealAttendanceController;
use App\Http\Controllers\AppealListController;
use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\FcmTokenController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\HomeDashboardController;
use App\Http\Controllers\LateListController;
use App\Http\Controllers\MiscController;
use App\Http\Controllers\NotificationMessageController;
use App\Http\Controllers\OfficeAccountController;
use App\Http\Controllers\OfficeConfigController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostingRequestController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StatisticController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;







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
Route::group(['middleware' => 'guest'], function () {
    Route::get('/',[FrontendController::class,'index'])->name('home');

});
Route::group(['prefix'=>'page'], function () {
    Route::get('privacy',[PageController::class,'privacy'])->name('page.privacy');
    Route::get('term',[PageController::class,'term'])->name('page.term');

});

Route::group(['middleware' => 'auth', 'prefix' => 'dashboard'], function () {
    Route::get('',[DashboardController::class,'index'])->name('dashboard');
    Route::get('admin',[DashboardController::class,'admin'])->name('dashboard.admin');
    Route::get('admin2',[DashboardController::class,'admin2'])->name('dashboard.admin2');
    Route::get('manager',[DashboardController::class,'manager'])->name('dashboard.manager');
    Route::get('managerchart',[DashboardController::class,'managerchart'])->name('dashboard.managerchart');
    Route::get('adminTotalLeave',[DashboardController::class,'adminTotalLeave'])->name('dashboard.adminTotalLeave');
});

Route::group(['middleware'=>['role:Manager'],'prefix'=>'dashboard'], function () {
    Route::get('totalofficial', [DashboardController::class, 'totalofficial'])->name('dashboard.totalofficial');
    Route::get('present', [DashboardController::class, 'present'])->name('dashboard.present');
    Route::get('absent', [DashboardController::class, 'absent'])->name('dashboard.absent');
    Route::get('leave', [DashboardController::class, 'leave'])->name('dashboard.leave');

});

Route::group(['middleware'=>['role:Manager'],'prefix'=>'appeal'], function () {
    Route::get('late_reason', [AppealListController::class, 'late_reason'])->name('appeal.late_reason');
    Route::get('on_duty', [AppealListController::class, 'on_duty'])->name('appeal.on_duty');
    Route::get('left_early', [AppealListController::class, 'left_early'])->name('appeal.left_early');
    Route::post('{model}/reject_lateReason', [AppealAttendanceController::class, 'reject_lateReason'])->name('appeal.rejectlate');
    Route::post('{model}/approve_lateReason', [AppealAttendanceController::class, 'approve_lateReason'])->name('appeal.approvelate');
    Route::post('{model}/reject_lateReason2', [AppealAttendanceController::class, 'reject_lateReason2'])->name('appeal.rejectlate2');
    Route::post('{model}/approve_lateReason2', [AppealAttendanceController::class, 'approve_lateReason2'])->name('appeal.approvelate2');
    Route::post('{model}/reject_leftEarly', [AppealAttendanceController::class, 'reject_leftEarly'])->name('appeal.rejectleft');
    Route::post('{model}/approve_leftEarly', [AppealAttendanceController::class, 'approve_leftEarly'])->name('appeal.approveleft');
    Route::post('{model}/reject_leftEarly2', [AppealAttendanceController::class, 'reject_leftEarly2'])->name('appeal.rejectleft2');
    Route::post('{model}/approve_leftEarly2', [AppealAttendanceController::class, 'approve_leftEarly2'])->name('appeal.approveleft2');
    Route::post('{model}/reject', [AppealAttendanceController::class, 'reject'])->name('appeal.reject');
    Route::post('{model}/approve', [AppealAttendanceController::class, 'approve'])->name('appeal.approve');
    Route::post('{model}/reject2', [AppealAttendanceController::class, 'reject2'])->name('appeal.reject2');
    Route::post('{model}/approve2', [AppealAttendanceController::class, 'approve2'])->name('appeal.approve2');
});

Route::group(['prefix'=>'auth','middleware'=>'guest'], function () {
    Route::get('login',[AuthController::class,'create'])->name('login');
    Route::get('forgot',[AuthController::class,'forgot'])->name('forgot.password');

    Route::post('otp/{mobile}/send',[AuthController::class,'sendOtp'])->name('otp.send');
    Route::post('otp/verify/mobile',[AuthController::class,'verifyOtp'])->name('otp.verify');

    Route::post('login/store', [AuthController::class, 'store'])->name('login.store');
});
Route::delete('logout', [AuthController::class, 'destroy'])->middleware('auth')->name('login.destroy');


Route::group(['middleware' => 'auth'], function () {
    Route::group(['prefix'=>'notification'], function () {
        Route::get('list', [NotificationMessageController::class, 'myNotifications'])->name('notification.list');
        Route::get('index', [NotificationMessageController::class, 'index'])->name('notification.index');
        Route::get('create', [NotificationMessageController::class, 'create'])->name('notification.create');
        Route::get('{model}/show', [NotificationMessageController::class, 'show'])->name('notification.show');
        Route::delete('{model}', [NotificationMessageController::class, 'destroy'])->name('notification.destroy');
        Route::post('store', [NotificationMessageController::class, 'store'])->name('notification.store');
        Route::post('token/upload', [FcmTokenController::class, 'updateToken'])->name('token.upload');
    });

    Route::group(['prefix'=>'profile'], function () {
        Route::get('edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('update', [ProfileController::class, 'update'])->name('profile.update');
        Route::get('change-password', [ProfileController::class, 'changePassword'])->name('profile.change-password');
        Route::get('create-new-password', [ProfileController::class, 'createPassword'])->name('profile.create-new-password');
        Route::put('change-password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');
        Route::put('change-create-password', [ProfileController::class, 'updatecreatePassword'])->name('profile.update-create-password');
        Route::get('posting-request', [PostingRequestController::class, 'create'])->name('posting.index');
        Route::get('appeal-onduty', [AppealAttendanceController::class, 'appealonduty'])->name('appeal.onduty');
        Route::post('posting-request/submit', [PostingRequestController::class, 'update'])->name('posting.store');
        Route::put('posting-request/{model}/reject', [PostingRequestController::class, 'reject'])->name('posting.reject');
        Route::put('posting-request/{model}/approve', [PostingRequestController::class, 'approve'])->name('posting.approve');
        Route::get('posting-request/submitted', [PostingRequestController::class, 'submitted'])->name('posting.submitted');
        Route::get('posting-request/rejected', [PostingRequestController::class, 'rejected'])->name('posting.rejected');
        Route::get('posting-request/approved', [PostingRequestController::class, 'approved'])->name('posting.approved');
    });
    Route::group(['prefix'=>'device'], function () {
        Route::post('{model}/reject', [DeviceController::class, 'reject'])->name('device.reject');
        Route::post('{model}/approve', [DeviceController::class, 'approve'])->name('device.approve');
    });

    Route::group(['prefix'=>'attendance'], function () {
        Route::post('submit', [AttendanceController::class, 'submit'])->name('attendance.submit');
        Route::get('index', [AttendanceController::class, 'myAttendances'])->name('attendance.index');
        Route::get('download', [AttendanceController::class, 'download'])->name('attendance.download');
        Route::get('{id}/show', [AttendanceController::class, 'show'])->name('attendance.show');
        Route::delete('{id}/signout', [AttendanceController::class, 'signout'])->name('attendance.signout');
    });

    Route::group(['prefix' => 'office'], function () {
        Route::get('', [OfficeController::class, 'index'])->middleware('role:Admin')->name('office.index');
        Route::post('graceperiod', [OfficeController::class, 'GracePeriodupdate'])->middleware('role:Admin')->name('office.graceperiod');
        Route::get('index2', [OfficeController::class, 'index2'])->middleware('role:Admin')->name('office.index2');
        Route::get('create', [OfficeController::class, 'create'])->middleware('role:Admin')->name('office.create');
        Route::post('', [OfficeController::class, 'store'])->middleware('role:Admin')->name('office.store');
        Route::get('{model}', [OfficeController::class, 'edit'])->middleware('role:Admin')->name('office.edit');
        Route::put('{model}', [OfficeController::class, 'update'])->middleware('role:Admin')->name('office.update');
        Route::delete('{model}', [OfficeController::class, 'destroy'])->middleware('role:Admin')->name('office.destroy');

        Route::group(['middleware'=>['auth','role:Admin|Manager'],'prefix'=>'config'], function () {
            Route::get('index', [OfficeConfigController::class, 'index'])->name('office.config.index');
            Route::get('{model}/edit', [OfficeConfigController::class, 'edit'])->name('config.edit');
            Route::put('{model}/update', [OfficeConfigController::class, 'update'])->name('config.update');
        });

        Route::group(['middleware'=>['role:Admin|Manager'],'prefix'=>'accounts'], function () {
            Route::get('inactive', [OfficeAccountController::class, 'inactive'])->name('account.inactive');
            Route::get('active', [OfficeAccountController::class, 'active'])->name('account.active');
            Route::get('{id}', [OfficeAccountController::class, 'show'])->name('account.show');
            Route::delete('{id}', [OfficeAccountController::class, 'destroy'])->name('account.destroy');
            Route::put('{model}/activate', [OfficeAccountController::class, 'activate'])->name('account.activate');
            Route::put('{model}/deactivate', [OfficeAccountController::class, 'deactivate'])->name('account.deactivate');
            Route::put('{id}/update', [OfficeAccountController::class, 'update'])->name('account.update');

        });

//        Route::get('attendances/index', [AttendanceController::class, 'officeAttendances'])->middleware('role:Manager|Admin')->name('office.attendances');
        Route::get('attendances/list', [AttendanceController::class, 'officeAttendancesList'])->middleware('role:Manager|Admin')->name('office.attendance-list');
        Route::get('attendances/download', [AttendanceController::class, 'exportAttendanceList'])->middleware('role:Manager|Admin')->name('office.attendance-list.export');
//        Route::get('attendances/download', [AttendanceController::class, 'downloadOfficeAttendances'])->middleware('role:Manager|Admin')->name('office.attendances.download');
    });
    Route::group(['prefix' => 'district'], function () {
        Route::get('index', [DistrictController::class, 'index'])->middleware('role:Admin')->name('district.index');
        Route::post('store', [DistrictController::class, 'store'])->middleware('role:Admin')->name('district.store');
        Route::put('{model}', [DistrictController::class, 'update'])->middleware('role:Admin')->name('district.update');
        Route::delete('{model}', [DistrictController::class, 'destroy'])->middleware('role:Admin')->name('district.destroy');
    });


    Route::group(['prefix' => 'user'], function () {
        Route::get('inactive', [UserController::class, 'inactive'])->middleware('role:Admin')->name('user.inactive');
        Route::get('active', [UserController::class, 'active'])->middleware('role:Admin')->name('user.active');
        Route::get('active2', [UserController::class, 'active2'])->middleware('role:Admin')->name('user.active2');
        Route::get('create', [UserController::class, 'create'])->middleware('role:Admin')->name('user.create');
        Route::post('', [UserController::class, 'store'])->middleware('role:Admin')->name('user.store');
        Route::get('{model}/attendances', [UserController::class, 'attendances'])->middleware('role:Admin|Manager')->name('user.attendances');
        Route::get('{id}', [UserController::class, 'edit'])->middleware('role:Admin')->name('user.edit');
        Route::put('{id}', [UserController::class, 'update'])->middleware('role:Admin')->name('user.update');
        Route::delete('{id}', [UserController::class, 'destroy'])->middleware('role:Admin')->name('user.destroy');
        Route::put('{model}/activate', [UserController::class, 'activate'])->middleware('role:Admin')->name('user.activate');
        Route::put('{model}/deactivate', [UserController::class, 'deactivate'])->middleware('role:Admin')->name('user.deactivate');
        Route::get('offices/search', [UserController::class, 'officesearch'])->name('offices.search');
        Route::group(['prefix' => 'device'], function () {
            Route::put('{model}',[DeviceController::class,'toggle'])->name('device.toggle');
             Route::delete('/device/{device}', [DeviceController::class, 'destroy'])->name('device.destroy');
        });
    });


    Route::resource('page', PageController::class)->middleware('role:Admin');

    Route::group(['prefix' => 'file'], function () {
        Route::post('store', [AttachmentController::class, 'store'])->middleware('role:Admin|Manager')->name('attachment.store');
        Route::delete('{model}/remove', [AttachmentController::class, 'destroy'])->middleware('role:Admin|Manager')->name('attachment.destroy');
    });

    Route::group(['prefix' => 'report'], function () {
        Route::get('index', [ReportController::class, 'index'])->middleware('role:Admin|Manager')->name('report.index');
        Route::post('store', [ReportController::class, 'store'])->middleware('role:Admin|Manager')->name('report.generate');
        Route::get('{office}/users', [ReportController::class, 'users'])->middleware('role:Admin|Manager')->name('report.users');
    });

    Route::group(['prefix' => 'stat'], function () {
        Route::get('office', [StatisticController::class, 'officeWiseReport'])->middleware('role:Admin')->name('statistic.office');
        Route::get('office2', [StatisticController::class, 'officeWiseReport2'])->middleware('role:Admin')->name('statistic.office2');
        Route::get('user', [StatisticController::class, 'userWiseReport'])->middleware('role:Manager')->name('statistic.user');
        Route::get('district', [StatisticController::class, 'districtWiseReport'])->middleware('role:Admin')->name('statistic.district');
        Route::get('attendance', [StatisticController::class, 'countAttendance'])->middleware('role:Admin')->name('statistic.attendance');
        Route::get('userattendance/{user_id}', [StatisticController::class, 'countUserAttendance'])->middleware('role:Admin|Manager')->name('statistic.userattendance');
        Route::get('late', [StatisticController::class, 'lateList'])->middleware('role:Admin')->name('statistic.late');
        Route::get('leave', [StatisticController::class, 'leavelist'])->middleware('role:Admin')->name('statistic.leave');
    });

});

Route::group(['prefix' => 'misc'], function () {
    Route::get('events', [MiscController::class, 'events'])->name('misc.events');
    Route::get('attendances', [MiscController::class, 'userAttendance'])->name('misc.attendances');
});
Route::group([['middleware' => 'auth']], function () {
    Route::post('appeal_onDutyweb', [AppealController::class, 'appeal_onDutyweb']);
});

//manager dashboard route
// Route::get('totalofficial', [UserController::class, 'totalofficial'])->name('totalofficial');
// Route::get('present', [UserController::class, 'present'])->name('present');
// Route::get('absent', [UserController::class, 'absent'])->name('absent');
// Route::get('leave', [UserController::class, 'leave'])->name('leave');

Route::group(['prefix' => 'list'], function () {
    Route::get('list', [LateListController::class, 'list'])->middleware('role:Manager')->name('list.late');
});
Route::get('/export-late-attendance', function (Request $request) {
    return Excel::download(new LateAttendanceExport($request->get('search')), 'late_attendance.xlsx');
})->name('export.late.attendance');

//Home dashboard
Route::get('/homedashboard', [HomeDashboardController::class, 'index'])->name('homedashboard');
Route::get('district', [StatisticController::class, 'districtWiseReport2'])->name('statistic.district2');
Route::get('attendance', [StatisticController::class, 'countAttendance'])->name('statistic.attendance2');
Route::get('office3', [StatisticController::class, 'officeWiseReport3'])->name('statistic.office3');
Route::get('office4', [StatisticController::class, 'officeWiseReport4'])->name('statistic.office4');


//require __DIR__.'/auth.php';

// Route::group(['prefix'=>'appeal'], function () {
//     Route::post('{model}/reject', [AppealAttendanceController::class, 'reject'])->name('appeal.reject');
//     Route::post('{model}/approve', [AppealAttendanceController::class, 'approve'])->name('appeal.approve');
// });
// Route::group(['prefix'=>'appeal'], function () {
//     Route::post('{model}/reject_lateReason', [AppealAttendanceController::class, 'reject_lateReason'])->name('appeal.rejectlate');
//     Route::post('{model}/approve_lateReason', [AppealAttendanceController::class, 'approve_lateReason'])->name('appeal.approvelate');
// });
// Route::group(['prefix'=>'appeal'], function () {
//     Route::post('{model}/reject_leftEarly', [AppealAttendanceController::class, 'reject_leftEarly'])->name('appeal.rejectleft');
//     Route::post('{model}/approve_leftEarly', [AppealAttendanceController::class, 'approve_leftEarly'])->name('appeal.approveleft');
// });
