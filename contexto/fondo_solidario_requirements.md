# 🏫 ALCANCE DEL PROYECTO - SISTEMA FONDO SOLIDARIO JAEC

## 📋 Introducción

El Fondo Solidario (FS) es un Fondo económico que integran un conjunto de Escuelas pertenecientes a la Organización que las aglutina, llamada JAEC (Junta Arquidiocesana de Educación Católica).

Dichas Escuelas aportan una cantidad de dinero "X" por cada alumno al FS. El fin es quedar cubiertos frente a accidentes que se den en el marco de la escuela.

### El FS cubre las siguientes contingencias:

1) **🚨 Accidentes médicos**: Cuando un niño sufre un accidente o tiene un malestar, la Escuela activa un Protocolo llamando al Sistema de Emergencias y Urgencias médicas (provisto por el FS). Si los médicos que van a la Escuela sugieren una derivación a una Clínica u Hospital para su atención, o de ser necesario algún gasto farmacéutico, o una operación, etc., el Fondo Solidario es el encargado de cubrir el costo de esas contingencias. De ahí que dicha derivación / gasto deba ser registrado en un sistema informático.

2) **🚌 Salidas educativas**: Toda salida de la Escuela también debe ser informada.

3) **⚰️ Fallecimientos**: Todo fallecimiento de personal de la Escuela es informado detalladamente.

> **📌 NOTA IMPORTANTE:** En el sistema actual, "Denuncias" = "Accidentes" (son términos equivalentes)

## 🚨 **PROTOCOLO DE EMERGENCIAS MÉDICAS**

### 📋 **Flujo del Protocolo:**
1. **Accidente en la Escuela**: Ocurre incidente con alumno
2. **Activación del Protocolo**: Escuela llama al Sistema de Emergencias y Urgencias médicas (provisto por el FS)
3. **Llegada de Médicos**: Profesionales van a la Escuela para evaluación
4. **Evaluación Médica**: Los médicos determinan si requiere derivación
5. **Generación de Derivación**: Si es necesario, se crea derivación en el sistema
6. **Documento Físico**: Se imprime derivación con sello y firma de escuela
7. **Traslado**: Adultos acompañantes llevan documento al prestador médico
8. **Atención Médica**: Prestador atiende al alumno con la derivación oficial

### 🏥 **Cobertura del Fondo Solidario:**
- Atención médica en clínicas y hospitales derivados
- Gastos farmacéuticos relacionados con el accidente
- Operaciones y tratamientos necesarios
- Estudios médicos complementarios
- **Todos los gastos deben registrarse en el sistema para reintegro**

---

## 🔄 **FLUJO DE TRABAJO COMPLETO - REINTEGROS**

### 📝 **Proceso Paso a Paso:**

1. **👤 Usuario General (Escuela)**
   - Registra accidente en el sistema ✅
   - Sube facturas/tickets médicos 📎
   - **Estado inicial**: *"En proceso"* 🟡

2. **🔔 Notificación Automática**
   - Sistema envía alerta al Médico Auditor 📧
   - Email automático con detalles del caso

3. **👨‍⚕️ Médico Auditor**
   - Recibe notificación y revisa documentación 🔍
   - **Opción A**: Puede solicitar más información 📋
     - Usuario recibe notificación automática 🔔
     - Usuario carga documentos faltantes 📎
     - Auditor recibe nueva notificación
   - **Opción B**: Autoriza o rechaza directamente ✅❌
   - Si autoriza → **Estado**: *"Autorizado"* 🟢
   - Si rechaza → **Estado**: *"Rechazado"* 🔴

4. **👨‍💼 Administrador JAEC**
   - Recibe notificación de reintegro autorizado 📧
   - Procesa el pago bancario 💳
   - Registra número de transferencia 🏦
   - **Estado final**: *"Pagado"* ✅

5. **👤 Usuario General (Escuela)**
   - Ve el estado actualizado en tiempo real ✅
   - Recibe notificación automática de pago 📧
   - Puede imprimir comprobante del proceso

---

## 🎯 Propósito del Proyecto

Desarrollar un sitio web que permita a los usuarios registrarse, iniciar sesión, recuperar sus contraseñas y gestionar información completa a través de formularios web y subida de archivos (PDF, JPG, PNG) relacionados con:
- Accidentes escolares
- Salidas educativas  
- Pasantías
- Empleados
- Beneficiarios de seguro de vida (SVO)

El objetivo es crear una plataforma simple, segura y eficiente donde los usuarios puedan gestionar sus cuentas y enviar documentos e información importantes a la Organización central (JAEC), quien gestiona el FS.

