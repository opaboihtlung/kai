<?php

namespace App\Http\Controllers;

use App\Models\AppealAttendance;
use App\Models\Attendance;
use App\Models\Device;
use App\Models\District;
use App\Models\Office;
use App\Models\User;
use App\Models\UserOffice;
use App\Traits\CanFlashMessage;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Controller;

class DashboardController extends Controller
{
    use CanFlashMessage;

    public function index(Request $request)
    {
        $user = auth()->user();

        if ($user->hasRole('Admin')) {
            return to_route('dashboard.admin');
        }

        if ($user->hasRole('Manager')) {
            return to_route('dashboard.manager');
        }


        $this->addBreadcrumbs([
            ['name' => 'dashboard', 'label' => 'Dashboard']
        ]);

//        $countAbsence = Attendance::query()->count();
        return inertia('Dashboard', [
            'user' => $user,
            'office' => ($user)->offices()->first(),
            'current_sessions' => Attendance::query()
                ->with(['user'])
                ->whereNull('signout_at')
                ->where('user_id', $user->id)
                ->get(),
            'weekly_attendances' => Attendance::query()
                ->whereBetween('signin_at', [now()->startOfWeek()->format('Y-m-d'), now()->endOfWeek()->format('Y-m-d')])
                ->where('user_id', auth()->id())
                ->latest()
                ->get()

        ]);
    }
    public function admin2()
    {
        return to_route('dashboard.admin');
    }

    public function admin(Request $request)
    {
        $from = $request->get('from') ?? now()->startOfWeek()->format('Y-m-d');
        $to = $request->get('to') ?? now()->endOfWeek()->format('Y-m-d');



        return inertia('Dashboard/Admin', [
            'count_user' => User::query()->count(),
            'count_office' => Office::query()->count(),
            'count_attendance' => Attendance::query()
                ->whereDate('signin_at', '>=', $from)
                ->whereDate('signin_at', '<=', $to)
                ->count(),
            'count_leave' => Attendance::query()
                ->whereDate('start_date', '<=', Carbon::today())
                ->whereDate('end_date', '>=', Carbon::today())
                ->distinct('user_id')
                ->count()
        ]);
    }
    public function adminTotalLeave(Request $request)
    {
        $from = $request->get('from') ?? now()->startOfWeek()->format('Y-m-d');
        $to = $request->get('to') ?? now()->endOfWeek()->format('Y-m-d');



        return inertia('Dashboard/adminTotalLeave', [
            'count_user' => User::query()->count(),
            'count_office' => Office::query()->count(),
            'count_attendance' => Attendance::query()
                ->whereDate('signin_at', '>=', $from)
                ->whereDate('signin_at', '<=', $to)
                ->count(),
            'count_leave' => Attendance::query()
                ->whereDate('start_date', '<=', Carbon::today())
                ->whereDate('end_date', '>=', Carbon::today())
                ->distinct('user_id')
                ->count()
        ]);
    }

