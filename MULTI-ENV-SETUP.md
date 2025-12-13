# 🔄 Configuration Multi-Environnements

## 🎯 Système Mis en Place

Vous avez maintenant **2 méthodes** pour gérer dev et production :

---

## 📋 Méthode 1 : Via Fichiers de Configuration (Recommandée)

### Structure

```
config/
└── database.php          ← Configuration dev + prod

app/Core/
├── Config.php           ← Chargeur de config
└── Database.php         ← Utilise Config selon APP_ENV
```

### Configuration

**`config/database.php`** contient les deux environnements :

```php
return [
    'development' => [
        'host' => 'localhost',
        'database' => 'webcup25',
        'username' => 'root',
        'password' => '',
    ],
    
    'production' => [
        'host' => 'localhost',
        'database' => 'serveur1_iastromatch',
        'username' => 'serveur1_root',
        'password' => 'kzkxfPpZYvNgVK1l',
    ],
];
```

### Utilisation

**Dans `.env`**, changez juste :

```env
# Développement
APP_ENV=development

# Production
APP_ENV=production
```

**Database.php** choisit automatiquement la bonne config ! ✨

---

## 📋 Méthode 2 : Via Variables .env Uniquement

### Configuration `.env` - Développement

```env
APP_ENV=development

# Base de données DEV
DB_HOST=localhost
DB_NAME=webcup25
DB_USER=root
DB_PASS=

APP_URL=http://localhost:8000
```

### Configuration `.env` - Production

```env
APP_ENV=production

# Base de données PROD
DB_HOST=localhost
DB_NAME=serveur1_iastromatch
DB_USER=serveur1_root
DB_PASS=kzkxfPpZYvNgVK1l

APP_URL=https://votre-domaine.com
```

---

## 🔄 Basculer Entre les Environnements

### Option 1 : Script Automatique

```bash
# Passer en développement
php switch-env.php development

# Passer en production
php switch-env.php production
```

### Option 2 : Manuellement

Éditez `.env` et changez :

```env
APP_ENV=development   # ou production
```

---

## 🗂️ Organisation des Fichiers

### Fichiers Créés

```
webcup25/
├── .env                        ← Environnement actuel
├── .env.example                ← Template avec les deux configs
├── config/
│   └── database.php            ← Config dev + prod
├── app/Core/
│   ├── Config.php              ← Chargeur de configuration
│   └── Database.php            ← Utilise Config selon APP_ENV
└── switch-env.php              ← Script pour basculer
```

---

## 💡 Quelle Méthode Utiliser ?

### ✅ Méthode 1 (Fichiers de Config) - Recommandée

**Avantages :**
- ✅ Tout est dans `config/database.php`
- ✅ Sécurisé (peut être versionné)
- ✅ Un seul changement dans `.env` : `APP_ENV`
- ✅ Facile à déployer

**Utiliser si :**
- Vous déployez souvent
- Plusieurs personnes travaillent sur le projet
- Vous voulez versionner les configs

### ✅ Méthode 2 (Variables .env)

**Avantages :**
- ✅ Plus simple
- ✅ Tout dans un fichier
- ✅ Pas de fichier de config supplémentaire

**Utiliser si :**
- Projet simple
- Vous travaillez seul
- Vous préférez tout dans `.env`

---

## 🚀 Déploiement Production (cPanel)

### Étape 1 : Sur cPanel

Créez un fichier `.env` dans votre dossier web :

```env
APP_ENV=production

DB_HOST=localhost
DB_NAME=serveur1_iastromatch
DB_USER=serveur1_root
DB_PASS=kzkxfPpZYvNgVK1l

APP_URL=https://votre-domaine.com
```

### Étape 2 : Vérifier

Le fichier `config/database.php` est déjà dans votre code.
La connexion se fera automatiquement sur la bonne BDD ! 🎉

---

## 🧪 Tester les Environnements

### Test Local (Dev)

```bash
# 1. Basculer en dev
php switch-env.php development

# 2. Tester
php test-db.php
```

**Résultat attendu :**
```
✅ Connexion réussie !
📦 Base de données : webcup25
```

### Test Production (Simulé)

```bash
# 1. Basculer en prod
php switch-env.php production

# 2. Tester
php test-db.php
```

**Résultat attendu :**
```
✅ Connexion réussie !
📦 Base de données : serveur1_iastromatch
```

---

## 📊 Exemple Complet

### Dans votre code PHP

```php
<?php

require_once 'vendor/autoload.php';

// Charger .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Afficher l'environnement
$env = $_ENV['APP_ENV'] ?? 'development';
echo "Environnement actuel : {$env}\n";

// Connexion BDD (automatique selon APP_ENV)
use App\Core\Database;
$db = Database::getInstance();

// Utiliser
use App\Models\User;
$userModel = new User();
$users = $userModel->getAll();

echo "Nombre d'utilisateurs : " . count($users) . "\n";
```

**En dev** → Utilise `webcup25`
**En prod** → Utilise `serveur1_iastromatch`

---

## 🔐 Sécurité

### ✅ Fichiers Versionnés (Safe)

- `config/database.php` ← Peut être commité
- `.env.example` ← Peut être commité
- `switch-env.php` ← Peut être commité

### ❌ Fichiers NON Versionnés (Secrets)

- `.env` ← Ne JAMAIS commit !

---

## 🎯 Workflow Quotidien

### En Développement

```bash
# Vérifier l'environnement
cat .env | grep APP_ENV

# Si en production, basculer
php switch-env.php development

# Développer normalement
php -S localhost:8000
```

### Avant le Déploiement

```bash
# Tester en mode production localement
php switch-env.php production
php test-db.php

# Si OK, push
git push origin main

# Sur cPanel, vérifier que .env a APP_ENV=production
```

---

## 🆘 Dépannage

### Erreur : "Environnement non trouvé"

Vérifiez que `APP_ENV` dans `.env` est bien `development` ou `production`.

### Connexion échoue

```bash
# Vérifier l'environnement actuel
php switch-env.php

# Vérifier la config chargée
php -r "
require 'vendor/autoload.php';
\$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
\$dotenv->load();
echo 'APP_ENV: ' . (\$_ENV['APP_ENV'] ?? 'non défini') . PHP_EOL;
"
```

---

## ✅ Avantages de ce Système

1. **Un seul changement** : `APP_ENV=production`
2. **Pas de doublon** : Config centralisée
3. **Sécurisé** : `.env` jamais versionné
4. **Flexible** : Facile d'ajouter un 3ème env (staging, etc.)
5. **Propre** : Séparation config / secrets

---

🎉 **Votre système multi-environnements est prêt !**

💡 **Conseil** : Utilisez la Méthode 1 (fichiers de config) pour plus de flexibilité !

