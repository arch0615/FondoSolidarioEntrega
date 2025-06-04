# DICCIONARIO DE DATOS - SISTEMA FONDO SOLIDARIO JAEC

## RESUMEN DEL SISTEMA
- **Total de tablas:** 19
- **Roles del sistema:** Usuario General, Administrador, Médico Auditor
- **Estados de reintegro:** En proceso, Autorizado, Pagado
- **Nota importante:** Las "denuncias" mencionadas en las pantallas son equivalentes a "accidentes"

## 1. TABLA: ROLES
- **Nombre Lógico:** Roles de Usuario
- **Nombre Físico:** roles
- **Descripción:** Catálogo de roles disponibles en el sistema (Usuario General, Administrador, Médico Auditor)

| Nombre Físico | Nombre Lógico | Identificador | Tipo de Dato | Tipo de Captura | Relación | Tabla Relacionada |
|---|---|---|---|---|---|---|
| id_rol | ID del Rol | SI (Autonumérico) | Numérico Entero | - | NO | - |
| nombre_rol | Nombre del Rol | NO | Alfanumérico(50) | Captura Libre | NO | - |
| descripcion | Descripción | NO | Alfanumérico(200) | Captura Libre | NO | - |
| activo | Estado Activo | NO | Lógico | Checkbox | NO | - |

## 2. TABLA: ESCUELAS
- **Nombre Lógico:** Escuelas Afiliadas
- **Nombre Físico:** escuelas
- **Descripción:** Catálogo de escuelas pertenecientes a JAEC que aportan al Fondo Solidario

| Nombre Físico | Nombre Lógico | Identificador | Tipo de Dato | Tipo de Captura | Relación | Tabla Relacionada |
|---|---|---|---|---|---|---|
| id_escuela | ID de Escuela | SI (Autonumérico) | Numérico Entero | - | NO | - |
| codigo_escuela | Código de Escuela | NO | Alfanumérico(20) | Captura Libre | NO | - |
| nombre | Nombre de Escuela | NO | Alfanumérico(200) | Captura Libre | NO | - |
| direccion | Dirección | NO | Alfanumérico(300) | Captura Libre | NO | - |
| telefono | Teléfono | NO | Alfanumérico(50) | Captura Libre | NO | - |
| email | Correo Electrónico | NO | Alfanumérico(100) | Captura Libre | NO | - |
| aporte_por_alumno | Aporte por Alumno | NO | Moneda | Captura Libre | NO | - |
| fecha_alta | Fecha de Alta | NO | Fecha | DatePicker | NO | - |
| activo | Estado Activo | NO | Lógico | Checkbox | NO | - |

## 3. TABLA: USUARIOS
- **Nombre Lógico:** Usuarios del Sistema
- **Nombre Físico:** usuarios
- **Descripción:** Usuarios registrados en el sistema con acceso autorizado

| Nombre Físico | Nombre Lógico | Identificador | Tipo de Dato | Tipo de Captura | Relación | Tabla Relacionada |
|---|---|---|---|---|---|---|
| id_usuario | ID de Usuario | SI (Autonumérico) | Numérico Entero | - | NO | - |
| email | Correo Electrónico | NO | Alfanumérico(100) | Captura Libre | NO | - |
| password | Contraseña | NO | Alfanumérico(255) | Captura Libre | NO | - |
| nombre | Nombre | NO | Alfanumérico(100) | Captura Libre | NO | - |
| apellido | Apellido | NO | Alfanumérico(100) | Captura Libre | NO | - |
| id_rol | ID del Rol | NO | Numérico Entero | Selección | SI | roles |
| id_escuela | ID de Escuela | NO | Numérico Entero | Selección | SI | escuelas |
| fecha_registro | Fecha de Registro | NO | Fecha | - | NO | - |
| email_verificado | Email Verificado | NO | Lógico | - | NO | - |
| token_verificacion | Token Verificación | NO | Alfanumérico(255) | - | NO | - |
| activo | Estado Activo | NO | Lógico | Checkbox | NO | - |

## 4. TABLA: ALUMNOS
- **Nombre Lógico:** Alumnos
- **Nombre Físico:** alumnos
- **Descripción:** Registro de alumnos de las escuelas afiliadas

