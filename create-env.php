<?php
/**
 * Script pour créer automatiquement le fichier .env
 */

$envContent = <<<'ENV'
# Configuration de la base de données
DB_HOST=localhost
DB_NAME=serveur1_iastromatch
DB_USER=serveur1_root
DB_PASS=kzkxfPpZYvNgVK1l

# Configuration de l'application
APP_ENV=development
APP_URL=http://localhost:8000

# Clé API pour l'IA narrateur (optionnel)
IA_API_KEY=

# Configuration du stockage
UPLOAD_PATH=storage/avatars/
ENV;

$envFile = __DIR__ . '/.env';

if (file_exists($envFile)) {
    echo "⚠️  Le fichier .env existe déjà !\n";
    echo "Voulez-vous le remplacer ? (o/n) : ";
    $handle = fopen("php://stdin", "r");
    $line = fgets($handle);
    if (trim(strtolower($line)) !== 'o') {
        echo "❌ Annulé. Le fichier .env n'a pas été modifié.\n";
        exit(0);
    }
}

if (file_put_contents($envFile, $envContent)) {
    echo "✅ Fichier .env créé avec succès !\n\n";
    echo "📋 Contenu :\n";
    echo str_repeat("-", 50) . "\n";
    echo $envContent . "\n";
    echo str_repeat("-", 50) . "\n\n";
    echo "🔒 Le fichier .env est maintenant dans .gitignore\n";
    echo "💡 Vous pouvez modifier les paramètres dans .env\n\n";
    echo "🧪 Testez la connexion avec : php test-db.php\n";
} else {
    echo "❌ Erreur lors de la création du fichier .env\n";
    echo "💡 Créez-le manuellement avec votre éditeur de texte\n";
    exit(1);
}

