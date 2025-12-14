<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;

class AuthController extends Controller
{
    public function start()
    {
        $data = [
            'title' => 'Créer votre Profil — IAstroMatch'
        ];
        
        $this->view('auth/start', $data);
    }
    
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /auth/start');
            exit();
        }
        
        $galacticName = trim($_POST['galactic_name'] ?? '');
        $originType = $_POST['origin_type'] ?? '';
        
        // Validation
        $userModel = new User();
        
        if (empty($galacticName) || empty($originType)) {
            $this->view('auth/start', [
                'error' => 'Veuillez remplir tous les champs.',
                'galactic_name' => $galacticName,
                'origin_type' => $originType
            ]);
            return;
        }
        
        if (strlen($galacticName) > 200) {
            $this->view('auth/start', [
                'error' => 'Le nom galactique ne peut pas dépasser 200 caractères.',
                'galactic_name' => $galacticName,
                'origin_type' => $originType
            ]);
            return;
        }
        
        if (!in_array($originType, $userModel->getOriginTypes())) {
            $this->view('auth/start', [
                'error' => 'Type d\'origine invalide.',
                'galactic_name' => $galacticName,
                'origin_type' => $originType
            ]);
            return;
        }
        
        // Générer une bio_signature unique (SHA256 = 64 caractères)
        $bioSignature = hash('sha256', $galacticName . $originType . time() . bin2hex(random_bytes(16)));
        
        $userId = $userModel->create([
            'galactic_name' => $galacticName,
            'origin_type' => $originType,
            'bio_signature' => $bioSignature
        ]);
        
        if ($userId) {
            $_SESSION['user_id'] = $userId;
            $_SESSION['galactic_name'] = $galacticName;
            $_SESSION['origin_type'] = $originType;
            $_SESSION['bio_signature'] = $bioSignature;
            
            header('Location: /profile/create');
            exit();
        } else {
            $this->view('auth/start', [
                'error' => 'Erreur lors de la création de votre signature galactique.',
                'galactic_name' => $galacticName,
                'origin_type' => $originType
            ]);
        }
    }
}
