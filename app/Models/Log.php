<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Quản lý nhật ký hoạt động của hệ thống
class Log extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'action',
        'model',
        'model_id',
        'details',
    ];

    // Mối quan hệ N:1 với User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
