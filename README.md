# 🚀 Proyecto Base Laravel + Livewire

Una plantilla base moderna y completa para proyectos web usando **Laravel 11.x + Livewire 3.x + MySQL**.

## 📋 Características

- ✅ **Laravel 11.x** - Framework PHP moderno
- ✅ **Livewire 3.x** - Componentes dinámicos sin JavaScript complejo
- ✅ **Tailwind CSS** - Framework CSS utilitario
- ✅ **Alpine.js** - JavaScript reactivo minimalista
- ✅ **Vite** - Build tool rápido y moderno
- ✅ **MySQL** - Base de datos robusta
- ✅ **Login responsivo** - Página de login moderna incluida
- ✅ **Estructura organizada** - Directorios y archivos bien estructurados

## 🛠️ Instalación

### Prerrequisitos

- PHP 8.1 o superior
- Composer
- Node.js y npm
- MySQL 8.0 o superior

### Pasos de instalación

1. **Clonar o descargar el proyecto**
   ```bash
   # Si usas git
   git clone <tu-repositorio>
   cd proyecto-base
   ```

2. **Instalar dependencias de PHP**
   ```bash
   composer install
   ```

3. **Instalar dependencias de Node.js**
   ```bash
   npm install
   ```

4. **Configurar variables de entorno**
   ```bash
   # Copiar archivo de ejemplo
   copy .env.example .env
   
   # Generar clave de aplicación
   php artisan key:generate
   ```

5. **Configurar base de datos**
   
   Edita el archivo `.env` con tus credenciales de MySQL:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=tu_base_de_datos
   DB_USERNAME=tu_usuario
   DB_PASSWORD=tu_password
   ```

6. **Ejecutar migraciones**
   ```bash
   php artisan migrate
   ```

7. **Compilar assets**
   ```bash
   # Para desarrollo
   npm run dev
   
   # Para producción
   npm run build
   ```

8. **Iniciar servidor de desarrollo**
   ```bash
   php artisan serve
   ```

## 🎯 Uso

### Acceso al sistema

- **URL principal**: `http://localhost:8000`
- **Login HTML**: `http://localhost:8000/login.html`
- **Login Laravel**: `http://localhost:8000/login`

### Credenciales de prueba (login.html)

- **Email**: `admin@ejemplo.com`
- **Password**: `admin`

## 📁 Estructura del proyecto

```
proyecto-base/
├── 📁 app/                     # Lógica de la aplicación
│   ├── 📁 Http/               # Controllers y Middleware
│   ├── 📁 Livewire/          # Componentes Livewire
│   ├── 📁 Models/            # Modelos Eloquent
│   └── 📁 Providers/         # Service Providers
├── 📁 bootstrap/              # Archivos de inicialización
├── 📁 config/                 # Archivos de configuración
├── 📁 database/               # Migraciones y seeders
├── 📁 public/                 # Archivos públicos
│   ├── login.html            # ⭐ Login HTML responsivo
│   └── index.php             # Punto de entrada
├── 📁 resources/              # Assets y vistas
│   ├── 📁 css/               # Estilos CSS
│   ├── 📁 js/                # JavaScript
│   └── 📁 views/             # Vistas Blade
├── 📁 routes/                 # Definición de rutas
├── 📁 storage/                # Archivos de almacenamiento
├── .env.example               # Variables de entorno
├── composer.json              # Dependencias PHP
├── package.json               # Dependencias Node.js
└── README.md                  # Este archivo
```

## 🎨 Características del Login

El archivo `public/login.html` incluye:

- ✅ **Diseño responsivo** (móvil, tablet, desktop)
- ✅ **UI moderna** con gradientes y animaciones
- ✅ **Validación en tiempo real**
- ✅ **Estados de carga**
- ✅ **Accesibilidad** mejorada
- ✅ **Dark mode** compatible
- ✅ **Font Awesome** icons
- ✅ **Google Fonts** (Inter)

## 🔧 Comandos útiles

### Desarrollo
```bash
# Servidor de desarrollo
php artisan serve

# Compilar assets en modo desarrollo
npm run dev

# Watch mode para assets
npm run watch
```

### Producción
```bash
# Compilar assets para producción
npm run build

# Optimizar autoloader
composer install --optimize-autoloader --no-dev

# Cachear configuración
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Base de datos
```bash
# Ejecutar migraciones
php artisan migrate

# Rollback migraciones
php artisan migrate:rollback

# Refresh migraciones
php artisan migrate:refresh

# Ejecutar seeders
php artisan db:seed
```

### Livewire
```bash
# Crear componente Livewire
php artisan make:livewire NombreComponente

# Publicar assets de Livewire
php artisan livewire:publish --assets
```

## 🚀 Próximos pasos

Esta plantilla base está lista para que la personalices según tus necesidades:

1. **Crear modelos** específicos de tu negocio
2. **Agregar migraciones** para tus tablas
3. **Desarrollar componentes Livewire** personalizados
4. **Implementar autenticación** completa
5. **Agregar middleware** de roles y permisos
6. **Crear seeders** con datos de prueba

## 📚 Recursos útiles

- [Documentación de Laravel](https://laravel.com/docs)
- [Documentación de Livewire](https://livewire.laravel.com/docs)
- [Documentación de Tailwind CSS](https://tailwindcss.com/docs)
- [Documentación de Alpine.js](https://alpinejs.dev/start-here)

## 🤝 Contribuir

Si encuentras algún error o tienes sugerencias de mejora:

1. Crea un issue describiendo el problema
2. Fork el proyecto
3. Crea una rama para tu feature
4. Commit tus cambios
5. Push a la rama
6. Abre un Pull Request

## 📄 Licencia

Este proyecto está bajo la licencia MIT. Ver archivo `LICENSE` para más detalles.

## 👨‍💻 Autor

Creado como plantilla base para proyectos Laravel + Livewire.

---

**¡Feliz codificación! 🎉**