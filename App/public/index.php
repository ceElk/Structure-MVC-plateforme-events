<?php

// ==============================
// FORCER L'AFFICHAGE DES ERREURS
// ==============================
/*ni_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/

// ... reste du code
// ==============================
// AUTOLOADER
// ==============================
require_once __DIR__ . '/../autoloader.php';
 // ⬅️ MINUSCULES !

App\Autoloader::register();

// ==============================
// SESSION
// ==============================
session_start();

// ==============================
// ROUTER
// ==============================
use App\core\Router;

$router = new Router();
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