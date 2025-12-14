<?php

namespace App\Controllers;

use App\Core\Controller;

class ChatController extends Controller
{
    public function index()
    {
        // Vérifier que l'utilisateur est connecté
        if (!isset($_SESSION['user_id'])) {
            header('Location: /auth/start');
            exit();
        }
        
        $data = [
            'title' => 'Échanges Cosmiques — IAstroMatch'
        ];
        
        // TODO: Implémenter la logique de chat
        echo "<h1>Page de chat en cours de développement</h1>";
        echo "<p>Bienvenue, " . htmlspecialchars($_SESSION['galactic_name'] ?? 'Voyageur') . " !</p>";
    }
    
    public function send()
    {
        // TODO: Envoyer un message
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /chat');
            exit();
        }
        
        // Traiter l'envoi du message
        echo "Message envoyé";
    }
}

