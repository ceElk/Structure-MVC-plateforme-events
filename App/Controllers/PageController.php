<?php

namespace App\Controllers;

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

            if (!$this->validateEmail($email)) {
                $this->setFlash('error', 'Format d\'email invalide.');
                $this->redirect('page', 'contact');
            }

            // TODO: Envoyer l'email (pour l'instant on simule)
            $this->setFlash('success', 'Votre message a été envoyé avec succès ! Nous vous répondrons dans les plus brefs délais. ✅');
            $this->redirect('page', 'contact');
        }

        $this->render('page/contact', [
            'title' => 'Nous contacter'
        ]);
    }
}