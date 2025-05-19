<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Quản lý thông tin xếp hàng
class Queue extends Model
{
    use HasFactory;

    protected $fillable = [
        'appointment_id',
        'queue_number',
        'status',
    ];

     // Mối quan hệ N:1 với Appointment
     public function appointment()
     {
         return $this->belongsTo(Appointment::class);
     }
}
