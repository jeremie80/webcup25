@echo off
echo Creation du fichier .env...
echo.

(
echo # Configuration de la base de donnees
echo DB_HOST=localhost
echo DB_NAME=serveur1_iastromatch
echo DB_USER=serveur1_root
echo DB_PASS=kzkxfPpZYvNgVK1l
echo.
echo # Configuration de l'application
echo APP_ENV=development
echo APP_URL=http://localhost:8000
echo.
echo # Cle API pour l'IA narrateur ^(optionnel^)
echo IA_API_KEY=
echo.
echo # Configuration du stockage
echo UPLOAD_PATH=storage/avatars/
) > .env

if exist .env (
    echo ✅ Fichier .env cree avec succes !
    echo.
    echo 📋 Contenu du fichier :
    echo ==================================================
    type .env
    echo ==================================================
    echo.
    echo 🔒 Le fichier .env est maintenant dans .gitignore
    echo 💡 Vous pouvez modifier les parametres dans .env
    echo.
    echo 🧪 Testez la connexion avec : php test-db.php
) else (
    echo ❌ Erreur lors de la creation du fichier .env
)

pause

