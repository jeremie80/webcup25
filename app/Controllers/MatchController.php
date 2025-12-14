<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Profile;
use App\Models\User;
use App\Models\MatchModel;

class MatchController extends Controller
{
    public function index()
    {
        // Vérifier que l'utilisateur est connecté
        if (!isset($_SESSION['user_id'])) {
            header('Location: /auth/start');
            exit();
        }
        
        // Vérifier que l'utilisateur a un profil
        $profileModel = new Profile();
        $userProfile = $profileModel->findByUserId($_SESSION['user_id']);
        
        if (!$userProfile) {
            header('Location: /profile/create');
            exit();
        }
        
        // Générer les suggestions de match si elles n'existent pas
        $this->generateMatchSuggestions($userProfile['id']);
        
        // Récupérer les matchs suggérés depuis la base de données
        $matchModel = new MatchModel();
        $suggestedMatches = $matchModel->getSuggestedMatches($userProfile['id']);
        
        // Enrichir les données des matchs avec les infos utilisateur et profil
        $matches = [];
        $userModel = new User();
        
        foreach ($suggestedMatches as $match) {
            // Déterminer l'autre profil
            $otherProfileId = ($match['profile_a_id'] == $userProfile['id']) 
                ? $match['profile_b_id'] 
                : $match['profile_a_id'];
            
            $otherProfile = $profileModel->findById($otherProfileId);
            if (!$otherProfile) continue;
            
            $otherUser = $userModel->findById($otherProfile['user_id']);
            if (!$otherUser) continue;
            
            $matches[] = [
                'match_id' => $match['id'],
                'user' => $otherUser,
                'profile' => $otherProfile,
                'compatibility' => [
                    'score' => $match['compatibility_score'],
                    'type' => $match['compatibility_type'],
                    'description' => $match['ia_summary'],
                    'emoji' => $this->getCompatibilityEmoji($match['compatibility_type']),
                    'label' => $this->getCompatibilityLabel($match['compatibility_type'])
                ]
            ];
        }
        
        $data = [
            'title' => 'Harmonies Cosmiques — IAstroMatch',
            'galactic_name' => $_SESSION['galactic_name'] ?? 'Voyageur',
            'matches' => $matches,
            'userProfile' => $userProfile
        ];
        
        $this->view('match/index', $data);
    }
    
    /**
     * Générer les suggestions de match pour un profil
     */
    private function generateMatchSuggestions($profileId)
    {
        $profileModel = new Profile();
        $matchModel = new MatchModel();
        $userProfile = $profileModel->findById($profileId);
        
        if (!$userProfile) return;
        
        // Récupérer tous les autres profils
        $allProfiles = $profileModel->getAll();
        
        foreach ($allProfiles as $otherProfile) {
            // Ignorer son propre profil
            if ($otherProfile['id'] == $profileId) continue;
            
            // Vérifier si un match existe déjà
            if ($matchModel->existsBetween($profileId, $otherProfile['id'])) continue;
            
            // Calculer la compatibilité
            $compatibility = $this->calculateCompatibility($userProfile, $otherProfile);
            
            // Créer le match suggéré
            $matchModel->create([
                'profile_a_id' => $profileId,
                'profile_b_id' => $otherProfile['id'],
                'compatibility_type' => $compatibility['type'],
                'compatibility_score' => $compatibility['score'],
                'ia_summary' => $compatibility['description'],
                'status' => 'suggested'
            ]);
        }
    }
    
    /**
     * Récupérer l'emoji selon le type de compatibilité
     */
    private function getCompatibilityEmoji($type)
    {
        $emojis = [
            'harmonious' => '🌱',
            'unstable' => '⚠️',
            'improbable' => '🌌',
            'dangerous' => '☢️'
        ];
        return $emojis[$type] ?? '❓';
    }
    
    /**
     * Récupérer le label selon le type de compatibilité
     */
    private function getCompatibilityLabel($type)
    {
        $labels = [
            'harmonious' => 'Compatible harmonieux',
            'unstable' => 'Instable mais enrichissant',
            'improbable' => 'Alliance improbable',
            'dangerous' => 'Risque diplomatique'
        ];
        return $labels[$type] ?? 'Inconnu';
    }
    
