# Diagrama de Clases (Fase 1)

Este diagrama muestra las relaciones principales entre los modelos de la aplicación en esta primera fase de desarrollo. Está escrito en sintaxis de Mermaid. Puedes copiar y pegar el código en un editor de Mermaid online (como [mermaid.live](https://mermaid.live)) para visualizarlo.

```mermaid
classDiagram
    class User {
        +int id
        +string name
        +string email
        +string password
        +bool activo
        +int sucursal_id
        +hasRoles()
        +sucursal() Sucursal
    }

    class Sucursal {
        +int id
        +string nombre
        +string direccion
        +string telefono
        +string email
        +int capacidad_maxima
        +string horario_operacion
        +bool activo
        +users() User[]
    }

    class Role {
        +int id
        +string name
        +users() User[]
    }

    class Miembro {
        <<Futuro>>
        +int id
        +string documento_identidad
        +string nombres
        +string apellidos
        +membresias() Membresia[]
    }

    class Membresia {
        <<Futuro>>
        +int id
        +int miembro_id
        +date fecha_inicio
        +date fecha_fin
        +string estado
        +miembro() Miembro
    }

    User "1" -- "1" Sucursal : "pertenece a (principal)"
    User "1" -- "N" Role : "tiene"
    Sucursal "1" -- "N" User : "tiene asignados"

    Miembro "1" -- "N" Membresia : "tiene"
    Membresia "1" -- "1" Miembro : "pertenece a"

```

### Descripción de Relaciones:

*   **User - Sucursal**: Un `User` (empleado/admin) tiene asignada una `Sucursal` principal. Una `Sucursal` puede tener muchos `Users` asignados.
*   **User - Role**: Un `User` puede tener uno o más `Roles` (ej. 'Admin', 'Recepcionista'). Un `Role` puede ser asignado a muchos `Users`. (Relación gestionada por Spatie).
*   **Miembro - Membresia (Futuro)**: Se planea que un `Miembro` (cliente del gym) pueda tener un historial de múltiples `Membresias`. Cada `Membresia` pertenece a un solo `Miembro`.
