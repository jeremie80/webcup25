# 🔐 Configuration des GitHub Secrets - Déploiement Automatique

## 🎯 Objectif

Créer automatiquement le fichier `.env` en production lors du déploiement via GitHub Actions.

---

## 📋 Secrets à Configurer

Vous devez ajouter **9 secrets** dans GitHub pour le déploiement automatique complet.

### Accéder aux Secrets

1. Allez sur votre dépôt GitHub : `https://github.com/jeremie80/webcup25`
2. Cliquez sur **Settings** (Paramètres)
3. Dans le menu gauche : **Secrets and variables** → **Actions**
4. Cliquez sur **New repository secret** pour chaque secret

---

## 🔧 Secrets FTP (Déploiement)

Ces secrets sont nécessaires pour le déploiement FTP vers cPanel :

| Secret | Valeur | Description |
|--------|--------|-------------|
| `FTP_SERVER` | `rns1.hodi.host` | Adresse du serveur FTP |
| `FTP_USERNAME` | Votre login cPanel | Nom d'utilisateur FTP |
| `FTP_PASSWORD` | Votre mot de passe | Mot de passe FTP |

---

## 🗄️ Secrets Base de Données (Production)

Ces secrets seront utilisés pour créer le `.env` en production :

| Secret | Valeur | Description |
|--------|--------|-------------|
| `DB_PROD_HOST` | `localhost` | Hôte de la base de données |
| `DB_PROD_NAME` | `serveur1_iastromatch` | Nom de la base de données |
| `DB_PROD_USER` | `serveur1_root` | Utilisateur de la base |
| `DB_PROD_PASS` | `kzkxfPpZYvNgVK1l` | Mot de passe de la base |

---

## 🌐 Secrets Application

| Secret | Valeur | Description |
|--------|--------|-------------|
| `APP_URL` | `https://votre-domaine.com` | URL de votre site |
| `IA_API_KEY` | (optionnel) | Clé API pour l'IA (si vous en avez une) |

---

## 📝 Guide Pas-à-Pas

### Étape 1 : Accéder aux Secrets

```
GitHub.com
  → Votre dépôt (jeremie80/webcup25)
  → Settings
  → Secrets and variables (menu gauche)
  → Actions
  → New repository secret
```

### Étape 2 : Ajouter Chaque Secret

#### Secret 1 : FTP_SERVER

```
Name:   FTP_SERVER
Secret: rns1.hodi.host
```

Cliquez sur **Add secret**

#### Secret 2 : FTP_USERNAME

```
Name:   FTP_USERNAME
Secret: votre_login_cpanel
```

Cliquez sur **Add secret**

#### Secret 3 : FTP_PASSWORD

```
Name:   FTP_PASSWORD
Secret: votre_mot_de_passe_cpanel
```

Cliquez sur **Add secret**

#### Secret 4 : DB_PROD_HOST

```
Name:   DB_PROD_HOST
Secret: localhost
```

Cliquez sur **Add secret**

#### Secret 5 : DB_PROD_NAME

```
Name:   DB_PROD_NAME
Secret: serveur1_iastromatch
```

Cliquez sur **Add secret**

#### Secret 6 : DB_PROD_USER

```
Name:   DB_PROD_USER
Secret: serveur1_root
```

Cliquez sur **Add secret**

#### Secret 7 : DB_PROD_PASS

```
Name:   DB_PROD_PASS
Secret: kzkxfPpZYvNgVK1l
```

Cliquez sur **Add secret**

#### Secret 8 : APP_URL

```
Name:   APP_URL
Secret: https://votre-domaine.com
```

Cliquez sur **Add secret**

#### Secret 9 : IA_API_KEY (optionnel)

```
Name:   IA_API_KEY
Secret: votre_cle_api_si_vous_en_avez
```

Cliquez sur **Add secret**

---

## ✅ Vérification

Vous devriez maintenant avoir **9 secrets** dans la liste :

```
✅ FTP_SERVER
✅ FTP_USERNAME
✅ FTP_PASSWORD
✅ DB_PROD_HOST
✅ DB_PROD_NAME
✅ DB_PROD_USER
✅ DB_PROD_PASS
✅ APP_URL
✅ IA_API_KEY
```

---

## 🚀 Comment Ça Marche ?

### Workflow Automatique

```
1. Vous push sur main
   ↓
2. GitHub Actions s'exécute
   ↓
3. Tests automatiques
   ↓
4. Création du .env depuis les secrets
   ↓
5. Déploiement FTP vers cPanel (avec .env)
   ↓
6. ✅ Site en ligne avec la bonne config !
```

### Fichier .env Créé Automatiquement

Le workflow créera ce fichier `.env` sur votre serveur :

