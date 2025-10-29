<?php

namespace App\Jobs;

use App\Models\Contract;
use App\Services\MailService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendContractMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $contract;

    /**
     * Create a new job instance.
     */
    public function __construct($contractId)
    {
        $this->contract = Contract::find($contractId);
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if (!$this->contract) {
            return;
        }

        // Tạo file PDF từ view
        $pdf = Pdf::loadView('pdf.contract', ['contract' => $this->contract]);
        $fileName = 'contract_' . $this->contract->id . '.pdf';
        $publicDir = public_path('contracts');

        // Đảm bảo thư mục tồn tại
        if (!file_exists($publicDir)) {
            mkdir($publicDir, 0755, true);
        }

        // Lưu file PDF vào thư mục public/contracts
        $pdfPath = $publicDir . '/' . $fileName;
        $pdf->save($pdfPath);

        // Lưu đường dẫn vào DB (để có thể hiển thị/public link)
        $this->contract->update([
            'path' => 'contracts/' . $fileName
        ]);

        // Gửi mail có đính kèm PDF
        MailService::sendMailRegisterContract($pdf, $this->contract);
    }
}
