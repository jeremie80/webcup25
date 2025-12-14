<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class Message
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Récupérer tous les messages
     */
    public function getAll()
    {
        $stmt = $this->db->query("SELECT * FROM messages ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }

    /**
     * Récupérer un message par ID
     */
    public function findById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM messages WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    /**
     * Récupérer tous les messages d'un match
     */
    public function findByMatchId($matchId)
    {
        $stmt = $this->db->prepare(
            "SELECT m.*, p.user_id, u.galactic_name
             FROM messages m
             INNER JOIN profiles p ON p.id = m.sender_profile_id
             INNER JOIN users u ON u.id = p.user_id
             WHERE m.match_id = :match_id
             ORDER BY m.created_at ASC"
        );
        $stmt->execute(['match_id' => $matchId]);
        return $stmt->fetchAll();
    }

    /**
     * Récupérer les conversations d'un profil (matches avec dernier message)
     */
    public function getConversations($profileId)
    {
        $stmt = $this->db->prepare(
            "SELECT 
                m.match_id,
                ma.profile_a_id,
                ma.profile_b_id,
                ma.compatibility_type,
                IF(ma.profile_a_id = :profile_id1, ma.profile_b_id, ma.profile_a_id) as other_profile_id,
                p.user_id as other_user_id,
                u.galactic_name as other_galactic_name,
                u.origin_type as other_origin_type,
                p.avatar_path as other_avatar_path,
                (SELECT content FROM messages WHERE match_id = m.match_id ORDER BY created_at DESC LIMIT 1) as last_message,
                (SELECT created_at FROM messages WHERE match_id = m.match_id ORDER BY created_at DESC LIMIT 1) as last_message_time,
                (SELECT COUNT(*) FROM messages WHERE match_id = m.match_id) as message_count
             FROM (
                 SELECT DISTINCT match_id 
                 FROM messages 
                 WHERE match_id IN (
                     SELECT id FROM matches 
                     WHERE (profile_a_id = :profile_id2 OR profile_b_id = :profile_id3)
                     AND (status = 'revealed' OR status = 'accepted')
                 )
             ) m
             INNER JOIN matches ma ON ma.id = m.match_id
             INNER JOIN profiles p ON p.id = IF(ma.profile_a_id = :profile_id4, ma.profile_b_id, ma.profile_a_id)
             INNER JOIN users u ON u.id = p.user_id
             ORDER BY last_message_time DESC"
        );
        $stmt->execute([
            'profile_id1' => $profileId,
            'profile_id2' => $profileId,
            'profile_id3' => $profileId,
            'profile_id4' => $profileId
        ]);
        return $stmt->fetchAll();
    }

    /**
     * Créer un nouveau message
     * @param array $data ['match_id', 'sender_profile_id', 'content']
     * @return int|false ID du nouveau message ou false en cas d'erreur
     */
    public function create($data)
    {
        // Validation
        if (empty($data['match_id']) || empty($data['sender_profile_id']) || empty($data['content'])) {
            return false;
        }

        if (strlen($data['content']) > 5000) {
            return false; // Limite de longueur
        }

        $stmt = $this->db->prepare(
            "INSERT INTO messages (match_id, sender_profile_id, content, created_at)
             VALUES (:match_id, :sender_profile_id, :content, :created_at)"
        );

        $result = $stmt->execute([
            'match_id' => $data['match_id'],
            'sender_profile_id' => $data['sender_profile_id'],
            'content' => trim($data['content']),
            'created_at' => time()
        ]);

        if ($result) {
            return $this->db->lastInsertId();
        }

        return false;
    }

    /**
     * Supprimer un message
     */
    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM messages WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    /**
     * Compter les messages d'un match
     */
    public function countByMatchId($matchId)
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM messages WHERE match_id = :match_id");
        $stmt->execute(['match_id' => $matchId]);
        $result = $stmt->fetch();
        return $result['count'] ?? 0;
    }
}

