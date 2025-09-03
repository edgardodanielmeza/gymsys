@echo off
setlocal enabledelayedexpansion

echo =======================================================
echo      ASISTENTE PARA SUBIR PROYECTO GYMSYS A GITHUB
echo =======================================================
echo.
echo Proyecto: gymsys
echo Repositorio: https://github.com/edgardodanielmeza/gymsys
echo.
echo Este script subira TODOS los archivos de tu proyecto
echo gymsys a tu repositorio de GitHub.
echo.
pause
cls

echo Verificando que estamos en el directorio correcto...
for %%i in ("%CD%") do set "CURRENT_FOLDER=%%~nxi"
if /i "!CURRENT_FOLDER!" neq "gymsys" (
    echo.
    echo ERROR: No estas en la carpeta del proyecto gymsys.
    echo Por favor, coloca este script dentro de la carpeta
    echo gymsys y ejecutalo de nuevo.
    echo.
    echo Carpeta actual: %CD%
    echo.
    pause
    exit /b 1
)

echo.
echo --- Inicializando repositorio Git...
call git init
if !errorlevel! neq 0 (
    echo ERROR: No se pudo inicializar el repositorio Git
    echo Asegurate de tener Git instalado y en el PATH
    pause
    exit /b 1
)

echo.
echo --- Verificando estado actual del repositorio...
call git status
echo.

echo --- Anadiendo TODOS los archivos al staging area...
call git add --all
if !errorlevel! neq 0 (
    echo ERROR: No se pudieron anadir los archivos
    pause
    exit /b 1
)

echo.
echo --- Creando el commit inicial para gymsys...
call git commit -m "Initial commit: Complete gym management system (gymsys)"
if !errorlevel! neq 0 (
    echo ERROR: No se pudo crear el commit
    echo Esto puede pasar si no hay cambios que committear
    echo Verificando si ya existe un commit...
    call git log --oneline -1
    if !errorlevel! neq 0 (
        echo No hay commits existentes, creando commit vacio...
        call git commit -m "Initial commit" --allow-empty
    )
)

echo.
echo --- Conectando con el repositorio remoto de GitHub...
call git remote add origin https://github.com/edgardodanielmeza/gymsys.git
if !errorlevel! neq 0 (
    echo El remoto ya existe, actualizando URL...
    call git remote set-url origin https://github.com/edgardodanielmeza/gymsys.git
)

echo.
echo --- Verificando ramas disponibles...
call git branch -a

echo.
echo --- Subiendo el proyecto a la rama main...
call git branch -M main
call git push -u origin main --force
if !errorlevel! neq 0 (
    echo.
    echo Intentando con la rama master...
    call git branch -M master
    call git push -u origin master --force
    if !errorlevel! neq 0 (
        echo.
        echo ERROR: No se pudo subir el proyecto
        echo.
        echo Soluciones:
        echo 1. Verifica tu conexion a Internet
        echo 2. Asegurate de tener permisos para el repositorio
        echo 3. Verifica que la URL del repositorio es correcta
        echo.
        echo URL actual: https://github.com/edgardodanielmeza/gymsys.git
        echo.
        pause
        exit /b 1
    )
)

echo.
echo =======================================================
echo      ¡GYMSYS SUBIDO A GITHUB EXITOSAMENTE!
echo =======================================================
echo.
echo Tu proyecto gymsys ha sido subido completamente a:
echo https://github.com/edgardodanielmeza/gymsys
echo.
echo Puedes verificar visitando tu repositorio en GitHub.
echo.
pause