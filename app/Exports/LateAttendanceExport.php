<?php

namespace App\Exports;

use App\Models\Attendance;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Database\Eloquent\Builder;

class LateAttendanceExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $ids = auth()->user()->offices()->pluck('offices.id');
        $from = Carbon::now()->startOfWeek()->format('Y-m-d');
        $to = Carbon::now()->endOfWeek()->format('Y-m-d');

        return Attendance::query()
            ->with(['user', 'user.offices'])
            ->whereHas('user.offices', fn(Builder $builder) =>
                $builder->whereIn('offices.id', $ids)
            )
            ->where('type', 'late')
            ->whereBetween('signin_at', [$from, $to])
            ->selectRaw('user_id, COUNT(DISTINCT DATE(signin_at)) as late_days, MAX(created_at) as last_late')
            ->groupBy('user_id')
            ->havingRaw('late_days >= 3')
            ->get()
            ->map(function ($attendance, $index) use ($from, $to) {
                $user = $attendance->user;
                $offices = $user->offices->pluck('name')->implode(', ');


                $lateDates = Attendance::query()
                    ->where('user_id', $attendance->user_id)
                    ->where('type', 'late')
                    ->whereBetween('signin_at', [$from, $to])
                    ->pluck('signin_at')
                    ->map(fn($date) => Carbon::parse($date)->format('Y-m-d'))
                    ->unique()
                    ->implode(', ');

                return [
                    'SN'           => $index + 1,
                    'full_name'    => $user->full_name,
                    'mobile'       => $user->mobile,
                    'designation'  => $user->designation,
                    'office_names' => $offices,
                    'late_days'    => $attendance->late_days,
                    'late_dates'   => $lateDates,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'SN',
            'Full Name',
            'Mobile',
            'Designation',
            'Office',
            'Late Days',
            'Late Dates',
        ];
    }

}
