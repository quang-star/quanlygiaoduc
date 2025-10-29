<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherSalary extends Model
{
    use HasFactory;
    const STATUS_PENDING = 0;   // Chưa tính lương
    const STATUS_CALCULATED = 1; // Đã tính lương
    const STATUS_EXPORTED = 2;   // Đã xuất lương

    public static $statusLabels = [
        self::STATUS_PENDING => 'Chưa tính lương',
        self::STATUS_CALCULATED => 'Đã tính lương',
        self::STATUS_EXPORTED => 'Đã xuất lương',
    ];
    public function getStatusColorAttribute()
    {
        return match ($this->status) {
            self::STATUS_PENDING => 'warning',
            self::STATUS_CALCULATED => 'success',
            self::STATUS_EXPORTED => 'primary',
            default => 'secondary',
        };
    }
    protected $table = 'teacher_salaries';

    protected $fillable = [
        'teacher_id',
        'month',
        'total_sessions',
        'base_salary',
        'bonus',
        'penalty',
        'total_salary',
        'bank_name',
        'account_number',
        'status',
        'note'
    ];

    public function getStatusLabelAttribute()
    {
        return self::$statusLabels[$this->status] ?? 'Chưa có';
    }


    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
}
