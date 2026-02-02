<?php

namespace App\Core;

class Router
{
    private $controller;
    private $action;

    public function routes()
    {
        // 🎬 Démarre la mise en tampon de sortie (buffer)
        // Capture tout ce qui sera affiché pour le gérer proprement
        ob_start();

        // Récupération du contrôleur depuis l'URL
        $this->controller = isset($_GET['controller'])
            ? ucfirst($_GET['controller']) . 'Controller'
            : 'HomeController';

        // Récupération de l'action depuis l'URL
        $this->action = isset($_GET['action'])
            ? $_GET['action']
            : 'index';

        // Namespace complet du controller
        $controllerClass = 'App\\Controllers\\' . $this->controller;

        // Vérification que le contrôleur existe
        if (class_exists($controllerClass)) {
            $controller = new $controllerClass();

            // Vérification que la méthode existe dans le contrôleur
            if (method_exists($controller, $this->action)) {
                // Récupération des paramètres éventuels (ex: ID)
                $params = isset($_GET['id']) ? [$_GET['id']] : [];
                
                // Appel dynamique avec call_user_func_array
                call_user_func_array([$controller, $this->action], $params);
                /*Premier argument : [$controller, $this->action] = L'objet et le nom de la méthode
Deuxième argument : $params = Un tableau de paramètres à passer*/
            } else {
                echo "Erreur 404 : L'action demandée n'existe pas.";
            }
        } else {
            echo "Erreur 404 : Le contrôleur demandé n'existe pas.";
            echo '<pre>';
            echo 'Controller : ' . $this->controller . PHP_EOL;
            echo 'Action : ' . $this->action . PHP_EOL;
            echo '</pre>';
        }

        // 📤 Vide le tampon et envoie le contenu au navigateur
        // Tout ce qui a été capturé est maintenant affiché
        ob_end_flush();
    }
}