| Nombre Físico | Nombre Lógico | Identificador | Tipo de Dato | Tipo de Captura | Relación | Tabla Relacionada |
|---|---|---|---|---|---|---|
| id_alumno | ID del Alumno | SI (Autonumérico) | Numérico Entero | - | NO | - |
| id_escuela | ID de Escuela | NO | Numérico Entero | Selección | SI | escuelas |
| nombre | Nombre | NO | Alfanumérico(100) | Captura Libre | NO | - |
| apellido | Apellido | NO | Alfanumérico(100) | Captura Libre | NO | - |
| dni | DNI | NO | Alfanumérico(10) | Captura Libre | NO | - |
| cuil | CUIL | NO | Alfanumérico(15) | Captura Libre | NO | - |
| sala_grado_curso | Sala/Grado/Curso | NO | Alfanumérico(50) | Captura Libre | NO | - |
| seccion | Sección | NO | Alfanumérico(5) | Selección | NO | - |
| nombre_padre_madre | Nombre Padre/Madre | NO | Alfanumérico(200) | Captura Libre | NO | - |
| telefono_contacto | Teléfono de Contacto | NO | Alfanumérico(50) | Captura Libre | NO | - |
| fecha_nacimiento | Fecha de Nacimiento | NO | Fecha | DatePicker | NO | - |
| activo | Estado Activo | NO | Lógico | Checkbox | NO | - |

## 5. TABLA: PRESTADORES
- **Nombre Lógico:** Prestadores Médicos
- **Nombre Físico:** prestadores
- **Descripción:** Catálogo de clínicas, hospitales y prestadores médicos asociados

| Nombre Físico | Nombre Lógico | Identificador | Tipo de Dato | Tipo de Captura | Relación | Tabla Relacionada |
|---|---|---|---|---|---|---|
| id_prestador | ID del Prestador | SI (Autonumérico) | Numérico Entero | - | NO | - |
| nombre | Nombre del Prestador | NO | Alfanumérico(200) | Captura Libre | NO | - |
| tipo_prestador | Tipo de Prestador | NO | Alfanumérico(50) | Selección | NO | - |
| es_sistema_emergencias | Es Sistema de Emergencias | NO | Lógico | Checkbox | NO | - |
| direccion | Dirección | NO | Alfanumérico(300) | Captura Libre | NO | - |
| telefono | Teléfono | NO | Alfanumérico(50) | Captura Libre | NO | - |
| email | Correo Electrónico | NO | Alfanumérico(100) | Captura Libre | NO | - |
| especialidades | Especialidades | NO | Alfanumérico(500) | Captura Libre | NO | - |
| activo | Estado Activo | NO | Lógico | Checkbox | NO | - |

## 6. TABLA: ACCIDENTES
- **Nombre Lógico:** Registro de Accidentes
- **Nombre Físico:** accidentes
- **Descripción:** Expediente principal de accidentes escolares que agrupa derivaciones y reintegros

| Nombre Físico | Nombre Lógico | Identificador | Tipo de Dato | Tipo de Captura | Relación | Tabla Relacionada |
|---|---|---|---|---|---|---|
| id_accidente | ID del Accidente | SI (Autonumérico) | Numérico Entero | - | NO | - |
| numero_expediente | Número de Expediente | NO | Alfanumérico(20) | - | NO | - |
| id_escuela | ID de Escuela | NO | Numérico Entero | - | SI | escuelas |
| id_alumno | ID del Alumno | NO | Numérico Entero | Selección | SI | alumnos |
| id_usuario_carga | ID Usuario que Carga | NO | Numérico Entero | - | SI | usuarios |
| fecha_accidente | Fecha del Accidente | NO | Fecha | DatePicker | NO | - |
| hora_accidente | Hora del Accidente | NO | Hora | HourPicker | NO | - |
| lugar_accidente | Lugar del Accidente | NO | Alfanumérico(200) | Captura Libre | NO | - |
| descripcion_accidente | Descripción del Accidente | NO | Alfanumérico(1000) | Captura Libre | NO | - |
| tipo_lesion | Tipo de Lesión | NO | Alfanumérico(200) | Captura Libre | NO | - |
| protocolo_activado | Protocolo Activado | NO | Lógico | Checkbox | NO | - |
| llamada_emergencia | Se llamó a Emergencia | NO | Lógico | Checkbox | NO | - |
| hora_llamada | Hora de Llamada | NO | Hora | HourPicker | NO | - |
| servicio_emergencia | Servicio de Emergencia | NO | Alfanumérico(100) | Captura Libre | NO | - |
| estado | Estado del Expediente | NO | Alfanumérico(50) | Selección | NO | - |
| fecha_carga | Fecha de Carga | NO | Fecha | - | NO | - |