### 📊 Situación Actual
- **Sistema en uso**: www.jaeccba.org → Fondo Solidario (credenciales: Usuario: Julieta, Clave: juntaJAEC891)
- **Sistema inconcluso**: https://juntadev.jaeccba.org/denuncias/create (desarrollador venezolano dejó de responder hace más de dos meses)
- **Hospedaje**: Servidor bajo dominio www.jaeccba.org gestionado por personal de informática de JAEC

---

## 👥 DEFINICIÓN DE ROLES Y ACCESOS

### 👤 **ROL: USUARIO GENERAL** (Personal de Escuela)
*Personal administrativo, preceptores, secretarios de escuelas*

#### 📋 **FUNCIONALIDADES DISPONIBLES:**

##### 🎯 **DASHBOARD ESCUELA**
- **📊 Estadísticas de la Escuela (4 métricas):**
  - Accidentes Reportados (12 - ↑ 2 este mes)
  - Alumnos Registrados (450 - ↑ 15 este mes)
  - Reintegros Pendientes (3 - En proceso)
  - Documentos Subidos (28 - ↑ 8 esta semana)

- **📋 Actividad Reciente:**
  - Accidentes reportados
  - Reintegros autorizados
  - Derivaciones generadas

- **⚡ Acciones Rápidas (Dashboard):**
  - Reportar Accidente
  - Registrar Alumno
  - Generar Derivación
  - Subir Documentos

##### � **GESTIÓN DE ACCIDENTES**
- ✅ Registrar nuevo accidente con datos completos del alumno:
  - Nombre, apellido, sala, grado o curso
  - Sección (A,B,C,D), DNI y CUIL
  - Nombre de padre/madre y contacto telefónico de la familia
- ✅ Ver accidentes de su escuela únicamente
- ✅ **Generar derivación médica** a prestadores pre-cargados del sistema
- ✅ **Imprimir derivación médica** con sello y firma de escuela (documento físico para presentar en prestador)
- ✅ Activar protocolo de emergencias médicas cuando corresponda
- ✅ Subir facturas/tickets para solicitud de reintegro
- ✅ **Ver estado de reintegros en tiempo real** (en proceso/autorizado/pagado)
- ✅ Adjuntar documentos relacionados (fotos, informes médicos)
- ✅ Responder a solicitudes de información adicional del auditor
- ✅ Organizar archivos por "carpeta" de accidente específico
- ❌ **NO puede** autorizar reintegros
- ❌ **NO puede** ver accidentes de otras escuelas
- ❌ **NO requiere autorización** para generar derivaciones (solo registro)

##### 👦 **GESTIÓN DE ALUMNOS**
- ✅ Registrar nuevo alumno
- ✅ Modificar datos de alumnos de su escuela
- ✅ Buscar alumnos de su escuela
- ❌ **NO puede** ver alumnos de otras escuelas

##### 🚌 **SALIDAS EDUCATIVAS**
- ✅ Registrar nueva salida educativa
- ✅ Cargar lista de alumnos participantes
- ✅ Subir autorizaciones de padres
- ✅ Ver historial de salidas de su escuela

##### 💼 **PASANTÍAS**
- ✅ Registrar nueva pasantía
- ✅ Cargar datos de empresa y alumno
- ✅ Ver pasantías activas de su escuela

##### 👥 **GESTIÓN DE PERSONAL**
- ✅ Ver lista de empleados de su escuela
- ✅ Registrar beneficiarios SVO (Seguro de Vida Obligatorio)
- ✅ Reportar fallecimientos de personal
- ❌ **NO puede** dar de alta/baja empleados

### 📋 **FORMULARIOS ESPECÍFICOS DEL SISTEMA**

#### 🚨 **Formulario de Accidente**
- Datos del alumno (nombre, apellido, sala, grado, sección A/B/C/D)
- DNI y CUIL del alumno
- Datos de contacto familiar (padre/madre, teléfono)
- Detalles del accidente ocurrido
- Hora y fecha del incidente
- **Nota**: Los campos específicos están definidos en el sistema actual y requieren mejoras

#### 🏥 **Formulario de Derivación**
- Datos del accidente relacionado
- Prestador médico seleccionado (de lista pre-cargada)
- Tipo de derivación (emergencia, consulta, especialista)
- **Resultado**: Documento imprimible con sello y firma oficial

#### 🚌 **Formulario de Salida Educativa**
- Destino y propósito de la salida
- Lista de alumnos participantes
- Fechas y horarios
- Responsables acompañantes
- Documentación de autorizaciones parentales

#### 💼 **Formulario de Pasantía**
- Datos del alumno participante
- Información de la empresa receptora
- Período de la pasantía
- Supervisor responsable

