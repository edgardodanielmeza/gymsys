# Instrucciones para la Configuración del Proyecto GymSys

Hola! Aquí tienes las instrucciones detalladas para aplicar los cambios que he generado en tu proyecto base de Laravel. Dado que no pude ejecutar comandos `composer` o `php artisan` en mi entorno, he creado todos los archivos necesarios para ti.

Sigue estos pasos en orden desde la terminal de tu entorno WAMP (asegúrate de tener acceso a `php`, `composer` y `npm`).

### Paso 1: Instalar Dependencias de Composer

Primero, necesitamos instalar el paquete para la gestión de roles y permisos que he configurado.

```bash
composer require spatie/laravel-permission
```

### Paso 2: Publicar Archivos de Configuración de Spatie

El paquete de permisos necesita un archivo de configuración y una migración. El siguiente comando los publicará.

```bash
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
```
*(Nota: Esto creará un archivo `config/permission.php` y una nueva migración en `database/migrations/`. Ya he preparado el código para que funcione con ellos.)*

### Paso 3: Ejecutar las Migraciones de la Base de Datos

Ahora vamos a crear todas las tablas en tu base de datos `gymsys`. Esto incluye las tablas de Jetstream, las de permisos de Spatie y las que yo he creado (`sucursales` y los campos adicionales en `users`).

**Asegúrate de que tu archivo `.env` esté configurado con los datos correctos de tu base de datos `gymsys` y que la base de datos exista y esté vacía.**

```bash
php artisan migrate
```

### Paso 4: Poblar la Base de Datos con Datos Iniciales

El siguiente comando ejecutará los seeders que he creado. Esto creará los roles, sucursales, tipos de membresía de ejemplo y el usuario administrador (`admin@admin.com` / `gym123admin`).

```bash
php artisan db:seed
```

### Paso 5: Crear el Enlace Simbólico de Almacenamiento

Este paso es **muy importante** para que las fotos de perfil de los miembros sean visibles públicamente.

```bash
php artisan storage:link
```

### Paso 6: Compilar los Assets (Opcional pero recomendado)

Aunque tu script inicial ya lo hizo, si has hecho algún cambio o por si acaso, es bueno recompilar.

```bash
npm run build
```

### Paso 7: Iniciar el Servidor

¡Todo está listo! Ahora puedes iniciar el servidor de desarrollo de Laravel.

```bash
php artisan serve
```

### Verificación

1.  Abre tu navegador y ve a `http://127.0.0.1:8000` (o la URL que te indique `php artisan serve`).
2.  Inicia sesión con el usuario:
    *   **Email:** `admin@admin.com`
    *   **Contraseña:** `gym123admin`
3.  Después de iniciar sesión, deberías ser redirigido a la página **"Seleccionar Sucursal"**.
4.  Elige una sucursal y haz clic en "Continuar".
5.  Serás redirigido al Dashboard. En el menú de navegación, ahora deberías ver:
    *   **Miembros**: Accesible para Admin y Recepcionista.
    *   **Sucursales**: Solo para Admin.
    *   **Tipos de Membresía**: Solo para Admin.
6.  Navega a **"Tipos de Membresía"** para asegurarte de que puedes ver, crear y editar los planes.
7.  Navega a **"Miembros"** y prueba a registrar un nuevo miembro. El formulario debería permitirte añadir sus datos, una foto, y seleccionar su primera membresía para inscribirlo.

¡Con esto, la segunda fase del proyecto está configurada y funcionando!