## 7. TABLA: DERIVACIONES
- **Nombre Lógico:** Derivaciones Médicas
- **Nombre Físico:** derivaciones
- **Descripción:** Registro de derivaciones a prestadores médicos asociadas a un accidente

| Nombre Físico | Nombre Lógico | Identificador | Tipo de Dato | Tipo de Captura | Relación | Tabla Relacionada |
|---|---|---|---|---|---|---|
| id_derivacion | ID de Derivación | SI (Autonumérico) | Numérico Entero | - | NO | - |
| id_accidente | ID del Accidente | NO | Numérico Entero | - | SI | accidentes |
| id_prestador | ID del Prestador | NO | Numérico Entero | Selección | SI | prestadores |
| fecha_derivacion | Fecha de Derivación | NO | Fecha | DatePicker | NO | - |
| hora_derivacion | Hora de Derivación | NO | Hora | HourPicker | NO | - |
| medico_deriva | Médico que Deriva | NO | Alfanumérico(200) | Captura Libre | NO | - |
| diagnostico_inicial | Diagnóstico Inicial | NO | Alfanumérico(500) | Captura Libre | NO | - |
| acompañante | Acompañante | NO | Alfanumérico(200) | Captura Libre | NO | - |
| observaciones | Observaciones | NO | Alfanumérico(1000) | Captura Libre | NO | - |
| sello_escuela | Sello de Escuela | NO | File Upload | File Upload | NO | - |
| firma_autorizada | Firma Autorizada | NO | Alfanumérico(200) | Captura Libre | NO | - |
| impresa | Fue Impresa | NO | Lógico | - | NO | - |
| fecha_impresion | Fecha de Impresión | NO | Fecha | - | NO | - |

## 8. TABLA: REINTEGROS
- **Nombre Lógico:** Reintegros de Gastos
- **Nombre Físico:** reintegros
- **Descripción:** Solicitudes de reintegro de gastos médicos y farmacéuticos

| Nombre Físico | Nombre Lógico | Identificador | Tipo de Dato | Tipo de Captura | Relación | Tabla Relacionada |
|---|---|---|---|---|---|---|
| id_reintegro | ID del Reintegro | SI (Autonumérico) | Numérico Entero | - | NO | - |
| id_accidente | ID del Accidente | NO | Numérico Entero | - | SI | accidentes |
| id_usuario_solicita | ID Usuario Solicita | NO | Numérico Entero | - | SI | usuarios |
| fecha_solicitud | Fecha de Solicitud | NO | Fecha | - | NO | - |
| tipo_gasto | Tipo de Gasto | NO | Alfanumérico(50) | Selección | NO | - |
| descripcion_gasto | Descripción del Gasto | NO | Alfanumérico(500) | Captura Libre | NO | - |
| monto_solicitado | Monto Solicitado | NO | Moneda | Captura Libre | NO | - |
| estado | Estado del Reintegro | NO | Alfanumérico(50) | Selección | NO | - |
| requiere_mas_info | Requiere Más Información | NO | Lógico | - | NO | - |
| id_medico_auditor | ID Médico Auditor | NO | Numérico Entero | - | SI | usuarios |
| fecha_auditoria | Fecha de Auditoría | NO | Fecha | - | NO | - |
| observaciones_auditor | Observaciones Auditor | NO | Alfanumérico(1000) | Captura Libre | NO | - |
| monto_autorizado | Monto Autorizado | NO | Moneda | Captura Libre | NO | - |
| fecha_autorizacion | Fecha de Autorización | NO | Fecha | - | NO | - |
| fecha_pago | Fecha de Pago | NO | Fecha | DatePicker | NO | - |
| numero_transferencia | Número de Transferencia | NO | Alfanumérico(50) | Captura Libre | NO | - |

## 9. TABLA: ARCHIVOS_ADJUNTOS
- **Nombre Lógico:** Archivos Adjuntos
- **Nombre Físico:** archivos_adjuntos
- **Descripción:** Archivos adjuntos asociados a diferentes entidades del sistema

