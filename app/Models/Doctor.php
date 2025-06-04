<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Quản lý thông tin bác sĩ
class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'specialty_id',
        'phone',
        'gender',
        'date_of_birth',
        'license_number',
        'status',
    ];

    // Mối quan hệ 1:1 với user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 1:N với appointments
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    // 1:N với medical_records
    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class);
    }

    public function schedule()
    {
        return $this->hasOne(DoctorSchedule::class);
    }

    public function scheduleExceptions()
    {
        return $this->hasMany(ScheduleException::class);
    }
    public function specialty()
    {
        return $this->belongsTo(Specialty::class);
    }

}
