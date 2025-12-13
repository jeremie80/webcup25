# 🔧 Configuration .env

## ⚠️ Fichier .env Requis

Le fichier `.env` est protégé et n'est pas versionné (c'est normal pour la sécurité).

Vous devez **créer manuellement** un fichier `.env` à la racine du projet.

## 📝 Créer le fichier .env

### Méthode 1 : Copie Manuelle

Créez un fichier `.env` à la racine avec ce contenu :

```env
# Configuration de la base de données
DB_HOST=localhost
DB_NAME=webcup25
DB_USER=root
DB_PASS=

# Configuration de l'application
APP_ENV=development
APP_URL=http://localhost:8000

# Clé API pour l'IA narrateur (optionnel)
IA_API_KEY=

# Configuration du stockage
UPLOAD_PATH=storage/avatars/
```

### Méthode 2 : Via Terminal

```bash
# Copier .env.example vers .env (si vous aviez un .env.example)
cp .env.example .env

# Ou créer directement
cat > .env << 'EOF'
DB_HOST=localhost
DB_NAME=webcup25
DB_USER=root
DB_PASS=

APP_ENV=development
APP_URL=http://localhost:8000

IA_API_KEY=

UPLOAD_PATH=storage/avatars/
EOF
```

## 🗄️ Créer la Base de Données

### En local (MySQL)

```sql
CREATE DATABASE webcup25 CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Créer une table users de test
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insérer un utilisateur de test
INSERT INTO users (email, password) 
VALUES ('test@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');
-- Mot de passe : password
```

### Sur cPanel

1. Connectez-vous à cPanel : https://rns1.hodi.host:2083/
2. Allez dans **MySQL Database Wizard**
3. Créez la base : `webcup25`
4. Créez l'utilisateur avec un mot de passe
5. Notez les informations pour votre `.env` de production

## ✅ Tester la Connexion

Créez un fichier `test-db.php` à la racine :

```php
<?php

require_once __DIR__ . '/vendor/autoload.php';

// Charger .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Tester la connexion
use App\Core\Database;

try {
    $db = Database::getInstance();
    echo "✅ Connexion à la base de données réussie !\n";
    
    // Tester une requête
    $stmt = $db->query("SELECT DATABASE() as db_name");
    $result = $stmt->fetch();
    echo "📦 Base de données connectée : " . $result['db_name'] . "\n";
    
} catch (Exception $e) {
    echo "❌ Erreur : " . $e->getMessage() . "\n";
}
```

Puis exécutez :

```bash
php test-db.php
```

## 🎯 Configuration Production (cPanel)

Pour la production, modifiez votre `.env` avec les identifiants cPanel :

```env
# Production
DB_HOST=localhost
DB_NAME=cpanel_user_webcup25
DB_USER=cpanel_user_webcup
DB_PASS=votre_mot_de_passe_cpanel

APP_ENV=production
APP_URL=https://votre-domaine.com
```

## 🔐 Sécurité

⚠️ **Important** :
- Ne JAMAIS commiter le fichier `.env`
- Le fichier `.env` est déjà dans `.gitignore`
- Utilisez des mots de passe forts en production
- Changez les credentials entre dev et prod

## ✅ Vérification

Une fois le `.env` créé, vous pouvez utiliser la connexion dans vos models :

```php
use App\Models\User;

$userModel = new User();
$users = $userModel->getAll();
```

---

💡 **Astuce** : Gardez toujours une copie de votre `.env` de production dans un endroit sûr (gestionnaire de mots de passe, coffre-fort numérique, etc.).