| Nombre Físico | Nombre Lógico | Identificador | Tipo de Dato | Tipo de Captura | Relación | Tabla Relacionada |
|---|---|---|---|---|---|---|
| id_archivo | ID del Archivo | SI (Autonumérico) | Numérico Entero | - | NO | - |
| tipo_entidad | Tipo de Entidad | NO | Alfanumérico(50) | - | NO | - |
| id_entidad | ID de la Entidad | NO | Numérico Entero | - | NO | - |
| nombre_archivo | Nombre del Archivo | NO | Alfanumérico(255) | - | NO | - |
| tipo_archivo | Tipo de Archivo | NO | Alfanumérico(10) | - | NO | - |
| tamaño | Tamaño (bytes) | NO | Numérico Entero | - | NO | - |
| ruta_archivo | Ruta del Archivo | NO | File Upload | File Upload | NO | - |
| descripcion | Descripción | NO | Alfanumérico(500) | Captura Libre | NO | - |
| id_usuario_carga | ID Usuario que Carga | NO | Numérico Entero | - | SI | usuarios |
| fecha_carga | Fecha de Carga | NO | Fecha | - | NO | - |

## 10. TABLA: SALIDAS_EDUCATIVAS
- **Nombre Lógico:** Salidas Educativas
- **Nombre Físico:** salidas_educativas
- **Descripción:** Registro de salidas educativas de las escuelas

| Nombre Físico | Nombre Lógico | Identificador | Tipo de Dato | Tipo de Captura | Relación | Tabla Relacionada |
|---|---|---|---|---|---|---|
| id_salida | ID de la Salida | SI (Autonumérico) | Numérico Entero | - | NO | - |
| id_escuela | ID de Escuela | NO | Numérico Entero | - | SI | escuelas |
| id_usuario_carga | ID Usuario que Carga | NO | Numérico Entero | - | SI | usuarios |
| fecha_salida | Fecha de Salida | NO | Fecha | DatePicker | NO | - |
| hora_salida | Hora de Salida | NO | Hora | HourPicker | NO | - |
| hora_regreso | Hora de Regreso | NO | Hora | HourPicker | NO | - |
| destino | Destino | NO | Alfanumérico(300) | Captura Libre | NO | - |
| proposito | Propósito | NO | Alfanumérico(500) | Captura Libre | NO | - |
| grado_curso | Grado/Curso | NO | Alfanumérico(50) | Captura Libre | NO | - |
| cantidad_alumnos | Cantidad de Alumnos | NO | Numérico Entero | Captura Libre | NO | - |
| docentes_acompañantes | Docentes Acompañantes | NO | Alfanumérico(500) | Captura Libre | NO | - |
| transporte | Medio de Transporte | NO | Alfanumérico(200) | Captura Libre | NO | - |
| fecha_carga | Fecha de Carga | NO | Fecha | - | NO | - |

## 11. TABLA: ALUMNOS_SALIDAS
- **Nombre Lógico:** Alumnos en Salidas
- **Nombre Físico:** alumnos_salidas
- **Descripción:** Relación de alumnos participantes en salidas educativas

| Nombre Físico | Nombre Lógico | Identificador | Tipo de Dato | Tipo de Captura | Relación | Tabla Relacionada |
|---|---|---|---|---|---|---|
| id_alumno_salida | ID Alumno-Salida | SI (Autonumérico) | Numérico Entero | - | NO | - |
| id_salida | ID de la Salida | NO | Numérico Entero | - | SI | salidas_educativas |
| id_alumno | ID del Alumno | NO | Numérico Entero | MultiSelección | SI | alumnos |
| autorizado | Autorizado | NO | Lógico | Checkbox | NO | - |

## 12. TABLA: PASANTIAS
- **Nombre Lógico:** Pasantías
- **Nombre Físico:** pasantias
- **Descripción:** Registro de pasantías educativas

