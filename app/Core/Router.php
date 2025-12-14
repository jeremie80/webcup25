<?php

namespace App\Core;

class Router
{
    private $routes = [];

    /**
     * Ajouter une route GET
     */
    public function get($path, $handler)
    {
        $this->routes['GET'][$path] = $handler;
    }

    /**
     * Ajouter une route POST
     */
    public function post($path, $handler)
    {
        $this->routes['POST'][$path] = $handler;
    }

    /**
     * Dispatcher la requête vers le bon contrôleur
     */
    public function dispatch()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        // Vérifier si la route existe
        if (!isset($this->routes[$method][$path])) {
            $this->notFound();
            return;
        }

        $handler = $this->routes[$method][$path];
        list($controller, $action) = explode('@', $handler);

        $controllerClass = "App\\Controllers\\$controller";
        
        // Vérifier si le contrôleur existe
        if (!class_exists($controllerClass)) {
            die("Contrôleur introuvable : $controllerClass");
        }

        $controllerInstance = new $controllerClass();
        
        // Vérifier si la méthode existe
        if (!method_exists($controllerInstance, $action)) {
            die("Méthode introuvable : $action dans $controllerClass");
        }

        // Exécuter le contrôleur
        $controllerInstance->$action();
    }

    /**
     * Page 404
     */
    private function notFound()
    {
        http_response_code(404);
        
        // Préparer les données pour la vue
        $title = '404 — Route Inconnue — IAstroMatch';
        $hideHeader = true;
        $viewPath = __DIR__ . '/../Views/error/404.php';
        
        // Vérifier si les fichiers existent
        if (file_exists($viewPath) && file_exists(__DIR__ . '/../Views/layout.php')) {
            include __DIR__ . '/../Views/layout.php';
        } else {
            echo "<!DOCTYPE html><html lang='fr'><head><meta charset='UTF-8'><title>404</title></head><body><h1>404 - Page non trouvée</h1><p><a href='/'>Retour à l'accueil</a></p></body></html>";
        }
    }
}

