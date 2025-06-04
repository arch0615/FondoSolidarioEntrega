# ✅ CHECKLIST DETALLADO - SISTEMA FONDO SOLIDARIO JAEC

> **Nota**: Este checklist está optimizado para desarrollo individual con base de datos existente (sin migraciones).

## 📋 **ETAPA 1: CONFIGURACIÓN Y ANÁLISIS INICIAL**

### 🔧 **1.1 Configuración Inicial**
- [X] Verificar conexión a base de datos `fondo_solidario_jaec` en `.env`
- [X] Probar conexión con `php artisan tinker` y `DB::connection()->getPdo()`
- [X] Verificar que las 19 tablas estén creadas correctamente
- [X] Configurar timezone a 'America/Argentina/Buenos_Aires' en `config/app.php`

### 🔍 **1.2 Análisis y Mapeo de Base de Datos**
- [X] Revisar proceso por proceso del documento fondo_solidario_requirements.md y asegurar que todas las tablas tablas necesarias están plasmadas en el archivo diccionario-datos-fondo-solidario.md
- [X] Documentar campos faltantes o modificaciones necesarias en archivo update.sql (No se requieren cambios)
- [X] Ejecutar update.sql para ajustes si es necesario (No hay archivo porque no se requieren cambios)
- [X] Modificar checklist-desarrollo-fondo-solidario.md en caso de ser necesario debido a nuevas tablas que se vayan a crear (No se requieren modificaciones)

### 🔐 **1.3 Sistema de Autenticación Básico**
- [X] Validar que el login existente tenga Laravel Breeze/Fortify (Sistema de autenticación personalizado implementado correctamente)

---

## 📋 **ETAPA 2: NAVEGACIÓN Y PROTOTIPOS VISUALES**

### 🎨 **2.1 Conversión a Blade Templates**
- [X] Crear layout principal `resources/views/layouts/app.blade.php` si es que no existe. ✅ Mejorado con navegación dinámica
- [X] Mantener estilos Tailwind CSS actuales ✅ Integrado con colores personalizados
- [X] Verificar responsive en móviles ✅ Responsive design implementado

### 🧭 **2.2 Navegación por Rol (Mockups)**

#### **Usuario General (Escuela)**
- [X] Crear menú lateral con opciones: ✅ Implementado completamente en `sidebar-navigation.blade.php`
  - [X] Accidentes ✅ Menú completo (Registrar, Ver, Generar Derivación, Solicitar Reintegros)
  - [X] Alumnos ✅ Menú navegable (Registrar, Buscar)
  - [X] Salidas Educativas ✅ Menú navegable (Nueva Salida, Ver Salidas)
  - [X] Pasantías ✅ Menú navegable (Nueva Pasantía, Ver Pasantías)
  - [X] Personal ✅ Menú navegable (Ver Empleados, Beneficiarios SVO)
  - [X] Documentos ✅ Menú navegable (Subir, Ver Documentos)
- [X] Vista de "Mis Notificaciones" (mockup) ✅ Dropdown funcional
- [X] Dashboard escuela ✅ Dashboard completamente implementado

#### **Dashboard Escuela Implementado:**
- [X] **4 Estadísticas de la escuela**: Accidentes Reportados, Alumnos Registrados, Reintegros Pendientes, Documentos Subidos
- [X] **Actividad Reciente**: Accidentes reportados, reintegros autorizados, derivaciones generadas
- [X] **4 Acciones rápidas**: Reportar Accidente, Registrar Alumno, Generar Derivación, Subir Documentos
- [X] **Métricas específicas de la escuela**: Solo datos de su institución

#### **Administrador JAEC**
- [X] Crear menú lateral con opciones: ✅ Navegación diferenciada por rol **REORG. 31/05/2025**
  - [X] Dashboard General ✅ Dashboard completamente funcional
  - [X] **Administración** ✅ Menú reorganizado (Escuelas, Empleados, Salidas Educativas, Pasantías, Beneficiarios SVO, Derivaciones)
  - [X] **Gestión** ✅ **NUEVO**: Menú con Accidentes, Reintegros, Gestión de Pagos
  - [X] Usuarios ✅ Menú independiente
  - [X] Auditoría Sistema ✅ Menú con Accesos al Sistema y Operaciones
  - [X] ❌ **REMOVIDO**: Ver Accidentes (movido a Gestión)
  - [X] ❌ **REMOVIDO**: Reintegros independiente (movido a Gestión)
- [X] Vista de métricas generales ✅ Dashboard con estadísticas completas
- [X] Páginas estáticas para cada sección ✅ Dashboard implementado completamente