| Nombre Físico | Nombre Lógico | Identificador | Tipo de Dato | Tipo de Captura | Relación | Tabla Relacionada |
|---|---|---|---|---|---|---|
| id_pasantia | ID de la Pasantía | SI (Autonumérico) | Numérico Entero | - | NO | - |
| id_escuela | ID de Escuela | NO | Numérico Entero | - | SI | escuelas |
| id_alumno | ID del Alumno | NO | Numérico Entero | Selección | SI | alumnos |
| empresa | Empresa | NO | Alfanumérico(200) | Captura Libre | NO | - |
| direccion_empresa | Dirección Empresa | NO | Alfanumérico(300) | Captura Libre | NO | - |
| tutor_empresa | Tutor en Empresa | NO | Alfanumérico(200) | Captura Libre | NO | - |
| fecha_inicio | Fecha de Inicio | NO | Fecha | DatePicker | NO | - |
| fecha_fin | Fecha de Fin | NO | Fecha | DatePicker | NO | - |
| horario | Horario | NO | Alfanumérico(100) | Captura Libre | NO | - |
| descripcion_tareas | Descripción de Tareas | NO | Alfanumérico(1000) | Captura Libre | NO | - |
| id_usuario_carga | ID Usuario que Carga | NO | Numérico Entero | - | SI | usuarios |
| fecha_carga | Fecha de Carga | NO | Fecha | - | NO | - |

## 13. TABLA: EMPLEADOS
- **Nombre Lógico:** Empleados de Escuelas
- **Nombre Físico:** empleados
- **Descripción:** Registro del personal empleado en las escuelas

| Nombre Físico | Nombre Lógico | Identificador | Tipo de Dato | Tipo de Captura | Relación | Tabla Relacionada |
|---|---|---|---|---|---|---|
| id_empleado | ID del Empleado | SI (Autonumérico) | Numérico Entero | - | NO | - |
| id_escuela | ID de Escuela | NO | Numérico Entero | Selección | SI | escuelas |
| nombre | Nombre | NO | Alfanumérico(100) | Captura Libre | NO | - |
| apellido | Apellido | NO | Alfanumérico(100) | Captura Libre | NO | - |
| dni | DNI | NO | Alfanumérico(10) | Captura Libre | NO | - |
| cuil | CUIL | NO | Alfanumérico(15) | Captura Libre | NO | - |
| cargo | Cargo | NO | Alfanumérico(100) | Captura Libre | NO | - |
| fecha_ingreso | Fecha de Ingreso | NO | Fecha | DatePicker | NO | - |
| fecha_egreso | Fecha de Egreso | NO | Fecha | DatePicker | NO | - |
| telefono | Teléfono | NO | Alfanumérico(50) | Captura Libre | NO | - |
| email | Correo Electrónico | NO | Alfanumérico(100) | Captura Libre | NO | - |
| direccion | Dirección | NO | Alfanumérico(300) | Captura Libre | NO | - |
| activo | Estado Activo | NO | Lógico | Checkbox | NO | - |

## 14. TABLA: BENEFICIARIOS_SVO
- **Nombre Lógico:** Beneficiarios Seguro Vida Obligatorio
- **Nombre Físico:** beneficiarios_svo
- **Descripción:** Registro de beneficiarios del seguro de vida obligatorio

| Nombre Físico | Nombre Lógico | Identificador | Tipo de Dato | Tipo de Captura | Relación | Tabla Relacionada |
|---|---|---|---|---|---|---|
| id_beneficiario | ID del Beneficiario | SI (Autonumérico) | Numérico Entero | - | NO | - |
| id_empleado | ID del Empleado | NO | Numérico Entero | Selección | SI | empleados |
| id_escuela | ID de Escuela | NO | Numérico Entero | Selección | SI | escuelas |
| nombre | Nombre | NO | Alfanumérico(100) | Captura Libre | NO | - |
| apellido | Apellido | NO | Alfanumérico(100) | Captura Libre | NO | - |
| dni | DNI | NO | Alfanumérico(10) | Captura Libre | NO | - |
| parentesco | Parentesco | NO | Alfanumérico(50) | Selección | NO | - |
| porcentaje | Porcentaje | NO | Numérico con Decimales | Captura Libre | NO | - |
| fecha_alta | Fecha de Alta | NO | Fecha | DatePicker | NO | - |
| activo | Estado Activo | NO | Lógico | Checkbox | NO | - |

## 15. TABLA: FALLECIMIENTOS
- **Nombre Lógico:** Registro de Fallecimientos
- **Nombre Físico:** fallecimientos
- **Descripción:** Registro de fallecimientos del personal escolar

