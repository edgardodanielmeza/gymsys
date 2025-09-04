# Guía de Configuración y Puesta en Marcha - GymSys

Este documento detalla todos los pasos necesarios para configurar el proyecto GymSys en tu entorno de desarrollo local (WAMP/Windows).

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

## 3. Instalación de AdminLTE

Vamos a integrar el tema del panel de administración.

1.  **Instala el paquete de AdminLTE vía Composer**:
    ```bash
    composer require "jeroennoten/laravel-adminlte"
    ```
2.  **Publica los assets y la configuración de AdminLTE**:
    ```bash
    php artisan adminlte:install --type=full
    ```
    Cuando te pregunte si quieres sobreescribir archivos, responde que **sí (yes)**, especialmente para las vistas de autenticación.

## 4. Verificación de Archivos

Los siguientes archivos fueron generados por el asistente. Confirma que se encuentren en las rutas correctas dentro de tu proyecto.

<details>
<summary><strong>Listado de Archivos Generados</strong></summary>

-   `app/Http/Livewire/Auth/SelectSucursal.php`
-   `app/Http/Livewire/Sucursales/SucursalManager.php`
-   `app/Http/Middleware/EnsureSucursalIsSelected.php`
-   `app/Http/Responses/LoginResponse.php`
-   `app/Models/Sucursal.php`
-   `database/migrations/2024_05_20_100001_create_sucursales_table.php`
-   `database/migrations/2024_05_20_100002_add_role_to_users_table.php`
-   `database/migrations/2024_05_20_100003_create_sucursal_user_pivot_table.php`
-   `database/seeders/SucursalSeeder.php`
-   `database/seeders/UserSeeder.php`
-   `resources/views/livewire/auth/select-sucursal.blade.php`
-   `resources/views/livewire/sucursales/sucursal-manager.blade.php`

</details>

## 5. Configuración del Menú de AdminLTE

Para que el CRUD de sucursales aparezca en el menú lateral del panel:

1.  Abre el archivo `config/adminlte.php`.
2.  Busca la sección `menu` (alrededor de la línea 225).
3.  Agrega un nuevo item de menú para las sucursales. Puedes agregarlo debajo del item de 'Dashboard'.

    ```php
    // Busca esta parte en el archivo:
    'menu' => [
        // Navbar items:
        ...
        // Sidebar items:
        [
            'type' => 'sidebar-menu-search',
            'text' => 'search',
        ],
        [
            'text' => 'blog',
            'url'  => 'admin/blog',
            'can'  => 'manage-blog',
        ],
        [
            'text'        => 'Dashboard',
            'url'         => 'dashboard',
            'icon'        => 'fas fa-fw fa-tachometer-alt',
        ],

        // AGREGA ESTE BLOQUE
        [
            'text'    => 'Sucursales',
            'route'   => 'sucursales.index',
            'icon'    => 'fas fa-fw fa-store',
            'can'     => 'admin', // Opcional: define un gate/permission
        ],

        // Continúa el resto del menú...
    ],
    ```
4.  **(Opcional pero recomendado) Definir Permiso de Administrador**: Para que la opción de menú `can => 'admin'` funcione y restrinja el acceso solo a administradores, sigue estos pasos:

    **Paso A: Crear `AuthServiceProvider`**

    El archivo `AuthServiceProvider.php` no es creado por defecto en Jetstream. Debes crearlo manualmente.

    Crea el archivo en la ruta: `app/Providers/AuthServiceProvider.php` y pega el siguiente contenido:

    ```php
    <?php

    namespace App\Providers;

    use App\Models\User;
    use Illuminate\Support\Facades\Gate;
    use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

    class AuthServiceProvider extends ServiceProvider
    {
        protected $policies = [
            // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        ];

        public function boot(): void
        {
            $this->registerPolicies();

            Gate::define('admin', function (User $user) {
                return $user->isAdmin();
            });
        }
    }
    ```

    **Paso B: Registrar el nuevo proveedor**

    Ahora, registra el proveedor que acabas de crear en la configuración de tu aplicación.

    1.  Abre el archivo `config/app.php`.
    2.  Busca el array `providers`.
    3.  Añade tu `AuthServiceProvider` a la lista:

    ```php
        //... otros providers
        App\Providers\FortifyServiceProvider::class,
        App\Providers\JetstreamServiceProvider::class,
        App\Providers\AuthServiceProvider::class, // <-- AÑADE ESTA LÍNEA
    ],
    ```

## 6. Base de Datos y Compilación

1.  **Ejecuta las migraciones y los seeders**: Este comando revisará todos los archivos de migración y creará todas las tablas necesarias en la base de datos.
    -   **Tablas iniciales**: `users`, `sucursales`, etc.
    -   **Nuevas tablas de módulos**: `tipos_membresia`, `miembros`, `membresias`, y `pagos`.

    El seeder también registrará el usuario administrador y las sucursales iniciales. Si necesitas refrescar toda la base de datos en el futuro, puedes usar `php artisan migrate:fresh --seed`.

    ```bash
    php artisan migrate --seed
    ```
2.  **Compila los assets de frontend**:
    ```bash
    npm run build
    ```

## 7. ¡Listo!

Ahora puedes iniciar tu servidor local (ej. `php artisan serve` o usando tu host virtual de WAMP) y probar la aplicación.

-   **URL de Login**: `http://tu-proyecto.test/login`
-   **Usuario**: `admin@admin.com`
-   **Contraseña**: `gym123admin`

Al iniciar sesión, el sistema te pedirá que selecciones una sucursal. Luego, serás redirigido al dashboard donde verás el nuevo item de menú "Sucursales".
