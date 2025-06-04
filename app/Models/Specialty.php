<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specialty extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image',
    ];

    // Mối quan hệ: Một chuyên khoa có nhiều bác sĩ 
    public function doctors()
    {
        return $this->hasMany(Doctor::class);
    }
}
