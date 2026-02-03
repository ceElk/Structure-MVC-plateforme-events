<?php

namespace App\Controllers;

use App\Models\User;

class UserController extends Controller
{
    // ============================================================
    // PROFIL UTILISATEUR
    // ============================================================
    public function profile(): void
    {
        // 🔒 Protection : utilisateur connecté
        $this->requireLogin();

        $model = new User();
        $user = $model->getById($_SESSION['user_id']);

        if (!$user) {
            $this->setFlash('error', 'Utilisateur introuvable.');
            $this->redirect('home', 'index');
        }

        $this->render('user/profile', [
            'title' => 'Mon profil',
            'user' => $user
        ]);
    }

    // ============================================================
    // MODIFIER SON PROFIL
    // ============================================================
    public function editProfile(): void
    {
        // 🔒 Protection : utilisateur connecté
        $this->requireLogin();

        $model = new User();
        $user = $model->getById($_SESSION['user_id']);

        if (!$user) {
            $this->setFlash('error', 'Utilisateur introuvable.');
            $this->redirect('home', 'index');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $firstName = trim($_POST['first_name'] ?? '');
            $lastName = trim($_POST['last_name'] ?? '');
            $phone = trim($_POST['phone'] ?? '');

            // Validation
            if ($username === '' || $email === '') {
                $this->setFlash('error', 'Le nom d\'utilisateur et l\'email sont obligatoires.');
                $this->redirect('user', 'editProfile');
            }

            if (!$this->validateEmail($email)) {
                $this->setFlash('error', 'Format d\'email invalide.');
                $this->redirect('user', 'editProfile');
            }

            // Vérifier si l'email existe déjà (sauf pour l'utilisateur actuel)
            $existingUser = $model->getByEmail($email);
            if ($existingUser && $existingUser->getId() !== $user->getId()) {
                $this->setFlash('error', 'Cet email est déjà utilisé par un autre utilisateur.');
                $this->redirect('user', 'editProfile');
            }

            // Mettre à jour
            $user
                ->setUsername($username)
                ->setEmail($email)
                ->setFirstName($firstName ?: null)
                ->setLastName($lastName ?: null)
                ->setPhone($phone ?: null);

            $ok = $model->update($user);

            if ($ok) {
                // Mettre à jour la session
                $_SESSION['username'] = $username;
                $_SESSION['email'] = $email;

                $this->setFlash('success', 'Profil mis à jour avec succès ! ✅');
                $this->redirect('user', 'profile');
            }

            $this->setFlash('error', 'Erreur lors de la mise à jour du profil.');
            $this->redirect('user', 'editProfile');
        }

        $this->render('user/edit-profile', [
            'title' => 'Modifier mon profil',
            'user' => $user
        ]);
    }

    // ============================================================
    // CHANGER SON MOT DE PASSE
    // ============================================================
    public function changePassword(): void
    {
        // 🔒 Protection : utilisateur connecté
        $this->requireLogin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $currentPassword = trim($_POST['current_password'] ?? '');
            $newPassword = trim($_POST['new_password'] ?? '');
            $confirmPassword = trim($_POST['confirm_password'] ?? '');

            // Validation
            if ($currentPassword === '' || $newPassword === '' || $confirmPassword === '') {
                $this->setFlash('error', 'Tous les champs sont obligatoires.');
                $this->redirect('user', 'changePassword');
            }

            if (strlen($newPassword) < 6) {
                $this->setFlash('error', 'Le nouveau mot de passe doit contenir au moins 6 caractères.');
                $this->redirect('user', 'changePassword');
            }

            if ($newPassword !== $confirmPassword) {
                $this->setFlash('error', 'Les mots de passe ne correspondent pas.');
                $this->redirect('user', 'changePassword');
            }

            // Vérifier le mot de passe actuel
            $model = new User();
            $user = $model->getById($_SESSION['user_id']);

            if (!$user) {
                $this->setFlash('error', 'Utilisateur introuvable.');
                $this->redirect('home', 'index');
            }

            if (!password_verify($currentPassword, $user->getPassword())) {
                $this->setFlash('error', 'Mot de passe actuel incorrect.');
                $this->redirect('user', 'changePassword');
            }

            // Mettre à jour le mot de passe
            $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
            $ok = $model->updatePassword($user->getId(), $hashedPassword);

            if ($ok) {
                $this->setFlash('success', 'Mot de passe modifié avec succès ! 🔒');
                $this->redirect('user', 'profile');
            }

            $this->setFlash('error', 'Erreur lors de la modification du mot de passe.');
            $this->redirect('user', 'changePassword');
        }

        $this->render('user/change-password', [
            'title' => 'Changer mon mot de passe'
        ]);
    }

    // ============================================================
    // MES RÉSERVATIONS (à venir)
    // ============================================================
    public function myReservations(): void
    {
        // 🔒 Protection : utilisateur connecté
        $this->requireLogin();

        // TODO: Implémenter quand le système de réservation sera prêt

        $this->render('user/reservations', [
            'title' => 'Mes réservations',
            'reservations' => []
        ]);
    }
}