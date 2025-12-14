<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class MatchModel
{
    private $db;
    
    // Types de compatibilité valides
    const COMPATIBILITY_TYPES = ['harmonious', 'unstable', 'improbable', 'dangerous'];
    
    // Statuts valides
    const STATUSES = ['suggested', 'accepted', 'rejected', 'revealed'];

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Récupérer tous les matchs
     */
    public function getAll()
    {
        $stmt = $this->db->query("SELECT * FROM matches ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }

    /**
     * Récupérer un match par ID
     */
    public function findById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM matches WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }
    
    /**
     * Récupérer tous les matchs d'un profil
     */
    public function findByProfileId($profileId)
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM matches 
             WHERE (profile_a_id = :profile_id1 OR profile_b_id = :profile_id2)
             ORDER BY created_at DESC"
        );
        $stmt->execute(['profile_id1' => $profileId, 'profile_id2' => $profileId]);
        return $stmt->fetchAll();
    }
    
    /**
     * Récupérer les matchs suggérés pour un profil avec JOIN
     */
    public function getSuggestedMatchesWithDetails($profileId)
    {
        $stmt = $this->db->prepare(
            "SELECT 
                m.id as match_id,
                m.profile_a_id,
                m.profile_b_id,
                m.compatibility_type,
                m.compatibility_score,
                m.ia_summary,
                m.status,
                m.created_at,
                IF(m.profile_a_id = :profile_id1, m.profile_b_id, m.profile_a_id) as other_profile_id,
                p.id as profile_id,
                p.user_id as other_user_id,
                p.atmosphere_type,
                p.communication_mode,
                p.tech_level,
                p.core_value,
                p.avatar_path,
                u.id as user_id,
                u.galactic_name,
                u.origin_type,
                u.bio_signature
             FROM matches m
             INNER JOIN profiles p ON p.id = IF(m.profile_a_id = :profile_id2, m.profile_b_id, m.profile_a_id)
             INNER JOIN users u ON u.id = p.user_id
             WHERE (m.profile_a_id = :profile_id3 OR m.profile_b_id = :profile_id4)
             AND m.status = 'suggested'
             ORDER BY 
                 CASE m.compatibility_type
                     WHEN 'harmonious' THEN 1
                     WHEN 'unstable' THEN 2
                     WHEN 'improbable' THEN 3
                     WHEN 'dangerous' THEN 4
                 END,
                 m.compatibility_score DESC"
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
     * Récupérer les matchs suggérés pour un profil (version simple)
     */
    public function getSuggestedMatches($profileId)
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM matches 
             WHERE (profile_a_id = :profile_id1 OR profile_b_id = :profile_id2)
             AND status = 'suggested'
             ORDER BY 
                 CASE compatibility_type
                     WHEN 'harmonious' THEN 1
                     WHEN 'unstable' THEN 2
                     WHEN 'improbable' THEN 3
                     WHEN 'dangerous' THEN 4
                 END,
                 compatibility_score DESC"
        );
        $stmt->execute(['profile_id1' => $profileId, 'profile_id2' => $profileId]);
        return $stmt->fetchAll();
    }
    
    /**
     * Récupérer les matchs acceptés (révélés mutuellement) avec JOIN
     */
    public function getAcceptedMatchesWithDetails($profileId)
    {
        $stmt = $this->db->prepare(
            "SELECT 
                m.id as match_id,
                m.profile_a_id,
                m.profile_b_id,
                m.compatibility_type,
                m.compatibility_score,
                m.ia_summary,
                m.status,
                m.created_at,
                IF(m.profile_a_id = :profile_id1, m.profile_b_id, m.profile_a_id) as other_profile_id,
                p.id as profile_id,
                p.user_id as other_user_id,
                p.atmosphere_type,
                p.communication_mode,
                p.tech_level,
                p.core_value,
                p.avatar_path,
                u.id as user_id,
                u.galactic_name,
                u.origin_type,
                u.bio_signature
             FROM matches m
             INNER JOIN profiles p ON p.id = IF(m.profile_a_id = :profile_id2, m.profile_b_id, m.profile_a_id)
             INNER JOIN users u ON u.id = p.user_id
             WHERE (m.profile_a_id = :profile_id3 OR m.profile_b_id = :profile_id4)
             AND (m.status = 'revealed' OR m.status = 'accepted')
             ORDER BY m.created_at DESC"
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
     * Récupérer les matchs acceptés (révélés mutuellement) - version simple
     */
    public function getAcceptedMatches($profileId)
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM matches 
             WHERE (profile_a_id = :profile_id1 OR profile_b_id = :profile_id2)
             AND status = 'revealed'
             ORDER BY created_at DESC"
        );
        $stmt->execute(['profile_id1' => $profileId, 'profile_id2' => $profileId]);
        return $stmt->fetchAll();
    }
    
    /**
     * Vérifier si un match existe déjà entre deux profils
     */
    public function existsBetween($profileAId, $profileBId)
    {
        $stmt = $this->db->prepare(
            "SELECT id FROM matches 
             WHERE (profile_a_id = :a1 AND profile_b_id = :b1)
             OR (profile_a_id = :b2 AND profile_b_id = :a2)
             LIMIT 1"
        );
        $stmt->execute([
            'a1' => $profileAId, 
            'b1' => $profileBId,
            'b2' => $profileBId,
            'a2' => $profileAId
        ]);
        return $stmt->fetch() !== false;
    }

    /**
     * Créer un nouveau match
     * @param array $data ['profile_a_id', 'profile_b_id', 'compatibility_type', 'compatibility_score', 'ia_summary', 'status'?]
     * @return int|false ID du nouveau match ou false en cas d'erreur
     */
    public function create($data)
    {
        // Validation
        if (empty($data['profile_a_id']) || empty($data['profile_b_id'])) {
            return false;
        }
        
        if (!in_array($data['compatibility_type'], self::COMPATIBILITY_TYPES)) {
            return false;
        }
        
        if (empty($data['ia_summary'])) {
            return false;
        }
        
        $status = $data['status'] ?? 'suggested';
        if (!in_array($status, self::STATUSES)) {
            $status = 'suggested';
        }
        
        // Vérifier que le match n'existe pas déjà
        if ($this->existsBetween($data['profile_a_id'], $data['profile_b_id'])) {
            return false;
        }
        
        $stmt = $this->db->prepare(
            "INSERT INTO matches (profile_a_id, profile_b_id, compatibility_type, compatibility_score, ia_summary, status)
             VALUES (:profile_a_id, :profile_b_id, :compatibility_type, :compatibility_score, :ia_summary, :status)"
        );

        $result = $stmt->execute([
            'profile_a_id' => $data['profile_a_id'],
            'profile_b_id' => $data['profile_b_id'],
            'compatibility_type' => $data['compatibility_type'],
            'compatibility_score' => $data['compatibility_score'] ?? null,
            'ia_summary' => $data['ia_summary'],
            'status' => $status
        ]);
        
        if ($result) {
            return $this->db->lastInsertId();
        }
        
        return false;
    }

    /**
     * Mettre à jour le statut d'un match
     */
    public function updateStatus($id, $status)
    {
        if (!in_array($status, self::STATUSES)) {
            return false;
        }
        
        $stmt = $this->db->prepare("UPDATE matches SET status = :status WHERE id = :id");
        return $stmt->execute(['id' => $id, 'status' => $status]);
    }
    
    /**
     * Accepter un match (côté d'un profil)
     */
    public function accept($matchId, $profileId)
    {
        $match = $this->findById($matchId);
        
        if (!$match) {
            return false;
        }
        
        // Vérifier que le profil est bien concerné par ce match
        if ($match['profile_a_id'] != $profileId && $match['profile_b_id'] != $profileId) {
            return false;
        }
        
        // Si le match est déjà accepté ou révélé, on change vers "revealed"
        if ($match['status'] === 'accepted' || $match['status'] === 'suggested') {
            return $this->updateStatus($matchId, 'accepted');
        }
        
        return false;
    }
    
    /**
     * Rejeter un match
     */
    public function reject($matchId, $profileId)
    {
        $match = $this->findById($matchId);
        
        if (!$match) {
            return false;
        }
        
        // Vérifier que le profil est bien concerné par ce match
        if ($match['profile_a_id'] != $profileId && $match['profile_b_id'] != $profileId) {
            return false;
        }
        
        return $this->updateStatus($matchId, 'rejected');
    }
    
    /**
     * Révéler un match (les deux profils se sont acceptés mutuellement)
     */
    public function reveal($matchId)
    {
        return $this->updateStatus($matchId, 'revealed');
    }

    /**
     * Mettre à jour un match
     */
    public function update($id, $data)
    {
        $fields = [];
        $params = ['id' => $id];
        
        if (isset($data['compatibility_type']) && in_array($data['compatibility_type'], self::COMPATIBILITY_TYPES)) {
            $fields[] = "compatibility_type = :compatibility_type";
            $params['compatibility_type'] = $data['compatibility_type'];
        }
        
        if (isset($data['compatibility_score'])) {
            $fields[] = "compatibility_score = :compatibility_score";
            $params['compatibility_score'] = $data['compatibility_score'];
        }
        
        if (isset($data['ia_summary'])) {
            $fields[] = "ia_summary = :ia_summary";
            $params['ia_summary'] = $data['ia_summary'];
        }
        
        if (isset($data['status']) && in_array($data['status'], self::STATUSES)) {
            $fields[] = "status = :status";
            $params['status'] = $data['status'];
        }
        
        if (empty($fields)) {
            return false;
        }
        
        $sql = "UPDATE matches SET " . implode(', ', $fields) . " WHERE id = :id";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute($params);
    }

    /**
     * Supprimer un match
     */
    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM matches WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
    
    /**
     * Récupérer les types de compatibilité valides
     */
    public function getCompatibilityTypes()
    {
        return self::COMPATIBILITY_TYPES;
    }
    
    /**
     * Récupérer les statuts valides
     */
    public function getStatuses()
    {
        return self::STATUSES;
    }
    
    /**
     * Obtenir l'autre profil du match
     */
    public function getOtherProfileId($matchId, $currentProfileId)
    {
        $match = $this->findById($matchId);
        
        if (!$match) {
            return null;
        }
        
        if ($match['profile_a_id'] == $currentProfileId) {
            return $match['profile_b_id'];
        } elseif ($match['profile_b_id'] == $currentProfileId) {
            return $match['profile_a_id'];
        }
        
        return null;
    }
}

