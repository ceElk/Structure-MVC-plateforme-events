<?php

namespace App\Controllers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class PageController extends Controller
{
    public function about(): void
    {
        $this->render('page/about', [
            'title' => 'À propos de nous'
        ]);
    }

    public function contact(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $subject = trim($_POST['subject'] ?? '');
            $message = trim($_POST['message'] ?? '');

            if ($name === '' || $email === '' || $subject === '' || $message === '') {
                $this->setFlash('error', 'Tous les champs sont obligatoires.');
                $this->redirect('page', 'contact');
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->setFlash('error', 'Format d\'email invalide.');
                $this->redirect('page', 'contact');
            }

            // ✅ CHARGEMENT DE LA CONFIG EMAIL
            $emailConfig = require __DIR__ . '/../Config/email.php';

            try {
                $mail = new PHPMailer(true);
                
                // Configuration SMTP depuis le fichier
                $mail->isSMTP();
                $mail->Host = $emailConfig['smtp_host'];
                $mail->SMTPAuth = true;
                $mail->Username = $emailConfig['smtp_username'];
                $mail->Password = $emailConfig['smtp_password'];
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = $emailConfig['smtp_port'];
                
                // Expéditeur et destinataire
                $mail->setFrom($email, $name);
                $mail->addAddress($emailConfig['smtp_to']);
                $mail->addReplyTo($email, $name);
                
                // Contenu
                $mail->CharSet = 'UTF-8';
                $mail->Subject = '[EventHub Contact] ' . $subject;
                $mail->Body = "Nouveau message de contact EventHub\n\n";
                $mail->Body .= "Nom: $name\n";
                $mail->Body .= "Email: $email\n";
                $mail->Body .= "Sujet: $subject\n\n";
                $mail->Body .= "Message:\n$message\n\n";
                $mail->Body .= "---\nDate: " . date('d/m/Y H:i:s');
                
                $mail->send();
                
                $this->setFlash('success', 'Votre message a été envoyé avec succès ! Nous vous répondrons dans les plus brefs délais. ✅');
            } catch (Exception $e) {
                $this->setFlash('error', 'Erreur lors de l\'envoi du message. Veuillez réessayer plus tard.');
            }
            
            $this->redirect('page', 'contact');
        }

        $this->render('page/contact', [
            'title' => 'Nous contacter'
        ]);
    }
}