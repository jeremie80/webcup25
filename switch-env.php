<?php
/**
 * Script pour basculer entre les environnements
 * Usage: php switch-env.php [development|production]
 */

$envFile = __DIR__ . '/.env';

if (!file_exists($envFile)) {
    die("❌ Fichier .env introuvable !\n");
}

$targetEnv = $argv[1] ?? null;

if (!in_array($targetEnv, ['development', 'production'])) {
    echo "Usage: php switch-env.php [development|production]\n";
    echo "\nEnvironnement actuel: ";
    
    $content = file_get_contents($envFile);
    if (preg_match('/APP_ENV=(\w+)/', $content, $matches)) {
        echo $matches[1] . "\n";
    } else {
        echo "Non défini\n";
    }
    exit(1);
}

// Lire le fichier .env
$content = file_get_contents($envFile);

// Remplacer APP_ENV
$content = preg_replace('/APP_ENV=\w+/', "APP_ENV={$targetEnv}", $content);

// Sauvegarder
if (file_put_contents($envFile, $content)) {
    echo "✅ Environnement basculé vers: {$targetEnv}\n\n";
    
    // Afficher la configuration qui sera utilisée
    if ($targetEnv === 'development') {
        echo "🔧 Configuration DÉVELOPPEMENT:\n";
        echo "   Base de données: webcup25 (localhost)\n";
        echo "   URL: http://localhost:8000\n";
    } else {
        echo "🚀 Configuration PRODUCTION:\n";
        echo "   Base de données: serveur1_iastromatch (localhost)\n";
        echo "   URL: https://votre-domaine.com\n";
    }
    
    echo "\n💡 Redémarrez votre serveur pour appliquer les changements\n";
} else {
    echo "❌ Erreur lors de la modification du fichier .env\n";
    exit(1);
}

