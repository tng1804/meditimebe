<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleTemplate extends Model
{
    use HasFactory;

    protected $table = 'schedule_templates';

    protected $fillable = [
        'name',
        'day_of_week',
        'start_time',
        'end_time',
        'status',
        'template_group_id',
    ];

    public function templateGroup()
    {
        return $this->belongsTo(ScheduleTemplateGroup::class, 'template_group_id');
    }
}
