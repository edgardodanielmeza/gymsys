# Guía de Configuración Simplificada - GymSys con Jetstream

Este documento detalla los pasos para configurar el proyecto GymSys utilizando la interfaz por defecto de Laravel Jetstream, que es más simple y estable.

## 1. Prerrequisitos

Asegúrate de tener instalado y configurado en el PATH de tu sistema:
- PHP 8.1+
- Composer
- Node.js y npm
- Git
- Una base de datos MySQL (ej. la que provee WAMP).

## 2. Configuración Inicial del Proyecto

1.  **Clona tu repositorio** o asegúrate de tener la última versión del código base.
2.  **Copia el archivo de entorno**: Si no existe, copia `.env.example` a `.env`.
    ```bash
    copy .env.example .env
    ```
3.  **Configura tu base de datos**: Abre el archivo `.env` y ajusta las siguientes variables con tus credenciales. La base de datos (`DB_DATABASE`) debe ser creada manualmente desde tu gestor de base de datos (ej. phpMyAdmin).
    ```dotenv
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=gymsys
    DB_USERNAME=root
    DB_PASSWORD=
    ```
4.  **Instala dependencias de PHP**:
    ```bash
    composer install
    ```
5.  **Instala dependencias de JavaScript**:
    ```bash
    npm install
    ```
6.  **Genera la clave de la aplicación**:
    ```bash
    php artisan key:generate
    ```

## 3. Base de Datos

Ejecuta las migraciones y los seeders. Este comando creará todas las tablas de la aplicación (usuarios, sucursales, miembros, pagos, etc.) y registrará el usuario administrador y las sucursales iniciales.

```bash
php artisan migrate:fresh --seed
```
*Nota: `migrate:fresh` eliminará todas las tablas existentes. Si solo quieres añadir las nuevas, usa `php artisan migrate`.*

## 4. Deshabilitar Registro Público (Opcional pero Recomendado)

Para asegurarte de que solo los administradores puedan crear usuarios:
1.  Abre `config/fortify.php`.
2.  Comenta la línea `Features::registration()`.
3.  Limpia la caché de configuración: `php artisan config:clear`.

## 5. Ejecutar el Entorno de Desarrollo

Para desarrollar, necesitas **dos terminales abiertas** en la carpeta del proyecto.

-   En la **Terminal 1**, inicia el servidor de Laravel:
    ```bash
    php artisan serve
    ```
-   En la **Terminal 2**, inicia el servidor de Vite (para CSS/JS):
    ```bash
    npm run dev
    ```
Mantén ambas terminales abiertas mientras trabajas.

## 6. ¡Listo!

Accede a la aplicación desde la URL que te proporciona `php artisan serve` (usualmente `http://127.0.0.1:8000`).

-   **Usuario**: `admin@admin.com`
-   **Contraseña**: `gym123admin`

Al iniciar sesión, el sistema te pedirá que selecciones una sucursal. Luego, serás redirigido al dashboard. En el menú de navegación superior, verás el enlace a "Sucursales" si has iniciado sesión como administrador.
