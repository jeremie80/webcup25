@echo off
echo Mise a jour du fichier .env avec toutes les variables...
echo.

(
echo # ===========================================
echo # ENVIRONNEMENT
echo # ===========================================
echo APP_ENV=development
echo.
echo # ===========================================
echo # BASE DE DONNEES - DEVELOPPEMENT
echo # ===========================================
echo DB_DEV_HOST=localhost
echo DB_DEV_NAME=serveur1_iastromatch
echo DB_DEV_USER=serveur1_root
echo DB_DEV_PASS=kzkxfPpZYvNgVK1l
echo.
echo # ===========================================
echo # BASE DE DONNEES - PRODUCTION
echo # ===========================================
echo DB_PROD_HOST=localhost
echo DB_PROD_NAME=serveur1_iastromatch
echo DB_PROD_USER=serveur1_root
echo DB_PROD_PASS=kzkxfPpZYvNgVK1l
echo.
echo # ===========================================
echo # APPLICATION
echo # ===========================================
echo APP_URL=http://localhost:8000
echo.
echo # ===========================================
echo # AUTRES
echo # ===========================================
echo IA_API_KEY=
echo UPLOAD_PATH=storage/avatars/
) > .env

echo ✅ Fichier .env mis a jour avec toutes les variables !
echo.
echo 📋 Contenu :
type .env
echo.
echo 🧪 Testez avec : php -S localhost:8000
echo.
pause

