<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Quản lý thông tin bệnh nhân
class Patient extends Model
{
    use HasFactory;

    // Nếu bảng không theo chuẩn Laravel (tên số nhiều), bạn có thể thêm:
    // protected $table = 'patients';

    protected $fillable = [
        'user_id',
        'date_of_birth',
        'gender',
        'phone',
        'address',
    ];

    // Mối quan hệ 1:1 với bảng users
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Mối quan hệ 1:N với bảng Appoiment
    function Appoiment()
    {
        // return $this->hasMany(Appoiment::class);
    }

    // Mối quan hệ 1:N với bảng MedicalRecord
    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class);
    }

    public function appointments()
{
    return $this->hasMany(Appointment::class);
}

}
