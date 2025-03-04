<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class LateListController extends Controller
{

    public function list(Request $request)
{
    // Get office IDs associated with the authenticated user
    $ids = auth()->user()->offices()->pluck('offices.id');

    // Get search query
    $search = $request->get('search');

    // Set the date range for the current week
    $from = Carbon::now()->startOfWeek()->format('Y-m-d');
    $to = Carbon::now()->endOfWeek()->format('Y-m-d');


        return inertia('Latelist/3daylatelist', [
            'list' => Attendance::query()
                ->with(['user', 'user.offices'])
                ->whereHas('user.offices', fn(Builder $builder) =>
                    $builder->whereIn('offices.id', $ids)
                )
                ->where('type', 'late')
                ->whereBetween('signin_at', [$from, $to])
                ->selectRaw('user_id, COUNT(DISTINCT DATE(signin_at)) as late_days, MAX(created_at) as last_late')
                ->groupBy('user_id')
                ->havingRaw('late_days >= 3')
                ->when($search, fn(Builder $builder) => $builder->whereHas('user', fn($query) =>
                    $query->where('full_name', 'LIKE', "%$search%")
                ))
                ->orderBy('last_late', 'desc')
                ->simplePaginate(),
            'search' => $search,
        ]);

}
}

