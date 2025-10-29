<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentsImport implements ToCollection, WithHeadingRow
{
    public $importedData;

    public function collection(Collection $rows)
    {
        $this->importedData = [];

        foreach ($rows as $row) {
            if (!empty($row['id'])) {
                $this->importedData[] = [
                    'id' => $row['id'],
                    'student_profile_id' => $row['id_ho_so_hoc_vien'],
                    'entry_score' => $row['diem_dau_vao'] ?? null,
                    'exit_score' => $row['diem_dau_ra'] ?? null,
                ];
            }
        }
    }

    public function getImportedData()
    {
        return $this->importedData;
    }
}
