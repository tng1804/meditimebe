<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleTemplateGroup extends Model
{
    use HasFactory;

    protected $table = 'schedule_template_groups';

    protected $fillable = [
        'name',
    ];

    public function templates()
    {
        return $this->hasMany(ScheduleTemplate::class, 'template_group_id');
    }

    public function doctorSchedules()
    {
        return $this->hasMany(DoctorSchedule::class, 'schedule_template_id');
    }
}
