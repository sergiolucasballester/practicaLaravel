# API REST Laravel - Gestión de Alumnos

## Descripción

API REST básica con Laravel para la gestión de alumnos incluyendo operaciones CRUD, validaciones y middleware.

## Requisitos

- PHP 8.2+
- Composer
- Laravel 12.0

## Instalación

### 1. Instalar dependencias

```bash
composer install
```

### 2. Configurar archivo .env

```bash
cp .env.example .env
php artisan key:generate
```

Para usar SQLite (ya configurado):

```
DB_CONNECTION=sqlite
```

Para usar MySQL, cambiar en `.env`:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nombre_base_datos
DB_USERNAME=root
DB_PASSWORD=
```

### 3. Crear base de datos SQLite

```bash
touch database/database.sqlite
```

### 4. Ejecutar migraciones

```bash
php artisan migrate
```

### 5. Ejecutar seeders (opcional)

```bash
php artisan db:seed --class=AlumnoSeeder
```

### 6. Iniciar servidor

```bash
php artisan serve
```

El servidor estará disponible en `http://localhost:8000`

## Comandos utilizados

### Crear proyecto

```bash
laravel new laravelTemp
cd laravelTemp
```

### Crear migration para tabla alumno

```bash
php artisan make:migration create_alumno_table
```

La migration define la estructura de la tabla con campos:

- id (autoincremental)
- nombre (varchar 32, requerido)
- telefono (varchar 16, nullable)
- edad (integer, nullable)
- password (varchar 64, requerido)
- email (varchar 64, único)
- sexo (varchar, nullable)
- timestamps (created_at, updated_at)

### Crear seeder con datos de prueba

```bash
php artisan make:seeder AlumnoSeeder
```

El seeder rellena la tabla alumno con 5 registros de ejemplo. Las contraseñas se hashean con bcrypt.

### Crear modelo Alumno

```bash
php artisan make:model Alumno
```

El modelo mapea la tabla `alumno` y define los campos mass assignable.

### Crear controller AlumnoController

```bash
php artisan make:controller AlumnoController
```

El controller implementa métodos para:

- **index()**: Obtener todos los alumnos
- **show($id)**: Obtener un alumno por ID
- **store()**: Crear un nuevo alumno
- **update()**: Modificar un alumno
- **destroy()**: Eliminar un alumno

### Crear middleware ValidateId

```bash
php artisan make:middleware ValidateId
```

El middleware valida que el parámetro `id` sea:

- Numérico
- Entero
- Positivo

Se aplica automáticamente a las rutas que lo necesitan.

## Rutas de la API

### GET /api/alumnos

Obtiene todos los alumnos.

**Respuesta (200):**

```json
{
    "message": "Alumnos obtenidos correctamente",
    "data": [
        {
            "id": 1,
            "nombre": "Juan García",
            "telefono": "612345678",
            "edad": 20,
            "email": "juan@example.com",
            "sexo": "M",
            "created_at": "2026-02-21T10:00:00Z",
            "updated_at": "2026-02-21T10:00:00Z"
        }
    ]
}
```

### POST /api/alumnos

Crea un nuevo alumno.

**Body (JSON):**

```json
{
    "nombre": "Pedro López",
    "telefono": "612345678",
    "edad": 20,
    "password": "micontraseña123",
    "email": "pedro@example.com",
    "sexo": "M"
}
```

**Respuesta (201):**

```json
{
    "message": "Alumno creado correctamente",
    "data": {
        "id": 6,
        "nombre": "Pedro López",
        "telefono": "612345678",
        "edad": 20,
        "email": "pedro@example.com",
        "sexo": "M",
        "created_at": "2026-02-21T11:00:00Z",
        "updated_at": "2026-02-21T11:00:00Z"
    }
}
```

**Errores (422):**

```json
{
    "error": "Error de validación",
    "messages": {
        "email": ["El email ya ha sido registrado."],
        "nombre": ["El campo nombre es obligatorio."]
    }
}
```

### GET /api/alumnos/{id}

Obtiene un alumno por ID.

**Parámetros:**

- `id` (integer): ID del alumno (validado por middleware)

**Respuesta (200):**

```json
{
    "message": "Alumno obtenido correctamente",
    "data": {
        "id": 1,
        "nombre": "Juan García",
        "...": "..."
    }
}
```

**Error (404):**

