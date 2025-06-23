Eres un desarrollador Laravel experto especializado en Livewire y Eloquent. Necesito que conectes un CRUD prototipo estático a la base de datos siguiendo una guía detallada paso a paso.

## 🎯 INFORMACIÓN DEL PROYECTO

ENTIDAD A CONECTAR: [PRESTADORES]
PANTALLAS: [LISTADO DE PRESTADORES, FORMULARIO DE PRESTADORES (REGISTRO, CONSULTA, EDICIÓN)]
PROYECTO: Sistema de Fondo Solidario (Laravel + Livewire)

## 🔥 INSTRUCCIONES CRÍTICAS

ANTES DE EMPEZAR:
1. **LEE TODA LA GUÍA** antes de hacer cualquier cambio
2. **ANALIZA EL CÓDIGO EXISTENTE** para entender la estructura actual
3. **IDENTIFICA QUÉ YA EXISTE** vs qué necesita crearse
4. **SIGUE LOS PASOS EN ORDEN** - no saltes pasos
5. **VERIFICA CADA PASO** antes de continuar al siguiente
6. **USA LOS NOMBRES EXACTOS** de archivos, clases y métodos del proyecto
7. **MANTÉN LA CONSISTENCIA** con el estilo de código existente
8. **PRUEBA CADA FUNCIONALIDAD** después de implementarla

## ❌ REGLAS CRÍTICAS - NO HACER:
- ❌ **NO sobrescribas** archivos existentes sin verificar primero
- ❌ **NO cambies** nombres de tablas o campos sin confirmar
- ❌ **NO omitas** validaciones o mensajes en español
- ❌ **NO uses** datos hardcodeados en las vistas
- ❌ **NO olvides** la auditoría en operaciones CRUD

## ✅ REGLAS CRÍTICAS - SÍ HACER:
- ✅ **SÍ mantén** el estilo y estructura existente
- ✅ **SÍ agrega** auditoría a todas las operaciones (AuditoriaService)
- ✅ **SÍ incluye** mensajes de retroalimentación con modal
- ✅ **SÍ usa** wire:model.live para filtros
- ✅ **SÍ implementa** paginación real
- ✅ **SÍ agrega** validaciones en español

## 🔧 COMANDOS DE VERIFICACIÓN

Después de cada paso, ejecuta estos comandos para verificar:

```bash
# Verificar que el modelo existe y está bien configurado
php artisan tinker --execute="dd(new App\Models\[Entidad]())"

# Verificar que las rutas están registradas
php artisan route:list | grep [entidad]

# Verificar que los componentes Livewire existen
php artisan livewire:list | grep [Entidad]

# Limpiar caché después de cambios
php artisan view:clear && php artisan config:clear
```

## 📚 GUÍA A SEGUIR

LEE EL ARCHIVO GUIA_CONEXION_CRUD_BASE_DATOS.md



-------------------------------------------------------------

Revisa DE NUEVO el archivo PROMPT_GEMINI_CRUD.md y los archivos correspondientes para que asegures que se realizaron todas las tareas. Por ejemplo la funcionalidad de exportar siempre se te olvida.

-------------------------------------------------------------
1.- en el listado de PRESTADORES si el rol de usuario = 1 (usuario general) debe estar oculto el filtro de escuela y se deben mostrar solo los registros de la escuela que pertenece al usuario logueado en el sistema.

2.- en el formulario de PRESTADORES, al dar de alta si el rol de usuario = 1 (usuario general), la escuela se debe asignar automaticamente con la escuela del usuario que está logueado en el sistema.

3.- en el formulario de PRESTADORES, si el rol de usuario = 1 (usuario general), el campo de escuela debe estar deshabilitado al dar de alta y al modificar