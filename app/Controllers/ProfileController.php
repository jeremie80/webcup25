<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Profile;
use App\Models\User;

class ProfileController extends Controller
{
    public function show()
    {
        // Vérifier que l'utilisateur est connecté
        if (!isset($_SESSION['user_id'])) {
            header('Location: /auth/start');
            exit();
        }
        
        // Récupérer l'utilisateur
        $userModel = new User();
        $user = $userModel->findById($_SESSION['user_id']);
        
        if (!$user) {
            header('Location: /auth/start');
            exit();
        }
        
        // Récupérer le profil
        $profileModel = new Profile();
        $profile = $profileModel->findByUserId($_SESSION['user_id']);
        
        if (!$profile) {
            header('Location: /profile/create');
            exit();
        }
        
        // Stocker l'ID du profil en session
        $_SESSION['profile_id'] = $profile['id'];
        
        $data = [
            'title' => 'Mon Profil Cosmique — IAstroMatch',
            'user' => $user,
            'profile' => $profile,
            'galactic_name' => $user['galactic_name']
        ];
        
        $this->view('profile/show', $data);
    }
    
    public function create()
    {
        // Vérifier que l'utilisateur est connecté
        if (!isset($_SESSION['user_id'])) {
            header('Location: /auth/start');
            exit();
        }
        
        // Vérifier si l'utilisateur a déjà un profil
        $profileModel = new Profile();
        $existingProfile = $profileModel->findByUserId($_SESSION['user_id']);
        
        if ($existingProfile) {
            // Rediriger vers le profil ou le match
            header('Location: /match');
            exit();
        }
        
        $data = [
            'title' => 'Créer votre Profil — IAstroMatch',
            'galactic_name' => $_SESSION['galactic_name'] ?? ''
        ];
        
        $this->view('profile/create', $data);
    }
    
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /profile/create');
            exit();
        }
        
        // Vérifier que l'utilisateur est connecté
        if (!isset($_SESSION['user_id'])) {
            header('Location: /auth/start');
            exit();
        }
        
        $atmosphereType = $_POST['atmosphere_type'] ?? '';
        $communicationMode = $_POST['communication_mode'] ?? '';
        $techLevel = $_POST['tech_level'] ?? '';
        $coreValue = $_POST['core_value'] ?? '';
        
        // Validation
        $profileModel = new Profile();
        
        if (empty($atmosphereType) || empty($communicationMode) || empty($techLevel) || empty($coreValue)) {
            $this->view('profile/create', [
                'error' => 'Veuillez remplir tous les champs.',
                'atmosphere_type' => $atmosphereType,
                'communication_mode' => $communicationMode,
                'tech_level' => $techLevel,
                'core_value' => $coreValue,
                'galactic_name' => $_SESSION['galactic_name'] ?? ''
            ]);
            return;
        }
        
        // Gérer l'upload d'avatar (pour l'instant, chemin par défaut)
        // TODO: Implémenter l'upload d'image
        $avatarPath = 'storage/avatars/default.jpg';
        
        // Si un fichier est uploadé
        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../../storage/avatars/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            
            $extension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
            $filename = 'avatar_' . $_SESSION['user_id'] . '_' . time() . '.' . $extension;
            $uploadPath = $uploadDir . $filename;
            
            if (move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadPath)) {
                $avatarPath = 'storage/avatars/' . $filename;
            }
        }
        
        $profileId = $profileModel->create([
            'user_id' => $_SESSION['user_id'],
            'atmosphere_type' => $atmosphereType,
            'communication_mode' => $communicationMode,
            'tech_level' => $techLevel,
            'core_value' => $coreValue,
            'avatar_path' => $avatarPath
        ]);
        
        if ($profileId) {
            $_SESSION['profile_id'] = $profileId;
            
            // Rediriger vers l'analyse IA
            header('Location: /profile/analysis');
            exit();
        } else {
            $this->view('profile/create', [
                'error' => 'Erreur lors de la création de votre profil cosmique.',
                'atmosphere_type' => $atmosphereType,
                'communication_mode' => $communicationMode,
                'tech_level' => $techLevel,
                'core_value' => $coreValue,
                'galactic_name' => $_SESSION['galactic_name'] ?? ''
            ]);
        }
    }
    
    public function analysis()
    {
        // Vérifier que l'utilisateur est connecté
        if (!isset($_SESSION['user_id'])) {
            header('Location: /auth/start');
            exit();
        }
        
        // Vérifier que l'utilisateur a un profil et le stocker en session si nécessaire
        if (!isset($_SESSION['profile_id'])) {
            $profileModel = new Profile();
            $userProfile = $profileModel->findByUserId($_SESSION['user_id']);
            
            if (!$userProfile) {
                header('Location: /profile/create');
                exit();
            }
            
            $_SESSION['profile_id'] = $userProfile['id'];
        }
        
        $data = [
            'title' => 'Analyse en cours — IAstroMatch',
            'galactic_name' => $_SESSION['galactic_name'] ?? 'Voyageur'
        ];
        
        $this->view('profile/analysis', $data);
    }
    
    public function validate()
    {
        // Vérifier que l'utilisateur est connecté
        if (!isset($_SESSION['user_id'])) {
            header('Location: /auth/start');
            exit();
        }
        
        // Vérifier que l'utilisateur a un profil et le stocker en session si nécessaire
        if (!isset($_SESSION['profile_id'])) {
            $profileModel = new Profile();
            $userProfile = $profileModel->findByUserId($_SESSION['user_id']);
            
            if (!$userProfile) {
                header('Location: /profile/create');
                exit();
            }
            
            $_SESSION['profile_id'] = $userProfile['id'];
        }
        
        // Marquer le profil comme validé (simulation)
        $_SESSION['profile_validated'] = true;
        
        // Rediriger vers le matching
        header('Location: /match');
        exit();
    }
}

