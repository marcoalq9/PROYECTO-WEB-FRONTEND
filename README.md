# Sistema de Gestión de Flotilla

Aplicación web para la gestión completa de flotas de vehículos, desarrollada con **Laravel** y **Vue.js** (Vite).

## 📋 Requisitos Previos

Antes de instalar el proyecto, asegúrate de tener instalado:

- **PHP** >= 8.1
- **Composer** (gestor de paquetes de PHP)
- **Node.js** >= 16 y **npm** (o yarn)
- **Git**
- **Base de datos**: MySQL, PostgreSQL o SQLite
- **XAMPP/Laragon/Wamp** (opcional, si prefieres un ambiente local preconfigurado)

## 🚀 Instalación

### 1. Clonar el repositorio

```bash
git clone <url-del-repositorio>
cd flotilla-frontend
```

### 2. Instalar dependencias de PHP

```bash
composer install
```

### 3. Instalar dependencias de Node.js

```bash
npm install
```

### 4. Configurar archivo de entorno

Copia el archivo `.env.example` a `.env`:

```bash
cp .env.example .env
```

Luego, edita el archivo `.env` y configura:

```env
APP_NAME=Flotilla
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=flotilla
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Generar clave de aplicación

```bash
php artisan key:generate
```

### 6. Crear base de datos

Crea la base de datos en tu gestor de base de datos:

```bash
mysql -u root -p -e "CREATE DATABASE flotilla;"
```

O si usas SQLite:

```bash
touch database/database.sqlite
```

### 7. Ejecutar migraciones

```bash
php artisan migrate
```

### 8. Llenar datos de prueba (opcional)

```bash
php artisan db:seed
```

## 🎯 Uso

### Iniciar servidor de desarrollo

Terminal 1 - Servidor PHP:

```bash
php artisan serve
```

El servidor estará disponible en: `http://localhost:8000`

Terminal 2 - Compilar assets con Vite:

```bash
npm run dev
```

### Compilar para producción

```bash
npm run build
```

## 📁 Estructura del Proyecto

```
flotilla-frontend/
├── app/                  # Lógica de la aplicación
│   ├── Http/
│   │   ├── Controllers/  # Controladores
│   │   └── Middleware/   # Middlewares
│   ├── Models/           # Modelos (Eloquent)
│   └── Providers/        # Proveedores de servicios
├── resources/
│   ├── css/              # Estilos
│   ├── js/               # JavaScript/Vue.js
│   └── views/            # Vistas Blade
│       ├── admin/        # Vistas de administrador
│       ├── auth/         # Vistas de autenticación
│       ├── chofer/       # Vistas de choferes
│       └── operador/     # Vistas de operadores
├── database/
│   ├── migrations/       # Migraciones de BD
│   ├── seeders/          # Datos iniciales
│   └── factories/        # Factories para pruebas
├── routes/               # Rutas de la aplicación
├── public/               # Archivos públicos
└── tests/                # Pruebas unitarias y funcionales
```

## 🔑 Credenciales de Prueba

Después de ejecutar `php artisan db:seed`, puedes usar:

- **Email**: admin@example.com
- **Contraseña**: password

## 🛠 Comandos Útiles

| Comando                                        | Descripción                        |
| ---------------------------------------------- | ---------------------------------- |
| `php artisan migrate`                          | Ejecutar migraciones               |
| `php artisan migrate:rollback`                 | Revertir última migración          |
| `php artisan db:seed`                          | Llenar datos de prueba             |
| `php artisan tinker`                           | Consola interactiva de PHP         |
| `php artisan make:model NombreModelo -m`       | Crear modelo con migración         |
| `php artisan make:controller NombreController` | Crear controlador                  |
| `npm run dev`                                  | Compilar assets en modo desarrollo |
| `npm run build`                                | Compilar assets para producción    |
| `php artisan test`                             | Ejecutar pruebas                   |

## 🐛 Solución de Problemas

### Error: "No such file or directory" al ejecutar `php artisan`

Asegúrate de estar en la carpeta correcta del proyecto.

### Error: "SQLSTATE[HY000]"

Verifica que:

- La base de datos existe
- Las credenciales en `.env` son correctas
- El servidor MySQL está ejecutándose

### Los assets no se cargan

Ejecuta `npm run dev` o `npm run build` para compilar los assets.

## 📝 Licencia

Este proyecto está bajo licencia MIT.

## 👥 Soporte

Para reportar problemas o sugerencias, crea un issue en el repositorio.

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
