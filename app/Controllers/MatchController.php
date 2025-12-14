<?php

namespace App\Controllers;

use App\Core\Controller;

class MatchController extends Controller
{
    public function index()
    {
        // Vérifier que l'utilisateur est connecté
        if (!isset($_SESSION['user_id'])) {
            header('Location: /auth/start');
            exit();
        }
        
        $data = [
            'title' => 'Harmonies Cosmiques — IAstroMatch'
        ];
        
        // TODO: Implémenter la logique de matching
        echo "<h1>Page de matching en cours de développement</h1>";
        echo "<p>Bienvenue, " . htmlspecialchars($_SESSION['galactic_name'] ?? 'Voyageur') . " !</p>";
    }
    
    public function detail()
    {
        // TODO: Afficher les détails d'un match
        echo "<h1>Détail du match</h1>";
    }
    
    public function result()
    {
        // TODO: Résultat du matching
        echo "<h1>Résultat du matching</h1>";
    }
}

