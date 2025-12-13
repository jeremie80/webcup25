<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class User
{
    private $db;
    
    public function __construct()
    {
        // Récupérer la connexion PDO
        $this->db = Database::getInstance();
    }

    /**
     * Récupérer tous les utilisateurs
     */
    public function getAll()
    {
        $stmt = $this->db->query("SELECT * FROM users");
        return $stmt->fetchAll();
    }

    /**
     * Récupérer un utilisateur par email
     */
    public function findByEmail($email)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch();
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
     * Créer un nouvel utilisateur
     */
    public function create($data)
    {
        $stmt = $this->db->prepare(
            "INSERT INTO users (email, password, created_at) 
             VALUES (:email, :password, NOW())"
        );
        
        return $stmt->execute([
            'email' => $data['email'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT)
        ]);
    }

    /**
     * Mettre à jour un utilisateur
     */
    public function update($id, $data)
    {
        $stmt = $this->db->prepare(
            "UPDATE users 
             SET email = :email, updated_at = NOW() 
             WHERE id = :id"
        );
        
        return $stmt->execute([
            'id' => $id,
            'email' => $data['email']
        ]);
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
     * Vérifier les credentials de connexion
     */
    public function checkCredentials($email, $password)
    {
        $user = $this->findByEmail($email);
        
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        
        return false;
    }
}

