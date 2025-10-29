<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;

class MailService
{
    public static function sendMailCreateAccount($user)
    {
        $email = $user->email;
        Mail::send('mails.add-account', ['user' => $user], function ($message) use ($email) {
            $message->to($email)
                ->subject('🎉 Tài khoản học viên đã được tạo!');
        });
        //dd($user);
    }

    public static function sendMailResetPassword($user, $resetLink)
    {
        $email = $user->email;
        Mail::send('mails.form-send-reset-password', ['user' => $user, 'resetLink' => $resetLink], function ($message) use ($email) {
            $message->to($email)
                ->subject('🔐 Đặt lại mật khẩu của bạn');
        });
    }

    public static function sendMailRegisterContract($pdf, $contract)
    {
        Mail::send('mails.add-contract', ['contract' => $contract], function ($message) use ($contract, $pdf) {
            $message->to($contract->studentProfile->student->email)
                ->subject('📄 Hợp đồng khóa học của bạn');

            $message->attachData($pdf->output(), 'contract.pdf', [
                'mime' => 'application/pdf',
            ]);
        });
    }
}