| Nombre Físico | Nombre Lógico | Identificador | Tipo de Dato | Tipo de Captura | Relación | Tabla Relacionada |
|---|---|---|---|---|---|---|
| id_fallecimiento | ID del Fallecimiento | SI (Autonumérico) | Numérico Entero | - | NO | - |
| id_empleado | ID del Empleado | NO | Numérico Entero | Selección | SI | empleados |
| fecha_fallecimiento | Fecha de Fallecimiento | NO | Fecha | DatePicker | NO | - |
| causa | Causa | NO | Alfanumérico(500) | Captura Libre | NO | - |
| lugar_fallecimiento | Lugar de Fallecimiento | NO | Alfanumérico(300) | Captura Libre | NO | - |
| observaciones | Observaciones | NO | Alfanumérico(1000) | Captura Libre | NO | - |
| id_usuario_carga | ID Usuario que Carga | NO | Numérico Entero | - | SI | usuarios |
| fecha_carga | Fecha de Carga | NO | Fecha | - | NO | - |

## 16. TABLA: NOTIFICACIONES
- **Nombre Lógico:** Notificaciones del Sistema
- **Nombre Físico:** notificaciones
- **Descripción:** Sistema de notificaciones para usuarios sobre eventos importantes

| Nombre Físico | Nombre Lógico | Identificador | Tipo de Dato | Tipo de Captura | Relación | Tabla Relacionada |
|---|---|---|---|---|---|---|
| id_notificacion | ID de Notificación | SI (Autonumérico) | Numérico Entero | - | NO | - |
| id_usuario_destino | ID Usuario Destino | NO | Numérico Entero | - | SI | usuarios |
| tipo_notificacion | Tipo de Notificación | NO | Alfanumérico(50) | - | NO | - |
| titulo | Título | NO | Alfanumérico(200) | - | NO | - |
| mensaje | Mensaje | NO | Alfanumérico(1000) | - | NO | - |
| id_entidad_referencia | ID Entidad Referencia | NO | Numérico Entero | - | NO | - |
| tipo_entidad | Tipo de Entidad | NO | Alfanumérico(50) | - | NO | - |
| fecha_creacion | Fecha de Creación | NO | Fecha | - | NO | - |
| leida | Leída | NO | Lógico | - | NO | - |
| fecha_lectura | Fecha de Lectura | NO | Fecha | - | NO | - |

## 17. TABLA: AUDITORIA_SISTEMA
- **Nombre Lógico:** Auditoría del Sistema
- **Nombre Físico:** auditoria_sistema
- **Descripción:** Registro de todas las acciones realizadas en el sistema

| Nombre Físico | Nombre Lógico | Identificador | Tipo de Dato | Tipo de Captura | Relación | Tabla Relacionada |
|---|---|---|---|---|---|---|
| id_auditoria | ID de Auditoría | SI (Autonumérico) | Numérico Entero | - | NO | - |
| id_usuario | ID del Usuario | NO | Numérico Entero | - | SI | usuarios |
| fecha_hora | Fecha y Hora | NO | Fecha | - | NO | - |
| accion | Acción Realizada | NO | Alfanumérico(100) | - | NO | - |
| tabla_afectada | Tabla Afectada | NO | Alfanumérico(50) | - | NO | - |
| id_registro | ID del Registro | NO | Numérico Entero | - | NO | - |
| datos_anteriores | Datos Anteriores | NO | Alfanumérico(2000) | - | NO | - |
| datos_nuevos | Datos Nuevos | NO | Alfanumérico(2000) | - | NO | - |
| ip_usuario | IP del Usuario | NO | Alfanumérico(50) | - | NO | - |

## 18. TABLA: DOCUMENTOS_INSTITUCIONALES
- **Nombre Lógico:** Documentos Institucionales
- **Nombre Físico:** documentos_institucionales
- **Descripción:** Documentos institucionales de las escuelas

