# Configuration GitHub Actions - CI/CD

## 🚀 Pipeline CI/CD configuré

Ce projet utilise GitHub Actions pour l'intégration et le déploiement continu.

## 📁 Fichiers

- `workflows/ci-cd.yml` : Pipeline principal
- `DEPLOYMENT.md` : Guide complet de configuration

## ⚡ Actions automatiques

### À chaque Push ou Pull Request
- ✅ Vérification de la syntaxe PHP
- ✅ Installation des dépendances Composer
- ✅ Exécution des tests
- ✅ Analyse de sécurité

### Déploiement automatique
- **Branche `main`** → Production
- **Branche `develop`** → Staging

## 🔐 Secrets requis

Pour activer le déploiement, configurez ces secrets dans Settings → Secrets :

**Production (branche main) :**
- `SSH_HOST`
- `SSH_USER`
- `SSH_PRIVATE_KEY`
- `DEPLOY_PATH`

**Staging (branche develop) :**
- `STAGING_SSH_HOST`
- `STAGING_SSH_USER`
- `STAGING_DEPLOY_PATH`

Voir `DEPLOYMENT.md` pour les instructions détaillées.

## 📊 Voir l'exécution

Allez dans l'onglet **Actions** de votre dépôt pour voir l'historique et les logs.

