<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Quản lý đơn thuốc
// Đơn thuốc là một tài liệu y tế được bác sĩ kê cho bệnh nhân, ghi rõ các loại thuốc cần sử dụng, liều lượng và thời gian sử dụng
class Prescription extends Model
{
    use HasFactory;

    protected $fillable = [
        'medical_record_id',
        'medicine_id',
        'dosage',
        'duration',
        'notes',
    ];

    // Mối quan hệ N:1 với MedicalRecord
    public function medicalRecord()
    {
        return $this->belongsTo(MedicalRecord::class);
    }

    // Mối quan hệ N:1 với Medicine
    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
}
