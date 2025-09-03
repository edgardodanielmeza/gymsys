# Instrucciones de Instalación y Configuración - GymSys

Sigue estos pasos para aplicar los cambios en tu entorno de desarrollo local.

## Paso 1 y 2: Migraciones y Modelos

Ya has debido crear los siguientes archivos que te he proporcionado:

1.  **Migraciones**: Todos los archivos en `database/migrations/`.
2.  **Modelos**: Todos los archivos en `app/Models/`.

Una vez que tengas esos archivos en tu proyecto, ejecuta el siguiente comando para crear todas las tablas en tu base de datos:

```bash
php artisan migrate
```

## Paso 3: Sistema de Roles y Permisos (Spatie)

Para gestionar los roles como "Administrador" y "Recepcionista", vamos a instalar y configurar el paquete `spatie/laravel-permission`.

**1. Instalar el paquete vía Composer:**

Ejecuta el siguiente comando en tu terminal:
```bash
composer require spatie/laravel-permission
```

**2. Publicar el archivo de migración y configuración:**

Este comando copiará un archivo de migración y un archivo de configuración (`config/permission.php`) a tu proyecto.
```bash
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
```

**3. Ejecutar la migración de Spatie:**

Ahora, ejecuta las migraciones de nuevo para crear las tablas `roles`, `permissions` y las tablas pivote relacionadas.
```bash
php artisan migrate
```

A continuación, te proporcionaré el código para modificar el modelo `User` y añadirle la funcionalidad de roles.

## Paso 4: Cargar Datos Iniciales (Seeders)

Después de ejecutar las migraciones, la base de datos estará lista pero vacía. El siguiente comando ejecutará los `seeders` que hemos creado para poblarla con los datos iniciales (roles, sucursales y el usuario administrador).

```bash
php artisan db:seed
```

Después de este paso, deberías poder iniciar sesión con el usuario `admin@admin.com` y la contraseña `gym123admin`.

## Paso 5: Flujo de Selección de Sucursal

He añadido la lógica para forzar a un usuario a seleccionar una sucursal después de iniciar sesión. Esto se compone de varios archivos nuevos que debes colocar en tu proyecto:

1.  **Middleware**: `app/Http/Middleware/EnsureSucursalIsSelected.php`
2.  **Componente Livewire (Clase)**: `app/Livewire/Auth/SeleccionarSucursal.php`
3.  **Componente Livewire (Vista)**: `resources/views/livewire/auth/seleccionar-sucursal.blade.php`

También he modificado los siguientes archivos, que ya deberías tener actualizados:

1.  `bootstrap/app.php` (para registrar el middleware).
2.  `routes/web.php` (para añadir la nueva ruta y proteger el dashboard).

Con estos cambios, al iniciar sesión, serás redirigido a la página de selección de sucursal antes de poder acceder al dashboard.
