# Diagrama de Clases (Fase 2)

Este diagrama muestra las relaciones principales entre los modelos de la aplicación tras la implementación del módulo de membresías. Está escrito en sintaxis de Mermaid.

```mermaid
classDiagram
    class User {
        +int id
        +string name
        +string email
        +bool activo
        +int sucursal_id
        +sucursal() Sucursal
        +pagos() Pago[]
    }

    class Sucursal {
        +int id
        +string nombre
        +string direccion
        +bool activo
        +users() User[]
        +miembros() Miembro[]
    }

    class Role {
        +int id
        +string name
    }

    class Miembro {
        +int id
        +string documento_identidad
        +string nombres
        +string apellidos
        +int sucursal_id
        +bool activo
        +sucursal() Sucursal
        +membresias() Membresia[]
        +membresiaActiva() Membresia
    }

    class TipoMembresia {
        +int id
        +string nombre
        +decimal precio
        +int duracion_en_dias
        +bool activo
        +membresias() Membresia[]
    }

    class Membresia {
        +int id
        +int miembro_id
        +int tipo_membresia_id
        +date fecha_inicio
        +date fecha_fin
        +string estado
        +miembro() Miembro
        +tipoMembresia() TipoMembresia
        +pagos() Pago[]
    }

    class Pago {
      +int id
      +int membresia_id
      +int user_id
      +decimal monto
      +string metodo_pago
      +membresia() Membresia
      +usuario() User
    }

    User "1" -- "1" Sucursal : "pertenece a"
    User "1" -- "N" Role : "tiene"
    User "1" -- "N" Pago : "registra"

    Miembro "1" -- "1" Sucursal : "es de"
    Miembro "1" -- "N" Membresia : "tiene"

    Membresia "1" -- "1" Miembro : "pertenece a"
    Membresia "1" -- "1" TipoMembresia : "es de tipo"
    Membresia "1" -- "N" Pago : "tiene"

    Pago "1" -- "1" Membresia : "corresponde a"
```

### Descripción de Relaciones:

*   Un **User** (empleado) pertenece a una **Sucursal** y puede registrar muchos **Pagos**.
*   Un **Miembro** (cliente) está registrado en una **Sucursal** principal y puede tener múltiples **Membresias** a lo largo del tiempo.
*   Una **Membresia** es de un **TipoMembresia** específico (ej. Mensual) y pertenece a un solo **Miembro**.
*   Una **Membresia** puede tener asociados uno o más **Pagos** (ej. pago inicial, cuotas).
*   Un **Pago** está siempre asociado a una **Membresia** y es registrado por un **User**.
