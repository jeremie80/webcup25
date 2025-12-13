# ⚡ Guide Rapide Multi-Environnements

## 🎯 2 Environnements Configurés

Vous avez maintenant **DEV** et **PROD** configurés automatiquement !

---

## 🔄 Comment Ça Marche ?

### Dans votre `.env`, changez juste UNE ligne :

```env
APP_ENV=development    # Pour développement local
# ou
APP_ENV=production     # Pour production (cPanel)
```

**C'est tout !** La bonne base de données est utilisée automatiquement ✨

---

## 📊 Configuration Actuelle

### 🔧 Développement (`APP_ENV=development`)

```
Base de données : webcup25
Serveur         : localhost
Utilisateur     : root
Mot de passe    : (vide)
URL             : http://localhost:8000
```

### 🚀 Production (`APP_ENV=production`)

```
Base de données : serveur1_iastromatch
Serveur         : localhost
Utilisateur     : serveur1_root
Mot de passe    : kzkxfPpZYvNgVK1l
URL             : https://votre-domaine.com
```

---

## 🔄 Basculer d'Environnement

### Méthode 1 : Script Automatique

```bash
# Passer en dev
php switch-env.php development

# Passer en prod
php switch-env.php production

# Voir l'environnement actuel
php switch-env.php
```

### Méthode 2 : Manuelle

Éditez `.env` et changez :
```env
APP_ENV=development   # ou production
```

---

## 🧪 Tester

```bash
php test-db.php
```

Vous verrez la base de données connectée selon `APP_ENV` !

---

## 📁 Où C'est Configuré ?

```
config/database.php    ← Les 2 configs (dev + prod)
app/Core/Config.php    ← Chargeur automatique
app/Core/Database.php  ← Utilise Config selon APP_ENV
.env                   ← Votre environnement actuel
```

---

## 🚀 Déploiement Production

### Sur cPanel, créez `.env` avec :

```env
APP_ENV=production

# Les autres paramètres ne sont pas nécessaires,
# config/database.php contient déjà tout !
```

**C'est tout !** La connexion se fera automatiquement sur la bonne BDD.

---

## ✅ Avantages

1. ✨ **Un seul changement** : `APP_ENV=development` ou `production`
2. 🔐 **Sécurisé** : Config dans `config/database.php` (peut être versionnée)
3. 🚀 **Simple** : Pas besoin de changer plusieurs variables
4. 🎯 **Automatique** : La bonne config est choisie automatiquement

---

## 📝 Exemple d'Utilisation

```php
<?php

// Dans votre .env : APP_ENV=development

use App\Core\Database;
use App\Models\User;

// Connexion automatique selon APP_ENV
$db = Database::getInstance();
// → Connecté à 'webcup25' en dev
// → Connecté à 'serveur1_iastromatch' en prod

// Utiliser normalement
$userModel = new User();
$users = $userModel->getAll();
```

---

## 🎯 Workflow

### Développement

```bash
# Dans .env
APP_ENV=development

# Développer
php -S localhost:8000
```

### Production

```bash
# Dans .env (sur cPanel)
APP_ENV=production

# Ça marche automatiquement ! ✅
```

---

## 🆘 Problème ?

```bash
# Voir l'environnement actuel
php switch-env.php

# Tester la connexion
php test-db.php
```

---

🎉 **C'est configuré et prêt !**

💡 **Astuce** : En local, gardez toujours `APP_ENV=development` dans votre `.env`

