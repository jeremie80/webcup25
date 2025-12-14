# 🚀 Démarrer Votre Application

## ✅ Configuration Terminée !

Tous vos fichiers sont maintenant configurés et prêts.

---

## 🎯 Lancer l'Application

### 1. Assurez-vous d'avoir Composer

```bash
composer install
```

### 2. Lancez le serveur PHP

```bash
php -S localhost:8000
```

### 3. Ouvrez votre navigateur

**http://localhost:8000**

---

## 🎨 Résultat Attendu

Vous devriez voir :

```
╔════════════════════════════════════════╗
║  WebCup 2025           [Menu]          ║ ← Header blanc
╠════════════════════════════════════════╣
║                                        ║
║     Bienvenue sur WebCup 2025          ║ ← Titre dégradé rouge
║  Application de rencontres avec IA     ║
║                                        ║
║  ┌──────────┐ ┌──────────┐ ┌─────────┐║
║  │    🎯    │ │    💬    │ │   🤖    │║
║  │ Matching │ │   Chat   │ │   IA    │║ ← 3 Features
║  │ Intel... │ │ Temps... │ │ Narr... │║
║  └──────────┘ └──────────┘ └─────────┘║
║                                        ║
║         [  Commencer  ]                ║ ← Bouton rouge
║                                        ║
╚════════════════════════════════════════╝
   Fond : Noir avec dégradé
```

---

## 📊 Fichiers Configurés

### Structure MVC

| Fichier | Status |
|---------|--------|
| `index.php` | ✅ Front Controller actif |
| `app/Core/Router.php` | ✅ Routeur fonctionnel |
| `app/Core/Controller.php` | ✅ Base controller avec `view()` |
| `app/Core/Database.php` | ✅ PDO Singleton avec .env |
| `app/Core/Config.php` | ✅ Multi-environnements |

### Controllers

| Fichier | Status |
|---------|--------|
| `app/Controllers/HomeController.php` | ✅ Page d'accueil |
| `app/Controllers/AuthController.php` | ⏳ À implémenter |
| `app/Controllers/ProfileController.php` | ⏳ À implémenter |
| `app/Controllers/MatchController.php` | ⏳ À implémenter |
| `app/Controllers/ChatController.php` | ⏳ À implémenter |

### Views

| Fichier | Status |
|---------|--------|
| `app/Views/layout.php` | ✅ Layout principal |
| `app/Views/home/intro.php` | ✅ Page d'accueil |
| `app/Views/partials/header.php` | ✅ Header |
| `app/Views/partials/ia.php` | ⏳ À créer |

### Assets

| Fichier | Status |
|---------|--------|
| `assets/css/style.css` | ✅ Design moderne |
| `assets/js/app.js` | ✅ jQuery configuré |

### Configuration

| Fichier | Status |
|---------|--------|
| `.env` | ✅ Variables d'environnement |
| `config/database.php` | ✅ Multi-env (dev/prod) |
| `.htaccess` | ✅ Routing + Assets |
| `.gitignore` | ✅ Ignore .env |

### CI/CD

| Fichier | Status |
|---------|--------|
| `.github/workflows/ci-cd.yml` | ✅ Déploiement auto avec .env |

---

## 🔐 Configuration Base de Données

### Fichier .env

```env
APP_ENV=development

# Dev
DB_DEV_HOST=localhost
DB_DEV_NAME=serveur1_iastromatch
DB_DEV_USER=serveur1_root
DB_DEV_PASS=kzkxfPpZYvNgVK1l

# Prod (utilisé en production)
DB_PROD_HOST=localhost
DB_PROD_NAME=serveur1_iastromatch
DB_PROD_USER=serveur1_root
DB_PROD_PASS=kzkxfPpZYvNgVK1l
```

### Connexion PDO

```php
use App\Core\Database;

$pdo = Database::getInstance();
```

✅ Singleton pattern
✅ Lecture depuis .env
✅ Multi-environnements

---

## 🌐 Routes Disponibles

| URL | Controller | Méthode |
|-----|------------|---------|
| `/` | HomeController | index |
| `/auth/start` | AuthController | start |
| `/auth/login` | AuthController | login (POST) |
| `/auth/register` | AuthController | register (POST) |
| `/profile/create` | ProfileController | create |
| `/profile/store` | ProfileController | store (POST) |
| `/match` | MatchController | index |
| `/match/detail` | MatchController | detail |
| `/match/result` | MatchController | result |
| `/chat` | ChatController | index |
| `/chat/send` | ChatController | send (POST) |

---

## 🧪 Tester la Connexion BDD

```bash
php test-db.php
```

**Résultat attendu :**
```
✅ Connexion à la base de données réussie !
📦 Environnement actif : development
📦 Base de données active : serveur1_iastromatch
🔍 Requête de test exécutée avec succès.
```

---

## 🎨 CSS Chargé

Le fichier `assets/css/style.css` contient :

- ✅ Design noir moderne
- ✅ Header blanc avec menu
- ✅ Boutons animés
- ✅ Cards avec effets au survol
- ✅ Responsive mobile
- ✅ Dégradés colorés

