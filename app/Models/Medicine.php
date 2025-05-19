<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Quản lý thông tin thuốc
// Thông tin thuốc bao gồm tên thuốc, mô tả, đơn vị tính
class Medicine extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'unit',
    ];

    // Quan hệ 1:N với prescriptions (sẽ tạo sau)
    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }
}
