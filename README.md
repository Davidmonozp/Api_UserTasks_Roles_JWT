
<!-- # Proyecto Backend - Laravel JWT API -->

Este es el backend de la aplicación, desarrollado utilizando **Laravel**. Esta API está diseñada para gestionar tareas de usuario, donde los usuarios pueden crear, leer, actualizar y eliminar tareas.

## Requisitos previos

Para ejecutar este proyecto, necesitas tener instalados los siguientes programas:

- **PHP** (versión 8.0 o superior)
- **Composer** (para gestionar dependencias PHP)
- **MySQL** o cualquier otro servidor de base de datos compatible con Laravel
- **Git** (para clonar el repositorio)
  
## Configuración y ejecución del proyecto

### 1. Clonar el repositorio


Primero, clona el repositorio en tu máquina local:

```bash
git clone https://github.com/Davidmonozp/Api_UserTasks_Roles_JWT.git
cd tu-repositorio

2. Configuración de variables de entorno

Copia el archivo .env.example a .env:

Luego, edita el archivo .env y configura los parámetros adecuados para tu base de datos y otras configuraciones:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=usertasks
DB_USERNAME=root
DB_PASSWORD=tu-contraseña

3. Instalación de dependencias
Usa Composer para instalar las dependencias de PHP necesarias:

composer install

4. Generar la clave de la aplicación
Laravel requiere una clave única para la aplicación. Genera una nueva clave ejecutando:

php artisan key:generate


5. Migrar la base de datos
Realiza las migraciones de la base de datos para crear las tablas necesarias:

php artisan migrate

6. Configuración de JWT
El backend utiliza JWT (JSON Web Tokens) para la autenticación. Asegúrate de que la clave secreta del JWT esté configurada correctamente en el archivo .env:

Puedes generar una clave JWT_SECRET ejecutando el siguiente comando:

php artisan jwt:secret

7. Iniciar el servidor de desarrollo
Para iniciar el servidor de desarrollo de Laravel, ejecuta:

php artisan serve


API Endpoints
Aquí puedes agregar algunos ejemplos de los endpoints principales de la API, como por ejemplo:

POST /login: Inicia sesión y devuelve un token JWT.
GET /tasks: Obtiene una lista de todas las tareas.
POST /tasks: Crea una nueva tarea.
PUT /tasks/{id}: Actualiza una tarea existente.
DELETE /tasks/{id}: Elimina una tarea.
