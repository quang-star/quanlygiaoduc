<?php

namespace App\Exports;

use App\Models\TeacherSalary;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

class TeacherSalaryExport implements FromCollection, WithHeadings
{
    protected $ids;
    protected $month;

    public function __construct($ids = [], $month = null)
    {
        $this->ids = $ids;
        $this->month = $month;
    }

    public function collection()
    {
        return TeacherSalary::with('teacher')
            ->when($this->ids, fn($q) => $q->whereIn('id', $this->ids))
            ->when($this->month, fn($q) => $q->where('month', $this->month))
            ->get()
            ->map(function ($salary) {
                return [
                    'ID' => $salary->teacher->id,
                    'Tên' => $salary->teacher->name,
                    'Email' => $salary->teacher->email,
                    'Lương cơ bản' => $salary->teacher->base_salary,
                    'Tổng buổi dạy' => $salary->total_sessions,
                    'Lương thực tế' => $salary->total_sessions * $salary->teacher->base_salary,
                    'Thưởng' => $salary->bonus ? $salary->bonus : '0',

                    'Tổng lương' => $salary->total_salary,
                    'Ngân hàng' => $salary->bank_name ?? '',
                    'Số tài khoản' => $salary->account_number ?? '',
                    'Tháng' => $salary->month,

                ];
            });
    }

    public function headings(): array
    {
        return ['ID', 'Tên', 'Email', 'Lương cơ bản', 'Tổng buổi dạy', 'Lương thực tế', 'Thưởng', 'Tổng lương', 'Ngân hàng', 'Số tài khoản', 'Tháng'];
    }

    public function styles(Worksheet $sheet)
    {
        $lastRow = $sheet->getHighestRow();
        $lastColumn = $sheet->getHighestColumn();

        // Bôi đậm và căn giữa hàng tiêu đề
        $sheet->getStyle("A1:{$lastColumn}1")->getFont()->setBold(true);
        $sheet->getStyle("A1:{$lastColumn}1")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // Nền màu vàng cho hàng tiêu đề
        $sheet->getStyle("A1:{$lastColumn}1")->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFE599');

        // Căn giữa toàn bộ bảng
        $sheet->getStyle("A1:{$lastColumn}{$lastRow}")
            ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // Thêm viền
        $sheet->getStyle("A1:{$lastColumn}{$lastRow}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);

        // Tự động giãn cột
        $startCol = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString('A');
        $endCol = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($lastColumn);
        foreach (range($startCol, $endCol) as $colIndex) {
            $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex);
            $sheet->getColumnDimension($colLetter)->setAutoSize(true);
        }

        // Freeze hàng tiêu đề
        $sheet->freezePane('A2');

        return [];
    }
}
