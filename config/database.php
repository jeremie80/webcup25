<?php

/**
 * Configuration de la base de données selon l'environnement
 * Les valeurs sensibles sont lues depuis .env
 */

return [
    'development' => [
        'host' => $_ENV['DB_DEV_HOST'] ?? 'localhost',
        'database' => $_ENV['DB_DEV_NAME'] ?? 'serveur1_iastromatch',
        'username' => $_ENV['DB_DEV_USER'] ?? 'root',
        'password' => $_ENV['DB_DEV_PASS'] ?? '',
        'charset' => 'utf8mb4',
    ],
    
    'production' => [
        'host' => $_ENV['DB_PROD_HOST'] ?? 'localhost',
        'database' => $_ENV['DB_PROD_NAME'] ?? 'serveur1_iastromatch',
        'username' => $_ENV['DB_PROD_USER'] ?? 'serveur1_root',
        'password' => $_ENV['DB_PROD_PASS'] ?? '',
        'charset' => 'utf8mb4',
    ],
];