**Pour modifier**, éditez simplement `assets/css/style.css` !

---

## 📱 Responsive

Le design s'adapte automatiquement :

- **Desktop** : Menu horizontal, 3 colonnes
- **Mobile** : Menu vertical, 1 colonne

---

## 🚀 Déploiement en Production

### 1. Configurer les Secrets GitHub

Voir : **[GITHUB-SECRETS-SETUP.md](GITHUB-SECRETS-SETUP.md)**

9 secrets à configurer :
- `FTP_SERVER`, `FTP_USERNAME`, `FTP_PASSWORD`
- `DB_PROD_HOST`, `DB_PROD_NAME`, `DB_PROD_USER`, `DB_PROD_PASS`
- `APP_URL`, `IA_API_KEY`

### 2. Push sur GitHub

```bash
git add .
git commit -m "🚀 Application complète avec CSS"
git push origin main
```

### 3. Déploiement Automatique

GitHub Actions va :
1. ✅ Exécuter les tests
2. ✅ Créer le `.env` depuis les secrets
3. ✅ Déployer via FTP vers cPanel
4. ✅ Site en ligne !

---

## 🔧 Développement

### Structure du Projet

```
webcup25/
├── app/
│   ├── Controllers/     ← Vos controllers
│   ├── Core/           ← Framework
│   ├── Models/         ← Modèles DB
│   ├── Services/       ← Logique métier
│   └── Views/          ← Templates HTML
├── assets/
│   ├── css/
│   │   └── style.css   ← Votre CSS
│   ├── js/
│   │   └── app.js      ← Votre JS
│   └── images/         ← Vos images
├── config/
│   └── database.php    ← Config DB
├── .env                ← Variables (local)
├── index.php           ← Front Controller
└── .htaccess           ← Apache config
```

### Créer une Nouvelle Page

**1. Créer le Controller**

```php
// app/Controllers/ExampleController.php
<?php
namespace App\Controllers;
use App\Core\Controller;

class ExampleController extends Controller
{
    public function index()
    {
        $data = ['title' => 'Ma Page'];
        $this->view('example/index', $data);
    }
}
```

**2. Créer la Vue**

```html
<!-- app/Views/example/index.php -->
<div class="container">
    <h1>Ma Nouvelle Page</h1>
    <p>Contenu ici...</p>
</div>
```

**3. Ajouter la Route**

```php
// index.php
$router->get('/example', 'ExampleController@index');
```

**4. Tester**

http://localhost:8000/example

---

## ✅ Checklist

- [x] Structure MVC créée
- [x] Router fonctionnel
- [x] Database avec PDO + Singleton
- [x] Multi-environnements (dev/prod)
- [x] CSS moderne chargé
- [x] JavaScript avec jQuery
- [x] Layout HTML complet
- [x] Page d'accueil fonctionnelle
- [x] .htaccess configuré
- [x] CI/CD avec création .env auto
- [ ] Lancer le serveur
- [ ] Voir le design
- [ ] Implémenter les autres pages

---

## 🎯 Prochaines Étapes

### 1. Tester Localement

```bash
php -S localhost:8000
```

Visitez : http://localhost:8000

### 2. Implémenter les Autres Controllers

- AuthController (connexion/inscription)
- ProfileController (profil utilisateur)
- MatchController (matching)
- ChatController (messagerie)

### 3. Créer les Tables de Base de Données

```sql
CREATE TABLE users (...);
CREATE TABLE profiles (...);
CREATE TABLE matches (...);
CREATE TABLE messages (...);
```

### 4. Configurer GitHub Secrets

Voir : [GITHUB-SECRETS-SETUP.md](GITHUB-SECRETS-SETUP.md)

### 5. Déployer en Production

```bash
git push origin main
```

---

## 📚 Documentation

| Guide | Description |
|-------|-------------|
| [TEST-CSS.md](TEST-CSS.md) | Comment vérifier que le CSS est chargé |
| [GITHUB-SECRETS-SETUP.md](GITHUB-SECRETS-SETUP.md) | Configurer les secrets GitHub |
| [AUTO-DEPLOY-SUMMARY.md](AUTO-DEPLOY-SUMMARY.md) | Déploiement automatique |
| [MULTI-ENV-SETUP.md](MULTI-ENV-SETUP.md) | Multi-environnements |

---

## 🆘 Aide

### Erreur 404

**Vérifiez** :
- Le `.htaccess` existe
- Apache `mod_rewrite` est activé
- La route existe dans `index.php`

### CSS ne se charge pas

**Vérifiez** :
- Le chemin dans `layout.php` : `/assets/css/style.css`
- Le fichier existe : `assets/css/style.css`
- Le serveur est lancé depuis la racine

### Base de données

**Testez** :
```bash
php test-db.php
```

---

## 🎉 C'est Parti !

```bash
php -S localhost:8000
```

**Ouvrez** : http://localhost:8000

**Profitez de votre application ! 🚀**

