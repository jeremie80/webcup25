<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Profile;
use App\Models\User;
use App\Models\MatchModel;
use App\Models\Message;

class DashboardController extends Controller
{
    public function index()
    {
        // Vérifier que l'utilisateur est connecté
        if (!isset($_SESSION['user_id'])) {
            header('Location: /auth/start');
            exit();
        }

        // Récupérer le profil de l'utilisateur
        $profileModel = new Profile();
        $userProfile = $profileModel->findByUserId($_SESSION['user_id']);

        if (!$userProfile) {
            header('Location: /profile/create');
            exit();
        }

        $_SESSION['profile_id'] = $userProfile['id'];

        // Récupérer l'utilisateur
        $userModel = new User();
        $user = $userModel->findById($_SESSION['user_id']);

        // Récupérer tous les matchs de l'utilisateur
        $matchModel = new MatchModel();
        $allMatches = $matchModel->findByProfileId($userProfile['id']);

        // Catégoriser les matchs
        $suggestedMatches = [];
        $acceptedMatches = [];
        $revealedMatches = [];
        $rejectedMatches = [];

        foreach ($allMatches as $match) {
            switch ($match['status']) {
                case 'suggested':
                    $suggestedMatches[] = $match;
                    break;
                case 'accepted':
                    $acceptedMatches[] = $match;
                    break;
                case 'revealed':
                    $revealedMatches[] = $match;
                    break;
                case 'rejected':
                    $rejectedMatches[] = $match;
                    break;
            }
        }

        // Calculer les statistiques globales
        $totalMatches = count($allMatches);
        $totalRevealed = count($revealedMatches);
        $totalAccepted = count($acceptedMatches);
        $totalRejected = count($rejectedMatches);

        // Calculer le nombre total de messages envoyés
        $messageModel = new Message();
        $totalMessages = 0;
        foreach ($revealedMatches as $match) {
            $messages = $messageModel->findByMatchId($match['id']);
            $totalMessages += count($messages);
        }

        // Calculer le score diplomatique (0-100)
        $diplomaticScore = $this->calculateDiplomaticScore($totalMatches, $totalRevealed, $totalAccepted, $totalRejected, $totalMessages);

        // Générer le message de l'IA selon le score
        $iaMessage = $this->generateIAMessage($diplomaticScore, $user['galactic_name'], $totalRevealed, $totalMessages);

        // Récupérer les 5 derniers matchs révélés avec détails
        $recentRevealedMatches = [];
        $revealedMatchesWithDetails = $matchModel->getAcceptedMatchesWithDetails($userProfile['id']);
        $recentRevealedMatches = array_slice($revealedMatchesWithDetails, 0, 5);

        $data = [
            'title' => 'Tableau de Bord — IAstroMatch',
            'galactic_name' => $_SESSION['galactic_name'] ?? 'Voyageur',
            'user' => $user,
            'profile' => $userProfile,
            'stats' => [
                'total_matches' => $totalMatches,
                'suggested' => count($suggestedMatches),
                'accepted' => $totalAccepted,
                'revealed' => $totalRevealed,
                'rejected' => $totalRejected,
                'total_messages' => $totalMessages,
                'diplomatic_score' => $diplomaticScore
            ],
            'recent_matches' => $recentRevealedMatches,
            'ia_message' => $iaMessage,
            'flash_success' => $_SESSION['success'] ?? null,
            'flash_error' => $_SESSION['error'] ?? null,
        ];
        unset($_SESSION['success']);
        unset($_SESSION['error']);

        $this->view('dashboard/index', $data);
    }

    /**
     * Calculer le score diplomatique global (0-100)
     */
    private function calculateDiplomaticScore($totalMatches, $totalRevealed, $totalAccepted, $totalRejected, $totalMessages)
    {
        if ($totalMatches === 0) {
            return 0;
        }

        // Pondération :
        // - Matchs révélés : 40 points max
        // - Matchs acceptés : 20 points max
        // - Messages échangés : 30 points max
        // - Pénalité pour rejets : -10 points max

        $revealedScore = min(40, ($totalRevealed / max(1, $totalMatches)) * 40);
        $acceptedScore = min(20, ($totalAccepted / max(1, $totalMatches)) * 20);
        $messagesScore = min(30, ($totalMessages / 20) * 30); // 20 messages = 30 points
        $rejectPenalty = min(10, ($totalRejected / max(1, $totalMatches)) * 10);

        $score = $revealedScore + $acceptedScore + $messagesScore - $rejectPenalty + 10; // +10 base

        return (int)max(0, min(100, $score));
    }

    /**
     * Générer un message personnalisé de l'IA selon le score diplomatique
     */
    private function generateIAMessage($score, $galacticName, $totalRevealed, $totalMessages)
    {
        if ($score >= 90) {
            return [
                'type' => 'excellence',
                'title' => '🌌 Ambassadeur·ice Cosmique',
                'message' => "Votre contribution renforce l'équilibre galactique, <strong>{$galacticName}</strong>. Vous incarnez l'harmonie interespèce et inspirez de nombreux voyageurs. L'écosystème rayonne grâce à votre présence.",
                'icon' => '🌟'
            ];
        } elseif ($score >= 70) {
            return [
                'type' => 'excellent',
                'title' => '🌿 Bâtisseur·se de Ponts',
                'message' => "Votre diplomatie est remarquable, <strong>{$galacticName}</strong>. Vous tissez des liens authentiques entre les mondes. Votre engagement enrichit l'écosystème solarpunk.",
                'icon' => '✨'
            ];
        } elseif ($score >= 50) {
            return [
                'type' => 'good',
                'title' => '🌱 Explorateur·ice Engagé·e',
                'message' => "Vous progressez avec intention, <strong>{$galacticName}</strong>. Chaque connexion que vous cultivez contribue à l'harmonie collective. Continuez sur cette voie.",
                'icon' => '🌸'
            ];
        } elseif ($score >= 30) {
            return [
                'type' => 'emerging',
                'title' => '🌾 Voyageur·se en Éveil',
                'message' => "Vos premiers pas sont encourageants, <strong>{$galacticName}</strong>. L'écosystème s'ouvre à vous. Prenez le temps d'explorer les connexions possibles.",
                'icon' => '🌿'
            ];
        } else {
            return [
                'type' => 'beginning',
                'title' => '🌱 Nouveau·lle Arrivant·e',
                'message' => "Bienvenue dans l'écosystème, <strong>{$galacticName}</strong>. Votre voyage ne fait que commencer. ASTRÆA vous accompagne dans vos premières rencontres.",
                'icon' => '🌱'
            ];
        }
    }
}

