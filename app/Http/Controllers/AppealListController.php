<?php

namespace App\Http\Controllers;

use App\Models\AppealAttendance;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AppealListController extends Controller
{
    public function late_reason(Request $request)
    {
        $ids = auth()->user()->offices()->pluck('offices.id');
        $search = $request->get('search');

        return inertia('Appeal/LateReasonList', [
            'list' => AppealAttendance::query()
                ->with(['user', 'user.offices'])
                ->whereHas('user.offices', fn(Builder $builder) => $builder->whereIn('offices.id', $ids)) // Filter by offices
                ->where('type', 'late_reason')
                ->when($search, fn(Builder $builder) => $builder->whereHas('user', fn($query) =>
                    $query->where('full_name', 'LIKE', "%$search%")
                ))
                ->latest()
                ->simplePaginate(),
            'search' => $search,
        ]);
    }
    public function on_duty(Request $request)
    {
        $ids = auth()->user()->offices()->pluck('offices.id');
        $search = $request->get('search');

        return inertia('Appeal/OnDutyList', [
            'list' => AppealAttendance::query()
                ->with(['user', 'user.offices'])
                ->whereHas('user.offices', fn(Builder $builder) => $builder->whereIn('offices.id', $ids)) // Filter by offices
                ->where('type', 'on_Duty')
                ->when($search, fn(Builder $builder) => $builder->whereHas('user', fn($query) =>
                    $query->where('full_name', 'LIKE', "%$search%")
                ))
                ->latest()
                ->simplePaginate(),
            'search' => $search,
        ]);
    }
    public function left_early(Request $request)
    {
        $ids = auth()->user()->offices()->pluck('offices.id');
        $search = $request->get('search');

        return inertia('Appeal/LeftEarlyList', [
            'list' => AppealAttendance::query()
                ->with(['user', 'user.offices'])
                ->whereHas('user.offices', fn(Builder $builder) => $builder->whereIn('offices.id', $ids)) // Filter by offices
                ->where('type', 'left_early')
                ->when($search, fn(Builder $builder) => $builder->whereHas('user', fn($query) =>
                    $query->where('full_name', 'LIKE', "%$search%")
                ))
                ->latest()
                ->simplePaginate(),
            'search' => $search,
        ]);
    }

}
