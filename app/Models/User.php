<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class User
{
    private $db;
    
    // Types d'origine valides selon le schéma de la table
    const ORIGIN_TYPES = [
        'earth_renewed',
        'oceanic_world',
        'forest_megacity',
        'orbital_habitat',
        'desert_solar',
        'synthetic_collective',
        'luminous_dimension',
        'nomadic_fleet'
    ];

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Récupérer tous les utilisateurs
     */
    public function getAll()
    {
        $stmt = $this->db->query("SELECT * FROM users ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }

    /**
     * Récupérer un utilisateur par ID
     */
    public function findById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }
    
    /**
     * Récupérer un utilisateur par nom galactique
     */
    public function findByGalacticName($galacticName)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE galactic_name = :galactic_name");
        $stmt->execute(['galactic_name' => $galacticName]);
        return $stmt->fetch();
    }
    
    /**
     * Récupérer un utilisateur par bio_signature
     */
    public function findByBioSignature($signature)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE bio_signature = :signature");
        $stmt->execute(['signature' => $signature]);
        return $stmt->fetch();
    }

    /**
     * Créer un nouvel utilisateur
     * @param array $data ['galactic_name', 'origin_type', 'bio_signature']
     * @return int|false ID du nouvel utilisateur ou false en cas d'erreur
     */
    public function create($data)
    {
        // Validation
        if (empty($data['galactic_name']) || strlen($data['galactic_name']) > 200) {
            return false;
        }
        
        if (!in_array($data['origin_type'], self::ORIGIN_TYPES)) {
            return false;
        }
        
        if (empty($data['bio_signature']) || strlen($data['bio_signature']) !== 64) {
            return false;
        }
        
        $stmt = $this->db->prepare(
            "INSERT INTO users (galactic_name, origin_type, bio_signature)
             VALUES (:galactic_name, :origin_type, :bio_signature)"
        );

        $result = $stmt->execute([
            'galactic_name' => $data['galactic_name'],
            'origin_type' => $data['origin_type'],
            'bio_signature' => $data['bio_signature']
        ]);
        
        if ($result) {
            return $this->db->lastInsertId();
        }
        
        return false;
    }

    /**
     * Mettre à jour un utilisateur
     */
    public function update($id, $data)
    {
        $fields = [];
        $params = ['id' => $id];
        
        if (isset($data['galactic_name']) && strlen($data['galactic_name']) <= 200) {
            $fields[] = "galactic_name = :galactic_name";
            $params['galactic_name'] = $data['galactic_name'];
        }
        
        if (isset($data['origin_type']) && in_array($data['origin_type'], self::ORIGIN_TYPES)) {
            $fields[] = "origin_type = :origin_type";
            $params['origin_type'] = $data['origin_type'];
        }
        
        if (empty($fields)) {
            return false;
        }
        
        $sql = "UPDATE users SET " . implode(', ', $fields) . " WHERE id = :id";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute($params);
    }

    /**
     * Supprimer un utilisateur
     */
    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
    
    /**
     * Récupérer la liste des types d'origine valides
     */
    public function getOriginTypes()
    {
        return self::ORIGIN_TYPES;
    }
}
