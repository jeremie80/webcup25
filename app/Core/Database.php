<?php

namespace App\Core;

use PDO;
use PDOException;
use App\Core\Config;

class Database
{
    private static $instance = null;
    private $connection;

    private function __construct()
    {
        // Déterminer l'environnement
        $env = $_ENV['APP_ENV'] ?? 'development';
        
        // Charger la configuration selon l'environnement
        $config = Config::getForEnv('database');
        
        // Si pas de config via fichier, utiliser les variables d'environnement
        if (!$config) {
            $config = [
                'host' => $_ENV['DB_HOST'] ?? 'localhost',
                'database' => $_ENV['DB_NAME'] ?? 'serveur1_iastromatch',
                'username' => $_ENV['DB_USER'] ?? 'root',
                'password' => $_ENV['DB_PASS'] ?? '',
                'charset' => 'utf8mb4'
            ];
        }

        try {
            // Créer la connexion PDO
            $this->connection = new PDO(
                "mysql:host={$config['host']};dbname={$config['database']};charset={$config['charset']}",
                $config['username'],
                $config['password'],
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false
                ]
            );
        } catch (PDOException $e) {
            $envDisplay = $env === 'production' ? '' : " (Environnement: {$env})";
            die("Erreur de connexion à la base de données{$envDisplay}: " . $e->getMessage());
        }
    }

    /**
     * Récupérer l'instance unique de la connexion PDO
     * 
     * @return PDO
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance->connection;
    }

    // Empêcher le clonage de l'instance
    private function __clone() {}
    
    // Empêcher la désérialisation de l'instance
    public function __wakeup() 
    {
        throw new \Exception("Cannot unserialize singleton");
    }
}