    public function managerchart(Request $request)
    {
        return inertia('Dashboard/ManagerChart', [
        ]);
    }
    public function manager(Request $request)
    {


        $user = auth()->user();
        $search = $request->get('search') ?? '';
        $officeIds = ($user)->offices()->pluck('offices.id');
        $from = $request->get('from') ?? Carbon::parse('last monday')->format('Y-m-d');
        $to = $request->get('to') ?? Carbon::parse('this friday')->format('Y-m-d');
        $users = User::query()
        ->whereHas('offices', fn(Builder $builder) => $builder->whereIn('offices.id', $officeIds))
        ->get();
    // $signedInUsers = Attendance::query()
    //     ->whereDate('signin_at', now())
    //     ->pluck('user_id');
    // $absentUsers = $users->whereNotIn('id', $signedInUsers);
    // $today = now()->toDateString();
    // $absentUsersWithLeave = $absentUsers->map(function ($user) use ($today) {
    //     $leave = Attendance::where('user_id', $user->id)
    //         ->where('start_date', '<=', $today)
    //         ->where('end_date', '>=', $today)
    //         ->first();

    //     $user->leaveType = $leave ? $leave->leaveType : null;
    //     return $user;
    // })->filter(function ($user) {
    //     return $user->leaveType !== null;
    // });
    // $noOfLeave=count($absentUsersWithLeave);
    $count_attendances = Attendance::query()
    ->with(['user'])
    ->whereDate('signin_at', now())
    ->whereIn('user_id', $users?->pluck('id'))->count();
    $attendances = Attendance::query()
    ->when(filled($search), function (Builder $builder) use ($search) {
    $builder->whereHas('user', function (Builder $query) use ($search) {
        $query->where('full_name', 'LIKE', "%$search%");
    });
    })
    ->with(['user'])
    ->whereDate('signin_at', now())
    ->whereIn('user_id', $users?->pluck('id'))
    ->simplePaginate();
//        $users = UserOffice::query()->whereIn('office_id', $officeIds)->pluck('user_id');
        $users = User::query()->whereHas('offices', fn(Builder $builder) => $builder->whereIn('offices.id',$officeIds))->get();
        return inertia('Dashboard/Manager', [
            'user' => auth()->user(),
            'total_users' => count($users),
            'search' => $search,
            'current_sessions' => Attendance::query()
                ->with(['user'])
                ->whereNull('signout_at')
                ->where('user_id', $user->id)
                ->get(),
            'devices' => Device::query()
                ->with(['user'])
                ->whereIn('user_id', $users?->pluck('id'))
                ->where('status', Device::SUBMITTED)
                ->take(7)->get(),
            'appeal_attendances' => AppealAttendance::query()
                ->with(['user'])
                ->whereIn('user_id', $users?->pluck('id'))
                ->where('type', 'on_Duty')
                ->where('status', AppealAttendance::SUBMITTED)
                ->take(7)->get(),
            'appeal_lateReason' => AppealAttendance::query()
                ->with(['user'])
                ->whereIn('user_id', $users?->pluck('id'))
                ->where('type', 'late_reason')
                ->where('status', AppealAttendance::SUBMITTED)
                ->take(7)->get(),
            'appeal_leftEarly' => AppealAttendance::query()
                ->with(['user'])
                ->whereIn('user_id', $users?->pluck('id'))
                ->where('type', 'left_early')
                ->where('status', AppealAttendance::SUBMITTED)
                ->take(7)->get(),
            'attendances' =>$attendances,
            'count_attendances'=> $count_attendances,

            // 'noOfLeave' => $noOfLeave
        ]);
    }
    public function totalofficial(Request $request)
    {
        $user = auth()->user();
        $officeIds = ($user)->offices()->pluck('offices.id');
        $users = User::query()->whereHas('offices', fn(Builder $builder) => $builder->whereIn('offices.id',$officeIds))->get();
        $search = $request->get('search');
        $signedInUsers = Attendance::query()
        ->whereDate('signin_at', now())
        ->pluck('user_id');
        $absentUsers = $users->whereNotIn('id', $signedInUsers);
        // $today = now()->toDateString();
        // $absentUsersWithLeave = $absentUsers->map(function ($user) use ($today) {
        //     $leave = Attendance::where('user_id', $user->id)
        //         ->where('start_date', '<=', $today)
        //         ->where('end_date', '>=', $today)
        //         ->first();

        //     $user->leaveType = $leave ? $leave->leaveType : null;
        //     return $user;
        // })->filter(function ($user) {
        //     return $user->leaveType !== null;
        // });

        // $noOfLeave=count($absentUsersWithLeave);
        $count_users = User::query()->whereHas('offices', fn(Builder $builder) => $builder->whereIn('offices.id',$officeIds))->get();
        $attendances = Attendance::query()
        ->with(['user'])
        ->whereDate('signin_at', now())
        ->whereIn('user_id', $users?->pluck('id'))->get();
        $count_attendances = Attendance::query()
        ->with(['user'])
        ->whereDate('signin_at', now())
        ->whereIn('user_id', $users?->pluck('id'))->count();
        $paginate_users = User::query()
        ->when($search,fn(Builder $builder)=>$builder->where('full_name','LIKE',"%$search%"))
        ->whereHas('offices', function (Builder $query) use ($officeIds) {
            $query->whereIn('offices.id', $officeIds);
        })->with('offices')->simplePaginate();

        return inertia('User/totalofficial', [
            'user' => auth()->user(),
            'total_users' => count($count_users),
            'current_sessions' => Attendance::query()
                ->with(['user'])
                ->whereNull('signout_at')
                ->where('user_id', $user->id)
                ->get(),
            'attendances' =>$attendances,
            'users' => $paginate_users,
            'search' => $search,
            'count_attendances' => $count_attendances,
            'absent_users' => $absentUsers,
            // 'noOfLeave' => $noOfLeave
        ]);
    }

