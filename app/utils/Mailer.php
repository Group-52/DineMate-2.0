<?php

namespace utils;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class Mailer
{
    private PHPMailer $mailer;

    public function __construct()
    {
        $this->mailer = new PHPMailer();
        $this->mailer->isSMTP();
        $this->mailer->Host = "smtp.gmail.com";
        $this->mailer->SMTPAuth = true;
        $this->mailer->Username = EMAIL;
        $this->mailer->Password = PASS;
        $this->mailer->SMTPSecure = "tls";
        $this->mailer->Port = PORT;
    }

    public function send($to, $subject, $body): bool
    {
        try {
            $this->mailer->setFrom("dinematesl@gmail.com", "DineMate");
            $this->mailer->addAddress($to);
            $this->mailer->Subject = $subject;
            $this->mailer->Body = $body;
            if ($this->mailer->send()) {
                $this->mailer->smtpClose();
                return true;
            }
        } catch (Exception $e) {
            show($e->errorMessage());
        }
        $this->mailer->smtpClose();
        return false;
    }
}
