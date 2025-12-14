<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class Profile
{
    private $db;
    
    // Types valides selon le schéma de la table
    const ATMOSPHERE_TYPES = ['oxygen', 'methane', 'vacuum', 'aquatic'];
    const COMMUNICATION_MODES = ['verbal', 'telepathic', 'chemical', 'luminous'];
    const TECH_LEVELS = ['organic', 'hybrid', 'advanced'];
    const CORE_VALUES = ['harmony', 'survival', 'expansion', 'knowledge'];

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Récupérer tous les profils
     */
    public function getAll()
    {
        $stmt = $this->db->query("SELECT * FROM profiles ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }

    /**
     * Récupérer un profil par ID
     */
    public function findById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM profiles WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }
    
    /**
     * Récupérer un profil par user_id
     */
    public function findByUserId($userId)
    {
        $stmt = $this->db->prepare("SELECT * FROM profiles WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetch();
    }

    /**
     * Créer un nouveau profil
     * @param array $data ['user_id', 'atmosphere_type', 'communication_mode', 'tech_level', 'core_value', 'avatar_path']
     * @return int|false ID du nouveau profil ou false en cas d'erreur
     */
    public function create($data)
    {
        // Validation
        if (empty($data['user_id']) || !is_numeric($data['user_id'])) {
            return false;
        }
        
        if (!in_array($data['atmosphere_type'], self::ATMOSPHERE_TYPES)) {
            return false;
        }
        
        if (!in_array($data['communication_mode'], self::COMMUNICATION_MODES)) {
            return false;
        }
        
        if (!in_array($data['tech_level'], self::TECH_LEVELS)) {
            return false;
        }
        
        if (!in_array($data['core_value'], self::CORE_VALUES)) {
            return false;
        }
        
        if (empty($data['avatar_path']) || strlen($data['avatar_path']) > 255) {
            return false;
        }
        
        // Vérifier qu'un profil n'existe pas déjà pour cet utilisateur
        if ($this->findByUserId($data['user_id'])) {
            return false;
        }
        
        $stmt = $this->db->prepare(
            "INSERT INTO profiles (user_id, atmosphere_type, communication_mode, tech_level, core_value, avatar_path)
             VALUES (:user_id, :atmosphere_type, :communication_mode, :tech_level, :core_value, :avatar_path)"
        );

        $result = $stmt->execute([
            'user_id' => $data['user_id'],
            'atmosphere_type' => $data['atmosphere_type'],
            'communication_mode' => $data['communication_mode'],
            'tech_level' => $data['tech_level'],
            'core_value' => $data['core_value'],
            'avatar_path' => $data['avatar_path']
        ]);
        
        if ($result) {
            return $this->db->lastInsertId();
        }
        
        return false;
    }

    /**
     * Mettre à jour un profil
     */
    public function update($id, $data)
    {
        $fields = [];
        $params = ['id' => $id];
        
        if (isset($data['atmosphere_type']) && in_array($data['atmosphere_type'], self::ATMOSPHERE_TYPES)) {
            $fields[] = "atmosphere_type = :atmosphere_type";
            $params['atmosphere_type'] = $data['atmosphere_type'];
        }
        
        if (isset($data['communication_mode']) && in_array($data['communication_mode'], self::COMMUNICATION_MODES)) {
            $fields[] = "communication_mode = :communication_mode";
            $params['communication_mode'] = $data['communication_mode'];
        }
        
        if (isset($data['tech_level']) && in_array($data['tech_level'], self::TECH_LEVELS)) {
            $fields[] = "tech_level = :tech_level";
            $params['tech_level'] = $data['tech_level'];
        }
        
        if (isset($data['core_value']) && in_array($data['core_value'], self::CORE_VALUES)) {
            $fields[] = "core_value = :core_value";
            $params['core_value'] = $data['core_value'];
        }
        
        if (isset($data['avatar_path']) && strlen($data['avatar_path']) <= 255) {
            $fields[] = "avatar_path = :avatar_path";
            $params['avatar_path'] = $data['avatar_path'];
        }
        
        if (empty($fields)) {
            return false;
        }
        
        $sql = "UPDATE profiles SET " . implode(', ', $fields) . " WHERE id = :id";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute($params);
    }

    /**
     * Supprimer un profil
     */
    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM profiles WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
    
    /**
     * Récupérer les types valides
     */
    public function getAtmosphereTypes()
    {
        return self::ATMOSPHERE_TYPES;
    }
    
    public function getCommunicationModes()
    {
        return self::COMMUNICATION_MODES;
    }
    
    public function getTechLevels()
    {
        return self::TECH_LEVELS;
    }
    
    public function getCoreValues()
    {
        return self::CORE_VALUES;
    }
}

