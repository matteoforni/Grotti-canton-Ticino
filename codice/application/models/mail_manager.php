<?php
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class mail_manager
{
    /**
     * Funzione che consente di inviare un email tramite la libreria phpmailer
     * @param $email string L'indirizzo a cui inviare il messaggio
     * @param $body string Il contenuto del messaggio
     * @param $subject string Il soggetto del messaggio
     * @return bool Se l'operazione ha avuto successo o meno
     */
    public function sendMail($email, $body, $subject){
        require_once "./vendor/phpmailer/phpmailer/src/Exception.php";
        require_once "./vendor/phpmailer/phpmailer/src/PHPMailer.php";
        require_once "./vendor/phpmailer/phpmailer/src/SMTP.php";

        try{
            $mail = new PHPMailer();
            $mail->IsSMTP();
            $mail->SMTPDebug = 1;
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Host = "smtp.gmail.com";
            $mail->Port = 587;
            $mail->CharSet = 'UTF-8';
            $mail->IsHTML(true);
            $mail->Username = EMAIL;
            $mail->Password = PASSWORD;
            $mail->SetFrom(EMAIL);
            $mail->Subject = $subject;
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