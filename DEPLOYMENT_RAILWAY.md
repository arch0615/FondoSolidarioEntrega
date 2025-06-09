# Deployment en Railway - Fondo Solidario JAEC

## 🚀 Guía de Deployment

### 1. Preparativos
- ✅ Proyecto en GitHub: `https://github.com/ttrcastanon/personal-fondo-solidario.git`
- ✅ Archivos de configuración creados:
  - `railway.json` - Configuración de Railway
  - `nixpacks.toml` - Buildpack personalizado
  - `Procfile` - Comando de inicio
  - `railway-deploy.sh` - Script de deployment

### 2. Pasos para Deployment

#### 2.1 Crear cuenta en Railway
1. Ve a [railway.app](https://railway.app)
2. Crea cuenta con GitHub
3. Autoriza acceso a tus repositorios

#### 2.2 Crear nuevo proyecto
1. Click en "New Project"
2. Selecciona "Deploy from GitHub repo"
3. Busca y selecciona: `ttrcastanon/personal-fondo-solidario`

#### 2.3 Base de Datos MySQL
✅ Ya tienes configurada una base de datos MySQL gratuita en FreeSQLDatabase.com
- No necesitas crear nada adicional en Railway
- Las credenciales ya están disponibles

#### 2.4 Configurar Variables de Entorno
En el servicio de tu aplicación, ve a "Variables" y agrega:

```env
APP_NAME=Fondo Solidario JAEC
APP_ENV=production
APP_DEBUG=false
APP_KEY= (se generará automáticamente)
APP_URL= (Railway lo proporcionará)

# Base de datos MySQL - FreeSQLDatabase
DB_CONNECTION=mysql
DB_HOST=sql5.freesqldatabase.com
DB_PORT=3306
DB_DATABASE=sql5783875
DB_USERNAME=sql5783875
DB_PASSWORD=JrFPaSyHnu

# Cache y Session
CACHE_DRIVER=file
SESSION_DRIVER=file
SESSION_LIFETIME=120

# Mail (opcional, configurar según necesidades)
MAIL_MAILER=smtp
MAIL_HOST=
MAIL_PORT=587
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@fondosolidario.com
MAIL_FROM_NAME="${APP_NAME}"

# Queue
QUEUE_CONNECTION=sync
```

#### 2.5 Deploy Automático
- Railway detectará los cambios y comenzará el deployment automáticamente
- El proceso incluye:
  - Instalación de dependencias PHP y Node.js
  - Build de assets con Vite
  - Ejecución de migraciones
  - Ejecución de seeders (primera vez)
  - Optimización de Laravel

### 3. Verificación Post-Deployment

#### 3.1 Acceso a la aplicación
- Railway proporcionará una URL pública (ej: `https://tu-proyecto.up.railway.app`)
- La aplicación estará disponible inmediatamente

#### 3.2 Verificar funcionalidad
- [ ] Página de login accesible
- [ ] Base de datos conectada correctamente
- [ ] Seeders ejecutados (usuarios y catálogos)
- [ ] Assets cargando correctamente

### 4. Usuarios de Prueba (Seeders)

Después del deployment, tendrás estos usuarios disponibles:

**Administrador:**
- Email: `admin@prueba.com`
- Password: `password`
- Rol: Administrador (Personal JAEC con acceso completo)

**Médico Auditor:**
- Email: `medico@prueba.com`  
- Password: `password`
- Rol: Médico Auditor (Profesional médico que evalúa reintegros)

**Usuario Escuela:**
- Email: `user@prueba.com`
- Password: `password`
- Rol: Usuario General (Personal de escuela con acceso básico)
- Escuela: Escuela Primaria N° 1

**Usuario Prueba Adicional:**
- Email: `test@prueba.com`
- Password: `password`
- Rol: Usuario General (Personal de escuela con acceso básico)
- Escuela: Escuela Primaria N° 1

### 5. Datos de Prueba Incluidos

Los seeders también crean:
- **Escuela**: Escuela Primaria N° 1 (ESC001)
- **Prestadores**: Clínica del Sol y Emergencias JAEC
- **Alumno**: Juan Perez (DNI: 12345678)
- **Catálogos completos**: Estados, tipos de gastos, tipos de prestadores, etc.

### 6. Comandos Útiles en Railway

```bash
# Ver logs en tiempo real
railway logs

# Ejecutar comandos en el servidor
railway run php artisan migrate
railway run php artisan db:seed

# Conectar a la base de datos
railway connect
```

### 7. Actualizaciones Futuras

Para actualizar la aplicación:
1. Haz push a GitHub
2. Railway detectará los cambios automáticamente
3. Se ejecutará el re-deployment

### 8. Costos Estimados

- **Plan Gratuito**: $5 USD de crédito mensual
- **Uso típico**: ~$2-3 USD/mes para desarrollo/demo
- **Escalamiento**: Automático según tráfico

### 9. Soporte y Troubleshooting

Si hay problemas:
1. Revisa los logs en Railway Dashboard
2. Verifica variables de entorno
3. Confirma que las migraciones se ejecutaron
4. Revisa la conectividad de la base de datos

---

**¡Tu aplicación estará lista para que tu cliente la revise!** 🎉

URL de ejemplo: `https://personal-fondo-solidario-production.up.railway.app`