| Nombre Físico | Nombre Lógico | Identificador | Tipo de Dato | Tipo de Captura | Relación | Tabla Relacionada |
|---|---|---|---|---|---|---|
| id_documento | ID del Documento | SI (Autonumérico) | Numérico Entero | - | NO | - |
| id_escuela | ID de Escuela | NO | Numérico Entero | Selección | SI | escuelas |
| tipo_documento | Tipo de Documento | NO | Alfanumérico(100) | Selección | NO | - |
| nombre_documento | Nombre del Documento | NO | Alfanumérico(200) | Captura Libre | NO | - |
| descripcion | Descripción | NO | Alfanumérico(500) | Captura Libre | NO | - |
| fecha_documento | Fecha del Documento | NO | Fecha | DatePicker | NO | - |
| fecha_vencimiento | Fecha de Vencimiento | NO | Fecha | DatePicker | NO | - |
| id_usuario_carga | ID Usuario que Carga | NO | Numérico Entero | - | SI | usuarios |
| fecha_carga | Fecha de Carga | NO | Fecha | - | NO | - |

## 19. TABLA: SOLICITUDES_INFO_AUDITOR
- **Nombre Lógico:** Solicitudes de Información del Auditor
- **Nombre Físico:** solicitudes_info_auditor
- **Descripción:** Solicitudes de información adicional realizadas por el médico auditor sobre reintegros

| Nombre Físico | Nombre Lógico | Identificador | Tipo de Dato | Tipo de Captura | Relación | Tabla Relacionada |
|---|---|---|---|---|---|---|
| id_solicitud | ID de Solicitud | SI (Autonumérico) | Numérico Entero | - | NO | - |
| id_reintegro | ID del Reintegro | NO | Numérico Entero | - | SI | reintegros |
| id_auditor | ID del Auditor | NO | Numérico Entero | - | SI | usuarios |
| fecha_solicitud | Fecha de Solicitud | NO | Fecha | - | NO | - |
| descripcion_solicitud | Descripción de Solicitud | NO | Alfanumérico(1000) | Captura Libre | NO | - |
| documentos_requeridos | Documentos Requeridos | NO | Alfanumérico(500) | Captura Libre | NO | - |
| estado | Estado | NO | Alfanumérico(50) | - | NO | - |
| id_usuario_responde | ID Usuario Responde | NO | Numérico Entero | - | SI | usuarios |
| fecha_respuesta | Fecha de Respuesta | NO | Fecha | - | NO | - |
| observaciones_respuesta | Observaciones Respuesta | NO | Alfanumérico(1000) | Captura Libre | NO | - |

---

# MAPEO DE PROCESOS VS TABLAS

## 1. GESTIÓN DE USUARIOS Y AUTENTICACIÓN
- **Proceso:** Registro de usuarios
  - **Tablas:** usuarios, escuelas, roles
- **Proceso:** Login/Autenticación
  - **Tablas:** usuarios
- **Proceso:** Recuperación de contraseña
  - **Tablas:** usuarios
- **Proceso:** Verificación de email
  - **Tablas:** usuarios

## 2. GESTIÓN DE ACCIDENTES
- **Proceso:** Registrar accidente
  - **Tablas:** accidentes, alumnos, usuarios, escuelas
- **Proceso:** Activar protocolo de emergencias
  - **Tablas:** accidentes, prestadores
- **Proceso:** Cargar datos del alumno accidentado
  - **Tablas:** alumnos, escuelas
- **Proceso:** Adjuntar archivos al accidente
  - **Tablas:** archivos_adjuntos, accidentes

## 3. GESTIÓN DE DERIVACIONES
- **Proceso:** Generar derivación médica
  - **Tablas:** derivaciones, accidentes, prestadores
- **Proceso:** Imprimir derivación
  - **Tablas:** derivaciones
- **Proceso:** Seleccionar prestador
  - **Tablas:** prestadores

## 4. GESTIÓN DE REINTEGROS
- **Proceso:** Solicitar reintegro
  - **Tablas:** reintegros, accidentes, usuarios
- **Proceso:** Adjuntar documentación de gastos
  - **Tablas:** archivos_adjuntos, reintegros
- **Proceso:** Auditar reintegro (Médico Auditor)
  - **Tablas:** reintegros, usuarios, notificaciones
- **Proceso:** Solicitar información adicional (Auditor)
  - **Tablas:** solicitudes_info_auditor, reintegros, notificaciones
- **Proceso:** Responder solicitud de información
  - **Tablas:** solicitudes_info_auditor, archivos_adjuntos
- **Proceso:** Autorizar reintegro
  - **Tablas:** reintegros
- **Proceso:** Registrar pago de reintegro
  - **Tablas:** reintegros
