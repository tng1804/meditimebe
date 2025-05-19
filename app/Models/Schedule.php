<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Quản lý lịch làm việc của bác sĩ
class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_id',
        'start_time',
        'end_time',
        'status',
    ];

    // Mối quan hệ N:1 với Doctor
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