    public function present(Request $request)
    {
        $user = auth()->user();
        $search = $request->get('search') ?? '';
        $officeIds = ($user)->offices()->pluck('offices.id');
        $users = User::query()->whereHas('offices', fn(Builder $builder) => $builder->whereIn('offices.id',$officeIds))->get();
        $signedInUsers = Attendance::query()
        ->whereDate('signin_at', now())
        ->pluck('user_id');
        $absentUsers = $users->whereNotIn('id', $signedInUsers);
        // $today = now()->toDateString();
        // $absentUsersWithLeave = $absentUsers->map(function ($user) use ($today) {
        //     $leave = Attendance::where('user_id', $user->id)
        //         ->where('start_date', '<=', $today)
        //         ->where('end_date', '>=', $today)
        //         ->first();

        //     $user->leaveType = $leave ? $leave->leaveType : null;
        //     return $user;
        // })->filter(function ($user) {
        //     return $user->leaveType !== null;
        // });
        // $noOfLeave=count($absentUsersWithLeave);

        $count_attendances = Attendance::query()
        ->with(['user'])
        ->whereDate('signin_at', now())
        ->whereIn('user_id', $users?->pluck('id'))->count();

        $attendances = Attendance::query()
        ->when(filled($search), function (Builder $builder) use ($search) {
        $builder->whereHas('user', function (Builder $query) use ($search) {
            $query->where('full_name', 'LIKE', "%$search%");
        });
        })
        ->with(['user'])
        ->whereDate('signin_at', now())
        ->whereIn('user_id', $users?->pluck('id'))
        ->simplePaginate();

        return inertia('User/present', [
            'user' => auth()->user(),
            'search' => $search,
            'total_users' => count($users),
            'current_sessions' => Attendance::query()
                ->with(['user'])
                ->whereNull('signout_at')
                ->where('user_id', $user->id)
                ->get(),
            'attendances' =>$attendances,
            'count_attendances'=> $count_attendances,
            // 'noOfLeave' => $noOfLeave

        ]);
    }

    public function absent(Request $request)
    {
        $user = auth()->user();
        $search = $request->get('search');
        $officeIds = ($user)->offices()->pluck('offices.id');
        $users = User::query()->whereHas('offices', fn(Builder $builder) => $builder->whereIn('offices.id',$officeIds))->get();
        $signedInUsers = Attendance::query()
        ->whereDate('signin_at', now())
        ->pluck('user_id');
        // $absentUsers = $users->whereNotIn('id', $signedInUsers);
        // $today = now()->toDateString();
        // $absentUsersWithLeave = $absentUsers->map(function ($user) use ($today) {
        //     $leave = Attendance::where('user_id', $user->id)
        //         ->where('start_date', '<=', $today)
        //         ->where('end_date', '>=', $today)
        //         ->first();

        //     $user->leaveType = $leave ? $leave->leaveType : null;
        //     return $user;
        // })->filter(function ($user) {
        //     return $user->leaveType !== null;
        // });
        // $noOfLeave=count($absentUsersWithLeave);
        $count_attendances = Attendance::query()
        ->with(['user'])
        ->whereDate('signin_at', now())
        ->whereIn('user_id', $users?->pluck('id'))->count();
        $paginate_absentUsers = User::query()
        ->when($search,fn(Builder $builder)=>$builder->where('full_name','LIKE',"%$search%"))
        ->whereHas('offices', fn(Builder $builder) => $builder->whereIn('offices.id', $officeIds))
        ->whereNotIn('id', $signedInUsers)
        ->simplePaginate();
        return inertia('User/absent', [
            'user' => auth()->user(),
            'search' => $search,
            'total_users' => count($users),
            'current_sessions' => Attendance::query()
                ->with(['user'])
                ->whereNull('signout_at')
                ->where('user_id', $user->id)
                ->get(),
            'attendances' => Attendance::query()
                ->with(['user'])
                ->whereDate('signin_at', now())
                ->whereIn('user_id', $users?->pluck('id'))->get(),
            'absent_users' => $paginate_absentUsers,
            'count_attendances'=> $count_attendances,
            // 'noOfLeave' => $noOfLeave
        ]);
    }
    // public function leave(Request $request)
    // {
    //     $user = auth()->user();
    //     $search = $request->get('search');
    //     $officeIds = $user->offices()->pluck('offices.id');
    //     $users = User::query()
    //         ->whereHas('offices', fn(Builder $builder) => $builder->whereIn('offices.id', $officeIds))
    //         ->get();
    //     $signedInUsers = Attendance::query()
    //         ->whereDate('signin_at', now())
    //         ->pluck('user_id');
    //     $absentUsers = $users->whereNotIn('id', $signedInUsers);
    //     $today = now()->toDateString();
    //     $totalAbsentUsersWithLeave = $absentUsers->map(function ($user) use ($today) {
    //         $leave = Attendance::query()
    //             ->where('user_id', $user->id)
    //             ->where('start_date', '<=', $today)
    //             ->where('end_date', '>=', $today)
    //             ->first();

