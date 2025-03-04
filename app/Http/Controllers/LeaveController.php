<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Device;
use App\Models\Office;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Controller;
use Illuminate\Database\Eloquent\Builder;

class LeaveController extends Controller
{
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'mobile' => 'required|string',
            'leaveType' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'no_of_days' => 'required|numeric',
        ]);

        // Find the user by mobile number
        $user = User::where('mobile', $validatedData['mobile'])->first();

        if (!$user) {
            return response()->json([
                'message' => 'Mobile No. not found',
            ], 404);
        }
        
        $device = Device::where('user_id', $user->id)->first();

        // Add user_id to the validated data
        $validatedData['user_id'] = $user->id;


        $office = Office::whereHas('users', function (Builder $builder) use ($user) {
            $builder->where('users.id', $user->id);
        })->first();

        unset($validatedData['mobile']);
        $randomDate = Carbon::now()->subDays(rand(0, 365))->startOfDay();

        $lat = rand(-90, 90) + (rand(0, 9999) / 10000); // Random latitude with more precision
        $long = rand(-180, 180) + (rand(0, 9999) / 10000);

        $leaveRequest = Attendance::create([
            'user_id' => $user->id,
            'office_id'=> $office->id,
            'device_id'=> $device->id,
            'signin_at'=> $randomDate,
            'signout_at'=> $randomDate,
            'lat' => $lat ,
            'lng' => $long,
            'type' => 'absent',
            'mobile' => $request->input('mobile'),
            'leaveType' => $request->input('leaveType'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
            'no_of_days' => $request->input('no_of_days'),
        ]);

        return response()->json([
            'message' => 'Leave request stored successfully',
            'data' => $leaveRequest
        ], 201);
    }
}

