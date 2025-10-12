<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    protected $table = 'contracts';

    protected $fillable = [
        'code', 'student_id', 'sign_date', 'certificate_id', 'course_id', 'class_id', 'total_value', 'status'
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
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
}
