<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntranceExam extends Model
{
    use HasFactory;

    protected $table = 'entrance_exams';

    protected $fillable = ['certificate_id', 'name', 'pdf_test_file'];

    public function certificate()
    {
        return $this->belongsTo(Certificate::class);
    }

    public function testResults()
    {
        return $this->hasMany(TestResult::class, 'exam_id');
    }
}
