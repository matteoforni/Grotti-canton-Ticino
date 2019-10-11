<?php
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class MailManager
{
    public function sendMail($email, $token){
        require_once "./vendor/phpmailer/phpmailer/src/Exception.php";
        require_once "./vendor/phpmailer/phpmailer/src/PHPMailer.php";
        require_once "./vendor/phpmailer/phpmailer/src/SMTP.php";

        $body = "Per reimpostare la tua password premi sul seguente link: \n" . URL . "reset/reset/" . $token;

        try{
            $mail = new PHPMailer();
            $mail->IsSMTP();
            $mail->SMTPDebug = 1;
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = 'ssl';
            $mail->Host = "smtp.gmail.com";
            $mail->Port = 465;
            $mail->IsHTML(true);
            $mail->Username = EMAIL;
            $mail->Password = PASSWORD;
            $mail->SetFrom(EMAIL);
            $mail->Subject = "Grotti Ticino - Reimposta la tua password";
            $mail->Body = $body;
            $mail->AddAddress($email);

            if(!$mail->Send()) {
                $error = 'Mail error: '.$mail->ErrorInfo;
                $_SESSION['warning'] = $error;
                header('Location: ' . URL . 'warning');
                exit();
            } else {
                return true;
            }
        }catch (Exception $e){
            $_SESSION['warning'] = $e->getCode() . " - " . $e->getMessage();
            header('Location: ' . URL . 'warning');
            exit();
        }
    }
}