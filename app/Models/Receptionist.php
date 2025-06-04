<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Quan lý thông tin lễ tân
class Receptionist extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'phone',
        'gender',
        'date_of_birth',
        'address',
        'status',
        'note'
    ];

    // Quan hệ 1:1 với User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
