<?php
/**
 * Test de la connexion à la base de données
 */

require_once __DIR__ . '/vendor/autoload.php';

// Charger les variables d'environnement
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Tester la connexion
use App\Core\Database;

echo "🔍 Test de connexion à la base de données...\n\n";

try {
    // Récupérer la connexion PDO
    $db = Database::getInstance();
    echo "✅ Connexion à la base de données réussie !\n\n";
    
    // Afficher les paramètres de connexion
    echo "📊 Configuration :\n";
    echo "   - Host: " . $_ENV['DB_HOST'] . "\n";
    echo "   - Database: " . $_ENV['DB_NAME'] . "\n";
    echo "   - User: " . $_ENV['DB_USER'] . "\n\n";
    
    // Tester une requête
    $stmt = $db->query("SELECT DATABASE() as db_name, VERSION() as version");
    $result = $stmt->fetch();
    
    echo "📦 Informations serveur MySQL :\n";
    echo "   - Base de données active : " . $result['db_name'] . "\n";
    echo "   - Version MySQL : " . $result['version'] . "\n\n";
    
    // Tester si la table users existe
    $stmt = $db->query("SHOW TABLES LIKE 'users'");
    $tableExists = $stmt->fetch();
    
    if ($tableExists) {
        echo "✅ Table 'users' trouvée\n";
        
        // Compter les utilisateurs
        $stmt = $db->query("SELECT COUNT(*) as count FROM users");
        $count = $stmt->fetch();
        echo "👥 Nombre d'utilisateurs : " . $count['count'] . "\n\n";
    } else {
        echo "⚠️  Table 'users' non trouvée\n";
        echo "💡 Créez la table avec :\n\n";
        echo "CREATE TABLE users (\n";
        echo "    id INT AUTO_INCREMENT PRIMARY KEY,\n";
        echo "    email VARCHAR(255) UNIQUE NOT NULL,\n";
        echo "    password VARCHAR(255) NOT NULL,\n";
        echo "    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,\n";
        echo "    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP\n";
        echo ");\n\n";
    }
    
    echo "🎉 Tout fonctionne correctement !\n";
    
} catch (Exception $e) {
    echo "❌ Erreur de connexion :\n";
    echo "   " . $e->getMessage() . "\n\n";
    echo "💡 Vérifiez :\n";
    echo "   1. Le fichier .env existe à la racine\n";
    echo "   2. Les paramètres DB_HOST, DB_NAME, DB_USER, DB_PASS sont corrects\n";
    echo "   3. MySQL est démarré\n";
    echo "   4. La base de données existe\n\n";
    exit(1);
}

