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
    
    /**
     * Afficher le résultat du lien (conclusion)
     */
    public function result()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /auth/start');
            exit();
        }

        if (!isset($_SESSION['profile_id'])) {
            $profileModel = new Profile();
            $userProfile = $profileModel->findByUserId($_SESSION['user_id']);
            if (!$userProfile) {
                header('Location: /profile/create');
                exit();
            }
            $_SESSION['profile_id'] = $userProfile['id'];
        }

        $matchId = (int)($_GET['match_id'] ?? 0);
        if (empty($matchId)) {
            $_SESSION['error'] = 'Match introuvable.';
            header('Location: /match');
            exit();
        }

        $matchModel = new MatchModel();
        $match = $matchModel->findById($matchId);

        if (!$match) {
            $_SESSION['error'] = 'Match introuvable.';
            header('Location: /match');
            exit();
        }

        if ($match['profile_a_id'] != $_SESSION['profile_id'] && $match['profile_b_id'] != $_SESSION['profile_id']) {
            $_SESSION['error'] = 'Vous n\'avez pas accès à ce match.';
            header('Location: /match');
            exit();
        }

        // Vérifier que le match est révélé
        if ($match['status'] !== 'revealed') {
            $_SESSION['error'] = 'Ce match n\'est pas encore révélé.';
            header('Location: /match/detail?id=' . $matchId);
            exit();
        }

        $otherProfileId = ($match['profile_a_id'] == $_SESSION['profile_id']) ? $match['profile_b_id'] : $match['profile_a_id'];
        $profileModel = new Profile();
        $otherProfile = $profileModel->findById($otherProfileId);
        $userModel = new User();
        $otherUser = $userModel->findById($otherProfile['user_id']);

        // Calculer le nombre de messages échangés
        $messageModel = new \App\Models\Message();
        $messages = $messageModel->findByMatchId($matchId);
        $messageCount = count($messages);

        // Évaluer le résultat du lien
        $linkResult = $this->evaluateLinkResult($match, $messageCount);

        $data = [
            'title' => 'Résultat du Lien — IAstroMatch',
            'galactic_name' => $_SESSION['galactic_name'] ?? 'Voyageur',
            'match' => $match,
            'match_id' => $matchId,
            'other_user' => $otherUser,
            'other_profile' => $otherProfile,
            'message_count' => $messageCount,
            'link_result' => $linkResult,
            'flash_success' => $_SESSION['success'] ?? null,
            'flash_error' => $_SESSION['error'] ?? null,
        ];
        unset($_SESSION['success']);
        unset($_SESSION['error']);

        $this->view('match/result', $data);
    }

    /**
     * Évaluer le résultat du lien
     */
    private function evaluateLinkResult($match, $messageCount)
    {
        $compatibilityType = $match['compatibility_type'];
        $compatibilityScore = $match['compatibility_score'];

        // Logique d'évaluation
        if ($compatibilityType === 'harmonious' && $messageCount >= 10) {
            return [
                'type' => 'harmonious',
                'emoji' => '🌿',
                'title' => 'Lien Harmonieux Établi',
                'description' => 'Votre connexion transcende les différences. Les échanges sont fluides, la compréhension mutuelle est profonde. Cette alliance s\'inscrit dans la durée.',
                'ia_message' => 'ASTRÆA observe une convergence exceptionnelle. Les énergies se complètent naturellement. Cette harmonie est rare et précieuse.',
                'cta_primary' => 'Poursuivre la relation',
                'cta_secondary' => null,
                'cta_tertiary' => 'Archiver temporairement',
                'color' => 'harmonious'
            ];
        } elseif (($compatibilityType === 'unstable' || $compatibilityType === 'improbable') && $messageCount >= 10) {
            return [
                'type' => 'complex',
                'emoji' => '⚠️',
                'title' => 'Relation Complexe mais Viable',
                'description' => 'Des tensions existent, mais le dialogue les apaise. Votre relation nécessite de l\'attention et de la communication continue. Les différences peuvent devenir des forces.',
                'ia_message' => 'ASTRÆA détecte des frictions créatives. Cette relation demande un engagement conscient, mais peut mener à une croissance mutuelle significative.',
                'cta_primary' => 'Continuer avec vigilance',
                'cta_secondary' => 'Demander médiation IA',
                'cta_tertiary' => 'Mettre en pause',
                'color' => 'unstable'
            ];
        } elseif ($compatibilityType === 'dangerous' && $messageCount >= 10) {
            return [
                'type' => 'risky',
                'emoji' => '☢️',
                'title' => 'Risque Élevé — Médiation Recommandée',
                'description' => 'Des incompatibilités fondamentales persistent. Sans intervention, cette relation pourrait générer des tensions importantes. Une médiation par ASTRÆA est vivement conseillée.',
                'ia_message' => 'ASTRÆA recommande une approche prudente. Les divergences sont profondes. Un accompagnement spécialisé est nécessaire pour éviter les conflits.',
                'cta_primary' => 'Demander médiation IA',
                'cta_secondary' => 'Poursuivre en autonomie',
                'cta_tertiary' => 'Mettre fin pacifiquement',
                'color' => 'dangerous'
            ];
        } elseif ($messageCount >= 20) {
            return [
                'type' => 'historic',
                'emoji' => '🌌',
                'title' => 'Alliance Historique Détectée',
                'description' => 'Votre relation a franchi un cap significatif. Au-delà de la compatibilité initiale, vous avez co-construit une connexion unique et profonde. Cette alliance marque l\'histoire de l\'écosystème.',
                'ia_message' => 'ASTRÆA enregistre cette union dans les archives cosmiques. Vous êtes devenus un modèle d\'harmonie interespèce. Votre lien inspire d\'autres voyageurs.',
                'cta_primary' => 'Célébrer l\'alliance',
                'cta_secondary' => 'Devenir mentors',
                'cta_tertiary' => 'Archives privées',
                'color' => 'harmonious-gold'
            ];
        } else {
            // Par défaut (peu de messages)
            return [
                'type' => 'emerging',
                'emoji' => '🌱',
                'title' => 'Lien en Construction',
                'description' => 'Votre relation est encore jeune. Continuez les échanges pour permettre à ASTRÆA d\'évaluer la profondeur de votre connexion.',
                'ia_message' => 'ASTRÆA collecte encore des données. Poursuivez vos interactions pour une évaluation complète.',
                'cta_primary' => 'Continuer les échanges',
                'cta_secondary' => null,
                'cta_tertiary' => 'Reporter l\'évaluation',
                'color' => 'emerging'
            ];
        }
    }

    /**
     * Demander une médiation IA
     */
    public function requestMediation()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /match');
            exit();
        }

        if (!isset($_SESSION['user_id']) || !isset($_SESSION['profile_id'])) {
            header('Location: /auth/start');
            exit();
        }

        $matchId = (int)($_POST['match_id'] ?? 0);
        if (empty($matchId)) {
            $_SESSION['error'] = 'Match introuvable.';
            header('Location: /match');
            exit();
        }

        // TODO: Implémenter la logique de médiation IA
        // Pour l'instant, on redirige avec un message de succès

        $_SESSION['success'] = 'Demande de médiation IA enregistrée. ASTRÆA vous contactera prochainement.';
        header('Location: /match/result?match_id=' . $matchId);
        exit();
    }

    /**
     * Mettre fin pacifiquement à la relation
     */
    public function endPeacefully()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /match');
            exit();
        }

        if (!isset($_SESSION['user_id']) || !isset($_SESSION['profile_id'])) {
            header('Location: /auth/start');
            exit();
        }

        $matchId = (int)($_POST['match_id'] ?? 0);
        if (empty($matchId)) {
            $_SESSION['error'] = 'Match introuvable.';
            header('Location: /match');
            exit();
        }

        $matchModel = new MatchModel();
        $match = $matchModel->findById($matchId);

        if (!$match) {
            $_SESSION['error'] = 'Match introuvable.';
            header('Location: /match');
            exit();
        }

        if ($match['profile_a_id'] != $_SESSION['profile_id'] && $match['profile_b_id'] != $_SESSION['profile_id']) {
            $_SESSION['error'] = 'Vous n\'avez pas accès à ce match.';
            header('Location: /match');
            exit();
        }

        // Mettre à jour le statut à 'rejected'
        $matchModel->updateStatus($matchId, 'rejected');

        $_SESSION['success'] = 'La relation a été close pacifiquement. ASTRÆA honore votre décision consciente.';
        header('Location: /match');
        exit();
    }
}