#### 👥 **Formulario de Empleados**
- Datos personales del empleado
- Cargo y función en la escuela
- Información contractual
- Beneficiarios de SVO (Seguro de Vida Obligatorio)

#### ⚰️ **Formulario de Beneficiarios SVO**
- Datos del fallecido (empleado de la escuela)
- Información detallada del deceso
- Beneficiarios designados
- Documentación requerida para el seguro

##### 📄 **DOCUMENTOS**
- ✅ Subir documentos institucionales
- ✅ Ver documentos de su escuela
- ✅ Subida ilimitada de archivos (PDF, JPG, PNG)

##### 👤 **CUENTA PERSONAL**
- ✅ Cambiar contraseña
- ✅ Ver notificaciones del sistema
- ✅ Actualizar datos personales

---

### 👨‍💼 **ROL: ADMINISTRADOR** (Personal JAEC)
*Personal administrativo de la Junta Arquidiocesana*

#### 📋 **FUNCIONALIDADES DISPONIBLES:**

##### 🎯 **DASHBOARD ADMINISTRADOR**
- **📊 Estadísticas Principales:**
  - Escuelas Activas (25 escuelas - ↑ 2 este año)
  - Total Accidentes (340 - ↑ 45 este mes)
  - Reintegros Autorizados (28 - ↑ 8 esta semana)
  - Monto Total Pagado ($125,400 - ↑ $15,200 este mes)

- **📋 Actividad Reciente del Sistema:**
  - Nueva escuela registrada
  - Reintegros pagados
  - Nuevos usuarios creados
  - Prestadores actualizados

- **⚡ Acciones de Gestión Administrativa:**
  - Administración (Escuelas, Empleados, Salidas Educativas, Pasantías, Beneficiarios SVO, Derivaciones)
  - Gestión (Accidentes, Reintegros, Gestión de Pagos)
  - Gestionar Usuarios
  - Auditoría Sistema

- **🏫 Tabla Resumen por Escuela:**
  - Escuela | Accidentes | Reintegros | Monto Pendiente
  - Sin columna de acciones (solo información)

##### 🚨 **GESTIÓN DE ACCIDENTES (Solo Visualización)**
- ✅ Ver **TODOS** los accidentes del sistema (todas las escuelas)
- ✅ **Sistema de filtros avanzados:**
  - 📅 Más recientes
  - 📆 Por mes específico
  - 🏥 Por prestador médico
  - 🏫 Por escuela
- ✅ Ver expedientes completos con toda la documentación
- ❌ **NO puede** registrar accidentes (solo usuarios de escuelas)
- ❌ **NO puede** autorizar reintegros médicos (solo el Médico Auditor)

##### 💰 **GESTIÓN DE REINTEGROS**
- ✅ Ver todas las solicitudes de reintegro del sistema
- ✅ Procesar pagos y marcar reintegros como pagados
- ✅ Registrar números de transferencia bancaria
- ✅ Ver historial completo de pagos realizados
- ❌ **NO puede** autorizar montos (solo el Médico Auditor puede hacerlo)

##### 🏫 **GESTIÓN DE ESCUELAS**
- ✅ Gestionar escuelas (alta/baja/modificación)
- ✅ Modificar datos institucionales de escuelas
- ✅ Configurar montos de aportes por alumno
- ✅ Ver estadísticas por escuela
- ✅ Activar/desactivar escuelas del sistema

##### 👥 **GESTIÓN COMPLETA DE USUARIOS**
- ✅ **Crear nuevos usuarios** (NO existe auto-registro)
- ✅ Asignar roles específicos (Usuario General, Administrador, Médico Auditor)
- ✅ Asignar usuarios a escuelas específicas
- ✅ Agregar, editar o eliminar cuentas de usuario
- ✅ Enviar correos de confirmación para verificar cuentas

##### 🔍 **AUDITORÍA DEL SISTEMA**
- ✅ **Accesos al Sistema**: Ver login/logout de usuarios
- ✅ **Operaciones**: Ver todas las creaciones y modificaciones del sistema
- ✅ Logs completos de auditoría
- ✅ Seguimiento de actividad por usuario

##### ❌ **FUNCIONALIDADES REMOVIDAS**
- ❌ **NO gestiona** prestadores médicos (funcionalidad eliminada)
- ❌ **NO genera** reportes automáticos (funcionalidad eliminada)
- ❌ **NO ve** usuarios por escuela por separado (están en gestión general)

---

### 👨‍⚕️ **ROL: MÉDICO AUDITOR**
*Profesional médico especializado en evaluación de reintegros*

