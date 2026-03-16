# 🎓 Sistema de Control Escolar - UASLP

Sistema integral para la gestión académica desarrollado como parte de la formación en la **Facultad de Ingeniería (ISI)**. Este proyecto permite administrar el catálogo de materias, la apertura de grupos con horarios específicos y la inscripción de alumnos.

## 🚀 Características principales

- **Autenticación Personalizada:** Login y Registro con diseño Split-Screen moderno.
- **Gestión de Materias:** CRUD completo con datos académicos (clave, créditos, semestre, área).
- **Horarios y Grupos:** Apertura de grupos vinculados a materias y profesores, con selección flexible de días y horas.
- **Inscripciones:** Sistema para que los alumnos armen su carga académica en tiempo real.
- **Dashboard Estadístico:** Panel principal con resumen de registros en la base de datos.

## 🛠️ Requisitos previos

Antes de comenzar, asegúrate de tener instalado:

- [WSL2 (Ubuntu)](https://learn.microsoft.com/en-us/windows/wsl/install)
- [Docker Desktop](https://www.docker.com/products/docker-desktop/)
- Git

## 💻 Instalación y Configuración

Sigue estos pasos para levantar el proyecto en una laptop nueva:

### 1. Clonar el repositorio

```bash
git clone [https://github.com/tu-usuario/control_escolar-interactivas.git](https://github.com/tu-usuario/control_escolar-interactivas.git)

cd control_escolar-interactivas
```

### 2. Configurar el entorno (.env)

Copia el archivo de ejemplo y genera la clave de la aplicación:

```bash
cp .env.example .env
```

### 3. Levantar contenedores con Laravel Sail

```bash
# Instalar dependencias de PHP (si no tienes PHP local, Sail lo hace por ti)
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php82-composer:latest \
    composer install --ignore-platform-reqs

# Levantar el servicio
./vendor/bin/sail up -d
```

### 4. Permisos de archivos (Linux/WSL2)

Para evitar errores de escritura en los logs o al editar archivos:

```bash
sudo chown -R $USER:$USER .
```

### 5. Base de Datos y Frontend

```bash
# Generar clave de aplicación
./vendor/bin/sail artisan key:generate

# Ejecutar migraciones
./vendor/bin/sail artisan migrate:fresh

# Instalar y compilar assets (Tailwind CSS)
./vendor/bin/sail npm install
./vendor/bin/sail npm run build
```