    /**
     * Calculer la compatibilité entre deux profils
     */
    private function calculateCompatibility($profile1, $profile2)
    {
        $score = 0;
        $reasons = [];
        
        // Compatibilité atmosphère (poids fort)
        if ($profile1['atmosphere_type'] === $profile2['atmosphere_type']) {
            $score += 30;
            $reasons[] = "Atmosphère partagée";
        } elseif (
            ($profile1['atmosphere_type'] === 'oxygen' && $profile2['atmosphere_type'] === 'aquatic') ||
            ($profile1['atmosphere_type'] === 'aquatic' && $profile2['atmosphere_type'] === 'oxygen')
        ) {
            $score += 15;
            $reasons[] = "Atmosphères complémentaires";
        } else {
            $score -= 10;
            $reasons[] = "Environnements incompatibles";
        }
        
        // Compatibilité communication
        if ($profile1['communication_mode'] === $profile2['communication_mode']) {
            $score += 25;
            $reasons[] = "Communication fluide";
        } elseif (
            ($profile1['communication_mode'] === 'telepathic' && $profile2['communication_mode'] === 'luminous') ||
            ($profile1['communication_mode'] === 'luminous' && $profile2['communication_mode'] === 'telepathic')
        ) {
            $score += 10;
            $reasons[] = "Modes de communication compatibles";
        } else {
            $score -= 5;
            $reasons[] = "Barrière de communication";
        }
        
        // Compatibilité technologique
        if ($profile1['tech_level'] === $profile2['tech_level']) {
            $score += 20;
            $reasons[] = "Même niveau technologique";
        } elseif (abs($this->techLevelValue($profile1['tech_level']) - $this->techLevelValue($profile2['tech_level'])) === 1) {
            $score += 5;
            $reasons[] = "Technologie adaptable";
        } else {
            $score -= 15;
            $reasons[] = "Fossé technologique";
        }
        
        // Valeurs fondamentales
        if ($profile1['core_value'] === $profile2['core_value']) {
            $score += 25;
            $reasons[] = "Valeurs alignées";
        } elseif (
            ($profile1['core_value'] === 'harmony' && $profile2['core_value'] === 'knowledge') ||
            ($profile1['core_value'] === 'knowledge' && $profile2['core_value'] === 'harmony') ||
            ($profile1['core_value'] === 'expansion' && $profile2['core_value'] === 'survival') ||
            ($profile1['core_value'] === 'survival' && $profile2['core_value'] === 'expansion')
        ) {
            $score += 10;
            $reasons[] = "Valeurs complémentaires";
        } else {
            $score -= 5;
            $reasons[] = "Divergence de valeurs";
        }
        
        // Déterminer le type de compatibilité
        if ($score >= 60) {
            $type = 'harmonious';
            $emoji = '🌱';
            $label = 'Compatible harmonieux';
            $description = 'Cette rencontre offre une compatibilité naturelle. Vos environnements et valeurs s\'alignent pour créer une synergie positive.';
        } elseif ($score >= 30) {
            $type = 'unstable';
            $emoji = '⚠️';
            $label = 'Instable mais enrichissant';
            $description = 'Cette connexion présente des défis, mais peut apporter une croissance mutuelle significative. L\'adaptation sera nécessaire.';
        } elseif ($score >= 0) {
            $type = 'improbable';
            $emoji = '🌌';
            $label = 'Alliance improbable';
            $description = 'Une rencontre peu conventionnelle qui pourrait mener à des découvertes inattendues. L\'issue reste incertaine.';
        } else {
            $type = 'dangerous';
            $emoji = '☢️';
            $label = 'Risque diplomatique';
            $description = 'Cette interaction comporte des risques significatifs. Les différences fondamentales peuvent créer des tensions importantes.';
        }
        
        return [
            'score' => $score,
            'type' => $type,
            'emoji' => $emoji,
            'label' => $label,
            'description' => $description,
            'reasons' => $reasons
        ];
    }
    
    /**
     * Convertir le niveau tech en valeur numérique
     */
    private function techLevelValue($level)
    {
        $values = ['organic' => 1, 'hybrid' => 2, 'advanced' => 3];
        return $values[$level] ?? 2;
    }
    
    public function detail()
    {
        // TODO: Afficher les détails d'un match
        echo "<h1>Détail du match</h1>";
    }
    
    public function accept()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /match');
            exit();
        }
        
        if (!isset($_SESSION['profile_id']) || !isset($_POST['match_id'])) {
            header('Location: /match');
            exit();
        }
        
        $matchModel = new MatchModel();
        $matchId = (int)$_POST['match_id'];
        
        // Accepter le match
        if ($matchModel->accept($matchId, $_SESSION['profile_id'])) {
            $_SESSION['success'] = 'Harmonie acceptée ! Si l\'autre voyageur accepte aussi, vous serez révélés mutuellement.';
        } else {
            $_SESSION['error'] = 'Erreur lors de l\'acceptation de l\'harmonie.';
        }
        
        header('Location: /match');
        exit();
    }
    
    public function reject()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /match');
            exit();
        }
        
        if (!isset($_SESSION['profile_id']) || !isset($_POST['match_id'])) {
            header('Location: /match');
            exit();
        }
        
        $matchModel = new MatchModel();
        $matchId = (int)$_POST['match_id'];
        
        // Rejeter le match
        if ($matchModel->reject($matchId, $_SESSION['profile_id'])) {
            $_SESSION['success'] = 'Harmonie rejetée.';
        } else {
            $_SESSION['error'] = 'Erreur lors du rejet de l\'harmonie.';
        }
        
        header('Location: /match');
        exit();
    }
    
    public function revealed()
    {
        // Vérifier que l'utilisateur est connecté
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['profile_id'])) {
            header('Location: /auth/start');
            exit();
        }
        
        // Récupérer les matchs révélés (acceptés mutuellement)
        $matchModel = new MatchModel();
        $revealedMatches = $matchModel->getAcceptedMatches($_SESSION['profile_id']);
        
        // Enrichir les données
        $matches = [];
        $profileModel = new Profile();
        $userModel = new User();
        
        foreach ($revealedMatches as $match) {
            $otherProfileId = ($match['profile_a_id'] == $_SESSION['profile_id']) 
                ? $match['profile_b_id'] 
                : $match['profile_a_id'];
            
            $otherProfile = $profileModel->findById($otherProfileId);
            if (!$otherProfile) continue;
            
            $otherUser = $userModel->findById($otherProfile['user_id']);
            if (!$otherUser) continue;
            
            $matches[] = [
                'match_id' => $match['id'],
                'user' => $otherUser,
                'profile' => $otherProfile,
                'compatibility' => [
                    'score' => $match['compatibility_score'],
                    'type' => $match['compatibility_type'],
                    'description' => $match['ia_summary'],
                    'emoji' => $this->getCompatibilityEmoji($match['compatibility_type']),
                    'label' => $this->getCompatibilityLabel($match['compatibility_type'])
                ]
            ];
        }
        
        $data = [
            'title' => 'Harmonies Révélées — IAstroMatch',
            'galactic_name' => $_SESSION['galactic_name'] ?? 'Voyageur',
            'matches' => $matches
        ];
        
        $this->view('match/revealed', $data);
    }
}