- **Proceso:** Consultar estado de reintegro
  - **Tablas:** reintegros, accidentes, solicitudes_info_auditor

## 5. GESTIÓN DE SALIDAS EDUCATIVAS
- **Proceso:** Registrar salida educativa
  - **Tablas:** salidas_educativas, escuelas, usuarios
- **Proceso:** Registrar alumnos participantes
  - **Tablas:** alumnos_salidas, alumnos
- **Proceso:** Adjuntar documentación
  - **Tablas:** archivos_adjuntos, salidas_educativas

## 6. GESTIÓN DE PASANTÍAS
- **Proceso:** Registrar pasantía
  - **Tablas:** pasantias, alumnos, escuelas, usuarios
- **Proceso:** Adjuntar documentación
  - **Tablas:** archivos_adjuntos, pasantias

## 7. GESTIÓN DE EMPLEADOS
- **Proceso:** Registrar empleado
  - **Tablas:** empleados, escuelas
- **Proceso:** Actualizar datos de empleado
  - **Tablas:** empleados
- **Proceso:** Registrar baja de empleado
  - **Tablas:** empleados

## 8. GESTIÓN DE BENEFICIARIOS SVO
- **Proceso:** Registrar beneficiario
  - **Tablas:** beneficiarios_svo, empleados
- **Proceso:** Actualizar porcentajes
  - **Tablas:** beneficiarios_svo

## 9. GESTIÓN DE FALLECIMIENTOS
- **Proceso:** Registrar fallecimiento
  - **Tablas:** fallecimientos, empleados, usuarios
- **Proceso:** Adjuntar documentación
  - **Tablas:** archivos_adjuntos, fallecimientos
- **Proceso:** Notificar beneficiarios
  - **Tablas:** beneficiarios_svo, notificaciones

## 10. GESTIÓN DE DOCUMENTOS INSTITUCIONALES
- **Proceso:** Cargar documento institucional
  - **Tablas:** documentos_institucionales, escuelas, usuarios
- **Proceso:** Adjuntar archivo
  - **Tablas:** archivos_adjuntos, documentos_institucionales

## 11. PANEL DE ADMINISTRACIÓN
- **Proceso:** Filtrar accidentes por fecha/escuela/prestador
  - **Tablas:** accidentes, escuelas, derivaciones, prestadores
- **Proceso:** Ver presentaciones enumeradas
  - **Tablas:** accidentes, salidas_educativas, pasantias, fallecimientos
- **Proceso:** Gestionar usuarios
  - **Tablas:** usuarios, roles, escuelas
- **Proceso:** Generar reportes
  - **Tablas:** Todas las tablas según el reporte

## 12. SISTEMA DE NOTIFICACIONES
- **Proceso:** Notificar nueva solicitud de reintegro
  - **Tablas:** notificaciones, reintegros, usuarios
- **Proceso:** Notificar cambio de estado
  - **Tablas:** notificaciones
- **Proceso:** Marcar notificación como leída
  - **Tablas:** notificaciones

## 13. AUDITORÍA Y TRAZABILIDAD
- **Proceso:** Registrar todas las acciones
  - **Tablas:** auditoria_sistema, usuarios
- **Proceso:** Consultar historial de cambios
  - **Tablas:** auditoria_sistema

---

## NOTAS IMPORTANTES

1. **Estados de Reintegro:** El campo "estado" en la tabla REINTEGROS debe tener los siguientes valores posibles:
   - "En proceso" - Cuando se solicita el reintegro
   - "Autorizado" - Cuando el médico auditor autoriza
   - "Pagado" - Cuando se registra el pago

2. **Sistema de Emergencias:** Los prestadores médicos incluyen el "Sistema de Emergencias y Urgencias médicas" provisto por el Fondo Solidario, identificado mediante el campo "es_sistema_emergencias".

3. **Derivaciones Impresas:** Las derivaciones deben poder imprimirse con sello de la escuela y firma autorizada para presentar en el prestador médico.

4. **Expedientes Numerados:** Cada accidente genera un número de expediente único que agrupa todas las derivaciones y reintegros asociados.

5. **Solicitudes de Información:** El médico auditor puede solicitar información adicional sobre un reintegro, lo cual se gestiona a través de la tabla solicitudes_info_auditor.