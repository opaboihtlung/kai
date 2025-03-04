<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AppealAttendance;
use App\Models\Attendance;
use App\Models\Device;
use App\Models\Office;
use App\Models\User;
use App\Traits\CanFlashMessage;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;



class AppealAttendanceController extends Controller
{
    use CanFlashMessage;
    public function reject(AppealAttendance $model)
    {
        $model->status = AppealAttendance::REJECTED;
        $model->save();

        $this->flashMessage('Appeal  rejected successfully');

        return to_route('dashboard.manager');
    }
    public function reject2(AppealAttendance $model)
    {
        $model->status = AppealAttendance::REJECTED;
        $model->save();

        $this->flashMessage('Appeal  rejected successfully');

        return to_route('appeal.on_duty');
    }


    public function approve(AppealAttendance $model)
    {
        $model->status = AppealAttendance::APPROVED;
        $model->save();

        $this->flashMessage('Appeal approved successfully');

        $user = User::find($model->user_id);
        $office = Office::find($model->office_id);
        $device = Device::where('user_id', $user->id)->first();

        $lat = $office->lat;
        $long = $office->lng;

        $startDate = Carbon::parse($model->start_date);
        $endDate = Carbon::parse($model->end_date);

        $holidays = [
            '01-01-2024', '02-02-2024', '11-01-2024', '26-01-2024', '20-02-2024', '01-03-2024', '25-03-2024', '29-03-2024',
            '11-04-2024', '21-04-2024', '23-05-2024', '15-06-2024', '17-06-2024', '30-06-2024', '06-07-2024', '17-07-2024',
            '15-08-2024', '16-09-2024', '02-10-2024', '12-10-2024', '31-10-2024', '15-11-2024', '24-12-2024', '24-12-2024',
            '26-12-2024', '31-12-2024'
        ];
    for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
        if ($date->isWeekend()) {
            continue;
        }
        $formattedDate = $date->format('d-m-Y');
            if (in_array($formattedDate, $holidays)) {
                continue;
            }


        $signin_at = $date->copy()->setTimeFromTimeString($office->start_time);
        $signout_at = $date->copy()->setTimeFromTimeString($office->close_time);


        $existingAttendance = Attendance::where('user_id', $user->id)
                            ->where('office_id', $office->id)
                            ->whereDate('signin_at', $date)
                            ->first();

                            if ($existingAttendance) {
                                $existingAttendance->update([
                                    'signout_at' => $signout_at,
                                    'signout_lat' =>  $lat,
                                    'signout_lng' => $long,
                                    'in_remark' => 'on-duty with approval'
                                ]);
                                continue;
                            }

        // $signout_at = $date->copy()->setTime(17, 00);
        // $signin_at = $date->copy()->setTime(9, 00);



        $attendance = Attendance::create([
            'user_id' => $user->id,
            'office_id' => $office->id,
            'device_id' => $device->id,
            'signin_at' => $signin_at,
            'signout_at' => $signout_at,
            'signout_lat' =>  $lat,
            'signout_lng' => $long,
            'lat' => $lat,
            'lng' => $long,
            'type' => 'present',
            'in_remark' => 'on-duty with approval'
        ]);

        $attendance->save();
    }

