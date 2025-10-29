<?php

namespace App\Models;

use Illuminate\Database\Console\Migrations\StatusCommand;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentProfile extends Model
{
    use HasFactory;
    const STATUS_WAIT_TEST = 0; // Chờ test
    const STATUS_WAIT_CLASS = 1; // Chờ vào lớp
    const STATUS_LEARNING = 2; // Đang học
    const STATUS_FINISH = 3; // Hoàn thành
    const STATUS_DROPOUT = 4; // Bỏ học
    const STATUS_INCOMPLETE = 5;   // chưa hoàn thành điều kiện
    const STATUS_RETAKE = 6; // Hoàn thành khóa học nhưng chưa đạt điểm đầu ra, học lại


    protected $table = 'student_profiles';

    protected $fillable = [
        'student_id',
        'language_id',
        'certificate_id',
        'current_level_id',
        'class_id',
        'status'
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

    public function class()
    {
        return $this->belongsTo(ClassModel::class);
    }

    public function testResults()
    {
        return $this->hasMany(TestResult::class);
    }

    // 🏷️ Thêm label mô tả trạng thái
    public static $statusLabels = [
        self::STATUS_WAIT_TEST => 'Chờ test đầu vào',
        self::STATUS_WAIT_CLASS => 'Chờ xếp lớp',
        self::STATUS_LEARNING => 'Đang học',
        self::STATUS_FINISH => 'Hoàn thành',
        self::STATUS_DROPOUT => 'Bỏ học',
        self::STATUS_INCOMPLETE => 'Chưa hoàn thành điều kiện',
        self::STATUS_RETAKE => 'Học lại',
    ];

    public static $statusColors = [
        self::STATUS_WAIT_TEST => 'warning',
        self::STATUS_WAIT_CLASS => 'secondary',
        self::STATUS_LEARNING => 'primary',
        self::STATUS_FINISH => 'success',
        self::STATUS_DROPOUT => 'danger',
        self::STATUS_INCOMPLETE => 'muted',
        self::STATUS_RETAKE => 'info',
    ];

    public function getStatusColorAttribute()
    {
        return self::$statusColors[$this->status] ?? 'dark';
    }


    // 🔁 Lấy label theo status (dễ gọi trong view hoặc controller)
    public function getStatusLabelAttribute()
    {
        return self::$statusLabels[$this->status] ?? 'Không xác định';
    }
}
