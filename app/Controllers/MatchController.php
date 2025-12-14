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
        
        // Stocker l'ID du profil en session pour utilisation ultérieure
        $_SESSION['profile_id'] = $userProfile['id'];
        
        // Générer les suggestions de match si elles n'existent pas
        $this->generateMatchSuggestions($userProfile['id']);
        
        // Récupérer les matchs suggérés avec JOIN (1 seule requête optimisée)
        $matchModel = new MatchModel();
        $suggestedMatches = $matchModel->getSuggestedMatchesWithDetails($userProfile['id']);
        
        // Transformer les données
        $matches = [];
        
        foreach ($suggestedMatches as $match) {
            // Vérifier que les données utilisateur sont présentes
            if (empty($match['user_id']) || empty($match['galactic_name'])) {
                continue;
            }
            
            $matches[] = [
                'match_id' => $match['match_id'],
                'user' => [
                    'id' => $match['user_id'],
                    'galactic_name' => $match['galactic_name'],
                    'origin_type' => $match['origin_type'],
                    'bio_signature' => $match['bio_signature']
                ],
                'profile' => [
                    'id' => $match['profile_id'],
                    'user_id' => $match['other_user_id'],
                    'atmosphere_type' => $match['atmosphere_type'],
                    'communication_mode' => $match['communication_mode'],
                    'tech_level' => $match['tech_level'],
                    'core_value' => $match['core_value'],
                    'avatar_path' => $match['avatar_path']
                ],
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
        
        // Récupérer l'ID du match
        $matchId = (int)($_GET['id'] ?? 0);
        
        if (empty($matchId)) {
            $_SESSION['error'] = 'Match introuvable.';
            header('Location: /match');
            exit();
        }
        
        // Récupérer le match
        $matchModel = new MatchModel();
        $match = $matchModel->findById($matchId);
        
        if (!$match) {
            $_SESSION['error'] = 'Match introuvable.';
            header('Location: /match');
            exit();
        }
        
        // Vérifier que l'utilisateur fait partie de ce match
        if ($match['profile_a_id'] != $_SESSION['profile_id'] && $match['profile_b_id'] != $_SESSION['profile_id']) {
            $_SESSION['error'] = 'Vous n\'avez pas accès à ce match.';
            header('Location: /match');
            exit();
        }
        
        // Récupérer l'autre profil
        $otherProfileId = ($match['profile_a_id'] == $_SESSION['profile_id']) ? $match['profile_b_id'] : $match['profile_a_id'];
        $profileModel = new Profile();
        $otherProfile = $profileModel->findById($otherProfileId);
        
        if (!$otherProfile) {
            $_SESSION['error'] = 'Profil introuvable.';
            header('Location: /match');
            exit();
        }
        
        // Récupérer l'utilisateur de l'autre profil
        $userModel = new User();
        $otherUser = $userModel->findById($otherProfile['user_id']);
        
        if (!$otherUser) {
            $_SESSION['error'] = 'Utilisateur introuvable.';
            header('Location: /match');
            exit();
        }
        
        // Préparer les données de compatibilité
        $compatibility = [
            'type' => $match['compatibility_type'],
            'score' => $match['compatibility_score'],
            'description' => $match['ia_summary'],
            'emoji' => $this->getCompatibilityEmoji($match['compatibility_type']),
            'label' => $this->getCompatibilityLabel($match['compatibility_type'])
        ];
        
        $data = [
            'title' => 'Détails du Match — IAstroMatch',
            'galactic_name' => $_SESSION['galactic_name'] ?? 'Voyageur',
            'match' => $match,
            'other_user' => $otherUser,
            'other_profile' => $otherProfile,
            'compatibility' => $compatibility
        ];
        
        $this->view('match/detail', $data);
    }
    
    public function contactMode()
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
        
        // Récupérer l'ID du match
        $matchId = (int)($_GET['match_id'] ?? 0);
        
        if (empty($matchId)) {
            $_SESSION['error'] = 'Match introuvable.';
            header('Location: /match');
            exit();
        }
        
        // Récupérer le match
        $matchModel = new MatchModel();
        $match = $matchModel->findById($matchId);
        
        if (!$match) {
            $_SESSION['error'] = 'Match introuvable.';
            header('Location: /match');
            exit();
        }
        
        // Vérifier que l'utilisateur fait partie de ce match
        if ($match['profile_a_id'] != $_SESSION['profile_id'] && $match['profile_b_id'] != $_SESSION['profile_id']) {
            $_SESSION['error'] = 'Vous n\'avez pas accès à ce match.';
            header('Location: /match');
            exit();
        }
        
        // Vérifier que le match est au statut "suggested"
        if ($match['status'] !== 'suggested') {
            $_SESSION['info'] = 'Ce match a déjà été accepté.';
            header('Location: /match/detail?id=' . $matchId);
            exit();
        }
        
        // Récupérer l'autre profil
        $otherProfileId = ($match['profile_a_id'] == $_SESSION['profile_id']) ? $match['profile_b_id'] : $match['profile_a_id'];
        $profileModel = new Profile();
        $otherProfile = $profileModel->findById($otherProfileId);
        
        if (!$otherProfile) {
            $_SESSION['error'] = 'Profil introuvable.';
            header('Location: /match');
            exit();
        }
        
        // Récupérer l'utilisateur de l'autre profil
        $userModel = new User();
        $otherUser = $userModel->findById($otherProfile['user_id']);
        
        if (!$otherUser) {
            $_SESSION['error'] = 'Utilisateur introuvable.';
            header('Location: /match');
            exit();
        }
        
        $data = [
            'title' => 'Choix du Mode de Contact — IAstroMatch',
            'galactic_name' => $_SESSION['galactic_name'] ?? 'Voyageur',
            'match' => $match,
            'other_user' => $otherUser,
            'other_profile' => $otherProfile
        ];
        
        $this->view('match/contact-mode', $data);
    }
    
    public function accept()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /match');
            exit();
        }
        
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
        
        if (!isset($_POST['match_id'])) {
            header('Location: /match');
            exit();
        }
        
        $matchModel = new MatchModel();
        $matchId = (int)$_POST['match_id'];
        $contactMode = $_POST['contact_mode'] ?? 'emotional'; // Par défaut : émotionnel
        
        // Valider le mode de contact
        $validModes = ['emotional', 'diplomatic', 'guided'];
        if (!in_array($contactMode, $validModes)) {
            $contactMode = 'emotional';
        }
        
        // Accepter le match
        if ($matchModel->accept($matchId, $_SESSION['profile_id'])) {
            // Stocker le mode de contact choisi en session (pourra être utilisé plus tard dans le chat)
            $_SESSION['contact_mode_' . $matchId] = $contactMode;
            
            $modeLabels = [
                'emotional' => 'Message Émotionnel',
                'diplomatic' => 'Protocole Diplomatique',
                'guided' => 'Dialogue Guidé par l\'IA'
            ];
            
            $_SESSION['success'] = 'Connexion initiée avec le mode "' . $modeLabels[$contactMode] . '". Si l\'autre voyageur accepte aussi, vous pourrez échanger.';
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
        
        if (!isset($_POST['match_id'])) {
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
        
        // Récupérer les matchs révélés avec JOIN (1 seule requête optimisée)
        $matchModel = new MatchModel();
        $revealedMatches = $matchModel->getAcceptedMatchesWithDetails($_SESSION['profile_id']);
        
        // Transformer les données
        $matches = [];
        
        foreach ($revealedMatches as $match) {
            // Vérifier que les données utilisateur sont présentes
            if (empty($match['user_id']) || empty($match['galactic_name'])) {
                continue;
            }
            
            $matches[] = [                'match_id' => $match['match_id'],
                'user' => [
                    'id' => $match['user_id'],
                    'galactic_name' => $match['galactic_name'],
                    'origin_type' => $match['origin_type'],
                    'bio_signature' => $match['bio_signature']
                ],
                'profile' => [
                    'id' => $match['profile_id'],
                    'user_id' => $match['other_user_id'],
                    'atmosphere_type' => $match['atmosphere_type'],
                    'communication_mode' => $match['communication_mode'],
                    'tech_level' => $match['tech_level'],
                    'core_value' => $match['core_value'],
                    'avatar_path' => $match['avatar_path']
                ],
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