#### 📋 **FUNCIONALIDADES DISPONIBLES:**

##### 🎯 **DASHBOARD MÉDICO AUDITOR**
- **📊 Estadísticas de Auditoría (5 métricas):**
  - Pendientes Auditoría (15 - ↑ 5 nuevos hoy)
  - Autorizados (28 - ↑ 8 esta semana)
  - Rechazados (7 - ↑ 2 esta semana)
  - Info. Solicitada (12 - ↑ 3 pendientes)
  - Tiempo Promedio (2.5 días - ↓ 0.5 días vs mes anterior)

- **📋 Actividad Médica Reciente:**
  - Reintegros autorizados
  - Información solicitada
  - Reintegros rechazados
  - Casos en revisión

- **⚡ Acciones Médicas (Dashboard):**
  - Revisar Pendientes (con contador)
  - Info. Solicitada (con contador)
  - Historial Autorizados

#####  **AUDITORÍA MÉDICA ESPECIALIZADA**
- ✅ Ver solicitudes de reintegro pendientes de autorización
- ✅ Revisar documentación médica adjunta (recetas, estudios, facturas)
- ✅ **Autorizar o rechazar reintegros** con criterio médico
- ✅ **Solicitar información adicional** a las escuelas
- ✅ Agregar observaciones médicas detalladas
- ✅ Ver historial completo de auditorías realizadas

##### 🚨 **CONSULTA MÉDICA DE ACCIDENTES**
- ✅ Ver detalles médicos específicos de accidentes
- ✅ Revisar diagnósticos y tratamientos prescriptos
- ✅ Analizar derivaciones médicas realizadas
- ❌ **NO puede** modificar datos originales del accidente

##### 📬 **SISTEMA DE NOTIFICACIONES MÉDICAS**
- ✅ Alertas automáticas de nuevos reintegros para auditar
- ✅ Notificaciones de respuestas a solicitudes de información

##### ❌ **FUNCIONALIDADES REMOVIDAS**
- ❌ **NO modifica** montos a reintegrar (no ve temas de dinero)
- ❌ **NO gestiona** casos urgentes (el sistema no los contempla)
- ❌ **NO genera** reportes médicos automáticos (funcionalidad eliminada)
- ❌ **NO ve** estadísticas médicas generales (funcionalidad eliminada)
- ❌ **NO ve** tabla de reintegros pendientes en el dashboard (solo en menús)

---

## ⚖️ **FLUJOS DE TRABAJO SIN AUTORIZACIÓN**

### 📝 **Registros que NO Requieren Autorización:**
- **Accidentes**: Solo registro e información
- **Derivaciones**: Generación automática una vez registrado el accidente  
- **Salidas Educativas**: Solo registro informativo
- **Pasantías**: Solo registro informativo
- **Empleados**: Solo gestión de datos
- **Beneficiarios SVO**: Solo registro de información

#### 💰 **ÚNICO FLUJO CON AUTORIZACIÓN: Reintegros Médicos**
Solo las solicitudes de reintegro farmacéutico/médico requieren:
1. Auditoría médica (Médico Auditor)
2. Autorización de pago (Administrador JAEC)
3. Seguimiento de estado por parte de la escuela

---

### 📝 **Proceso Paso a Paso:**

1. **👤 Usuario General (Escuela)**
   - Registra accidente en el sistema ✅
   - Sube facturas/tickets médicos 📎
   - **Estado inicial**: *"En proceso"* 🟡

2. **🔔 Notificación Automática**
   - Sistema envía alerta al Médico Auditor 📧
   - Email automático con detalles del caso

3. **👨‍⚕️ Médico Auditor**
   - Recibe notificación y revisa documentación 🔍
   - **Opción A**: Puede solicitar más información 📋
     - Usuario recibe notificación automática 🔔
     - Usuario carga documentos faltantes 📎
     - Auditor recibe nueva notificación
   - **Opción B**: Autoriza o rechaza directamente ✅❌
   - Si autoriza → **Estado**: *"Autorizado"* 🟢
   - Si rechaza → **Estado**: *"Rechazado"* 🔴

4. **👨‍💼 Administrador JAEC**
   - Recibe notificación de reintegro autorizado 📧
   - Procesa el pago bancario 💳
   - Registra número de transferencia 🏦
   - **Estado final**: *"Pagado"* ✅

5. **👤 Usuario General (Escuela)**
   - Ve el estado actualizado en tiempo real ✅
   - Recibe notificación automática de pago 📧
   - Puede imprimir comprobante del proceso

---

## 🔐 **MATRIZ DE PERMISOS DEL SISTEMA**

