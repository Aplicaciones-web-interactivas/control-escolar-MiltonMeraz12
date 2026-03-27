# 🎓 Sistema de Control Escolar - UASLP

## 🚀 Características principales

- **Autenticación por roles:** Alumno, Profesor y Admin con vistas y permisos separados.
- **Gestión de Materias:** CRUD completo con clave, créditos, semestre y área.
- **Horarios y Grupos:** Apertura de grupos vinculados a materias y profesores.
- **Inscripciones:** Alumnos arman su carga académica con validación de cupo.
- **Calificaciones:** Profesores capturan parciales; alumnos consultan su boleta.
- **Tareas:** Profesores asignan tareas con fecha límite; alumnos suben PDFs como entrega.

## 👥 Roles y accesos

| Rol          | Puede hacer                                              |
| ------------ | -------------------------------------------------------- |
| **Admin**    | Gestionar materias y grupos                              |
| **Profesor** | Capturar calificaciones, crear tareas, revisar entregas  |
| **Alumno**   | Inscribirse a grupos, ver boleta, entregar tareas en PDF |

## 🛠️ Requisitos previos

- [WSL2 (Ubuntu)](https://learn.microsoft.com/en-us/windows/wsl/install)
- [Docker Desktop](https://www.docker.com/products/docker-desktop/)
- Git

## 💻 Instalación en una laptop nueva

### 1. Clonar el repositorio

```bash
git clone https://github.com/tu-usuario/control_escolar-interactivas.git
cd control_escolar-interactivas
```

### 2. Instalar dependencias PHP

```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php82-composer:latest \
    composer install --ignore-platform-reqs
```

### 3. Configurar entorno

```bash
cp .env.example .env
```

### 4. Levantar Docker

```bash
./vendor/bin/sail up -d
```

### 5. Permisos (Linux/WSL2)

```bash
sudo chown -R $USER:$USER .
```

### 6. Base de datos, assets y storage

```bash
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate:fresh --seed
./vendor/bin/sail artisan storage:link
./vendor/bin/sail npm install
./vendor/bin/sail npm run build
```

## 🔑 Usuarios de prueba (seeder)

| Email                             | Contraseña  | Rol      |
| --------------------------------- | ----------- | -------- |
| `merazmilton9@gmail.com`          | `temporal1` | Alumno   |
| `renata@example.com`              | `temporal1` | Alumno   |
| `admin@example.com`               | `temporal1` | Admin    |
| `muniz@example.com`               | `temporal1` | Profesor |
| `meade@example.com`               | `temporal1` | Profesor |
| _(cualquier profesor del seeder)_ | `temporal1` | Profesor |
