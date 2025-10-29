<?php

namespace App\Imports;

use App\Models\Attendance;
use App\Models\CheckExercise;
use App\Models\ClassModel;
use App\Models\Level;
use App\Models\StudentProfile;
use App\Models\TestResult;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;

class FinalExamImport implements ToModel, WithHeadingRow
{
    protected $classId;
    protected $class;
    public function __construct($classId)
    {
        $this->classId = $classId;
        $this->class = ClassModel::find($classId);
    }

    public function model(array $row)
    {
        // Chuẩn hóa key: bỏ dấu, viết thường, thay khoảng trắng = _
        $normalized = [];
        foreach ($row as $key => $value) {
            $normalized[Str::slug($key, '_')] = $value;
        }

        $studentCode = $normalized['ma_sinh_vien'] ?? null;
        $entryScore  = $normalized['diem_dau_vao'] ?? null;
        $exitScore   = $normalized['diem_dau_ra'] ?? null;

        if (!$studentCode) return null; // bỏ qua hàng lỗi

        $student = StudentProfile::where('class_id', $this->classId)
            ->whereHas('student', fn($q) => $q->where('id', $studentCode))
            ->first();
        $now = now();
        if ($student) {
            if (!empty($entryScore)) {
                TestResult::updateOrCreate(
                    [
                        'student_profile_id' => $student->id,
                        'result_status' => TestResult::ROLE_FIRST_TEST,
                    ],
                    [
                        'total_score' => $entryScore,
                        'test_date' => $now,
                        'updated_at' => $now
                    ]
                );
                $student->update([
                    'status' => $this->determineStatus($student, $entryScore)
                ]);
            }

            if (!empty($exitScore)) {
                TestResult::updateOrCreate(
                    [
                        'student_profile_id' => $student->id,
                        'result_status' => TestResult::ROLE_OTHER_TEST,
                    ],
                    [
                        'total_score' => $exitScore,
                        'test_date' => $now,
                        'updated_at' => $now,
                    ]

                );
                $student->update([
                    'status' => $this->determineStatus($student, $exitScore)
                ]);
            }
        }
    }

     private function determineStatus($studentProfile, $score)
    {
        $level = Level::find($studentProfile->current_level_id);

        if ($level && $score >= $level->max_score) {
            return StudentProfile::STATUS_FINISH;
        }

        $countAttendance = Attendance::where('student_profile_id', $studentProfile->id)->count();
        $countCheckExercise = CheckExercise::where('student_profile_id', $studentProfile->id)->count();

        if (
            $this->class &&
            $this->class->total_lesson > 0 &&
            $countAttendance / $this->class->total_lesson >= 0.8 &&
            $countCheckExercise / $this->class->total_lesson >= 0.8
        ) {
            return StudentProfile::STATUS_RETAKE;
        }

        return StudentProfile::STATUS_INCOMPLETE;
    }
}