| **Funcionalidad** | **Usuario General** | **Administrador** | **Médico Auditor** |
|-------------------|-------------------|------------------|-------------------|
| Ver su escuela | ✅ | ✅ | ✅ |
| Ver todas las escuelas | ❌ | ✅ | ✅ |
| Registrar accidentes | ✅ | ❌ | ❌ |
| Ver todos los accidentes | ❌ | ✅ | ✅ |
| Autorizar reintegros | ❌ | ❌ | ✅ |
| Procesar pagos | ❌ | ✅ | ❌ |
| Gestionar usuarios | ❌ | ✅ | ❌ |
| Ver reportes generales | ❌ | ✅ | ✅* |
| Solicitar más información | ❌ | ❌ | ✅ |
| Crear usuarios | ❌ | ✅ | ❌ |
| Filtros avanzados | ❌ | ✅ | ✅* |

*Solo funciones relacionadas con aspectos médicos

---

## 💻 **ESPECIFICACIONES TÉCNICAS**

### 🔐 **Sistema de Autenticación**
- **NO existe auto-registro**: Todos los usuarios son creados por JAEC
- **Verificación por email**: Al crear la cuenta, se envía correo de confirmación
- **Recuperación de contraseña**: Por email personal del usuario (JAEC no gestiona este proceso)
- **Asignación específica**: Cada usuario se asigna a su escuela correspondiente
- **Sesiones seguras**: Control de acceso por rol específico
- **Credenciales actuales del sistema**: Usuario: Julieta, Clave: juntaJAEC891

### 📎 **Gestión de Archivos**
- **Formatos soportados**: PDF, JPG, PNG
- **Límite de archivos**: Ilimitado (archivos generalmente pequeños)
- **Organización**: Por "carpetas" de accidente específico
- **Confirmación**: Mensaje de éxito al subir archivos
- **Seguridad**: Almacenamiento seguro de toda la documentación

### 🖨️ **Funcionalidades de Impresión**
- **Derivaciones médicas**: Con sello de escuela y firma oficial
- **Planillas de resumen**: Vista simplificada y ordenada
- **Reportes**: Exportación a PDF y Excel
- **Comprobantes**: De reintegros procesados

### 📧 **Sistema de Notificaciones**
- **Automáticas por email** para todos los cambios de estado
- **Alertas en tiempo real** dentro del sistema
- **Notificaciones específicas** según el rol del usuario

### 📱 **Compatibilidad y Acceso**
- **Responsive**: Acceso desde computadoras y dispositivos móviles
- **Integración web**: Acceso desde menú de www.jaeccba.org
- **Velocidad**: Carga en máximo 2 segundos
- **Usabilidad**: Interfaz intuitiva para usuarios no técnicos

---

## 🎨 **ESPECIFICACIONES DE DISEÑO**

### ✨ **Características Visuales**
- **Aspecto**: Limpio, moderno y profesional
- **Navegación**: Intuitiva y clara
- **Mensajes**: Instrucciones claras en cada proceso
- **Accesibilidad**: Compatible con estándares web

### 📊 **Dashboard por Rol**
- **Usuario General**: Vista centrada en su escuela
- **Administrador**: Dashboard completo con métricas globales
- **Médico Auditor**: Vista especializada en casos médicos

---

## 🔒 **CONSIDERACIONES DE SEGURIDAD**

### 🛡️ **Protección de Datos**
- Encriptación de contraseñas y datos sensibles
- Acceso controlado por roles específicos
- Logs de auditoría de todas las acciones
- Backup automático de información crítica

### 🔍 **Control de Acceso**
- Verificación de permisos en cada funcionalidad
- Sesiones con tiempo de expiración
- Protección contra accesos no autorizados
- Separación estricta de datos por escuela

---

## 📈 **MÉTRICAS DE ÉXITO**

### 🎯 **Objetivos Medibles**
- **Tiempo de registro de accidentes**: Reducir a menos de 5 minutos
- **Tiempo de procesamiento de reintegros**: Máximo 5 días hábiles
- **Satisfacción del usuario**: Interfaz intuitiva sin necesidad de capacitación extensa
- **Disponibilidad del sistema**: 99.9% uptime
- **Adopción**: 100% de escuelas migrando del sistema actual

---

## 🚀 **FUNCIONALIDADES FUTURAS (Fuera del Alcance Actual)**
- App móvil nativa
- Integración con sistemas contables
- API para terceros
- Dashboard analítico avanzado con BI
- Integración con prestadores médicos

---

*Este documento constituye el alcance completo del proyecto Sistema Fondo Solidario JAEC y debe ser aprobado antes del inicio del desarrollo.*