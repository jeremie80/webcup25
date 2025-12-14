# 🔧 Correction Erreur FTP server-dir

## ❌ Erreur

```
Error: server-dir should be a folder (must end with /)
```

## ✅ Solution

Le secret `FTP_SERVER_DIR` **DOIT SE TERMINER PAR UN `/`**

### Dans GitHub → Settings → Secrets → Actions

Modifiez ou ajoutez le secret `FTP_SERVER_DIR` :

#### ✅ CORRECT

```
/public_html/
/public_html/webcup25/
/domains/monsite.com/public_html/
```

#### ❌ INCORRECT

```
/public_html           ← Manque le / final
/public_html/webcup25  ← Manque le / final
public_html/           ← Manque le / initial
```

---

## 🔧 Correction Appliquée

J'ai mis en dur `/public_html/` dans le workflow pour le moment.

**Si vous voulez déployer ailleurs**, changez cette ligne dans `.github/workflows/ci-cd.yml` :

```yaml
server-dir: /public_html/  # ← Changez ce chemin
```

Par exemple :
```yaml
server-dir: /public_html/webcup25/
server-dir: /domains/monsite.com/public_html/
```

**⚠️ N'oubliez pas le `/` à la fin !**

---

## 📝 Trouver le Bon Chemin

### Dans cPanel → File Manager

1. Connectez-vous : https://rns1.hodi.host:2083/
2. Allez dans **File Manager**
3. Naviguez vers le dossier où vous voulez déployer
4. Regardez le chemin en haut de la page

**Exemples de chemins** :

| Cas | Chemin complet | À utiliser |
|-----|----------------|------------|
| Racine du site | `/home/user/public_html` | `/public_html/` |
| Sous-dossier | `/home/user/public_html/webcup25` | `/public_html/webcup25/` |
| Domaine additionnel | `/home/user/domains/site.com/public_html` | `/domains/site.com/public_html/` |

**Règle** : Utilisez la partie **après** `/home/user`

---

## 🚀 Après Correction

```bash
# Commit et push
git add .github/workflows/ci-cd.yml
git commit -m "🔧 Fix: Correction server-dir FTP (ajout / final)"
git push origin main
```

Le déploiement devrait maintenant fonctionner ! ✅

---

## ✅ Checklist

- [ ] Chemin se termine par `/`
- [ ] Chemin commence par `/`
- [ ] Workflow mis à jour
- [ ] Push effectué
- [ ] Déploiement testé

---

💡 **Astuce** : Pour éviter cette erreur, utilisez toujours un `/` final dans vos chemins FTP !