```env
APP_ENV=production

DB_DEV_HOST=localhost
DB_DEV_NAME=webcup25
DB_DEV_USER=root
DB_DEV_PASS=

DB_PROD_HOST=localhost
DB_PROD_NAME=serveur1_iastromatch
DB_PROD_USER=serveur1_root
DB_PROD_PASS=kzkxfPpZYvNgVK1l

APP_URL=https://votre-domaine.com
IA_API_KEY=
UPLOAD_PATH=storage/avatars/
```

---

## 🧪 Tester le Déploiement

### 1. Faire un Push

```bash
git add .
git commit -m "🚀 Test déploiement automatique .env"
git push origin main
```

### 2. Vérifier GitHub Actions

Allez sur : `https://github.com/jeremie80/webcup25/actions`

Vous verrez :

```
✅ Tests et Qualité du Code
✅ Vérification de Sécurité
✅ Vérification des Assets
✅ Déploiement en Production
   ├── Création du .env  ← Nouvelle étape !
   └── Upload FTP
```

### 3. Vérifier sur cPanel

Dans **File Manager**, vous devriez voir le fichier `.env` créé automatiquement !

---

## 🔐 Sécurité

### ✅ Avantages

1. **Secrets centralisés** : Tous dans GitHub (sécurisé)
2. **Automatique** : Plus besoin de créer `.env` manuellement
3. **Versionné** : Workflow dans Git (pas les secrets)
4. **Reproductible** : Même config à chaque déploiement

### ⚠️ Points d'Attention

1. **Qui a accès** : Seuls les admins du dépôt peuvent voir les secrets
2. **Logs** : GitHub masque les secrets dans les logs
3. **Rotation** : Changez les secrets régulièrement
4. **Backup** : Gardez une copie de vos secrets dans un gestionnaire de mots de passe

---

## 🆘 Dépannage

### Erreur : "Secret not found"

**Cause** : Un secret n'est pas configuré

**Solution** : Vérifiez que tous les 9 secrets sont bien ajoutés dans GitHub

### .env vide ou incorrect

**Cause** : Secrets mal configurés

**Solution** : 
1. Allez dans GitHub → Settings → Secrets
2. Vérifiez chaque secret
3. Corrigez les valeurs si nécessaire

### Déploiement échoue

**Cause** : Secrets FTP incorrects

**Solution** :
1. Testez vos identifiants FTP avec FileZilla
2. Mettez à jour les secrets dans GitHub

---

## 🔄 Modifier un Secret

1. GitHub → Settings → Secrets → Actions
2. Cliquez sur le secret à modifier
3. Cliquez sur **Update secret**
4. Entrez la nouvelle valeur
5. **Update secret**

Le prochain déploiement utilisera la nouvelle valeur.

---

## 📊 Comparaison

### ❌ Avant (Manuel)

```
1. Déployer le code
2. Se connecter à cPanel
3. Créer .env manuellement
4. Copier les identifiants
5. Sauvegarder
```

**Temps : ~10 minutes** à chaque déploiement

### ✅ Après (Automatique)

```
1. git push origin main
2. Attendre 5 minutes
3. ✅ Tout est déployé avec .env !
```

**Temps : 0 minute** de votre part ! 🎉

---

## 💡 Bonnes Pratiques

1. **Documentez vos secrets** : Gardez une liste dans un gestionnaire de mots de passe
2. **Changez régulièrement** : Mots de passe tous les 3-6 mois
3. **Limitez l'accès** : Seuls les développeurs de confiance doivent être admins du dépôt
4. **Utilisez des secrets différents** : Dev ≠ Staging ≠ Production
5. **Testez localement** : Avant de push en production

---

## ✅ Checklist Complète

- [ ] 9 secrets ajoutés dans GitHub
- [ ] Workflow `.github/workflows/ci-cd.yml` à jour
- [ ] Push effectué sur `main`
- [ ] GitHub Actions lancé
- [ ] Logs vérifiés (étape "Création du .env" présente)
- [ ] Fichier `.env` présent sur cPanel
- [ ] Site accessible en ligne
- [ ] Base de données connectée

---

## 🎉 C'est Configuré !

Maintenant, **à chaque push sur `main`** :

1. ✅ Tests automatiques
2. ✅ Création du `.env` depuis les secrets
3. ✅ Déploiement vers cPanel
4. ✅ Site mis à jour automatiquement

**Plus besoin de créer `.env` manuellement !** 🚀

---

## 📚 Ressources

- [GitHub Encrypted Secrets](https://docs.github.com/en/actions/security-guides/encrypted-secrets)
- [FTP Deploy Action](https://github.com/SamKirkland/FTP-Deploy-Action)

---

💡 **Astuce** : Sauvegardez vos secrets dans un gestionnaire de mots de passe sécurisé (1Password, Bitwarden, etc.)

