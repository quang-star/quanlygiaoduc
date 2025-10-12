<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    const ROLE_ADMIN = 0;
    const ROLE_TEACHER = 1;
    
    const ROLE_STUDENT = 2;
    const  ROLE_SUPPOTER = 3;
   protected $table = 'users';

    protected $fillable = [
        'name', 'email', 'phone_number', 'password', 'avatar', 'birthday', 'role'
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    // Quan hệ
    public function studentProfile()
    {
        return $this->hasOne(StudentProfile::class, 'student_id');
    }

    public function contracts()
    {
        return $this->hasMany(Contract::class, 'student_id');
    }

    public function classesTeaching()
    {
        return $this->hasMany(ClassModel::class, 'teacher_id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'student_id');
    }

    public function testResults()
    {
        return $this->hasMany(TestResult::class, 'student_id');
    }
}
