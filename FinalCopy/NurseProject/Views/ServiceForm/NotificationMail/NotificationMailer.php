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
            $this->mailer->Password = 'mvnn ifin jblh sfuc';
            $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $this->mailer->Port = 587;

            $this->mailer->setFrom('nurseryappsystem@gmail.com', 'Nursery App System');
        } catch (Exception $e) {
            //echo 'Mailer Setup Error: ', $e->errorMessage();
        }
    }

    public function sendEmail($recipient, $subject, $body) {
        try {
            //$this->mailer->clearAddresses();
            $this->mailer->addAddress($recipient);
            $this->mailer->isHTML(true);
            $this->mailer->Subject = $subject;
            $this->mailer->Body = $body;

            //error_log("Attempting to send email to: $recipient");
            
            if ($this->mailer->send()) {
                //error_log("Email sent successfully to: $recipient");
                return true;
            } else {
                //error_log("Mailer Error: " . $this->mailer->ErrorInfo);
                return false;
            }
        } catch (Exception $e) {
            //error_log("Mailer Exception: " . $e->getMessage());
            return false;
        }
    }
}

?>
