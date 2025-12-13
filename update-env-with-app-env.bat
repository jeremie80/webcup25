@echo off
echo Mise a jour du fichier .env avec APP_ENV...
echo.

REM Lire le contenu actuel
set "found=0"
for /f "usebackq delims=" %%a in (".env") do (
    echo %%a | findstr /C:"APP_ENV" >nul
    if not errorlevel 1 set "found=1"
)

if "%found%"=="1" (
    echo APP_ENV est deja present dans .env
) else (
    echo Ajout de APP_ENV=development au debut de .env...
    echo # Configuration environnement > .env.tmp
    echo APP_ENV=development >> .env.tmp
    echo. >> .env.tmp
    type .env >> .env.tmp
    move /y .env.tmp .env >nul
    echo ✅ APP_ENV ajoute !
)

echo.
echo Contenu actuel de .env :
echo ==========================================
type .env
echo ==========================================
echo.
pause

