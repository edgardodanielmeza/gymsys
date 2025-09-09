@echo off
echo Iniciando entorno de desarrollo Laravel + Vite...
echo.

:: Verificar que estamos en la raíz de un proyecto Laravel
if not exist "artisan" (
    echo ERROR: No se encuentra el archivo artisan.
    echo Asegúrate de que este bat está en la raíz de tu proyecto Laravel.
    pause
    exit /b 1
)

if not exist "package.json" (
    echo ERROR: No se encuentra package.json.
    echo Asegúrate de que este bat está en la raíz de tu proyecto Laravel.
    pause
    exit /b 1
)

:: Verificar dependencias
echo Verificando dependencias...
node --version >nul 2>&1
if errorlevel 1 (
    echo ERROR: Node.js no está instalado o no está en el PATH.
    pause
    exit /b 1
)

php --version >nul 2>&1
if errorlevel 1 (
    echo ERROR: PHP no está instalado o no está en el PATH.
    pause
    exit /b 1
)

:: Iniciar servicios
echo Iniciando servicios...
echo.

:: Frontend - npm run dev en nueva ventana
start "Laravel Frontend (Vite)" cmd /k "npm run dev"

:: Esperar 3 segundos para que Vite inicie primero
timeout /t 3 /nobreak >nul

:: Backend - artisan serve en nueva ventana
start "Laravel Backend" cmd /k "php artisan serve"

echo.
echo ¡Servicios iniciados correctamente!
echo.
echo - Frontend (Vite): http://localhost:5173
echo - Backend: http://localhost:8000
echo.
echo Presiona cualquier tecla para cerrar este mensaje...
pause >nul