        return to_route('dashboard.manager');
    }
    public function approve2(AppealAttendance $model)
    {
        $model->status = AppealAttendance::APPROVED;
        $model->save();

        $this->flashMessage('Appeal approved successfully');

        $user = User::find($model->user_id);
        $office = Office::find($model->office_id);
        $device = Device::where('user_id', $user->id)->first();

        $lat = $office->lat;
        $long = $office->lng;

        $startDate = Carbon::parse($model->start_date);
        $endDate = Carbon::parse($model->end_date);

        $holidays = [
            '01-01-2024', '02-02-2024', '11-01-2024', '26-01-2024', '20-02-2024', '01-03-2024', '25-03-2024', '29-03-2024',
            '11-04-2024', '21-04-2024', '23-05-2024', '15-06-2024', '17-06-2024', '30-06-2024', '06-07-2024', '17-07-2024',
            '15-08-2024', '16-09-2024', '02-10-2024', '12-10-2024', '31-10-2024', '15-11-2024', '24-12-2024', '24-12-2024',
            '26-12-2024', '31-12-2024'
        ];
    for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
        if ($date->isWeekend()) {
            continue;
        }
        $formattedDate = $date->format('d-m-Y');
            if (in_array($formattedDate, $holidays)) {
                continue;
            }


        $signin_at = $date->copy()->setTimeFromTimeString($office->start_time);
        $signout_at = $date->copy()->setTimeFromTimeString($office->close_time);


        $existingAttendance = Attendance::where('user_id', $user->id)
                            ->where('office_id', $office->id)
                            ->whereDate('signin_at', $date)
                            ->first();

                            if ($existingAttendance) {
                                $existingAttendance->update([
                                    'signout_at' => $signout_at,
                                    'signout_lat' =>  $lat,
                                    'signout_lng' => $long,
                                    'in_remark' => 'on-duty with approval'
                                ]);
                                continue;
                            }

        // $signout_at = $date->copy()->setTime(17, 00);
        // $signin_at = $date->copy()->setTime(9, 00);



        $attendance = Attendance::create([
            'user_id' => $user->id,
            'office_id' => $office->id,
            'device_id' => $device->id,
            'signin_at' => $signin_at,
            'signout_at' => $signout_at,
            'signout_lat' =>  $lat,
            'signout_lng' => $long,
            'lat' => $lat,
            'lng' => $long,
            'type' => 'present',
            'in_remark' => 'on-duty with approval'
        ]);

        $attendance->save();
    }

        return to_route('appeal.on_duty');
    }

    public function reject_lateReason(AppealAttendance $model)
    {

        $model->status = AppealAttendance::REJECTED;
        $model->save();

        $this->flashMessage('Late Reason rejected successfully');

        return to_route('dashboard.manager');
    }
    public function reject_lateReason2(AppealAttendance $model)
    {

        $model->status = AppealAttendance::REJECTED;
        $model->save();

        $this->flashMessage('Late Reason rejected successfully');

        return to_route('appeal.late_reason');
    }

    public function approve_lateReason(AppealAttendance $model)
    {

        $office = Office::find($model->office_id);
        $attendance = Attendance::where('id', $model->attendance_id)
                    ->first();

        $model->status = AppealAttendance::APPROVED;
        $model->save();

        //siamthat leh tur
        // $signinDate = $attendance->signin_at->format('Y-m-d');
        // $attendance->signin_at = $signinDate . $office->start_time;
        // $attendance->signin_at = '9:00:00';
        $attendance->in_remark = 'late with approval';
        $attendance->type = 'present';
        $attendance->save();

        $this->flashMessage('Late Reason approved successfully');

        return to_route('dashboard.manager');
    }
    public function approve_lateReason2(AppealAttendance $model)
    {

        $office = Office::find($model->office_id);
        $attendance = Attendance::where('id', $model->attendance_id)
                    ->first();

        $model->status = AppealAttendance::APPROVED;
        $model->save();

        //siamthat leh tur
        $signinDate = $attendance->signin_at->format('Y-m-d');
        $attendance->signin_at = $signinDate . $office->start_time;
        // $attendance->signin_at = '9:00:00';
        $attendance->in_remark = 'late with approval';
        $attendance->type = 'present';
        $attendance->save();

        $this->flashMessage('Late Reason approved successfully');

        return to_route('appeal.late_reason');
    }
    public function reject_leftEarly(AppealAttendance $model)
    {
        $model->status = AppealAttendance::REJECTED;
        $model->save();

        $this->flashMessage('Left Early Reason rejected successfully');

        return to_route('dashboard.manager');
    }
    public function reject_leftEarly2(AppealAttendance $model)
    {
        $model->status = AppealAttendance::REJECTED;
        $model->save();

        $this->flashMessage('Left Early Reason rejected successfully');

        return to_route('appeal.left_early');
    }

    public function approve_leftEarly(AppealAttendance $model)
    {
        $office = Office::find($model->office_id);

        $attendance = Attendance::where('id', $model->attendance_id)
                    ->first();

        $model->status = AppealAttendance::APPROVED;
        $model->save();

        //siamthat leh tur
        $signinDate = $attendance->signin_at->format('Y-m-d');
        $attendance->signout_at = $signinDate . ' ' . $office->close_time;
        // $attendance->signout_at = $office->close_time;
        $attendance->signout_lat = $office->lat;
        $attendance->signout_lng = $office->lng;
        $attendance->in_remark = 'left-early with approval';
        $attendance->save();
        $this->flashMessage('Left Early Reason approved successfully');

        return to_route('dashboard.manager');
    }
    public function approve_leftEarly2(AppealAttendance $model)
    {
        $office = Office::find($model->office_id);

        $attendance = Attendance::where('id', $model->attendance_id)
                    ->first();

        $model->status = AppealAttendance::APPROVED;
        $model->save();

        //siamthat leh tur
        $signinDate = $attendance->signin_at->format('Y-m-d');
        $attendance->signout_at = $signinDate . ' ' . $office->close_time;
        // $attendance->signout_at = $office->close_time;
        $attendance->signout_lat = $office->lat;
        $attendance->signout_lng = $office->lng;
        $attendance->in_remark = 'left-early with approval';
        $attendance->save();
        $this->flashMessage('Left Early Reason approved successfully');

        return to_route('appeal.left_early');
    }
    public function appealonduty()
    {
        return inertia('Appeal/OnDuty', [

        ]);


    }


}
