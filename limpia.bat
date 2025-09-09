@echo off
echo Limpiando cache de Laravel...
echo.

cd /d "C:\ruta\a\tu\proyecto\laravel"

php artisan optimize:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear
php artisan event:clear

echo.
echo ¡Cache limpiado exitosamente!
echo.
pause