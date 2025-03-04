<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;
use App\Constants\ApiResponseType;
// use App\Http\Controllers\Controller;
use App\Models\AppealAttendance;
use App\Models\Attendance;
use App\Models\Office;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;


class AppealController extends Controller
{
    //
    public function index(Request $request)
    {

        $offset = $request->get('offset') ?? 0;
        $limit = $request->get('limit') ?? 10;
        return response()->json([
            'list' => AppealAttendance::query()
                ->where('user_id', auth()->id())
                ->where('type', 'on_Duty')
                ->orderBy('created_at', 'desc')
                ->limit($limit)
                ->offset($offset)
                ->get(),
        ]);
    }

    public function appeal_onDuty(Request $request)
    {

        $validator=Validator::make($request->all(), [
            'reason' => 'required',
            'start_date' => 'required|date_format:d-m-Y',
            'end_date' => 'required|date_format:d-m-Y',

        ]);
        if ($validator->fails()) {
            return response()->json([
                'status'=>ApiResponseType::VALIDATION_ERROR,
                'errors'=>$validator->errors()
            ]);
        }
        $office=Office::query()
        ->whereHas('users', fn(Builder $builder)=>$builder->where('users.id',auth()->id()))
        ->first();
        $data = $validator->validated();
        $startDate = Carbon::createFromFormat('d-m-Y', $request->start_date)->format('Y-m-d');
        $endDate = Carbon::createFromFormat('d-m-Y', $request->end_date)->format('Y-m-d');

        $duplicate = AppealAttendance::query()
                    ->where('user_id', auth()->id())
                    ->where('type', 'on_Duty')
                    ->where(function ($query) use ($startDate, $endDate) {
                        $query->whereBetween('start_date', [$startDate, $endDate])
                            ->orWhereBetween('end_date', [$startDate, $endDate])
                            ->orWhere(function ($query) use ($startDate, $endDate) {
                                $query->where('start_date', '<=', $startDate)
                                        ->where('end_date', '>=', $endDate);
                            });
                    })
    ->exists();
        if ($duplicate) {
        return response()->json([
            'status' => ApiResponseType::DUPLICATE_APPEAL_ATTENDANCE,
            'message' => 'Appeal already applied',
        ]);
        }


        $appeal_onDuty=AppealAttendance::query()->create([
            'user_id'=>auth()->id(),
            'office_id'=>$office->id,
            'start_date' => $startDate ,
            'end_date' => $endDate,
            'type' => 'on_Duty',
            'reason' => $data['reason'],
        ]);


        return response()->json([
            'status'=>ApiResponseType::SUCCESS,
            'data'=>$appeal_onDuty,
            'message'=>'Your application is processing, Please wait for approval'
        ]);
    }
    public function appeal_onDutyweb(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'reason' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => ApiResponseType::VALIDATION_ERROR,
                'errors' => $validator->errors()
            ]);
        }

        $office = Office::query()
            ->whereHas('users', fn(Builder $builder) => $builder->where('users.id', auth()->id()))
            ->first();

        $data = $validator->validated();


        $startDate = $request->start_date;
        $endDate = $request->end_date;


        $duplicate = AppealAttendance::query()
            ->where('user_id', auth()->id())
            ->where('type', 'on_Duty')
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('start_date', [$startDate, $endDate])
                    ->orWhereBetween('end_date', [$startDate, $endDate])
                    ->orWhere(function ($query) use ($startDate, $endDate) {
                        $query->where('start_date', '<=', $startDate)
                            ->where('end_date', '>=', $endDate);
                    });
            })
            ->exists();

        if ($duplicate) {
            return response()->json([
                'status' => ApiResponseType::DUPLICATE_APPEAL_ATTENDANCE,
                'message' => 'Appeal already applied',
            ]);
        }


        $appeal_onDuty = AppealAttendance::query()->create([
            'user_id' => auth()->id(),
            'office_id' => $office->id,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'type' => 'on_Duty',
            'reason' => $data['reason'],
        ]);

        return response()->json([
            'status' => ApiResponseType::SUCCESS,
            'data' => $appeal_onDuty,
            'message' => 'Your application is processing, please wait for approval'
        ]);
    }

    public function appeal_lateReason(Request $request,Attendance  $model)
    {


        $validator=Validator::make($request->all(),[
            'reason' => 'required|string',
            // 'type' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'=>ApiResponseType::VALIDATION_ERROR,
                'errors'=>$validator->errors()
            ]);
        }
        $data = $validator->validated();


        $duplicate = AppealAttendance::query()
                    ->where('attendance_id', $model->id)
                    ->where('type','late_reason' )
                    ->exists();
        if ($duplicate) {

        return response()->json([
            'status' => ApiResponseType::DUPLICATE_APPEAL_ATTENDANCE,
            'message' => 'Appeal already applied',
        ]);

        }
        $signinTime = \Carbon\Carbon::parse($model->signin_at)->format('h:i A');
        info($signinTime);
        $appeal_lateReason = AppealAttendance::query()->create([
            'attendance_id' => $model->id,
            'user_id' => $model->user_id,
            'office_id' => $model->office_id,
            'start_date' => $model->signin_at,
            'type' => 'late_reason',
            'reason' => $data['reason'],
            'signin_time' => $signinTime
        ]);


        return response()->json([
            'status'=>ApiResponseType::SUCCESS,
            'data'=>$appeal_lateReason,
            'message'=>'Your application is processing, Please wait for approval'
        ]);
    }
    public function appeal_leftEarly(Request $request,Attendance  $model)
    {
// info($request->all());

        $validator=Validator::make($request->all(),[
            'reason' => 'required|string',
            // 'type' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'=>ApiResponseType::VALIDATION_ERROR,
                'errors'=>$validator->errors()
            ]);
        }
        $data = $validator->validated();


        $duplicate = AppealAttendance::query()
                    ->where('attendance_id', $model->id)
                    ->where('type', 'left_early')
                    ->exists();
        if ($duplicate) {

        return response()->json([
            'status' => ApiResponseType::DUPLICATE_APPEAL_ATTENDANCE,
            'message' => 'Appeal already applied',
        ]);

        }

        $left_early = AppealAttendance::query()->create([
            'attendance_id' => $model->id,
            'user_id' => $model->user_id,
            'office_id' => $model->office_id,
            'start_date' => $model->signin_at,
            'type' => 'left_early',
            'reason' => $data['reason'],
        ]);


        return response()->json([
            'status'=>ApiResponseType::SUCCESS,
            'data'=>$left_early,
            'message'=>'Your application is processing, Please wait for approval'
        ]);
    }
}
