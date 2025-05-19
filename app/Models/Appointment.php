<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Quản lý thông tin cuộc hẹn
class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'appointment_date',
        'status',
        'notes',
    ];

    // Mối quan hệ N:1 với Patient
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    // Mối quan hệ N:1 với Doctor
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function medicalRecord()
    {
        return $this->hasOne(MedicalRecord::class);
    }

    public function queue()
    {
        return $this->hasOne(Queue::class);
    }
}
