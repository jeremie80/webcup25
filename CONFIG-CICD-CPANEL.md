# ⚡ Configuration CI/CD avec cPanel - 5 Minutes

## 🎯 Ce que vous allez faire

Configurer GitHub Actions pour déployer automatiquement sur votre cPanel à chaque push !
 
---

## 📋 Les 4 Secrets Nécessaires

Vous devez ajouter **4 secrets** dans GitHub :

| # | Secret | Votre Valeur |
|---|--------|--------------|
| 1 | `FTP_SERVER` | `rns1.hodi.host` |
| 2 | `FTP_USERNAME` | Votre login cPanel |
| 3 | `FTP_PASSWORD` | Votre mot de passe cPanel |
| 4 | `FTP_SERVER_DIR` | `/public_html/` (ou votre dossier) |

---

## 🚀 Configuration en 5 Étapes

### 1️⃣ Trouver vos Identifiants (2 min)

**Connectez-vous à cPanel** : https://rns1.hodi.host:2083/

Vos identifiants FTP sont :
- **Serveur** : `rns1.hodi.host`
- **Utilisateur** : Votre nom d'utilisateur cPanel
- **Mot de passe** : Votre mot de passe cPanel

**Notez-les quelque part !**

### 2️⃣ Ajouter les Secrets dans GitHub (3 min)

1. Allez sur votre dépôt GitHub : `https://github.com/YOUR-USERNAME/webcup25`

2. Cliquez sur **Settings** (onglet en haut)

3. Dans le menu gauche : **Secrets and variables** → **Actions**

4. Cliquez sur **New repository secret** (bouton vert)

5. Ajoutez ces 4 secrets un par un :

#### Secret 1 : FTP_SERVER
```
Name:   FTP_SERVER
Secret: rns1.hodi.host
```
→ **Add secret**

#### Secret 2 : FTP_USERNAME
```
Name:   FTP_USERNAME
Secret: votre_nom_utilisateur_cpanel
```
→ **Add secret**

#### Secret 3 : FTP_PASSWORD
```
Name:   FTP_PASSWORD
Secret: votre_mot_de_passe_cpanel
```
→ **Add secret**

#### Secret 4 : FTP_SERVER_DIR
```
Name:   FTP_SERVER_DIR
Secret: /public_html/
```

**Note** : Ajustez le chemin selon où vous voulez déployer :
- Site principal : `/public_html/`
- Sous-dossier : `/public_html/webcup25/`
- Sous-domaine : `/public_html/subdomains/webcup/`

→ **Add secret**

### 3️⃣ Vérifier les Secrets

Vous devriez voir 4 secrets dans la liste :

```
✅ FTP_SERVER
✅ FTP_USERNAME
✅ FTP_PASSWORD
✅ FTP_SERVER_DIR
```

---

## 🧪 Tester le Déploiement

### Faire un Push

```bash
# Sur votre machine
git add .
git commit -m "🚀 Test CI/CD avec cPanel"
git push origin main
```

### Voir le Déploiement en Direct

1. Allez sur GitHub → Onglet **Actions**
2. Cliquez sur le workflow qui vient de démarrer
3. Suivez les étapes en temps réel

**Vous verrez** :
```
✅ Tests et Qualité du Code      (~2 min)
✅ Vérification de Sécurité      (~1 min)
✅ Vérification des Assets       (~30 sec)
✅ Déploiement en Production     (~1-2 min)
   ├── Checkout du code
   ├── Installation Composer
   └── Upload FTP → cPanel
```

**Total : ~5 minutes** ⚡

### Vérifier sur votre Site

Visitez votre site : `https://votre-domaine.com`

Les changements devraient être là ! 🎉

---

## 🎯 C'est Tout !

Maintenant, **à chaque fois que vous push sur `main`** :

```bash
git push origin main
```

GitHub Actions va **automatiquement** :
1. ✅ Tester votre code
2. ✅ Vérifier la sécurité
3. ✅ Installer les dépendances
4. ✅ Déployer sur cPanel

**En 5 minutes, c'est en ligne ! 🚀**

---

## 🐛 Problèmes ?

### ❌ "Login authentication failed"

**Cause** : Mauvais login/password

**Solution** :
1. Testez vos identifiants dans FileZilla
2. Corrigez les secrets GitHub si nécessaire

### ❌ "Directory not found"

**Cause** : Mauvais chemin `FTP_SERVER_DIR`

**Solution** :
1. Connectez-vous à cPanel → File Manager
2. Naviguez vers votre dossier
3. Notez le chemin exact (ex: `/public_html/webcup25/`)
4. Mettez à jour le secret

### ❌ Upload échoue

**Cause** : Permissions ou quota

**Solution** :
1. cPanel → FTP Accounts
2. Vérifiez que le quota est "Unlimited" ou > 500 MB
3. Vérifiez les permissions du dossier

---

## 📊 Workflow Visual

```
Votre Machine                     GitHub                    cPanel
─────────────                     ──────                    ──────

   💻 Code                         
      │                            
      │ git push                   
      ↓                            
   📤 GitHub                       ⚙️ GitHub Actions
                                      │
                                      │ 1. Tests ✅
                                      │ 2. Sécurité ✅
                                      │ 3. Composer ✅
                                      │
                                      │ FTP Upload
                                      ↓
                                   📁 cPanel
                                      /public_html/
                                      
                                      ↓
                                      
                                   🌐 Site En Ligne !
```

---

## ✅ Checklist

- [ ] 4 secrets GitHub configurés
- [ ] Push effectué sur `main`
- [ ] GitHub Actions lancé (onglet Actions)
- [ ] Workflow terminé avec succès (tout vert ✅)
- [ ] Site vérifié en ligne
- [ ] Ça marche ! 🎉

---

## 📚 Guides Complets

- **[GITHUB-SECRETS-CPANEL.md](GITHUB-SECRETS-CPANEL.md)** - Guide détaillé des secrets
- **[DEPLOYMENT-CPANEL.md](DEPLOYMENT-CPANEL.md)** - Guide complet cPanel
- **[WORKFLOW.md](WORKFLOW.md)** - Workflow de développement

---

## 🎉 Félicitations !

Votre CI/CD est maintenant configuré ! 

**Workflow de développement** :
```bash
1. Code localement
2. git push origin main
3. ☕ Prenez un café pendant que GitHub déploie
4. ✅ C'est en ligne !
```

**Simple et Automatique ! 🚀**

