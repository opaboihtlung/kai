<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AppealAttendance extends Model
{
    use HasFactory;

    const SUBMITTED = 'Submitted';
    const APPROVED = 'Approved';
    const REJECTED = 'Rejected';
    protected $fillable = [ 'attendance_id','user_id','office_id', 'start_date','end_date', 'status', 'type', 'reason', 'signin_time'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function office(): BelongsTo
    {
        return $this->belongsTo(Office::class);
    }
    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class, 'attendance_id');
    }

}
