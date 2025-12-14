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
        echo "<!DOCTYPE html>
<html lang='fr'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>404 - Page Non Trouvée</title>
    <link rel='stylesheet' href='/assets/css/style.css'>
    <style>
        .error-404 {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            text-align: center;
            color: white;
        }
        .error-404 h1 {
            font-size: 6rem;
            margin-bottom: 1rem;
            background: linear-gradient(45deg, #e74c3c, #ff6b6b);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .error-404 p {
            font-size: 1.5rem;
            margin-bottom: 2rem;
            color: #ccc;
        }
    </style>
</head>
<body>
    <div class='error-404'>
        <h1>404</h1>
        <p>Page non trouvée</p>
        <a href='/' class='btn btn-primary'>Retour à l'accueil</a>
    </div>
</body>
</html>";
    }
}

