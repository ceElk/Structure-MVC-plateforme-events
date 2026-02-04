<?php

// ==============================
// FORCER L'AFFICHAGE DES ERREURS
// ==============================
/*ni_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/
// pour les log d'erreur commande terminal:tail -f /Applications/MAMP/logs/php_error.log
// ✅ AFFICHER LES ERREURS


// ✅ AFFICHER LES ERREURS (développement uniquement)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// ✅ Autoloader Composer (PHPMailer) - DOIT ÊTRE AVANT session_start()
require_once __DIR__ . '/../../vendor/autoload.php';

// ✅ Démarrer la session UNE SEULE FOIS
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ✅ Définir la constante BASE_URL
$scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
$BASE_URL = str_replace('/index.php', '', $scriptName);
$BASE_URL = rtrim($BASE_URL, '/');
define('BASE_URL', $BASE_URL);

// ✅ Autoloader du projet
require_once __DIR__ . '/../Autoloader.php';
App\Autoloader::register();

// ✅ Router
$router = new App\Core\Router();
$router->routes();
/*## Les changements importants :

1. ✅ `require_once __DIR__ . '/../Autoloader.php';` → Charge le fichier
2. ✅ `App\Autoloader::register();` → **ACTIVE** l'autoloader (c'était ça qui manquait !)
3. ❌ **Enlevez** toutes les autres lignes `require_once` et `spl_autoload_register`

---

## Vérifiez aussi votre structure :

Votre structure doit être :
```
/home/cefiidev/www/cecilia1440/applicationMVC/
├── public/
│   └── index.php
├── Core/
│   ├── Router.php (avec namespace App\Core;)
│   └── DbConnect.php (avec namespace App\Core;)
├── Controllers/
├── Models/
├── Views/
└── Autoloader.php (avec namespace App;)

*/