    //         $user->leaveType = $leave ? $leave->leaveType : null;
    //         return $user;
    //     })->filter(function ($user) {
    //         return $user->leaveType !== null;
    //     })->count();
    //     $absentUsersWithLeave = $absentUsers->map(function ($user) use ($today, $search) {
    //         $leave = Attendance::query()
    //             ->when(filled($search), function (Builder $builder) use ($search) {
    //                 $builder->whereHas('user', function (Builder $query) use ($search) {
    //                     $query->where('full_name', 'LIKE', "%$search%");
    //                 });
    //             })
    //             ->where('user_id', $user->id)
    //             ->where('start_date', '<=', $today)
    //             ->where('end_date', '>=', $today)
    //             ->first();

    //         $user->leaveType = $leave ? $leave->leaveType : null;
    //         return $user;
    //     })->filter(function ($user) {
    //         return $user->leaveType !== null;
    //     });
    //     $absentUsersWithLeaveArray = $absentUsersWithLeave->values()->all();
    //     $perPage = 15;
    //     $currentPage = LengthAwarePaginator::resolveCurrentPage();
    //     $currentItems = array_slice($absentUsersWithLeaveArray, ($currentPage - 1) * $perPage, $perPage);
    //     $absentUsersWithLeavePaginated = new LengthAwarePaginator(
    //         $currentItems,
    //         count($absentUsersWithLeaveArray),
    //         $perPage,
    //         $currentPage,
    //         ['path' => LengthAwarePaginator::resolveCurrentPath()]
    //     );


    //     $count_attendances = Attendance::query()
    //         ->with(['user'])
    //         ->whereDate('signin_at', now())
    //         ->whereIn('user_id', $users?->pluck('id'))->count();

    //     return inertia('User/leave', [
    //         'user' => auth()->user(),
    //         'total_users' => count($users),
    //         'current_sessions' => Attendance::query()
    //             ->with(['user'])
    //             ->whereNull('signout_at')
    //             ->where('user_id', $user->id)
    //             ->get(),
    //         'attendances' => Attendance::query()
    //             ->with(['user'])
    //             ->whereDate('signin_at', now())
    //             ->whereIn('user_id', $users?->pluck('id'))->get(),
    //         'absentUsersWithLeave' => $absentUsersWithLeavePaginated,
    //         'count_attendances' => $count_attendances,
    //         'search' => $search,
    //         'noOfLeave' => $totalAbsentUsersWithLeave
    //     ]);
    // }
    public function leave(Request $request)
{
    $user = auth()->user();
    $search = $request->get('search');
    $officeIds = $user->offices()->pluck('offices.id');

    // Fetch users with their leave information
    $users = User::query()
        ->whereHas('offices', fn(Builder $builder) => $builder->whereIn('offices.id', $officeIds))
        ->when(filled($search), function ($query) use ($search) {
            $query->where('full_name', 'LIKE', "%$search%");
        })
        ->with(['attendances' => function ($query) {
            $query->whereDate('start_date', '<=', now())
                  ->whereDate('end_date', '>=', now());
        }])
        ->get();

    // Filter users to include only those with leaveType
    $filteredUsers = $users->map(function ($user) {
        $user->leaveType = $user->attendances->isEmpty() ? null : $user->attendances->first()->leaveType;
        return $user;
    })->filter(fn($user) => $user->leaveType !== null)->values(); // Remove users with null leaveType

    // Manually paginate
    $perPage = 15;
    $currentPage = LengthAwarePaginator::resolveCurrentPage();
    $currentPageItems = $filteredUsers->slice(($currentPage - 1) * $perPage, $perPage)->values();

    $paginatedUsers = new LengthAwarePaginator(
        $currentPageItems,
        $filteredUsers->count(),
        $perPage,
        $currentPage,
        ['path' => request()->url(), 'query' => request()->query()]
    );

    return inertia('User/leave', [
        'absentUsersWithLeave' => $paginatedUsers,
        'search' => $search,
    ]);
}
}
