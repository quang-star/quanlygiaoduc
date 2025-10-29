<?php

namespace App\Jobs;

use App\Models\Contract;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateFileContract implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $contractId;

    /**
     * Create a new job instance.
     */
    public function __construct($contractId)
    {
        $this->contractId = $contractId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // 🔍 Tìm đúng contract
        $contract = Contract::find($this->contractId);

        if (!$contract) {
            return;
        }

        $publicDir = public_path('contracts');

        // 🗂️ Tạo thư mục nếu chưa có
        if (!file_exists($publicDir)) {
            mkdir($publicDir, 0755, true);
        }

        // 🧹 Nếu contract có file cũ thì xóa
        if ($contract->path && file_exists(public_path($contract->path))) {
            unlink(public_path($contract->path));
        }

        // 🧾 Tạo file PDF mới
        $pdf = Pdf::loadView('pdf.contract', ['contract' => $contract]);
        $fileName = 'contract_' . $contract->id . '.pdf';
        $pdfPath = $publicDir . '/' . $fileName;

        // 💾 Lưu file mới
        $pdf->save($pdfPath);

        // 🔁 Cập nhật lại DB
        $contract->update([
            'path' => 'contracts/' . $fileName,
        ]);
    }
}
