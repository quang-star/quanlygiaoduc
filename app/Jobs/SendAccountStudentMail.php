<?php

namespace App\Jobs;

use App\Models\Contract;
use App\Models\User;
use App\Services\MailService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendAccountStudentMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $student;

    /**
     * Create a new job instance.
     */
    public function __construct($studentId)
    {
        $this->student = User::find($studentId);
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        MailService::sendMailCreateAccount($this->student);
    }
}
