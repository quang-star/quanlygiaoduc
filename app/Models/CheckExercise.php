<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckExercise extends Model
{
    use HasFactory;

    protected $table = 'check_exercises';

    protected $fillable = ['student_profile_id', 'class_id', 'time_check'];

    public function studentProfile()
    {
        return $this->belongsTo(User::class, 'student_profile_id');
    }

    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }
}