#### **Dashboard Administrador Implementado:**
- [X] **4 Estadísticas principales**: Escuelas Activas, Total Accidentes, Reintegros Autorizados, Monto Total Pagado
- [X] **Actividad Reciente del Sistema**: Nuevas escuelas, reintegros pagados, usuarios creados
- [X] **4 Acciones administrativas reorganizadas**: Administración, Gestión, Gestionar Usuarios, Auditoría Sistema
- [X] **Tabla resumen por escuela**: Sin columna de acciones (solo información)

#### **Médico Auditor**
- [X] Crear menú lateral con opciones: ✅ Navegación especializada ACTUALIZADA
  - [X] Reintegros Pendientes ✅ Con badge de notificación funcional
  - [X] Historial de Auditorías ✅ Menú navegable con submenús (Casos Aprobados, Rechazados, Solicitudes Info)
  - [X] ❌ **REMOVIDO**: Estadísticas Médicas (funcionalidad eliminada)
- [X] Vista especializada de casos médicos ✅ Dashboard completamente funcional
- [X] Sistema de alertas de nuevos casos ✅ Badge de notificación implementado

#### **Dashboard Médico Auditor Implementado:**
- [X] **5 Estadísticas de auditoría**: Pendientes, Autorizados, Rechazados, Info Solicitada, Tiempo Promedio
- [X] **Actividad Médica Reciente**: Reintegros autorizados, información solicitada, rechazados, casos en revisión
- [X] **3 Acciones médicas**: Revisar Pendientes (con contador), Info Solicitada (con contador), Historial Autorizados
- [X] **Sin tabla de reintegros pendientes** en dashboard (solo en menús laterales)
- [X] **Sin gestión de montos** (no ve temas de dinero)
- [X] **Sin casos urgentes** (el sistema no los contempla)

### 🚨 **2.3 Prototipos de Pantallas Principales (Solo UI)**

#### **Módulo de Accidentes**
- [ ] Pantalla: Listado de Accidentes (tabla estática)
- [ ] Pantalla: Registro de Accidente (formulario sin funcionalidad)
- [ ] Pantalla: Detalle de Accidente (vista estática)

#### **Módulo de Derivaciones**
- [ ] Pantalla: Generar Derivación (formulario mockup)
- [ ] Componente: Vista previa PDF de Derivación

#### **Módulo de Reintegros**
- [ ] Pantalla: Solicitar Reintegro (formulario mockup)
- [ ] Pantalla: Mis Reintegros (lista estática con estados)
- [ ] Pantalla: Auditoría de Reintegros (vista médico)
- [ ] Pantalla: Gestión de Pagos (vista admin)

#### **Otros Módulos**
- [ ] Pantalla: Gestión de Alumnos (CRUD mockup)
- [ ] Pantalla: Salidas Educativas (formulario y lista)
- [ ] Componente: Carga de archivos (UI only)
- [ ] Componente: Sistema de notificaciones (campanita con badge)

### ✅ **2.4 Validación con Cliente**
- [ ] Preparar demo navegable con datos de ejemplo
- [ ] Documentar flujos de navegación
- [ ] Recopilar feedback del cliente
- [ ] Documentar cambios solicitados

---

## 📋 **ETAPA 3: FUNCIONALIDAD BÁSICA**

### 🔌 **3.1 Controladores con Datos Simulados**

#### **Controladores Básicos**
- [ ] DashboardController - Vistas por rol
- [ ] AccidenteController - CRUD básico con arrays
- [ ] AlumnoController - Búsqueda simulada
- [ ] NotificacionController - Notificaciones fake

### 🔄 **3.2 Componentes Interactivos Básicos**

#### **Componentes JavaScript/Alpine.js**
- [ ] Búsqueda de alumnos (con datos locales)
- [ ] Filtros de fecha
- [ ] Modales de confirmación
- [ ] Tabs de navegación
- [ ] Contador de notificaciones

### 📊 **3.3 Flujos Completos Simulados**

#### **Flujo de Accidente**
- [ ] Crear accidente (guardar en sesión)
- [ ] Ver listado (desde array)
- [ ] Ver detalle (datos simulados)
- [ ] Generar derivación (PDF estático)

#### **Flujo de Reintegro**
- [ ] Solicitar reintegro (formulario completo)
- [ ] Simular estados (En proceso → Autorizado → Pagado)
- [ ] Vista de auditor (aprobar/rechazar simulado)
- [ ] Vista de admin (marcar como pagado)

### 🧪 **3.4 Testing de UX**
- [ ] Pruebas de navegación completa
- [ ] Verificar todos los flujos simulados
- [ ] Documentar problemas de usabilidad
- [ ] Ajustar según feedback

