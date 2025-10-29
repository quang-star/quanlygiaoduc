<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassModel extends Model
{
    use HasFactory;

    protected $table = 'classes';
    const SCHEDULED = 0;
    const RUNNING = 1;
    const COMPLETED = 2;
    const CANCELLED = 3;

    protected $fillable = [
        'name', 'teacher_id', 'course_id', 'end_date', 'start_date',
        'total_lesson', 'lesson_per_week', 'schedule', 'time_start',
        'time_end', 'min_student', 'max_student', 'status', 'note', 'day_learn'
    ];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function studentProfiles()
    {
        return $this->hasMany(StudentProfile::class, 'class_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'class_id');
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class, 'class_id');
    }

    public function contracts()
    {
        return $this->hasMany(Contract::class, 'class_id');
    }
}
