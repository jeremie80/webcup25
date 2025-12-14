<?php

namespace App\Core;

class Controller
{
    /**
     * Afficher une vue avec le layout
     * 
     * @param string $view Chemin de la vue (ex: 'home/intro')
     * @param array $data Données à passer à la vue
     */
    protected function view($view, $data = [])
    {
        // Extraire les données pour les rendre disponibles dans la vue
        extract($data);
        
        // Démarrer la capture du contenu
        ob_start();
        
        // Inclure la vue demandée
        $viewPath = __DIR__ . '/../Views/' . $view . '.php';
        
        if (file_exists($viewPath)) {
            require_once $viewPath;
        } else {
            die("Vue introuvable : {$view}");
        }
        
        // Récupérer le contenu capturé
        $content = ob_get_clean();
        
        // Inclure le layout avec le contenu
        require_once __DIR__ . '/../Views/layout.php';
    }

    /**
     * Rediriger vers une URL
     * 
     * @param string $url
     */
    protected function redirect($url)
    {
        header('Location: ' . $url);
        exit;
    }

    /**
     * Retourner une réponse JSON
     * 
     * @param mixed $data
     * @param int $statusCode
     */
    protected function json($data, $statusCode = 200)
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}