---

## 📋 **ETAPA 4: INTEGRACIÓN BACKEND COMPLETA**

### 📦 **4.1 Creación de Modelos Eloquent**

#### **Modelos de Usuario y Permisos**
- [X] Crear `app/Models/Role.php` ✅ **COMPLETADO**
  - [X] Definir fillable: nombre, descripcion, activo ✅
  - [X] Relación hasMany con User ✅
  - [X] Tabla 'roles' configurada ✅
- [ ] Crear `app/Models/Permission.php`
  - [ ] Definir fillable: name, guard_name
  - [ ] Relación belongsToMany con Role
- [X] Actualizar `app/Models/User.php` ✅ **COMPLETADO**
  - [X] Cambiar tabla a 'usuarios' ✅
  - [X] Definir todos los campos fillable ✅
  - [X] Implementar método isActive() ✅
  - [X] Implementar método getRolAttribute() ✅
  - [X] Relación belongsTo con Role ✅
  - [X] Eager loading configurado ✅
  - [X] Accessor rol_nombre implementado ✅

#### **Modelos de Entidades Principales**
- [ ] Crear `app/Models/Escuela.php`
  - [ ] Definir todos los campos fillable
  - [ ] Relaciones: alumnos, personal, usuarios, accidentes
  - [ ] Scope para escuelas activas
- [ ] Crear `app/Models/Alumno.php`
  - [ ] Definir todos los campos fillable
  - [ ] Relación belongsTo: escuela
  - [ ] Relación hasMany: accidentes
  - [ ] Accessor para nombre completo
- [ ] Crear `app/Models/Personal.php`
  - [ ] Definir todos los campos fillable
  - [ ] Relación belongsTo: escuela
  - [ ] Scope para beneficiarios SVO

#### **Modelos de Accidentes y Derivaciones**
- [ ] Crear `app/Models/Accidente.php`
  - [ ] Definir todos los campos fillable
  - [ ] Relaciones: alumno, escuela, usuario, derivaciones, reintegros
  - [ ] Generar número de expediente automático
  - [ ] Scope para accidentes por estado
- [ ] Crear `app/Models/Derivacion.php`
  - [ ] Definir todos los campos fillable
  - [ ] Relación belongsTo: accidente, prestador
  - [ ] Método para marcar como impresa
- [ ] Crear `app/Models/Prestador.php`
  - [ ] Definir todos los campos fillable
  - [ ] Scope para prestadores activos
  - [ ] Scope para sistema de emergencias

#### **Modelos de Reintegros**
- [ ] Crear `app/Models/Reintegro.php`
  - [ ] Definir todos los campos fillable
  - [ ] Relaciones: accidente, usuario_solicita, medico_auditor
  - [ ] Estados como constantes de clase
  - [ ] Scopes por estado
  - [ ] Relación hasMany: solicitudes_info
- [ ] Crear `app/Models/SolicitudInfoAuditor.php`
  - [ ] Definir todos los campos fillable
  - [ ] Relaciones: reintegro, auditor, usuario_responde

#### **Modelos de Archivos y Notificaciones**
- [ ] Crear `app/Models/ArchivoAdjunto.php`
  - [ ] Definir todos los campos fillable
  - [ ] Relación polimórfica (morphTo)
  - [ ] Validación de tipos permitidos
- [ ] Crear `app/Models/Notificacion.php`
  - [ ] Definir todos los campos fillable
  - [ ] Relación belongsTo: usuario_destino
  - [ ] Scope para no leídas
  - [ ] Método marcarComoLeida()

#### **Otros Modelos**
- [ ] Crear modelos para: SalidaEducativa, AlumnoSalida, Pasantia, Empleado, BeneficiarioSVO, Fallecimiento, DocumentoInstitucional, AuditoriaSistema

### 🔌 **4.2 Actualización de Controladores**

#### **Refactorizar Controladores Existentes**
- [X] DashboardController ✅ **COMPLETADO** - Detección automática de rol y redirección
- [ ] AccidenteController - Conectar con modelos reales
- [ ] DerivacionController - Generar PDFs dinámicos
- [ ] ReintegroController - Flujo completo con BD
- [ ] NotificacionController - Sistema real de notificaciones

#### **Nuevos Controladores**
- [ ] EscuelaController - Gestión de escuelas
- [ ] ❌ **REMOVIDO**: PrestadorController - Gestión de prestadores (funcionalidad eliminada)
- [ ] AuditoriaController - Log de cambios
- [X] CheckUserRole Middleware ✅ **COMPLETADO** - Control de acceso por roles

### 🔄 **4.3 Componentes Livewire**

