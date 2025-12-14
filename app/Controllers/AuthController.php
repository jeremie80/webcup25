<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;
use App\Models\Profile;

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
    
    public function login()
    {
        $data = [
            'title' => 'Connexion — IAstroMatch'
        ];
        
        $this->view('auth/login', $data);
    }
    
    public function authenticate()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /auth/login');
            exit();
        }
        
        $galacticName = trim($_POST['galactic_name'] ?? '');
        
        // Validation
        if (empty($galacticName)) {
            $this->view('auth/login', [
                'error' => 'Veuillez saisir votre nom galactique.',
                'galactic_name' => $galacticName
            ]);
            return;
        }
        
        // Rechercher l'utilisateur par nom galactique
        $userModel = new User();
        $user = $userModel->findByGalacticName($galacticName);
        
        if (!$user) {
            $this->view('auth/login', [
                'error' => 'Aucune signature cosmique trouvée pour ce nom galactique.',
                'galactic_name' => $galacticName
            ]);
            return;
        }
        
        // Connexion réussie - Créer la session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['galactic_name'] = $user['galactic_name'];
        $_SESSION['origin_type'] = $user['origin_type'];
        $_SESSION['bio_signature'] = $user['bio_signature'];
        
        // Vérifier si l'utilisateur a déjà un profil
        $profileModel = new Profile();
        $profile = $profileModel->findByUserId($user['id']);
        
        if ($profile) {
            $_SESSION['profile_id'] = $profile['id'];
            // Rediriger vers les suggestions de match
            header('Location: /match');
        } else {
            // Rediriger vers la création de profil
            header('Location: /profile/create');
        }
        exit();
    }
    
    public function logout()
    {
        // Récupérer le nom galactique avant de détruire la session
        $galacticName = $_SESSION['galactic_name'] ?? 'Voyageur';
        
        // Générer un message d'adieu avec IALanguage
        $farewell = \App\Core\IALanguage::getFarewellMessage($galacticName);
        
        // Détruire la session
        session_destroy();
        
        // Afficher la page d'adieu
        $data = [
            'title' => 'Au revoir — IAstroMatch',
            'galactic_name' => $galacticName,
            'farewell_message' => $farewell['message'],
            'farewell_subtitle' => $farewell['subtitle']
        ];
        
        $this->view('auth/logout', $data);
    }
}
