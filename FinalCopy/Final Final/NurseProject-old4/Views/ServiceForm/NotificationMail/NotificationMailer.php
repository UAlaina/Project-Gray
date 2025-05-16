<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'Views/ForgotPass/mailer/src/Exception.php';
require 'Views/ForgotPass/mailer/src/PHPMailer.php';
require 'Views/ForgotPass/mailer/src/SMTP.php';

class NotificationMailer {
    private $mailer;

    public function __construct() {
        $this->mailer = new PHPMailer(true);
        $this->setupMailer();
    }

    private function setupMailer() {
        try {
            $this->mailer->isSMTP();
            $this->mailer->Host = 'smtp.gmail.com';
            $this->mailer->SMTPAuth = true;
            $this->mailer->Username = 'nurserywebsystem@gmail.com';
            $this->mailer->Password = 'jfxn wtck joja jwqm';
            $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $this->mailer->Port = 587;
            $this->mailer->setFrom('nurserywebsystem@gmail.com', 'Nursery App System');
        } catch (Exception $e) {
            echo 'Mailer Setup Error: ', $e->getMessage();
        }
    }

    public function sendEmail($recipient, $subject, $body) {
        echo "Sending to: " . $recipient;

        try {
            $this->mailer->clearAddresses();
            $this->mailer->addAddress($recipient);
            $this->mailer->isHTML(true);
            $this->mailer->Subject = $subject;
            $this->mailer->Body = $body;

            return $this->mailer->send();
        } catch (Exception $e) {
            error_log("Mailer Error: " . $e->getMessage());
            return false;
        }
    }
}
?>