#### **Componentes de Dashboard (COMPLETADOS)**
- [X] AdminDashboard ✅ **COMPLETADO** - Dashboard completo para administradores
- [X] MedicoDashboard ✅ **COMPLETADO** - Dashboard especializado para médicos auditores
- [X] EscuelaDashboard ✅ **COMPLETADO** - Dashboard específico para escuelas

#### **Componentes de Búsqueda**
- [ ] AlumnoSearch - Búsqueda en tiempo real
- [ ] EscuelaFilter - Filtro de escuelas
- [ ] DateRangePicker - Selector de fechas

#### **Componentes de Carga**
- [ ] FileUpload - Carga múltiple real
- [ ] FilePreview - Vista previa
- [ ] FileManager - Gestor de archivos

#### **Componentes de Estado**
- [ ] StatusBadge - Badge de estado dinámico
- [ ] ProgressTracker - Seguimiento de proceso
- [X] NotificationBell ✅ **IMPLEMENTADO** - Badge de notificación en menú médico auditor

### 📧 **4.4 Sistema de Notificaciones**

#### **Eventos y Listeners**
- [ ] ReintegroCreated → NotificarAuditor
- [ ] ReintegroAuthorized → NotificarAdmin
- [ ] ReintegroPaid → NotificarEscuela
- [ ] InfoRequested → NotificarEscuela

#### **Implementación**
- [ ] Configurar colas de trabajo
- [ ] Crear plantillas de notificación
- [ ] Sistema de preferencias de usuario

### 🛡️ **4.5 Middleware y Seguridad**

#### **Middleware**
- [X] CheckUserRole ✅ **COMPLETADO** - Verificar rol de usuario
- [ ] CheckSchool - Restricción por escuela
- [X] AuditoriaMiddleware ✅ **COMPLETADO** - Registro de actividad de operaciones

#### **Servicios de Auditoría**
- [X] AuditoriaService ✅ **COMPLETADO** - Servicio para logs de login/logout y operaciones

#### **Policies**
- [ ] AccidentePolicy - Permisos por escuela
- [ ] ReintegroPolicy - Permisos por rol
- [ ] UserPolicy - Solo administradores

### 📊 **4.6 Reportes y Exportaciones**

#### **Reportes Excel**
- [ ] Accidentes por período
- [ ] Reintegros por estado
- [ ] Estadísticas por escuela
- [ ] Resumen financiero

#### **Reportes PDF**
- [ ] Comprobante de reintegro
- [ ] Resumen mensual
- [ ] Planilla de presentaciones

### 🧪 **4.7 Testing Completo**

#### **Feature Tests**
- [ ] Test de autenticación por rol
- [ ] Test de creación de accidente
- [ ] Test de flujo completo de reintegro
- [ ] Test de restricciones por escuela

#### **Unit Tests**
- [ ] Test de modelos y relaciones
- [ ] Test de cálculos de montos
- [ ] Test de generación de números

### 🚀 **4.8 Optimización Final**

#### **Performance**
- [ ] Eager loading en consultas
- [ ] Caché de consultas frecuentes
- [ ] Índices en base de datos
- [ ] Compresión de assets

#### **UX/UI Final**
- [ ] Loading states reales
- [ ] Mensajes de error mejorados
- [ ] Animaciones y transiciones
- [ ] Tour de primera vez

---

## 📋 **CHECKLIST DE ENTREGA FINAL**

### 📝 **Documentación**
- [ ] Manual de usuario por rol
- [ ] Guía de instalación
- [ ] Documentación técnica
- [ ] Videos tutoriales

### 🔒 **Seguridad**
- [ ] Auditoría de seguridad completa
- [ ] Configuración de CORS
- [ ] Rate limiting
- [ ] Backup automático

### 🧪 **Pruebas Finales**
- [ ] Pruebas con usuarios reales
- [ ] Pruebas de carga
- [ ] Pruebas en diferentes navegadores
- [ ] Pruebas en dispositivos móviles

### 🚀 **Despliegue**
- [ ] Configuración de producción
- [ ] Migración de datos existentes
- [ ] Configuración de SSL
- [ ] Monitoreo de errores

---

## 🎯 **CRITERIOS DE ÉXITO**

- ✅ Todos los roles pueden realizar sus tareas específicas
- ✅ El flujo de reintegros funciona de principio a fin
- ✅ Las notificaciones llegan correctamente
- ✅ Los reportes se generan sin errores
- ✅ La aplicación es intuitiva y fácil de usar
- ✅ Tiempo de respuesta óptimo
- ✅ Cero errores críticos en producción

---

*Este checklist debe ser revisado y actualizado conforme avance el desarrollo del proyecto.*