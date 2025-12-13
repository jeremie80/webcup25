# WebCup 2025 - Application de Rencontres

Application de rencontres avec système de matching intelligent et IA narrateur.

## 🚀 Installation Rapide

```bash
# 1. Installer les dépendances
composer install

# 2. Configurer l'environnement
cp .env.example .env
# Éditez .env avec vos paramètres MySQL

# 3. Lancer le serveur
php -S localhost:8000

# 4. Tester
composer test
```

## 🏗️ Architecture MVC

```
app/
├── Controllers/     # Logique de contrôle
├── Models/          # Accès aux données
├── Views/           # Templates
├── Services/        # Services métier
└── Core/            # Framework
```

## 🔧 Stack Technique

- **Backend** : PHP 8.2+
- **Frontend** : JavaScript/jQuery
- **Base de données** : MySQL 8.0
- **CI/CD** : GitHub Actions → cPanel (FTP)

**Pas de Node.js requis !**

## 🚀 Déploiement avec cPanel

### Configuration GitHub Actions (5 min)

Ajoutez ces 4 secrets dans **GitHub → Settings → Secrets → Actions** :

```
FTP_SERVER      → rns1.hodi.host
FTP_USERNAME    → votre_login_cpanel
FTP_PASSWORD    → votre_mot_de_passe
FTP_SERVER_DIR  → /public_html/
```

### Push = Déploiement automatique !

```bash
git push origin main
# → Tests automatiques
# → Déploiement FTP vers cPanel
# → En ligne en ~5 minutes !
```

## 🧪 Tests

```bash
# Exécuter tous les tests
composer test

# Tests avec couverture
composer test-coverage

# Analyse statique
composer analyse
```

## 📁 Fichiers Clés

- `index.php` - Point d'entrée (Front Controller)
- `composer.json` - Dépendances PHP
- `.github/workflows/ci-cd.yml` - Pipeline CI/CD
- `phpunit.xml.dist` - Configuration des tests
- `.env.example` - Variables d'environnement

## 🌿 Workflow Git

```bash
# Développer une feature
git checkout -b feature/ma-feature
# ... coder ...
git commit -am "✨ Ma feature"
git push origin feature/ma-feature

# Déployer (via Pull Request vers main)
# → Tests automatiques
# → Déploiement en production
```

## 📊 Routes Disponibles

| Méthode | Route | Description |
|---------|-------|-------------|
| GET | `/` | Page d'accueil |
| GET | `/auth/start` | Connexion/Inscription |
| GET | `/profile/create` | Création de profil |
| GET | `/match` | Liste des matchs |
| GET | `/chat` | Interface de chat |

## 🛠️ Développement

### Ajouter un contrôleur

```php
<?php
namespace App\Controllers;
use App\Core\Controller;

class MonController extends Controller {
    public function index() {
        $this->view('ma-vue');
    }
}
```

### Ajouter une route

Dans `index.php` :
```php
$router->get('/ma-route', 'MonController@index');
```

## 📦 Dépendances

```json
{
  "require": {
    "php": ">=8.0",
    "vlucas/phpdotenv": "^5.5"
  },
  "require-dev": {
    "phpunit/phpunit": "^9.5",
    "phpstan/phpstan": "^1.10"
  }
}
```

## 🔐 Configuration

Créez un fichier `.env` à la racine :

```env
DB_HOST=localhost
DB_NAME=webcup25
DB_USER=root
DB_PASS=

APP_ENV=development
APP_URL=http://localhost:8000
```

## 🎯 CI/CD Pipeline

À chaque push sur `main` :

1. ✅ Tests PHP (PHPUnit)
2. ✅ Vérification sécurité (Composer audit)
3. ✅ Vérification qualité (PHPStan)
4. ✅ Déploiement FTP vers cPanel

**Durée totale : ~5 minutes**

## 📚 Documentation

- `.github/DEPLOYMENT.md` - Guide de déploiement
- `composer.json` - Scripts disponibles

## 🆘 Dépannage

### Erreur Composer
```bash
composer install
```

### Tests qui échouent
```bash
composer test
```

### Serveur local
```bash
php -S localhost:8000
```

## 📝 Scripts Composer

```bash
composer test              # Tests PHPUnit
composer test-coverage     # Tests avec couverture
composer analyse           # Analyse statique PHPStan
```

## 🏆 WebCup 2025

Projet développé pour la WebCup 2025.

**Déploiement** : Direct en production via GitHub Actions + cPanel (FTP)

---

💡 **Conseil** : Testez toujours localement avant de pusher sur `main` !

🚀 **Bon développement !**
