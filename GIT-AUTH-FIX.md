# 🔐 Correction Authentification Git

## ❌ Problème

```
fatal: Authentication failed for 'https://github.com/jeremie80/webcup25.git/'
```

## ✅ Solution : Utiliser un Personal Access Token

### Étape 1 : Créer un Token GitHub (2 min)

1. Allez sur GitHub : https://github.com/settings/tokens
2. Cliquez sur **"Generate new token"** → **"Generate new token (classic)"**
3. Donnez un nom : `webcup25-dev`
4. Cochez les permissions :
   - ✅ **repo** (tous les sous-items)
   - ✅ **workflow**
5. Cliquez sur **"Generate token"**
6. **COPIEZ LE TOKEN** (vous ne le reverrez plus !)
   - Format : `ghp_xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx`

### Étape 2 : Configurer Git avec le Token

**Option A : Via Git Credential Manager (Recommandé)**

```bash
# Le prochain push vous demandera vos identifiants
git push origin main

# Utilisez :
# Username: jeremie80
# Password: [COLLEZ VOTRE TOKEN ICI]
```

**Option B : Modifier l'URL du remote**

```bash
# Remplacer l'URL HTTPS par une URL avec token
git remote set-url origin https://jeremie80:VOTRE_TOKEN@github.com/jeremie80/webcup25.git

# Puis push
git push origin main
```

**Option C : Utiliser SSH (Plus sécurisé)**

```bash
# 1. Générer une clé SSH (si pas déjà fait)
ssh-keygen -t ed25519 -C "votre.email@example.com"

# 2. Copier la clé publique
cat ~/.ssh/id_ed25519.pub
# Ou sur Windows :
type %USERPROFILE%\.ssh\id_ed25519.pub

# 3. Ajouter la clé sur GitHub
# https://github.com/settings/keys → New SSH key

# 4. Changer l'URL du remote
git remote set-url origin git@github.com:jeremie80/webcup25.git

# 5. Push
git push origin main
```

### Étape 3 : Push !

```bash
git push origin main
```

Cette fois ça devrait marcher ! ✅

## 🎯 Après le Push

Allez sur GitHub → **Actions** pour voir le CI/CD s'exécuter :

```
https://github.com/jeremie80/webcup25/actions
```

Vous devriez voir :
```
✅ Tests et Qualité du Code
✅ Vérification de Sécurité
✅ Vérification des Assets
✅ Déploiement en Production (si secrets configurés)
```

## 📊 Vérifier que les Tests Passent

Dans les logs GitHub Actions, section "Tests et Qualité du Code" :

```
PHPUnit 9.6.31 by Sebastian Bergmann and contributors.

....                                                  4 / 4 (100%)

Time: 00:00.023, Memory: 6.00 MB

OK (4 tests, 4 assertions) ✅
```

## ✅ Checklist

- [ ] Token GitHub créé
- [ ] Git configuré avec le token
- [ ] Push réussi : `git push origin main`
- [ ] CI/CD lancé sur GitHub Actions
- [ ] Tests passent (4/4) ✅
- [ ] Secrets cPanel configurés (optionnel pour déploiement)

## 🚀 Configuration Déploiement cPanel

Si vous voulez activer le déploiement automatique, ajoutez ces secrets :

**GitHub → Settings → Secrets → Actions** :

```
FTP_SERVER      → rns1.hodi.host
FTP_USERNAME    → votre_login_cpanel
FTP_PASSWORD    → votre_mot_de_passe
FTP_SERVER_DIR  → /public_html/
```

## 💡 Astuce

Sauvegardez votre token GitHub dans un endroit sûr (gestionnaire de mots de passe).

---

🎉 **Une fois configuré, vous pourrez push sans problème !**

