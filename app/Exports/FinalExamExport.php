<?php

namespace App\Exports;

use App\Models\StudentProfile;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FinalExamExport implements FromCollection, WithHeadings
{
    protected $classId;

    public function __construct($classId)
    {
        $this->classId = $classId;
    }

    public function collection()
    {
        return StudentProfile::with(['student', 'testResults'])
            ->where('class_id', $this->classId)
            ->get()
            ->map(function ($profile) {
                $first = $profile->testResults->firstWhere('result_status', 0);
                $last = $profile->testResults->firstWhere('result_status', 1);
                return [
                    'Mã sinh viên' => $profile->student->id,
                    'Họ tên' => $profile->student->name,
                    'Điểm đầu vào' => $first->total_score ?? '',
                    'Điểm đầu ra' => $last->total_score ?? '',
                ];
            });
    }

    public function headings(): array
    {
        return ['Mã sinh viên', 'Họ tên', 'Điểm đầu vào', 'Điểm đầu ra'];
    }
}
