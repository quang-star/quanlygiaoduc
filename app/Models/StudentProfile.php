<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentProfile extends Model
{
    use HasFactory;

    protected $table = 'student_profiles';

    protected $fillable = [
        'student_id', 'language_id', 'certificate_id', 'current_level_id', 'status'
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

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
        return $this->belongsTo(Level::class, 'current_level_id');
    }
}