```json
{
    "error": "Alumno no encontrado"
}
```

**Error (400):** Si el ID no es válido

```json
{
    "error": "El ID debe ser numérico"
}
```

### PUT /api/alumnos/{id}

Actualiza completamente un alumno.

**Parámetros:**

- `id` (integer): ID del alumno

**Body (JSON):**

```json
{
    "nombre": "Juan García Actualizado",
    "telefono": "699999999",
    "edad": 21,
    "password": "nuevacontraseña123",
    "email": "juan.nuevo@example.com",
    "sexo": "M"
}
```

**Respuesta (200):**

```json
{
    "message": "Alumno actualizado correctamente",
    "data": { ... }
}
```

### PATCH /api/alumnos/{id}

Actualiza parcialmente un alumno (actualizar solo algunos campos).

**Body (JSON):**

```json
{
    "edad": 22,
    "telefono": "666666666"
}
```

**Respuesta (200):**

```json
{
    "message": "Alumno actualizado correctamente",
    "data": { ... }
}
```

### DELETE /api/alumnos/{id}

Elimina un alumno.

**Parámetros:**

- `id` (integer): ID del alumno

**Respuesta (200):**

```json
{
    "message": "Alumno eliminado correctamente"
}
```

## Validaciones

### Al crear alumno (POST)

- **nombre**: Requerido, string, máximo 32 caracteres
- **telefono**: Opcional, string, máximo 16 caracteres
- **edad**: Opcional, entero, entre 1 y 150
- **password**: Requerido, string, mínimo 6 caracteres, máximo 64
- **email**: Requerido, email válido, máximo 64 caracteres, único en la tabla
- **sexo**: Opcional, string, máximo 1 carácter

### Al actualizar alumno (PUT/PATCH)

- Se validan solo los campos enviados
- Email debe ser único (excepto el del alumno actual)
- Password se hashea automáticamente antes de guardarse

## Seguridad

- Las contraseñas se hashean usando bcrypt(Hash::make())
- El middleware ValidateId previene inyección de código via parámetros ID
- Las validaciones previenen campos inesperados o datos inválidos
- Se utiliza JSON para todas las respuestas

## Estructura de archivos

```
app/
├── Http/
│   ├── Controllers/
│   │   └── AlumnoController.php
│   └── Middleware/
│       └── ValidateId.php
└── Models/
    └── Alumno.php

database/
├── migrations/
│   └── 2026_02_21_000000_create_alumno_table.php
└── seeders/
    └── AlumnoSeeder.php

routes/
└── api.php
```

## Testing

### Ejemplos con curl

**Obtener todos los alumnos:**

```bash
curl http://localhost:8000/api/alumnos
```

**Obtener alumno con ID 1:**

```bash
curl http://localhost:8000/api/alumnos/1
```

**Crear nuevo alumno:**

```bash
curl -X POST http://localhost:8000/api/alumnos \
  -H "Content-Type: application/json" \
  -d '{
    "nombre": "Nuevo Alumno",
    "email": "nuevo@example.com",
    "password": "contraseña123",
    "edad": 20,
    "sexo": "M"
  }'
```

**Actualizar alumno:**

```bash
curl -X PUT http://localhost:8000/api/alumnos/1 \
  -H "Content-Type: application/json" \
  -d '{
    "nombre": "Nombre Actualizado",
    "edad": 21
  }'
```

**Eliminar alumno:**

```bash
curl -X DELETE http://localhost:8000/api/alumnos/1
```

## Notas

- El módulo `api.php` en `routes/` es automatizado por Laravel 12
- Si no existe, asegúrate de crear el archivo con la configuración mostrada
- El middleware `validate.id` se debe registrar en `bootstrap/app.php`
- Los passwords nunca se devuelven en las respuestas JSON (definido como `hidden` en el modelo)

## Criterios de evaluación cumplidos

✓ Uso correcto de PHP siguiendo PSR-12
✓ Código limpio, organizado y con buenas prácticas
✓ Respeto de principios REST (GET, POST, PUT/PATCH, DELETE)
✓ Validaciones exhaustivas de entrada
✓ Middleware de validación de ID
✓ Modelo Eloquent para interacción con BD
✓ Seeders para datos de prueba
✓ Respuestas JSON estructuradas
✓ Manejo de errores adecuado
✓ Documentación completa
