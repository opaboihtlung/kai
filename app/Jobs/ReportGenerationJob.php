<?php

namespace App\Jobs;

use App\Models\Attendance;
use App\Models\Leave;
use App\Models\Office;
use App\Models\Report;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Spatie\SimpleExcel\SimpleExcelWriter;

class ReportGenerationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Report $report;
    private string $fromDate;
    private string $toDate;
    private Office $office;

    public function __construct(Report $report, Office $office, string $fromDate, string $toDate)
    {
        $this->report = $report;
        $this->office = $office;
        $this->fromDate = $fromDate;
        $this->toDate = $toDate;
    }

    public function handle(): void
    {
        $office = $this->office;
        $attendances = Attendance::query()
            ->where('office_id', $office->id)
            ->whereBetween('signin_at', [$this->fromDate, $this->toDate])
            ->with(['user', 'office', 'device'])
            ->get();

        $users = User::query()
            ->whereHas('offices', fn (Builder $builder) => $builder->where('offices.id', $office->id))
            ->orderBy('employee_no')
            ->get();

        $fileName = 'report/' . now()->timestamp . '.xlsx';
        $filePath = Storage::disk('public')->path($fileName);
        $writer = SimpleExcelWriter::create($filePath);

        foreach (CarbonPeriod::create($this->fromDate, $this->toDate) as $date) {
            $sheetName = $date->format('d-m-Y');
            $writer->addNewSheetAndMakeItCurrent()->nameCurrentSheet($sheetName);

            $dateWiseAttendances = $attendances->where('signin_at', '>=', $date->startOfDay())
                                               ->where('signin_at', '<=', $date->endOfDay());

            foreach ($users as $index => $user) {
                $attendance = $dateWiseAttendances->firstWhere('user_id', $user->id);
                $leaveType = $this->getUserLeaveType($user->mobile, $date->toDateString());

                $writer->addRow([
                    'SN' => $index + 1,
                    'Employment Code' => $user->employee_no,
                    'Full Name' => $user->full_name,
                    'Designation' => $user->designation,
                    'Mobile' => $user->mobile,
                    'Office' => $office->name,
                    'Signin Time' => $attendance?->signin_at?->format('d-m-Y H:i') ?? '',
                    'Signout Time' => $attendance?->signout_at?->format('d-m-Y H:i') ?? '',
                    'Device' => $attendance?->device?->name ?? '',
                    'Present' => $leaveType ?: ($attendance ? ($attendance->type === Attendance::PRESENT ? 'Present' : 'Late') : 'ABSENT'),
                    'Remarks' => $attendance?->in_remark ?? '',
                ]);
            }
        }

        $this->report->update([
            'path' => Storage::url($fileName),
            'status' => Report::PROCESSED,
        ]);
    }

    private function getUserLeaveType(string $mobile, string $date): ?string
    {
        try {
            $carbonDate = Carbon::parse($date);
            $year = $carbonDate->year;
            $holidays = [
                '01-01', '01-02', '01-11', '01-26', '02-20', '02-26', '03-07', '03-14', '03-31',
                '04-10', '04-18', '05-12', '06-07', '06-15', '06-30', '07-06', '07-17',
                '08-15', '08-16', '09-05', '10-02', '10-20', '11-05', '12-24', '12-25',
                '12-26', '12-31'
            ];

            if ($carbonDate->isWeekend() || in_array($carbonDate->format('Y-m-d'), array_map(fn($h) => "$year-$h", $holidays))) {
                return null;
            }

            return Attendance::whereHas('user', fn ($query) => $query->where('mobile', $mobile))
                ->whereBetween('start_date', [$date, $date])
                ->orWhereBetween('end_date', [$date, $date])
                ->value('leaveType');
        } catch (\Exception $e) {
            Log::error('Error in getUserLeaveType function', [
                'mobile' => $mobile,
                'date' => $date,
                'error' => $e->getMessage(),
            ]);
            return null;
        }
    }
}
