# Configuration du CI/CD - Guide de Déploiement

Ce guide explique comment configurer le pipeline CI/CD GitHub Actions pour votre projet.

## 📋 Prérequis

- Un dépôt GitHub avec votre code
- Un serveur de production avec accès SSH ou FTP
- PHP 8.0+ et Composer installés sur le serveur

## 🔐 Configuration des Secrets GitHub

Pour que le déploiement fonctionne, vous devez configurer les secrets dans votre dépôt GitHub.

### Accéder aux secrets

1. Allez dans votre dépôt GitHub
2. Cliquez sur **Settings** (Paramètres)
3. Dans le menu latéral, cliquez sur **Secrets and variables** → **Actions**
4. Cliquez sur **New repository secret**

### Secrets à configurer

#### Pour le déploiement SSH (Production)

| Secret | Description | Exemple |
|--------|-------------|---------|
| `SSH_HOST` | Adresse IP ou domaine du serveur | `123.45.67.89` ou `server.example.com` |
| `SSH_USER` | Nom d'utilisateur SSH | `root` ou `deploy` |
| `SSH_PRIVATE_KEY` | Clé privée SSH (contenu complet) | Commencer par `-----BEGIN RSA PRIVATE KEY-----` |
| `SSH_PORT` | Port SSH (optionnel, défaut: 22) | `22` |
| `DEPLOY_PATH` | Chemin vers le dossier du projet sur le serveur | `/var/www/webcup25` |

#### Pour le déploiement FTP (Alternative)

| Secret | Description | Exemple |
|--------|-------------|---------|
| `FTP_SERVER` | Adresse du serveur FTP | `ftp.example.com` |
| `FTP_USERNAME` | Nom d'utilisateur FTP | `username@example.com` |
| `FTP_PASSWORD` | Mot de passe FTP | `votreMotDePasse` |

#### Pour le staging (Environnement de test)

| Secret | Description | Exemple |
|--------|-------------|---------|
| `STAGING_SSH_HOST` | Adresse du serveur staging | `staging.example.com` |
| `STAGING_SSH_USER` | Utilisateur SSH staging | `deploy` |
| `STAGING_DEPLOY_PATH` | Chemin du projet en staging | `/var/www/staging` |

## 🔑 Génération de la clé SSH

Si vous n'avez pas encore de clé SSH, voici comment en générer une :

```bash
# Sur votre machine locale
ssh-keygen -t rsa -b 4096 -C "github-actions" -f ~/.ssh/github_actions

# Copier la clé publique sur le serveur
ssh-copy-id -i ~/.ssh/github_actions.pub user@your-server.com

# Afficher la clé privée pour la copier dans GitHub Secrets
cat ~/.ssh/github_actions
```

⚠️ **Important** : Copiez **TOUT** le contenu de la clé privée, y compris les lignes `-----BEGIN RSA PRIVATE KEY-----` et `-----END RSA PRIVATE KEY-----`

## 🌿 Stratégie de Branches

Le pipeline CI/CD est configuré avec la stratégie suivante :

### Branche `main` (Production)
- ✅ Tests automatiques
- ✅ Vérifications de sécurité
- ✅ Déploiement automatique en production
- Déclenchement : À chaque push ou merge

### Branche `develop` (Staging)
- ✅ Tests automatiques
- ✅ Vérifications de sécurité
- ✅ Déploiement automatique en staging
- Déclenchement : À chaque push

### Pull Requests
- ✅ Tests automatiques
- ✅ Vérifications de sécurité
- ❌ Pas de déploiement

## 📦 Workflow du Pipeline

```mermaid
graph LR
    A[Push/PR] --> B[Tests]
    B --> C[Sécurité]
    B --> D[Build Assets]
    C --> E{Branche?}
    D --> E
    E -->|main| F[Deploy Production]
    E -->|develop| G[Deploy Staging]
    E -->|autres| H[Fin]
    F --> I[Notification]
    G --> I
```

## 🚀 Commandes de Déploiement

### Déploiement en Production

```bash
# Méthode 1 : Push direct
git checkout main
git push origin main

# Méthode 2 : Via Pull Request
git checkout -b feature/ma-feature
# ... modifications ...
git push origin feature/ma-feature
# Créer une PR vers main et merger
```

### Déploiement en Staging

```bash
git checkout develop
git push origin develop
```

## 🛠️ Personnalisation du Pipeline

### Activer le déploiement FTP au lieu de SSH

Dans `.github/workflows/ci-cd.yml`, modifiez :

```yaml
- name: Déploiement via FTP (alternative)
  if: false  # Changer en true pour activer
```

### Ajouter des tests supplémentaires

Ajoutez vos tests dans le job `test` :

```yaml
- name: Mes tests personnalisés
  run: |
    # Vos commandes de test
```

### Modifier le déploiement

Personnalisez les commandes dans la section `deploy` selon vos besoins :

```yaml
script: |
  cd ${{ secrets.DEPLOY_PATH }}
  git pull origin main
  composer install --no-dev --optimize-autoloader
  # Ajoutez vos commandes ici
```

## 📊 Vérification du Pipeline

Après avoir configuré les secrets :

1. Allez dans l'onglet **Actions** de votre dépôt
2. Vous verrez l'historique de tous les workflows
3. Cliquez sur un workflow pour voir les détails de chaque job

## 🔧 Dépannage

### Erreur : "Permission denied (publickey)"

- Vérifiez que la clé SSH est correctement copiée dans les secrets
- Assurez-vous que la clé publique est bien dans `~/.ssh/authorized_keys` sur le serveur

### Erreur : "composer: command not found"

- Installez Composer sur votre serveur de production
- Ou ajoutez le chemin complet : `/usr/local/bin/composer install`

### Le déploiement ne se déclenche pas

- Vérifiez que vous êtes bien sur la branche `main` ou `develop`
- Vérifiez que tous les secrets sont configurés
- Consultez l'onglet Actions pour voir les erreurs

## 📝 Checklist de Configuration

- [ ] Créer le dépôt GitHub
- [ ] Configurer tous les secrets nécessaires
- [ ] Générer et installer la clé SSH
- [ ] Tester un push sur `develop` pour vérifier le staging
- [ ] Tester un push sur `main` pour vérifier la production
- [ ] Vérifier les logs dans l'onglet Actions

## 🔗 Ressources Utiles

- [Documentation GitHub Actions](https://docs.github.com/en/actions)
- [SSH Action](https://github.com/appleboy/ssh-action)
- [FTP Deploy Action](https://github.com/SamKirkland/FTP-Deploy-Action)

## 💡 Bonnes Pratiques

1. **Ne jamais pusher directement sur `main`** : Utilisez des Pull Requests
2. **Tester d'abord en `develop`** avant de merger vers `main`
3. **Garder les secrets secrets** : Ne jamais les commiter dans le code
4. **Sauvegarder la clé SSH** dans un endroit sécurisé
5. **Activer les notifications** pour être alerté en cas d'échec

---

🎉 Une fois configuré, votre pipeline CI/CD déploiera automatiquement votre application à chaque push !

