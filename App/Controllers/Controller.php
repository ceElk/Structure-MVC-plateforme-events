<?php

namespace App\Controllers;

abstract class Controller
{
    /**
     * Charge une vue avec des données
     * 
     * @param string $view Chemin de la vue (ex: 'home/index')
     * @param array $data Données à passer à la vue
     */
    protected function render(string $view, array $data = []): void
    {
// ✅ APRÈS (CORRECT - sans /App/)
$data['BASE_URL'] = '/coursPhp2025/POO/plateforme-events';
        
        // Extrait les variables du tableau pour les rendre accessibles dans la vue
        extract($data);
        //    // Résultat : $reservations = $data['reservations'];

        // Démarre le buffer de sortie
        ob_start();

        // Chemin vers le fichier de vue
        $viewPath = __DIR__ . '/../Views/' . $view . '.php';

        // Vérifie si la vue existe
        if (file_exists($viewPath)) {
            require_once $viewPath;
        } else {
            die("Erreur : La vue '{$view}' est introuvable à l'emplacement : {$viewPath}");
        }

        // Récupère le contenu de la vue
        $content = ob_get_clean();

        // ✅ Charge le layout principal (dans base/)
        require_once __DIR__ . '/../Views/base.php';
    }

    /**
     * Redirige vers une URL
     * 
     * @param string $controller Nom du contrôleur
     * @param string $action Nom de l'action
     * @param array $params Paramètres supplémentaires (ex: ['id' => 5])
     */
    protected function redirect(string $controller, string $action = 'index', array $params = []): void
    {
        $url = '?controller=' . $controller . '&action=' . $action;
        
        foreach ($params as $key => $value) {
            $url .= '&' . $key . '=' . urlencode($value);
        }
        
        header('Location: ' . $url);
        exit;
    }

    /**
     * Vérifie si l'utilisateur est connecté
     * 
     * @return bool
     */
    protected function isLoggedIn(): bool
    {
        return isset($_SESSION['user_id']);
    }

    /**
     * Vérifie si l'utilisateur est administrateur
     * 
     * @return bool
     */
    protected function isAdmin(): bool
    {
        return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
    }

    /**
     * Redirige si l'utilisateur n'est pas connecté
     */
    protected function requireLogin(): void
    {
        if (!$this->isLoggedIn()) {
            $_SESSION['flash']['error'] = "Vous devez être connecté pour accéder à cette page.";
            $this->redirect('auth', 'login');
        }
    }

    /**
     * Redirige si l'utilisateur n'est pas administrateur
     */
    protected function requireAdmin(): void
    {
        if (!$this->isAdmin()) {
            $_SESSION['flash']['error'] = "Accès refusé : droits administrateur requis.";
            $this->redirect('home', 'index');
        }
    }

    /**
     * Nettoie et sécurise une chaîne de caractères
     * 
     * @param string $data
     * @return string
     */
    protected function sanitize(string $data): string
    {
        return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
    }

    /**
     * Définit un message flash
     * 
     * @param string $type Type du message (success, error, warning, info)
     * @param string $message Le message à afficher
     */
    protected function setFlash(string $type, string $message): void
    {
        $_SESSION['flash'][$type] = $message;
    }

    /**
     * Récupère et supprime un message flash
     * 
     * @param string $type Type du message
     * @return string|null
     */
    protected function getFlash(string $type): ?string
    {
        if (isset($_SESSION['flash'][$type])) {
            $message = $_SESSION['flash'][$type];
            unset($_SESSION['flash'][$type]);
            return $message;
        }
        return null;
    }

    /**
     * Valide que tous les champs requis sont présents dans $_POST
     * 
     * @param array $requiredFields Tableau des champs requis
     * @return bool
     */
    protected function validateRequired(array $requiredFields): bool
    {
        foreach ($requiredFields as $field) {
            if (!isset($_POST[$field]) || empty(trim($_POST[$field]))) {
                return false;
            }
        }
        return true;
    }

    /**
     * Valide un email
     * 
     * @param string $email
     * @return bool
     */
    protected function validateEmail(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * Retourne les données JSON
     * 
     * @param array $data
     * @param int $statusCode
     */
    protected function json(array $data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}