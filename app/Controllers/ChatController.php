<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Message;
use App\Models\Profile;
use App\Models\MatchModel;

class ChatController extends Controller
{
    public function index()
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
        
        // Si un match_id est fourni, afficher la conversation
        if (isset($_GET['match_id'])) {
            $this->showConversation((int)$_GET['match_id']);
            return;
        }
        
        // Sinon, afficher la liste des conversations
        $messageModel = new Message();
        $conversations = $messageModel->getConversations($_SESSION['profile_id']);
        
        $data = [
            'title' => 'Échanges Cosmiques — IAstroMatch',
            'galactic_name' => $_SESSION['galactic_name'] ?? 'Voyageur',
            'conversations' => $conversations
        ];
        
        $this->view('chat/index', $data);
    }
    
    private function showConversation($matchId)
    {
        // Vérifier que le match existe et que l'utilisateur y participe
        $matchModel = new MatchModel();
        $match = $matchModel->findById($matchId);
        
        if (!$match) {
            $_SESSION['error'] = 'Conversation introuvable.';
            header('Location: /chat');
            exit();
        }
        
        // Vérifier que l'utilisateur fait partie de ce match
        if ($match['profile_a_id'] != $_SESSION['profile_id'] && $match['profile_b_id'] != $_SESSION['profile_id']) {
            $_SESSION['error'] = 'Vous n\'avez pas accès à cette conversation.';
            header('Location: /chat');
            exit();
        }
        
        // Vérifier que le match est révélé ou accepté
        if ($match['status'] !== 'revealed' && $match['status'] !== 'accepted') {
            $_SESSION['error'] = 'Cette conversation n\'est pas encore accessible.';
            header('Location: /chat');
            exit();
        }
        
        // Récupérer les messages
        $messageModel = new Message();
        $messages = $messageModel->findByMatchId($matchId);
        
        // Récupérer l'autre profil
        $otherProfileId = ($match['profile_a_id'] == $_SESSION['profile_id']) ? $match['profile_b_id'] : $match['profile_a_id'];
        $profileModel = new Profile();
        $otherProfile = $profileModel->findById($otherProfileId);
        
        // Récupérer l'utilisateur de l'autre profil
        $userModel = new \App\Models\User();
        $otherUser = $userModel->findById($otherProfile['user_id']);
        
        $data = [
            'title' => 'Conversation — IAstroMatch',
            'galactic_name' => $_SESSION['galactic_name'] ?? 'Voyageur',
            'match_id' => $matchId,
            'match' => $match,
            'messages' => $messages,
            'other_user' => $otherUser,
            'other_profile' => $otherProfile,
            'current_profile_id' => $_SESSION['profile_id']
        ];
        
        $this->view('chat/conversation', $data);
    }
    
    public function send()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /chat');
            exit();
        }
        
        // Vérifier que l'utilisateur est connecté
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['profile_id'])) {
            header('Location: /auth/start');
            exit();
        }
        
        $matchId = (int)($_POST['match_id'] ?? 0);
        $content = trim($_POST['content'] ?? '');
        
        if (empty($matchId) || empty($content)) {
            $_SESSION['error'] = 'Message vide ou match invalide.';
            header('Location: /chat?match_id=' . $matchId);
            exit();
        }
        
        // Vérifier que le match existe et que l'utilisateur y participe
        $matchModel = new MatchModel();
        $match = $matchModel->findById($matchId);
        
        if (!$match) {
            $_SESSION['error'] = 'Conversation introuvable.';
            header('Location: /chat');
            exit();
        }
        
        if ($match['profile_a_id'] != $_SESSION['profile_id'] && $match['profile_b_id'] != $_SESSION['profile_id']) {
            $_SESSION['error'] = 'Vous n\'avez pas accès à cette conversation.';
            header('Location: /chat');
            exit();
        }
        
        // Créer le message
        $messageModel = new Message();
        $messageId = $messageModel->create([
            'match_id' => $matchId,
            'sender_profile_id' => $_SESSION['profile_id'],
            'content' => $content
        ]);
        
        if ($messageId) {
            $_SESSION['success'] = 'Message envoyé.';
        } else {
            $_SESSION['error'] = 'Erreur lors de l\'envoi du message.';
        }
        
        header('Location: /chat?match_id=' . $matchId);
        exit();
    }
    
    public function getMessages()
    {
        // Vérifier que l'utilisateur est connecté
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['profile_id'])) {
            http_response_code(401);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Non authentifié']);
            exit();
        }
        
        $matchId = (int)($_GET['match_id'] ?? 0);
        
        if (empty($matchId)) {
            http_response_code(400);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Match ID manquant']);
            exit();
        }
        
        // Vérifier que le match existe et que l'utilisateur y participe
        $matchModel = new MatchModel();
        $match = $matchModel->findById($matchId);
        
        if (!$match) {
            http_response_code(404);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Conversation introuvable']);
            exit();
        }
        
        if ($match['profile_a_id'] != $_SESSION['profile_id'] && $match['profile_b_id'] != $_SESSION['profile_id']) {
            http_response_code(403);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Accès interdit']);
            exit();
        }
        
        // Récupérer les messages
        $messageModel = new Message();
        $messages = $messageModel->findByMatchId($matchId);
        
        // Formater les messages pour JSON
        $formattedMessages = [];
        foreach ($messages as $msg) {
            $formattedMessages[] = [
                'id' => $msg['id'],
                'sender_profile_id' => $msg['sender_profile_id'],
                'content' => $msg['content'],
                'created_at' => $msg['created_at'],
                'galactic_name' => $msg['galactic_name'],
                'is_current_user' => ($msg['sender_profile_id'] == $_SESSION['profile_id'])
            ];
        }
        
        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'messages' => $formattedMessages,
            'current_profile_id' => $_SESSION['profile_id']
        ]);
        exit();
    }
}

