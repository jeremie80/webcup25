# 🚀 Déploiement avec cPanel - Guide Complet

## 📋 Vue d'ensemble

Vous avez un hébergement avec **cPanel** (https://rns1.hodi.host:2083/), ce qui simplifie grandement le déploiement !

```
┌─────────────────┐
│  Développement  │  ← Vous codez localement
│  Local          │
└────────┬────────┘
         │
         │ 2 Options :
         │
    ┌────┴────┐
    │         │
    ↓         ↓
┌────────┐  ┌────────┐
│   FTP  │  │  Git   │  ← Déploiement via cPanel
└────────┘  └────────┘
    │         │
    └────┬────┘
         ↓
┌─────────────────┐
│  Production     │  ← Votre site en ligne
│  (cPanel)       │
└─────────────────┘
```

## 🎯 Deux Méthodes de Déploiement

### Méthode 1 : Git via cPanel (Recommandé) ⭐

Plus moderne, automatisable avec CI/CD

### Méthode 2 : FTP (Simple)

Plus simple, manuel

---

## 🔧 Méthode 1 : Git via cPanel (Recommandé)

### Avantages
- ✅ Intégration avec GitHub
- ✅ Compatible avec le CI/CD
- ✅ Gestion des versions
- ✅ Déploiement rapide

### Prérequis

Vérifier si Git est disponible dans votre cPanel :
1. Connectez-vous : https://rns1.hodi.host:2083/
2. Cherchez **"Git Version Control"** dans les outils

### Configuration Étape par Étape

#### 1️⃣ Créer le Dépôt Git dans cPanel

**Dans cPanel → Git Version Control** :

1. Cliquez sur **"Create"**
2. Configurez :
   - **Clone URL** : `https://github.com/YOUR-USERNAME/webcup25.git`
   - **Repository Path** : `/home/votre-user/public_html/webcup25`
   - **Repository Name** : `webcup25`

3. Cliquez sur **"Create"**

#### 2️⃣ Configurer les Permissions

**Dans cPanel → Terminal** (si disponible) :

```bash
cd ~/public_html/webcup25
chmod -R 755 storage/
chmod 644 .env
```

Ou via **File Manager** :
- Clic droit sur `storage` → **Permissions** → `755`
- Clic droit sur `.env` → **Permissions** → `644`

#### 3️⃣ Installer les Dépendances

**Dans cPanel → Terminal** :

```bash
cd ~/public_html/webcup25
composer install --no-dev --optimize-autoloader
```

**Ou via SSH** (si votre hébergeur le permet) :

```bash
ssh user@rns1.hodi.host
cd ~/public_html/webcup25
composer install --no-dev --optimize-autoloader
```

#### 4️⃣ Configurer .env

**Dans cPanel → File Manager** :

1. Naviguez vers `/public_html/webcup25`
2. Copiez `.env.example` → `.env`
3. Éditez `.env` :

```env
DB_HOST=localhost
DB_NAME=votre_base_de_donnees
DB_USER=votre_utilisateur
DB_PASS=votre_mot_de_passe

APP_ENV=production
APP_URL=https://votre-domaine.com

UPLOAD_PATH=storage/avatars/
```

#### 5️⃣ Créer la Base de Données

**Dans cPanel → MySQL Database Wizard** :

1. **Étape 1** : Créer la base
   - Nom : `webcup25` (ou autre)

2. **Étape 2** : Créer l'utilisateur
   - Nom : `webcup25_user`
   - Mot de passe : (générer un mot de passe fort)

3. **Étape 3** : Privilèges
   - ✅ ALL PRIVILEGES

4. Notez les informations pour le `.env`

#### 6️⃣ Configurer le Domaine

**Option A : Sous-dossier**

Si votre site est dans `/public_html/webcup25`, il sera accessible via :
```
https://votre-domaine.com/webcup25
```

**Option B : Domaine/Sous-domaine (Recommandé)**

**Dans cPanel → Domains** :

1. Créer un sous-domaine : `webcup.votre-domaine.com`
2. Document Root : `/home/user/public_html/webcup25`
3. Le site sera accessible via : `https://webcup.votre-domaine.com`

#### 7️⃣ Configurer .htaccess

Votre `.htaccess` est déjà créé, mais vérifiez qu'il est à la racine :

```apache
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php [QSA,L]

Options -Indexes

<FilesMatch "^\.">
    Order allow,deny
    Deny from all
</FilesMatch>
```

#### 8️⃣ Déploiement Automatique

**Dans cPanel → Git Version Control** :

1. Sélectionnez votre dépôt `webcup25`
2. Cliquez sur **"Manage"**
3. Cliquez sur **"Pull or Deploy"**
4. Sélectionnez la branche `main`
5. Cliquez sur **"Update from Remote"**

**Après chaque mise à jour** :

```bash
# Via Terminal cPanel ou SSH
cd ~/public_html/webcup25
composer install --no-dev --optimize-autoloader
```

### 🤖 Automatisation avec GitHub Actions

Adaptez le CI/CD pour utiliser FTP après les tests :

**Modifier `.github/workflows/ci-cd.yml`** :

```yaml
deploy:
  name: Déploiement en Production
  runs-on: ubuntu-latest
  needs: [test, security, assets-check]
  if: github.ref == 'refs/heads/main' && github.event_name == 'push'

  steps:
    - name: Checkout du code
      uses: actions/checkout@v3

    - name: Téléchargement des artifacts
      uses: actions/download-artifact@v3
      with:
        name: assets
        path: assets/

    - name: Déploiement via FTP
      uses: SamKirkland/FTP-Deploy-Action@4.3.0
      with:
        server: ftp.rns1.hodi.host
        username: ${{ secrets.FTP_USERNAME }}
        password: ${{ secrets.FTP_PASSWORD }}
        server-dir: /public_html/webcup25/
        exclude: |
          **/.git*
          **/.git*/**
          **/node_modules/**
          **/tests/**
          **/.env
          **/composer.lock
```

**Secrets GitHub à ajouter** :
- `FTP_USERNAME` : Votre nom d'utilisateur FTP cPanel
- `FTP_PASSWORD` : Votre mot de passe FTP cPanel

---

## 📦 Méthode 2 : Déploiement FTP (Simple)

### Avantages
- ✅ Très simple
- ✅ Fonctionne toujours
- ✅ Pas de configuration complexe

### Inconvénients
- ❌ Manuel
- ❌ Pas d'automatisation
- ❌ Plus lent pour les grosses mises à jour

### Configuration FTP

#### 1️⃣ Obtenir les Identifiants FTP

**Dans cPanel → FTP Accounts** :

1. Créez un compte FTP (ou utilisez le compte principal)
2. Notez :
   - **Serveur** : `ftp.rns1.hodi.host` ou `rns1.hodi.host`
   - **Port** : `21` (ou `22` pour SFTP)
   - **Utilisateur** : votre nom d'utilisateur
   - **Mot de passe** : votre mot de passe

#### 2️⃣ Installer un Client FTP

**Recommandations** :
- **FileZilla** (gratuit) : https://filezilla-project.org/
- **WinSCP** (Windows) : https://winscp.net/
- **Cyberduck** (Mac/Windows) : https://cyberduck.io/

#### 3️⃣ Connexion FTP

**Dans FileZilla** :

1. **Hôte** : `ftp://rns1.hodi.host`
2. **Utilisateur** : votre nom d'utilisateur
3. **Mot de passe** : votre mot de passe
4. **Port** : `21`
5. Cliquez sur **Connexion rapide**

#### 4️⃣ Upload des Fichiers

1. **Local** (gauche) : Naviguez vers `C:\Users\jerem\Desktop\projet dev\webcup25\`
2. **Serveur** (droite) : Naviguez vers `/public_html/webcup25/`

3. **Sélectionnez et uploadez** :
   ```
   ✅ app/
   ✅ assets/
   ✅ storage/
   ✅ vendor/  (après composer install local)
   ✅ index.php
   ✅ .htaccess
   ✅ composer.json
   ❌ .env (créer sur le serveur)
   ❌ .git/ (pas nécessaire)
   ❌ tests/ (pas nécessaire en prod)
   ```

4. Clic droit → **Upload**

#### 5️⃣ Configuration Post-Upload

**Via File Manager cPanel** :

1. Créer `.env` (copier depuis `.env.example`)
2. Configurer les permissions :
   - `storage/` : `755`
   - `.env` : `644`
   - `index.php` : `644`

3. Installer Composer (si pas déjà fait) :
   - Via Terminal cPanel : `composer install --no-dev`
   - Ou uploader le dossier `vendor/` depuis votre local

---

## 🔄 Workflow de Mise à Jour

### Via Git (Recommandé)

```bash
# 1. Sur votre machine locale
git add .
git commit -m "✨ Nouvelle fonctionnalité"
git push origin main

# 2. Dans cPanel → Git Version Control
# Cliquez sur "Update from Remote"

# 3. Via Terminal cPanel (si dépendances modifiées)
composer install --no-dev
```

### Via FTP

```bash
# 1. Sur votre machine locale
# Modifiez vos fichiers

# 2. Dans FileZilla
# Uploadez seulement les fichiers modifiés

# 3. Via File Manager cPanel (si dépendances modifiées)
# Exécuter : composer install
```

---

## 🗄️ Gestion de la Base de Données

### Créer la Base via cPanel

**cPanel → MySQL Databases** :

1. **Créer une base** :
   - Nom : `cpanel_user_webcup25`
   - Cliquez sur **Create Database**

2. **Créer un utilisateur** :
   - Nom : `cpanel_user_webcup`
   - Mot de passe : (générer un fort)
   - Cliquez sur **Create User**

3. **Associer l'utilisateur à la base** :
   - Base : `cpanel_user_webcup25`
   - Utilisateur : `cpanel_user_webcup`
   - Privilèges : **ALL PRIVILEGES**

4. **Notez les infos pour .env** :
   ```env
   DB_HOST=localhost
   DB_NAME=cpanel_user_webcup25
   DB_USER=cpanel_user_webcup
   DB_PASS=votre_mot_de_passe
   ```

### Importer une Base de Données

**cPanel → phpMyAdmin** :

1. Sélectionnez votre base
2. Onglet **Import**
3. Choisissez votre fichier `.sql`
4. Cliquez sur **Go**

---

## 🔐 Sécurité

### Permissions Recommandées

```
dossiers : 755
fichiers : 644
.env : 644 (et protégé par .htaccess)
storage/ : 755 (writable)
```

### Protéger les Fichiers Sensibles

Votre `.htaccess` protège déjà :

```apache
<FilesMatch "^\.">
    Order allow,deny
    Deny from all
</FilesMatch>
```

Cela protège `.env`, `.git`, etc.

### SSL/HTTPS

**Dans cPanel → SSL/TLS Status** :

1. Vérifiez que votre domaine a un certificat SSL
2. Activez **AutoSSL** si disponible
3. Forcez HTTPS dans `.htaccess` :

```apache
# Forcer HTTPS
RewriteEngine On
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
```

---

## 🛠️ Dépannage

### Erreur 500

**Vérifier les logs** :
- cPanel → **Errors** → Derniers messages
- `/home/user/public_html/webcup25/storage/logs/`

**Solutions courantes** :
```bash
# Permissions
chmod -R 755 storage/
chmod 644 .env

# Vérifier .htaccess
# Vérifier composer install
```

### Composer pas disponible

**Installer Composer via SSH** :

```bash
curl -sS https://getcomposer.org/installer | php
mv composer.phar ~/bin/composer
chmod +x ~/bin/composer
```

### PHP Version

**Vérifier la version PHP** :
- cPanel → **Select PHP Version**
- Choisir **PHP 8.0** ou supérieur

---

## ⚡ Checklist de Déploiement

### Première Installation

- [ ] Connexion à cPanel réussie
- [ ] Base de données créée
- [ ] Utilisateur MySQL créé
- [ ] Git configuré ou FTP configuré
- [ ] Fichiers uploadés
- [ ] `.env` créé et configuré
- [ ] `composer install` exécuté
- [ ] Permissions configurées (`storage/` en 755)
- [ ] SSL/HTTPS activé
- [ ] Test du site : OK

### Chaque Mise à Jour

- [ ] Code testé localement
- [ ] Commit et push (Git) ou Upload (FTP)
- [ ] Pull dans cPanel (Git) ou Upload (FTP)
- [ ] `composer install` si nécessaire
- [ ] Test du site en prod
- [ ] Vérifier les logs

---

## 📊 Configuration GitHub Actions pour cPanel

**Modifier `.github/workflows/ci-cd.yml`** :

Remplacez la section `deploy` par :

```yaml
deploy:
  name: Déploiement via FTP (cPanel)
  runs-on: ubuntu-latest
  needs: [test, security, assets-check]
  if: github.ref == 'refs/heads/main' && github.event_name == 'push'

  steps:
    - name: Checkout du code
      uses: actions/checkout@v3
      with:
        fetch-depth: 0

    - name: Configuration PHP
      uses: shivammathur/setup-php@v2
      with:
        php-version: '8.2'

    - name: Installation des dépendances
      run: composer install --no-dev --optimize-autoloader

    - name: Déploiement FTP vers cPanel
      uses: SamKirkland/FTP-Deploy-Action@4.3.0
      with:
        server: ftp.rns1.hodi.host
        username: ${{ secrets.FTP_USERNAME }}
        password: ${{ secrets.FTP_PASSWORD }}
        server-dir: /public_html/webcup25/
        exclude: |
          **/.git*
          **/.git*/**
          **/node_modules/**
          **/tests/**
          **/.env.example
          **/phpunit.xml.dist
          **/composer.lock
          **/.gitignore
          **/.gitattributes
          **/README.md
```

**Secrets GitHub à ajouter** :

Dans **GitHub → Settings → Secrets → Actions** :

| Secret | Valeur |
|--------|--------|
| `FTP_USERNAME` | Votre utilisateur cPanel/FTP |
| `FTP_PASSWORD` | Votre mot de passe FTP |

---

## 🎯 Recommandation Finale

**Pour la WebCup 2025, je recommande** :

1. **Développement** : Local avec `php -S localhost:8000`
2. **Tests** : GitHub Actions automatique
3. **Déploiement** : FTP automatique via GitHub Actions

**Workflow** :
```
Code local → Git push → Tests auto → Déploiement FTP auto ! ✅
```

**C'est simple, rapide et automatique !** 🚀

---

## 📚 Ressources

- [Documentation cPanel](https://docs.cpanel.net/)
- [FileZilla Guide](https://wiki.filezilla-project.org/)
- [FTP Deploy Action](https://github.com/SamKirkland/FTP-Deploy-Action)

---

💡 **Conseil** : Testez d'abord le déploiement FTP manuel pour comprendre, puis activez l'automatisation GitHub Actions !

🎉 **Bon déploiement sur cPanel !**

