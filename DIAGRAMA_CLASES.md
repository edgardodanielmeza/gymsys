# Diagrama de Clases (Simplificado)

Este diagrama representa la arquitectura de los modelos principales y sus relaciones en la etapa actual del proyecto.

```
+---------------------------+          +-----------------------------+
| User                      |          | sucursal_user (Pivot Table) |
+---------------------------+          +-----------------------------+
| - id (PK)                 |          | - user_id (FK)              |
| - name: string            |          | - sucursal_id (FK)          |
| - email: string           |          +-----------------------------+
| - password: hashed        |                  |            |
| - role: string            |                  |            |
|   ('admin', 'recepcionista')|                  |            |
| - ... (otros campos)      |                  |            |
+---------------------------+                  |            |
           |                                   |            |
           | 1                                 *            | *
           |                                                |
           +------------------ (belongsToMany) -------------+
                                                            |
                                                            |
+---------------------------+                               |
| Sucursal                  |                               |
+---------------------------+                               |
| - id (PK)                 |                               |
| - nombre: string          |                               |
| - direccion: string       |                               |
| - telefono: string        |                               |
| - activa: boolean         |                               |
| - ... (otros campos)      |                               |
+---------------------------+                               |
           |                                                |
           | 1                                              |
           |                                                |
           +----------------- (belongsToMany) ---------------+


```

## Descripción de las Relaciones

### User ↔ Sucursal

-   **Tipo**: Muchos a Muchos (`belongsToMany`).
-   **Tabla Pivote**: `sucursal_user`.
-   **Lógica**:
    -   Un `User` (como un recepcionista o administrador) puede tener acceso a una o varias `Sucursal`(es).
    -   Una `Sucursal` puede tener muchos `User`s trabajando en ella.
-   **Implementación**:
    -   En el modelo `User`: `public function sucursales() { return $this->belongsToMany(Sucursal::class); }`
    -   En el modelo `Sucursal`: `public function users() { return $this->belongsToMany(User::class); }`

### Próximos Modelos a Añadir

-   **Miembro**: Representará a los clientes del gimnasio. Tendrá una relación de Uno a Muchos con `Pago` y `Membresia`.
-   **Membresia**: El estado de la suscripción de un `Miembro`.
-   **TipoMembresia**: Los planes disponibles (ej. Mensual, Anual).
-   **Pago**: Los registros de transacciones financieras.
