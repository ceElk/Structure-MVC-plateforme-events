<?php

namespace App\Controllers;

use App\Models\User;
use App\Entities\UserEntity;

class AuthController extends Controller
{
    // ============================================================
    // PAGE DE LOGIN
    // ============================================================
    public function login(): void
    {
        // Si déjà connecté, rediriger vers l'accueil
        if ($this->isLoggedIn()) {
            $this->redirect('home', 'index');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');

            if ($email === '' || $password === '') {
                $this->setFlash('error', 'Email et mot de passe requis.');
                $this->redirect('auth', 'login');
            }

            $model = new User();
            $user = $model->getByEmail($email);

            if (!$user) {
                $this->setFlash('error', 'Email ou mot de passe incorrect.');
                $this->redirect('auth', 'login');
            }

            // Vérifier le mot de passe
            if (!password_verify($password, $user->getPassword())) {
                $this->setFlash('error', 'Email ou mot de passe incorrect.');
                $this->redirect('auth', 'login');
            }

            // Vérifier si le compte est actif
            if (!$user->getIsActive()) {
                $this->setFlash('error', 'Votre compte a été désactivé.');
                $this->redirect('auth', 'login');
            }

            // Mettre à jour last_login
            $model->updateLastLogin($user->getId());

            // Créer la session
            $_SESSION['user_id'] = $user->getId();
            $_SESSION['username'] = $user->getUsername();
            $_SESSION['email'] = $user->getEmail();
            $_SESSION['role'] = $user->getRoleName() ?? 'user';

            $this->setFlash('success', 'Connexion réussie ! Bienvenue ' . $user->getUsername() . ' 👋');
            
            // Rediriger selon le rôle
            if ($user->isAdmin()) {
                $this->redirect('admin', 'dashboard');
            } else {
                $this->redirect('home', 'index');
            }
        }

        $this->render('auth/login', [
            'title' => 'Connexion'
        ]);
    }

    // ============================================================
    // PAGE D'INSCRIPTION
    // ============================================================
    public function register(): void
    {
        // Si déjà connecté, rediriger vers l'accueil
        if ($this->isLoggedIn()) {
            $this->redirect('home', 'index');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');
            $passwordConfirm = trim($_POST['password_confirm'] ?? '');
            $firstName = trim($_POST['first_name'] ?? '');
            $lastName = trim($_POST['last_name'] ?? '');
            $phone = trim($_POST['phone'] ?? '');

            // Validation
            if ($username === '' || $email === '' || $password === '') {
                $this->setFlash('error', 'Nom d\'utilisateur, email et mot de passe requis.');
                $this->redirect('auth', 'register');
            }

            if (!$this->validateEmail($email)) {
                $this->setFlash('error', 'Format d\'email invalide.');
                $this->redirect('auth', 'register');
            }

            if (strlen($password) < 6) {
                $this->setFlash('error', 'Le mot de passe doit contenir au moins 6 caractères.');
                $this->redirect('auth', 'register');
            }

            if ($password !== $passwordConfirm) {
                $this->setFlash('error', 'Les mots de passe ne correspondent pas.');
                $this->redirect('auth', 'register');
            }

            $model = new User();

            // Vérifier si l'email existe déjà
            if ($model->getByEmail($email)) {
                $this->setFlash('error', 'Cet email est déjà utilisé.');
                $this->redirect('auth', 'register');
            }

            // Créer l'utilisateur
            $user = new UserEntity();
            $user
                ->setUsername($username)
                ->setEmail($email)
                ->setPassword(password_hash($password, PASSWORD_BCRYPT))
                ->setFirstName($firstName ?: null)
                ->setLastName($lastName ?: null)
                ->setPhone($phone ?: null)
                ->setRoleId(2) // Role user par défaut
                ->setIsActive(true)
                ->setEmailVerified(false);

            $userId = $model->insert($user);

            if ($userId) {
                $this->setFlash('success', 'Inscription réussie ! Vous pouvez maintenant vous connecter 🎉');
                $this->redirect('auth', 'login');
            }

            $this->setFlash('error', 'Erreur lors de l\'inscription.');
            $this->redirect('auth', 'register');
        }

        $this->render('auth/register', [
            'title' => 'Inscription'
        ]);
    }

    // ============================================================
    // DÉCONNEXION
    // ============================================================
    public function logout(): void
    {
        // Détruire la session
        session_unset();
        session_destroy();

        $this->setFlash('success', 'Vous avez été déconnecté avec succès.');
        $this->redirect('home', 'index');
    }
}