<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\District;
use App\Models\Office;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticController extends Controller
{
//     public function officeWiseReport(Request $request)
//     {
// //        $from = $request->get('from') ?? Carbon::parse('last monday')->format('Y-m-d');
// //        $to = $request->get('to') ?? Carbon::parse('this friday')->format('Y-m-d');
//         $from = $request->get('from') ?? now()->format('Y-m-d');
//         $to = $request->get('to') ?? now()->format('Y-m-d');

//         $list = Office::query()
//             ->with([
//                 'attendances'=>fn($builder)=> $builder->whereDate('signin_at','>=',$from)
//                                                       ->whereDate('signin_at','<=',$to)
//             ])
//             ->withCount('users')
//             ->whereHas('attendances')->get();

//         return response()->json([
//             'offices' => $list
//         ]);
//     }
public function officeWiseReport(Request $request)
{
    $from = $request->get('from') ?? now()->format('Y-m-d');
    $to = $request->get('to') ?? now()->format('Y-m-d');

    // Fetch all offices with attendance within the date range
    $list = Office::with([
        'attendances' => fn($builder) => $builder->whereDate('signin_at', '>=', $from)
                                                  ->whereDate('signin_at', '<=', $to)
    ])
    ->withCount('users')
    ->whereHas('attendances')
    ->get(); // Get all records instead of limiting

    // Calculate the number of records to take (50%)
    $totalRecords = $list->count();
    $halfRecords = (int) ceil($totalRecords / 2); // Calculate 50%

    // Take the first 50% of the records
    $firstHalf = $list->slice(0, $halfRecords);

    return response()->json([
        'offices' => $firstHalf
    ]);
}
public function officeWiseReport2(Request $request)
{
    $from = $request->get('from') ?? now()->format('Y-m-d');
    $to = $request->get('to') ?? now()->format('Y-m-d');

    // Fetch all offices with attendance within the date range
    $list = Office::with([
        'attendances' => fn($builder) => $builder->whereDate('signin_at', '>=', $from)
                                                  ->whereDate('signin_at', '<=', $to)
    ])
    ->withCount('users')
    ->whereHas('attendances')
    ->orderBy('created_at', 'desc')
    ->get(); // Get all records instead of limiting

    // Calculate the number of records to take (50%)
    $totalRecords = $list->count();
    $halfRecords = (int) ceil($totalRecords / 2); // Calculate 50%

    // Take the first 50% of the records
    $firstHalf = $list->slice(0, $halfRecords);

    return response()->json([
        'offices' => $firstHalf
    ]);
}
public function officeWiseReport3(Request $request)
{
    $from = $request->get('from') ?? now()->format('Y-m-d');
    $to = $request->get('to') ?? now()->format('Y-m-d');

    // Fetch all offices with attendance within the date range
    $list = Office::with([
        'attendances' => fn($builder) => $builder->whereDate('signin_at', '>=', $from)
                                                  ->whereDate('signin_at', '<=', $to)
    ])
    ->withCount('users')
    ->whereHas('attendances')
    ->orderBy('name', 'asc')
    ->get(); // Get all records instead of limiting

    // Calculate the number of records to take (50%)
    $totalRecords = $list->count();
    $halfRecords = (int) ceil($totalRecords / 2); // Calculate 50%

    // Take the first 50% of the records
    $firstHalf = $list->slice(0, $halfRecords);

    return response()->json([
        'offices' => $firstHalf
    ]);
}
public function officeWiseReport4(Request $request)
{
    $from = $request->get('from') ?? now()->format('Y-m-d');
    $to = $request->get('to') ?? now()->format('Y-m-d');

    // Fetch all offices with attendance within the date range
    $list = Office::with([
        'attendances' => fn($builder) => $builder->whereDate('signin_at', '>=', $from)
                                                  ->whereDate('signin_at', '<=', $to)
    ])
    ->withCount('users')
    ->whereHas('attendances')
    ->orderBy('name', 'desc')
    ->get(); // Get all records instead of limiting

    // Calculate the number of records to take (50%)
    $totalRecords = $list->count();
    $halfRecords = (int) ceil($totalRecords / 2-1); // Calculate 50%

    // Take the first 50% of the records
    $firstHalf = $list->slice(0, $halfRecords);

    return response()->json([
        'offices' => $firstHalf
    ]);
}


    public function countAttendance(Request $request)
    {
        $from = $request->get('from') ?? Carbon::parse('last monday')->format('Y-m-d');
        $to = $request->get('to') ?? Carbon::parse('this friday')->format('Y-m-d');

        $countPresent = Attendance::query()->whereDate('signin_at', now())
            ->where('type', Attendance::PRESENT)
            ->count();

        $countLate = Attendance::query()->whereDate('signin_at', now())
            ->where('type', Attendance::LATE)
            ->count();

        $countTotal = User::query()->count();
        return response()->json([
            'count_present'=>$countPresent,
            'count_late'=>$countLate,
            'count_absent'=>$countTotal-$countPresent-$countLate,
        ]);
    }
    public function countUserAttendance($id)
    {
        // dd($id);
        $user = User::query();

        $countPresent = Attendance::query()
            ->where('type', Attendance::PRESENT)
            ->where('user_id', $id)
            ->count();

        $countLate = Attendance::query()
            ->where('type', Attendance::LATE)
            ->where('user_id', $id)
            ->count();


        return response()->json([
            'count_present'=>$countPresent,
            'count_late'=>$countLate
        ]);
    }
    public function districtWiseReport(Request $request)
    {
//        $from = $request->get('from') ?? Carbon::parse('last monday')->format('Y-m-d');
//        $to = $request->get('to') ?? Carbon::parse('this friday')->format('Y-m-d');
        $from = $request->get('from') ?? now()->startOfWeek()->format('Y-m-d');
        $to = $request->get('to') ?? now()->endOfWeek()->format('Y-m-d');
        $list = District::query()
            ->with([
                'attendances'=>fn($builder)=> $builder->whereDate('signin_at','>=',$from)
                    ->whereDate('signin_at','<=',$to)
            ])
            ->whereHas('attendances')
            ->get();

        return response()->json([
            'districts' => $list
        ]);
    }
    public function districtWiseReport2(Request $request)
    {
//        $from = $request->get('from') ?? Carbon::parse('last monday')->format('Y-m-d');
//        $to = $request->get('to') ?? Carbon::parse('this friday')->format('Y-m-d');
        $from = $request->get('from') ?? now()->startOfWeek()->format('Y-m-d');
        $to = $request->get('to') ?? now()->endOfWeek()->format('Y-m-d');
        $list = District::query()
            ->with([
                'attendances'=>fn($builder)=> $builder->whereDate('signin_at','>=',$from)
                    ->whereDate('signin_at','<=',$to)
            ])
            ->whereHas('attendances')
            ->get();

        return response()->json([
            'districts' => $list
        ]);
    }
    // public function userWiseReport(Request $request)
    // {
    //     $from = $request->get('from') ?? now()->format('Y-m-d');
    //     $to = $request->get('to') ?? now()->format('Y-m-d');
    //     $user = auth()->user();
    //     $officeIds = $user->offices()->pluck('offices.id');

    //     $list = User::query()
    //         ->whereHas('offices', fn(Builder $builder) => $builder->whereIn('offices.id', $officeIds))
    //         ->withCount('attendances') // Get the count of attendances
    //         ->with([
    //             'attendances' => fn($builder) => $builder->whereDate('signin_at', '>=', $from)
    //                                                      ->whereDate('signin_at', '<=', $to)
    //         ])
    //         ->whereHas('attendances')
    //         ->get();

    //     return response()->json([
    //         'users' => $list
    //     ]);
    // }

    public function userWiseReport(Request $request)
    {
        // Get the 'from' and 'to' dates, defaulting to the current week if not provided
        $from = $request->get('from') ?? now()->startOfWeek()->format('Y-m-d'); // Start of the week (Monday)
        $to = $request->get('to') ?? now()->format('Y-m-d'); // End of the week (today)

        // Get the authenticated user and their associated office IDs
        $user = auth()->user();
        $officeIds = $user->offices()->pluck('offices.id');

        // Query users who belong to the same offices as the authenticated user
        $list = User::query()
            ->whereHas('offices', fn(Builder $builder) => $builder->whereIn('offices.id', $officeIds))
            ->with([
                'attendances' => fn($builder) => $builder->whereDate('signin_at', '>=', $from)
                                                         ->whereDate('signin_at', '<=', $to)
            ])
            ->withCount([
                // Count the number of 'present' attendances within the date range
                'attendances as present_count' => fn($builder) => $builder->where('type', 'present')
                                                                          ->whereDate('signin_at', '>=', $from)
                                                                          ->whereDate('signin_at', '<=', $to),

                // Count the number of 'late' attendances within the date range
                'attendances as late_count' => fn($builder) => $builder->where('type', 'late')
                                                                        ->whereDate('signin_at', '>=', $from)
                                                                        ->whereDate('signin_at', '<=', $to),

                // Count the total number of attendances within the date range
                'attendances as total_count' => fn($builder) => $builder->whereDate('signin_at', '>=', $from)
                                                                         ->whereDate('signin_at', '<=', $to),
            ])
            ->get();

        // Return the result as a JSON response
        return response()->json([
            'users' => $list
        ]);
    }


    public function lateList(Request $request)
    {
        $list = User::query()
            ->latest()
            ->take(5)->get();

        return response()->json([
            'list' => $list
        ]);
    }
    public function leaveList(Request $request)
    {
        $today = Carbon::today();

                $list = Attendance::query()->with(['user','office'])
                ->where('type', 'absent')
                ->whereDate('start_date', '<=', $today)
                ->whereDate('end_date', '>=', $today)
                ->get();

        return response()->json([
            'list' => $list
        ]);
}
}
