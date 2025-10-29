<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    const STATUS_DONE = 1;
    const STATUS_PENDING = 0;
    
    protected $table = 'contracts';

    protected $fillable = [
        'code', 'student_profile_id', 'sign_date', 'certificate_id', 'course_id', 'class_id', 'total_value', 'status', 'collected', 'note', 'path'
    ];

    public function studentProfile()
    {
        return $this->belongsTo(StudentProfile::class, 'student_profile_id');
    }
    public function course(){
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }

    public function bills()
    {
        return $this->hasMany(BillHistory::class, 'contract_id');
    }

    public function certificate()
    {
        return $this->belongsTo(Certificate::class, 'certificate_id');
    }
    
}
