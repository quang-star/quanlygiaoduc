<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StudentsExport implements FromCollection, WithHeadings, WithStyles
{
    protected $students;

    public function __construct($students)
    {
        $this->students = $students;
    }

    // Dữ liệu chính
    public function collection()
    {
        return $this->students->map(function ($student) {
            return [
                'id' => $student->id,
                'studentprofile_id' => $student->student_profile_id,
                'Tên' => $student->name,
                'SĐT' => $student->phone_number,
                'Email' => $student->email,
                'Khóa học' => $student->course_name,
                'Level' => $student->level_name,
                'Lớp học' => $student->class_name,
                'Điểm đầu vào' => $student->entry_score ?? '',
                'Điểm đầu ra' => $student->exit_score ?? '',
                'Trạng thái' => $student->status,
            ];
        });
    }

    // Tiêu đề cột
    public function headings(): array
    {
        return [
            'ID',
            'ID hồ sơ học viên',
            'Tên học viên',
            'Số điện thoại',
            'Email',
            'Khóa học',
            'Level',
            'Lớp học',
            'Điểm đầu vào',
            'Điểm đầu ra',
            'Trạng thái',
        ];
    }

    // Style Excel
    public function styles(Worksheet $sheet)
    {
        $lastColumn = 'K'; // Cột cuối cùng (11 cột)
        $lastRow = count($this->students) + 1;

        // Bôi đậm và căn giữa hàng tiêu đề
        $sheet->getStyle("A1:{$lastColumn}1")->getFont()->setBold(true);
        $sheet->getStyle("A1:{$lastColumn}1")->getAlignment()->setHorizontal('center');

        // Căn giữa toàn bảng
        $sheet->getStyle("A:{$lastColumn}")->getAlignment()->setHorizontal('center');

        // Tự động giãn cột
        foreach (range('A', $lastColumn) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Thêm viền
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ];
        $sheet->getStyle("A1:{$lastColumn}{$lastRow}")->applyFromArray($styleArray);

        // Nền hàng tiêu đề
        $sheet->getStyle("A1:{$lastColumn}1")->getFill()
            ->setFillType('solid')
            ->getStartColor()->setARGB('FFE599');

        // Freeze tiêu đề (hàng đầu)
        $sheet->freezePane('A2');

        return [];
    }
}
