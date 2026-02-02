<?php

namespace App;

class Autoloader
{
    public static function register()
    {
        spl_autoload_register([__CLASS__, 'autoload']);
    }

    public static function autoload($class)
    {
        // Retire le namespace "App\"
        $class = str_replace(__NAMESPACE__ . '\\', '', $class);
        $class = str_replace('\\', '/', $class);

        // Construit le chemin du fichier
        $file = __DIR__ . '/' . $class . '.php';

        // Si le fichier existe, on le charge
        if (file_exists($file)) {
            require $file;
        }
    }
}
/*class Autoloader
{
    public static function register()
    {
        spl_autoload_register([__CLASS__, 'autoload']);
    }

    public static function autoload($class)
    {
        $class = str_replace(__NAMESPACE__ . '\\', '', $class);
        $class = str_replace('\\', '/', $class);

        $file = __DIR__ . '/' . $class . '.php';

        if (file_exists($file)) {
            require $file;
        }
    }
}*/


/*Ton autoloader fait :

enlève applicationMVC\
→ Controllers\HomeController

remplace \ par /
→ Controllers/HomeController

ajoute .php + racine
→ application-MVC/Controllers/HomeController.php

👉 C’est EXACTEMENT ton fichier.
👉 Donc : autoload OK ✅*/
