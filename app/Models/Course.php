<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $table = 'courses';

    protected $fillable = [
        'code',
        'name',
        'language_id',
        'certificate_id',
        'level_id',
        'price',
        'total_lesson',
        'lesson_per_week',
        'max_student',
        'min_student',
        'description',
    ];


    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    public function certificate()
    {
        return $this->belongsTo(Certificate::class);
    }

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function classes()
    {
        return $this->hasMany(ClassModel::class);
    }
}
