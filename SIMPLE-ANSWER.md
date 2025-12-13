# 🎯 Réponse Simple : Rôle du .env

## Question
> "À quoi sert mon .env si mes informations sont dans /config et que .env est dans .gitignore ?"

---

## Réponse en 30 Secondes ⏱️

Le `.env` contient vos **MOTS DE PASSE**.

Il n'est PAS versionné **JUSTEMENT** pour protéger vos mots de passe !

Le `config/database.php` lit depuis le `.env` :
```php
'password' => $_ENV['DB_PROD_PASS']  // Pas de mot de passe en dur !
```

**En production**, GitHub Actions **crée automatiquement** le `.env` depuis les secrets GitHub !

---

## Schéma Simple

```
VOTRE PC (Dev)                  GITHUB                     SERVEUR (Prod)
─────────────                   ──────                     ──────────────

.env                            
├── mots de passe DEV           ❌ PAS versionné           
                                                           .env
                                                           ├── mots de passe PROD
                                                           └── créé par GitHub Actions
                                                              depuis les secrets ✅

config/database.php             ✅ Versionné               config/database.php
├── Structure                   └── Pas de secrets         ├── Structure (même)
└── Lit depuis .env                                        └── Lit depuis .env
```

---

## Workflow de Déploiement

```
1. git push origin main
        ↓
2. GitHub Actions
   ├── Lit les secrets GitHub
   ├── Crée .env en production
   └── Déploie via FTP
        ↓
3. cPanel reçoit :
   ├── Votre code ✅
   ├── config/ ✅
   └── .env (créé automatiquement) ✅
```

---

## ✅ Pourquoi C'est Sécurisé

1. **Vos mots de passe ne sont JAMAIS dans Git** ✅
2. **Chaque environnement a son .env** ✅
3. **GitHub Actions crée .env automatiquement** ✅
4. **Vous n'avez rien à faire manuellement** ✅

---

## 🚀 Action

**Configurez les 9 secrets GitHub** :

```
FTP_SERVER, FTP_USERNAME, FTP_PASSWORD
DB_PROD_HOST, DB_PROD_NAME, DB_PROD_USER, DB_PROD_PASS
APP_URL, IA_API_KEY
```

**Puis :**

```bash
git push origin main
```

**Et c'est automatique !** 🎉

---

📖 **Guide complet** : [GITHUB-SECRETS-SETUP.md](GITHUB-SECRETS-SETUP.md)

