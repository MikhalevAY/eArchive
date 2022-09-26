<?php

namespace App\Services;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class MailService
{
    /**
     * @throws Exception
     */
    public function send(array $emails, string $message, string $subject): bool
    {
        $mail = new PHPMailer(true);
        $mail->CharSet = 'UTF-8';
        $mail->setFrom(config('mail.from.address'), config('app.name'));

        foreach ($emails as $email) {
            $mail->addAddress($email);
        }

        $mail->isHTML();
        $mail->Subject = $subject;
        $mail->Body = $message;

        return $mail->send();
    }
}
