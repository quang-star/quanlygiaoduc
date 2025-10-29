<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestResult extends Model
{
    use HasFactory;
    const ROLE_FIRST_TEST = 0; // test đầu vào
    const ROLE_OTHER_TEST = 1; // test khác
    protected $table = 'test_results';

    protected $fillable = ['student_profile_id', 'exam_id', 'test_date', 'total_score', 'result_status'];

    public function studentProfile()
    {
        return $this->belongsTo(StudentProfile::class, 'student_profile_id');
    }

    public function exam()
    {
        return $this->belongsTo(EntranceExam::class, 'exam_id');
    }
}
