# 📋 GUÍA INFALIBLE: CONECTAR CRUD PROTOTIPO A BASE DE DATOS

## 🎯 **OBJETIVO**
Esta guía te permitirá convertir cualquier prototipo de CRUD estático existente en un CRUD completamente funcional conectado a la base de datos.

**IMPORTANTE**: Esta guía asume que ya tienes:
- ✅ Migraciones creadas y ejecutadas
- ✅ Prototipos de vistas funcionando
- ✅ Rutas básicas definidas

## 🤖 **INSTRUCCIONES PARA IA (Gemini 2.5 Flash u otros modelos)**

**ANTES DE EMPEZAR:**
1. **LEE TODA LA GUÍA** antes de hacer cualquier cambio
2. **ANALIZA EL CÓDIGO EXISTENTE** para entender la estructura actual
3. **IDENTIFICA QUÉ YA EXISTE** vs qué necesita crearse
4. **SIGUE LOS PASOS EN ORDEN** - no saltes pasos
5. **VERIFICA CADA PASO** antes de continuar al siguiente
6. **USA LOS NOMBRES EXACTOS** de archivos, clases y métodos del proyecto
7. **MANTÉN LA CONSISTENCIA** con el estilo de código existente
8. **PRUEBA CADA FUNCIONALIDAD** después de implementarla

**REGLAS CRÍTICAS:**
- ❌ **NO sobrescribas** archivos existentes sin verificar
- ❌ **NO cambies** nombres de tablas o campos sin confirmar
- ❌ **NO omitas** validaciones o mensajes en español
- ✅ **SÍ mantén** el estilo y estructura existente
- ✅ **SÍ agrega** auditoría a todas las operaciones
- ✅ **SÍ incluye** mensajes de retroalimentación

---

## 📚 **PASOS PARA CONECTAR A BASE DE DATOS**

### **PASO 1: CREAR/CONFIGURAR MODELO ELOQUENT**

#### 1.1 Verificar/Crear el Modelo
```bash
# 🔍 PRIMERO: Verificar si el modelo ya existe
ls app/Models/[Entidad].php

# ✅ Si NO existe, crearlo:
php artisan make:model [Entidad]

# ✅ Si SÍ existe, continuar con la configuración
```

#### 1.2 Configurar el Modelo
**Archivo: `app/Models/[Entidad].php`**

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class [Entidad] extends Model
{
    // 🔥 CRÍTICO: Configurar tabla
    protected $table = '[nombre_tabla_plural]';
    
    // 🔥 CRÍTICO: Configurar primary key
    protected $primaryKey = 'id_[entidad]';
    
    // 🔥 CRÍTICO: Timestamps (verificar si tu tabla los tiene)
    public $timestamps = false; // Cambiar a true si tienes created_at/updated_at
    
    // 🔥 CRÍTICO: Campos fillable (TODOS los campos del formulario)
    protected $fillable = [
        'campo1',
        'campo2', 
        'campo3',
        'activo',
        // ... TODOS los campos que aparecen en tu formulario
    ];
    
    // 🔥 CRÍTICO: Casting de tipos
    protected $casts = [
        'activo' => 'boolean',
        'fecha_campo' => 'date',
        // ... otros según tus campos
    ];
}
```

#### 1.3 Agregar Relaciones (si aplica)
```php
// Ejemplo: Si tu entidad pertenece a una escuela
public function escuela()
{
    return $this->belongsTo(Escuela::class, 'id_escuela', 'id_escuela');
}

// Ejemplo: Accessor para nombre completo
public function getNombreCompletoAttribute()
{
    return $this->nombre . ' ' . $this->apellido;
}
```

---

### **PASO 2: CREAR COMPONENTES LIVEWIRE**

#### 2.1 Verificar/Crear los Componentes
```bash
# 🔍 PRIMERO: Verificar si los componentes ya existen
ls app/Livewire/[Entidad]/Index.php
ls app/Livewire/[Entidad]/Form.php

# ✅ Si NO existen, crearlos:
php artisan make:livewire [Entidad]/Index
php artisan make:livewire [Entidad]/Form

# ✅ Si SÍ existen, continuar con la configuración
```

#### 2.2 Configurar Componente Index (Listado)
**Archivo: `app/Livewire/[Entidad]/Index.php`**

**ELEMENTOS CRÍTICOS A INCLUIR:**

```php
<?php

namespace App\Livewire\[Entidad];

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\[Entidad];
use App\Services\AuditoriaService;

class Index extends Component
{
    use WithPagination;

    // 🔥 FILTROS: Según los campos de tu prototipo
    public $filtro_campo1 = '';
    public $filtro_campo2 = '';
    public $filtro_estado = '';

    // 🔥 ORDENAMIENTO
    public $sortField = 'campo_principal';
    public $sortDirection = 'asc';

    // 🔥 PAGINACIÓN
    public $perPage = 10;

    // 🔥 QUERY STRING para mantener filtros en URL
    protected $queryString = [
        'filtro_campo1' => ['except' => ''],
        'filtro_campo2' => ['except' => ''],
        'filtro_estado' => ['except' => ''],
        'sortField' => ['except' => 'campo_principal'],
        'sortDirection' => ['except' => 'asc'],
    ];

    // 🔥 MÉTODO RENDER: Conectar con BD
    public function render()
    {
        $entidades = $this->getEntidades();
        
        return view('livewire.[entidad].index', compact('entidades'));
    }

    // 🔥 MÉTODO PRINCIPAL: Consulta a BD con filtros
    public function getEntidades()
    {
        $query = [Entidad]::query()
            ->when($this->filtro_campo1, function ($query) {
                $query->where('campo1', 'like', '%' . $this->filtro_campo1 . '%');
            })
            ->when($this->filtro_campo2, function ($query) {
                $query->where('campo2', 'like', '%' . $this->filtro_campo2 . '%');
            })
            ->when($this->filtro_estado !== '', function ($query) {
                $activo = $this->filtro_estado === 'activo';
                $query->where('activo', $activo);
            });

        // Aplicar ordenamiento
        $query->orderBy($this->sortField, $this->sortDirection);

        return $query->paginate($this->perPage);
    }

    // 🔥 MÉTODOS DE ACCIÓN
    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
        $this->resetPage();
    }

    public function limpiarFiltros()
    {
        $this->reset(['filtro_campo1', 'filtro_campo2', 'filtro_estado']);
        $this->resetPage();
    }

    public function cambiarEstado($entidadId)
    {
        $entidad = [Entidad]::findOrFail($entidadId);
        $estadoAnterior = $entidad->activo;
        
        $entidad->activo = !$entidad->activo;
        $entidad->save();

        // Auditoría
        AuditoriaService::registrarActualizacion(
            '[tabla_plural]',
            $entidadId,
            ['activo' => $estadoAnterior],
            ['activo' => $entidad->activo]
        );

        $estado = $entidad->activo ? 'activado' : 'desactivado';
        session()->flash('message', "[Entidad] {$estado} exitosamente.");
    }

    public function eliminar($entidadId)
    {
        $entidad = [Entidad]::findOrFail($entidadId);
        $datosEntidad = $entidad->toArray();
        $entidad->delete();

        AuditoriaService::registrarEliminacion('[tabla_plural]', $entidadId, $datosEntidad);
        session()->flash('message', '[Entidad] eliminado exitosamente.');
    }

    // 🔥 MÉTODOS PARA RESETEAR PÁGINA EN FILTROS
    public function updatingFiltroCampo1() { $this->resetPage(); }
    public function updatingFiltroCampo2() { $this->resetPage(); }
    public function updatingFiltroEstado() { $this->resetPage(); }
}
```

#### 2.3 Configurar Componente Form (Crear/Editar)
**Archivo: `app/Livewire/[Entidad]/Form.php`**

**ELEMENTOS CRÍTICOS A INCLUIR:**

```php
<?php

namespace App\Livewire\[Entidad];

use Livewire\Component;
use App\Models\[Entidad];
use App\Services\AuditoriaService;

class Form extends Component
{
    public $modo = 'create';
    public $entidad_id;

    // 🔥 PROPIEDADES: Una por cada campo del formulario
    public $campo1;
    public $campo2;
    public $campo3;
    public $activo = true;

    // 🔥 MENSAJES DE RETROALIMENTACIÓN
    public $mensaje = '';
    public $tipoMensaje = '';

    // 🔥 VALIDACIONES
    protected function rules()
    {
        return [
            'campo1' => 'required|string|max:100',
            'campo2' => 'required|string|max:100',
            'campo3' => 'nullable|string|max:255',
            'activo' => 'boolean',
        ];
    }

    // 🔥 MENSAJES EN ESPAÑOL
    protected function messages()
    {
        return [
            'campo1.required' => 'El campo1 es obligatorio.',
            'campo1.max' => 'El campo1 no puede tener más de 100 caracteres.',
            'campo2.required' => 'El campo2 es obligatorio.',
            'campo2.max' => 'El campo2 no puede tener más de 100 caracteres.',
        ];
    }

    // 🔥 MOUNT: Cargar datos en modo edición
    public function mount($modo = 'create', $entidad_id = null)
    {
        $this->modo = $modo;
        if ($entidad_id) {
            $this->entidad_id = $entidad_id;
            $entidad = [Entidad]::findOrFail($entidad_id);
            $this->campo1 = $entidad->campo1;
            $this->campo2 = $entidad->campo2;
            $this->campo3 = $entidad->campo3;
            $this->activo = $entidad->activo;
        }
    }

    // 🔥 RENDER
    public function render()
    {
        return view('livewire.[entidad].form');
    }

    // 🔥 GUARDAR: Crear o actualizar
    public function guardar()
    {
        $this->validate();

        $data = [
            'campo1' => $this->campo1,
            'campo2' => $this->campo2,
            'campo3' => $this->campo3,
            'activo' => $this->activo,
        ];

        if ($this->modo == 'create') {
            $entidad = [Entidad]::create($data);
            AuditoriaService::registrarCreacion('[tabla_plural]', $entidad->id_[entidad], $data);
            
            // Modal de confirmación con redirección
            $this->mensaje = '[Entidad] creado exitosamente.';
            $this->tipoMensaje = 'success';
            $this->dispatch('mostrar-mensaje-y-redirigir');
        } else {
            $entidad = [Entidad]::findOrFail($this->entidad_id);
            $datosAnteriores = $entidad->getOriginal();
            $entidad->update($data);
            AuditoriaService::registrarActualizacion('[tabla_plural]', $entidad->id_[entidad], $datosAnteriores, $data);
            
            // Modal de confirmación sin redirección
            $this->mensaje = '[Entidad] actualizado exitosamente.';
            $this->tipoMensaje = 'success';
            $this->dispatch('mostrar-mensaje');
        }
    }

    // 🔥 MÉTODOS AUXILIARES
    public function limpiarMensaje()
    {
        $this->mensaje = '';
        $this->tipoMensaje = '';
    }

    public function redirigirAlListado()
    {
        return redirect()->route('[entidad].index');
    }
}
```

---

### **PASO 3: ACTUALIZAR RUTAS**

**Archivo: `routes/web.php`**

**VERIFICAR Y REEMPLAZAR las rutas mockup por rutas reales:**

```php
# 🔍 PRIMERO: Verificar las rutas actuales en routes/web.php
# Buscar las rutas de tu entidad para ver si son mockup o reales

// 🔥 ANTES (Mockup - Si encuentras esto):
Route::prefix('[entidad]')->name('[entidad].')->group(function () {
    Route::get('/', function () {
        return view('livewire.[entidad].index');
    })->name('index');
    // ... más rutas mockup
});

// 🔥 DESPUÉS (Conectado a BD - Reemplazar por esto):
Route::prefix('[entidad]')->name('[entidad].')->middleware('auth')->group(function () {
    Route::get('/', \App\Livewire\[Entidad]\Index::class)->name('index');

    Route::get('/create', function () {
        return view('[entidad].form', ['modo' => 'create']);
    })->name('create');

    Route::get('/{id}/edit', function ($id) {
        return view('[entidad].form', ['modo' => 'edit', 'entidad_id' => $id]);
    })->name('edit');

    Route::get('/{id}', function ($id) {
        return view('[entidad].form', ['modo' => 'show', 'entidad_id' => $id]);
    })->name('show');
});
```

---

### **PASO 4: ACTUALIZAR VISTAS**

#### 4.1 Verificar/Actualizar Vista del Listado
```bash
# 🔍 PRIMERO: Verificar si la vista del listado ya existe
ls resources/views/livewire/[entidad]/index.blade.php

# ✅ Si NO existe, crearla desde cero
# ✅ Si SÍ existe, aplicar los cambios críticos siguientes
```

**Archivo: `resources/views/livewire/[entidad]/index.blade.php`**

**CAMBIOS CRÍTICOS A APLICAR:**

```blade
<!-- 🔥 AGREGAR: Mensajes flash al inicio -->
@if (session()->has('message'))
    <div class="mb-6 bg-success-50 border border-success-200 text-success-700 px-4 py-3 rounded-lg relative">
        <div class="flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <span class="font-medium">{{ session('message') }}</span>
        </div>
    </div>
@endif

<!-- 🔥 CAMBIAR: Filtros estáticos por dinámicos -->
<input wire:model.live="filtro_campo1" type="text" ...>
<input wire:model.live="filtro_campo2" type="text" ...>
<button wire:click="limpiarFiltros" type="button" ...>Limpiar</button>

<!-- 🔥 CAMBIAR: Headers de tabla por ordenables -->
<th scope="col" class="...">
    <button wire:click="sortBy('campo1')" class="group inline-flex items-center hover:text-secondary-700">
        Campo1
        @if($sortField === 'campo1')
            @if($sortDirection === 'asc')
                <svg class="ml-2 w-4 h-4 text-primary-500" ...>↑</svg>
            @else
                <svg class="ml-2 w-4 h-4 text-primary-500" ...>↓</svg>
            @endif
        @else
            <svg class="ml-2 w-4 h-4 text-secondary-400" ...>↕</svg>
        @endif
    </button>
</th>

<!-- 🔥 CAMBIAR: Datos estáticos por dinámicos -->
@forelse($entidades as $entidad)
<tr class="hover:bg-secondary-50 transition-colors duration-150">
    <td class="px-6 py-4 whitespace-nowrap">
        <div class="text-sm font-medium text-secondary-900">{{ $entidad->campo1 }}</div>
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-center">
        <div class="flex items-center justify-center space-x-2">
            <a href="{{ route('[entidad].show', $entidad->id_[entidad]) }}" ...>Ver</a>
            <a href="{{ route('[entidad].edit', $entidad->id_[entidad]) }}" ...>Editar</a>
            <button wire:click="cambiarEstado({{ $entidad->id_[entidad] }})" ...>
                {{ $entidad->activo ? 'Desactivar' : 'Activar' }}
            </button>
            <button wire:click="eliminar({{ $entidad->id_[entidad] }})" 
                    wire:confirm="¿Estás seguro?" ...>Eliminar</button>
        </div>
    </td>
</tr>
@empty
<tr>
    <td colspan="X" class="px-6 py-12 text-center">
        <div class="text-secondary-500">No hay registros disponibles.</div>
    </td>
</tr>
@endforelse

<!-- 🔥 CAMBIAR: Paginación estática por dinámica -->
<div class="px-6 py-4 bg-secondary-50 border-t border-secondary-200">
    <div class="flex flex-col sm:flex-row items-center justify-between">
        <div class="text-sm text-secondary-700 mb-4 sm:mb-0">
            @if($entidades->total() > 0)
                Mostrando <span class="font-medium text-secondary-900">{{ $entidades->firstItem() }}</span> a <span class="font-medium text-secondary-900">{{ $entidades->lastItem() }}</span> de <span class="font-medium text-secondary-900">{{ $entidades->total() }}</span> resultados
            @else
                No hay resultados para mostrar
            @endif
        </div>
        @if($entidades->hasPages())
            {{ $entidades->links('pagination.custom-tailwind') }}
        @endif
    </div>
</div>
```

#### 4.2 Verificar/Actualizar Vista del Formulario
```bash
# 🔍 PRIMERO: Verificar si la vista del formulario ya existe
ls resources/views/livewire/[entidad]/form.blade.php

# ✅ Si NO existe, crearla desde cero
# ✅ Si SÍ existe, aplicar los cambios críticos siguientes
```

**Archivo: `resources/views/livewire/[entidad]/form.blade.php`**

**CAMBIOS CRÍTICOS A APLICAR:**

```blade
<!-- 🔥 AGREGAR: Modal de confirmación al inicio -->
@if($mensaje)
    <div class="fixed inset-0 z-50 overflow-y-auto" x-data="{ show: true }" x-show="show" x-transition>
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="show = false"></div>
            <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-sm sm:w-full sm:p-6">
                <div>
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full {{ $tipoMensaje === 'success' ? 'bg-green-100' : 'bg-red-100' }}">
                        @if($tipoMensaje === 'success')
                            <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        @endif
                    </div>
                    <div class="mt-3 text-center sm:mt-5">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">¡Éxito!</h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">{{ $mensaje }}</p>
                            @if($modo == 'create' && $tipoMensaje === 'success')
                                <p class="text-xs text-gray-400 mt-2">Redirigiendo al listado en 3 segundos...</p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="mt-5 sm:mt-6">
                    @if($modo == 'create')
                        <button @click="show = false" wire:click="redirigirAlListado" type="button" class="inline-flex justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 hover:bg-green-700 text-base font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:text-sm">
                            Ir al Listado
                        </button>
                    @else
                        <button @click="show = false" wire:click="limpiarMensaje" type="button" class="inline-flex justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 hover:bg-green-700 text-base font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:text-sm">
                            Aceptar
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endif

<!-- 🔥 CAMBIAR: Formulario estático por Livewire -->
<form wire:submit.prevent="guardar" class="space-y-6 p-6">
    @csrf

    <!-- 🔥 CAMBIAR: Inputs estáticos por wire:model -->
    <input wire:model="campo1" type="text" id="campo1" 
           class="..." placeholder="..." required>
    @error('campo1') 
        <span class="text-red-500 text-sm">{{ $message }}</span> 
    @enderror

    <input wire:model="campo2" type="text" id="campo2" 
           class="..." placeholder="..." required>
    @error('campo2') 
        <span class="text-red-500 text-sm">{{ $message }}</span> 
    @enderror

    <!-- 🔥 CAMBIAR: Botón submit -->
    <button type="submit" class="...">
        {{ $modo == 'create' ? 'Crear [Entidad]' : 'Actualizar [Entidad]' }}
    </button>
</form>

<!-- 🔥 AGREGAR: JavaScript para modal -->
@push('scripts')
<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('mostrar-mensaje', () => {
            console.log('Mensaje mostrado - modo edición');
        });

        Livewire.on('mostrar-mensaje-y-redirigir', () => {
            console.log('Mensaje mostrado - modo creación');
            setTimeout(() => {
                @this.call('redirigirAlListado');
            }, 3000);
        });
    });
</script>
@endpush
```

---

### **PASO 5: VERIFICAR/CREAR VISTAS WRAPPER**

#### 5.1 Verificar/Crear Vista Index Wrapper
```bash
# 🔍 PRIMERO: Verificar si la vista wrapper ya existe
ls resources/views/[entidad]/index.blade.php

# ✅ Si NO existe, crearla:
```

**Archivo: `resources/views/[entidad]/index.blade.php`**

```blade
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <livewire:[entidad].index />
</div>
@endsection
```

#### 5.2 Verificar/Crear Vista Form Wrapper
```bash
# 🔍 PRIMERO: Verificar si la vista wrapper ya existe
ls resources/views/[entidad]/form.blade.php

# ✅ Si NO existe, crearla:
```

**Archivo: `resources/views/[entidad]/form.blade.php`**

```blade
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <livewire:[entidad].form :modo="$modo" :entidad_id="$entidad_id ?? null" />
</div>
@endsection
```

---

### **PASO 6: LIMPIAR CACHÉ**

```bash
php artisan view:clear
php artisan config:clear
php artisan route:clear
```

---

## 🔥 **CHECKLIST DE VERIFICACIÓN**

### 🤖 **PARA IA: VERIFICACIÓN AUTOMÁTICA**
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

### ✅ **Modelo**
- [ ] Tabla configurada correctamente (`protected $table`)
- [ ] Primary key configurada (`protected $primaryKey`)
- [ ] Timestamps configurados según tu tabla (`public $timestamps`)
- [ ] Fillable con todos los campos del formulario (`protected $fillable`)
- [ ] Casts configurados para tipos especiales (`protected $casts`)
- [ ] Relaciones agregadas (si aplica)

### ✅ **Componente Index**
- [ ] WithPagination incluido
- [ ] Filtros definidos según campos
- [ ] Método getEntidades() implementado
- [ ] Métodos sortBy() y limpiarFiltros() implementados
- [ ] Métodos cambiarEstado() y eliminar() implementados
- [ ] Métodos updating para resetear página

### ✅ **Componente Form**
- [ ] Propiedades para todos los campos
- [ ] Validaciones definidas
- [ ] Mensajes en español
- [ ] Método mount() para cargar datos
- [ ] Método guardar() para crear/actualizar
- [ ] Mensajes de retroalimentación implementados

### ✅ **Rutas**
- [ ] Rutas mockup reemplazadas por rutas reales
- [ ] Middleware de autenticación agregado
- [ ] Parámetros correctos en rutas

### ✅ **Vistas**
- [ ] Mensajes flash agregados
- [ ] Filtros conectados con wire:model.live
- [ ] Tabla con datos dinámicos
- [ ] Paginación dinámica
- [ ] Formulario con wire:model
- [ ] Modal de confirmación implementado
- [ ] JavaScript para modal agregado

---

## 🚨 **ERRORES COMUNES Y SOLUCIONES**

### Error: "Class [Entidad] not found"
**Solución:** Verificar namespace y nombre de clase en el modelo

### Error: "Table doesn't exist"
**Solución:** Verificar nombre de tabla en propiedad `$table` del modelo

### Error: "Column not found"
**Solución:** Verificar que todos los campos en `$fillable` existan en la tabla

### Error: "Call to undefined method"
**Solución:** Verificar que el componente Livewire extienda de `Component`

### Error: "Route not found"
**Solución:** Ejecutar `php artisan route:clear` y verificar nombres de rutas

### Error: "Property not found"
**Solución:** Verificar que todas las propiedades públicas estén definidas en el componente

---

## ⚙️ **CONFIGURACIÓN CRÍTICA PARA PAGINACIÓN**

Si la paginación no se muestra correctamente, es probable que se deba a un problema con la forma en que Livewire renderiza las vistas. Sigue estos pasos para asegurar que funcione:

### **Paso A: Configurar el Proveedor de Servicios**

Asegúrate de que Livewire utilice las vistas de paginación de Tailwind por defecto.

**Archivo: `app/Providers/AppServiceProvider.php`**

```php
<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator; // 👈 Asegúrate de importar esto

class AppServiceProvider extends ServiceProvider
{
    // ...

    public function boot(): void
    {
        // ... otro código ...

        // 🔥 AGREGAR ESTO: Configurar paginación para que use Tailwind
        Paginator::defaultView('pagination.custom-tailwind');
        Paginator::defaultSimpleView('pagination.custom-tailwind');
    }
}
```

Si las vistas de paginación no existen, publícalas primero con:
```bash
php artisan livewire:publish --pagination
```

### **Paso B: Verificar la Estructura de Vistas y Rutas**

El patrón correcto para componentes de página completa que usan paginación es:

1.  **Ruta (`routes/web.php`):** La ruta DEBE apuntar directamente a la clase del componente Livewire.
    ```php
    // ✅ CORRECTO
    Route::get('/', \App\Livewire\[Entidad]\Index::class)->name('index');
    ```

2.  **Componente Livewire (`app/Livewire/[Entidad]/Index.php`):** El componente **NO** debe tener el atributo `#[Layout]`.
    ```php
    // ✅ CORRECTO
    class Index extends Component
    {
        // ...
    }
    ```

3.  **Vista del Componente (`resources/views/livewire/[entidad]/index.blade.php`):** La vista del componente **NO** debe contener `@extends` o `@section`. Debe empezar directamente con su HTML (generalmente un `<div>` raíz).
    ```blade
    {{-- ✅ CORRECTO --}}
    <div>
        <h1>Mi Contenido</h1>
        {{-- ... resto del código ... --}}
    </div>
    ```

4.  **Vista Wrapper (`resources/views/[entidad]/index.blade.php`):** DEBE existir una vista "wrapper" que sí contenga el layout principal. Aunque la ruta no apunte a ella, Livewire la usará para renderizar el componente.
    ```blade
    {{-- ✅ CORRECTO --}}
    @extends('layouts.app')

    @section('content')
        <livewire:[entidad].index />
    @endsection
    ```

Corregir estos cuatro puntos solucionará la mayoría de los problemas de paginación.

---

## 🎯 **RESULTADO ESPERADO**

Al completar todos los pasos, tendrás:

✅ **CRUD completamente funcional** conectado a la base de datos
✅ **Filtros dinámicos** que consultan la BD
✅ **Ordenamiento** por cualquier columna
✅ **Paginación** automática
✅ **Validaciones** en español
✅ **Mensajes de confirmación** con modal elegante
✅ **Auditoría** de todas las operaciones
✅ **Experiencia de usuario** profesional

¡Tu prototipo estático ahora es un CRUD completamente funcional! 🚀

---

## 📎 **INTEGRACIÓN DE ARCHIVOS ADJUNTOS**

### **CUÁNDO USAR ESTA SECCIÓN**
Esta sección es para pantallas que necesitan:
- ✅ Subir archivos (PDF, imágenes, documentos)
- ✅ Mostrar archivos existentes
- ✅ Eliminar archivos
- ✅ Descargar/visualizar archivos

### **PASO 7: CONFIGURAR MODELO PARA ARCHIVOS**

#### 7.1 Verificar Modelo ArchivoAdjunto
```bash
# 🔍 PRIMERO: Verificar si el modelo ArchivoAdjunto existe
ls app/Models/ArchivoAdjunto.php

# ✅ Si NO existe, crearlo:
php artisan make:model ArchivoAdjunto
```

**Archivo: `app/Models/ArchivoAdjunto.php`**

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class ArchivoAdjunto extends Model
{
    protected $table = 'archivos_adjuntos';
    protected $primaryKey = 'id_archivo';
    public $timestamps = false;

    protected $fillable = [
        'tipo_entidad',
        'id_entidad',
        'nombre_archivo',
        'tipo_archivo',
        'tamano',
        'ruta_archivo',
        'descripcion',
        'id_usuario_carga',
        'fecha_carga'
    ];

    protected $casts = [
        'fecha_carga' => 'datetime',
        'tamano' => 'integer'
    ];

    /**
     * Usuario que subió el archivo
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_usuario_carga', 'id_usuario');
    }

    /**
     * Obtener la URL completa del archivo
     */
    public function getUrlAttribute(): string
    {
        return Storage::url($this->ruta_archivo);
    }

    /**
     * Obtener el tamaño formateado del archivo
     */
    public function getTamanoFormateadoAttribute(): string
    {
        if (!$this->tamano) {
            return 'N/A';
        }

        $bytes = $this->tamano;
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Verificar si el archivo es una imagen
     */
    public function esImagen(): bool
    {
        $tiposImagen = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'];
        return in_array(strtolower($this->tipo_archivo), $tiposImagen);
    }

    /**
     * Verificar si el archivo es un PDF
     */
    public function esPdf(): bool
    {
        return strtolower($this->tipo_archivo) === 'pdf';
    }

    /**
     * Eliminar el archivo físico del almacenamiento
     */
    public function eliminarArchivo(): bool
    {
        if (Storage::exists($this->ruta_archivo)) {
            return Storage::delete($this->ruta_archivo);
        }
        return true;
    }

    /**
     * Scope para filtrar archivos por tipo de entidad
     */
    public function scopeParaEntidad($query, string $tipoEntidad, int $idEntidad)
    {
        return $query->where('tipo_entidad', $tipoEntidad)
                    ->where('id_entidad', $idEntidad);
    }
}
```

#### 7.2 Agregar Relación en Modelo Principal
**En tu modelo principal (ej: `app/Models/[Entidad].php`):**

```php
use Illuminate\Database\Eloquent\Relations\HasMany;

class [Entidad] extends Model
{
    // ... código existente ...

    /**
     * Archivos adjuntos de la entidad
     */
    public function archivos(): HasMany
    {
        return $this->hasMany(ArchivoAdjunto::class, 'id_entidad', 'id_[entidad]')
                    ->where('tipo_entidad', '[entidad]');
    }

    /**
     * Verificar si tiene archivos adjuntos
     */
    public function tieneArchivos(): bool
    {
        return $this->archivos()->count() > 0;
    }

    /**
     * Obtener cantidad de archivos adjuntos
     */
    public function getCantidadArchivosAttribute(): int
    {
        return $this->archivos()->count();
    }

    /**
     * Boot method para eventos del modelo
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($entidad) {
            // Eliminar archivos físicos al eliminar la entidad
            $entidad->archivos->each(function ($archivo) {
                $archivo->eliminarArchivo();
                $archivo->delete();
            });
        });
    }
}
```

### **PASO 8: CONFIGURAR COMPONENTE LIVEWIRE CON ARCHIVOS**

#### 8.1 Agregar WithFileUploads al Componente Form
**Archivo: `app/Livewire/[Entidad]/Form.php`**

```php
<?php

namespace App\Livewire\[Entidad];

use Livewire\Component;
use Livewire\WithFileUploads; // 🔥 AGREGAR ESTO
use App\Models\[Entidad];
use App\Models\ArchivoAdjunto; // 🔥 AGREGAR ESTO
use App\Services\AuditoriaService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Form extends Component
{
    use WithFileUploads; // 🔥 AGREGAR ESTO
    
    // ... propiedades existentes ...

    // 🔥 AGREGAR: Propiedades para archivos
    public $archivos_descripcion = '';
    public $archivos_adjuntos = [];
    public $archivos_existentes = [];

    // 🔥 MODIFICAR: Método mount para cargar archivos existentes
    public function mount($modo = 'create', $entidad_id = null)
    {
        $this->modo = $modo;
        if ($entidad_id) {
            $this->entidad_id = $entidad_id;
            $entidad = [Entidad]::with('archivos')->findOrFail($entidad_id);
            
            // Cargar datos existentes...
            $this->campo1 = $entidad->campo1;
            $this->campo2 = $entidad->campo2;
            // ... otros campos ...
            
            // 🔥 AGREGAR: Cargar archivos existentes
            $this->archivos_existentes = $entidad->archivos;
        }
    }

    // 🔥 AGREGAR: Método para eliminar archivos existentes
    public function eliminarArchivoExistente($idArchivo)
    {
        $archivo = ArchivoAdjunto::findOrFail($idArchivo);
        Storage::disk('public')->delete($archivo->ruta_archivo);
        $archivo->delete();
        
        // Actualizar la colección de archivos existentes
        $this->archivos_existentes = collect($this->archivos_existentes)->where('id_archivo', '!=', $idArchivo)->values();
        
        // Registrar auditoría
        AuditoriaService::registrarEliminacion('archivos_adjuntos', $idArchivo, $archivo->toArray());
        
        $this->mensaje = 'Archivo eliminado exitosamente.';
        $this->tipoMensaje = 'success';
        $this->dispatch('mostrar-mensaje');
    }

    // 🔥 AGREGAR: Método para guardar archivos
    public function guardarArchivos($idEntidad)
    {
        $this->validate([
            'archivos_adjuntos.*' => 'file|max:10240', // 10MB Max
        ]);

        foreach ($this->archivos_adjuntos as $archivo) {
            $rutaArchivo = $archivo->store('archivos_[entidad]', 'public');

            ArchivoAdjunto::create([
                'tipo_entidad' => '[entidad]',
                'id_entidad' => $idEntidad,
                'nombre_archivo' => $archivo->getClientOriginalName(),
                'tipo_archivo' => $archivo->getClientOriginalExtension(),
                'tamano' => $archivo->getSize(),
                'ruta_archivo' => $rutaArchivo,
                'descripcion' => $this->archivos_descripcion,
                'id_usuario_carga' => Auth::id(),
                'fecha_carga' => now(),
            ]);
        }
    }

    // 🔥 MODIFICAR: Método guardar para incluir archivos
    public function guardar()
    {
        $this->validate();

        $data = [
            'campo1' => $this->campo1,
            'campo2' => $this->campo2,
            // ... otros campos ...
        ];

        if ($this->modo == 'create') {
            $entidad = [Entidad]::create($data);
            
            // 🔥 AGREGAR: Guardar archivos adjuntos
            $this->guardarArchivos($entidad->id_[entidad]);
            
            AuditoriaService::registrarCreacion('[tabla_plural]', $entidad->id_[entidad], $data);
            
            $this->mensaje = '[Entidad] creado exitosamente.';
            $this->tipoMensaje = 'success';
            $this->dispatch('mostrar-mensaje-y-redirigir');
        } else {
            $entidad = [Entidad]::findOrFail($this->entidad_id);
            $datosAnteriores = $entidad->getOriginal();
            $entidad->update($data);
            
            // 🔥 AGREGAR: Guardar archivos adjuntos nuevos
            $this->guardarArchivos($entidad->id_[entidad]);
            
            AuditoriaService::registrarActualizacion('[tabla_plural]', $entidad->id_[entidad], $datosAnteriores, $data);
            
            $this->mensaje = '[Entidad] actualizado exitosamente.';
            $this->tipoMensaje = 'success';
            $this->dispatch('mostrar-mensaje');
        }
    }
}
```

### **PASO 9: AGREGAR SECCIÓN DE ARCHIVOS EN LA VISTA**

#### 9.1 Agregar HTML para Archivos en el Formulario
**Archivo: `resources/views/livewire/[entidad]/form.blade.php`**

**🔥 AGREGAR ANTES DEL CIERRE DEL FORMULARIO:**

```blade
<!-- Documentos Adjuntos -->
<div class="border-b border-secondary-200 pb-6">
    <h3 class="text-lg font-medium text-secondary-900 mb-4">Documentos Adjuntos</h3>
    
    <!-- Información explicativa -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
        <div class="flex items-start">
            <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div>
                <h4 class="text-sm font-medium text-blue-800 mb-1">Subida de Documentos</h4>
                <p class="text-sm text-blue-700">
                    Puede adjuntar múltiples documentos relacionados (fotos, informes, facturas, etc.).
                    Formatos permitidos: PDF, JPG, JPEG, PNG. Tamaño máximo por archivo: 10MB.
                </p>
            </div>
        </div>
    </div>

    <!-- Subida de archivos -->
    @if($modo != 'show')
    <div class="mb-6"
         x-data="{ isUploading: false, progress: 0 }"
         x-on:livewire-upload-start="isUploading = true"
         x-on:livewire-upload-finish="isUploading = false"
         x-on:livewire-upload-error="isUploading = false"
         x-on:livewire-upload-progress="progress = $event.detail.progress">
        <label class="block text-sm font-medium text-secondary-700 mb-2">
            Seleccionar Archivos
        </label>
        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-secondary-300 border-dashed rounded-lg hover:border-secondary-400 transition-colors duration-200"
             @dragover.prevent @dragenter.prevent @drop.prevent="$wire.uploadMultiple('archivos_adjuntos', $event.dataTransfer.files)">
            <div class="space-y-1 text-center">
                <svg class="mx-auto h-12 w-12 text-secondary-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <div class="flex text-sm text-secondary-600">
                    <label for="archivos_adjuntos" class="relative cursor-pointer bg-white rounded-md font-medium text-primary-600 hover:text-primary-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-primary-500">
                        <span>Subir archivos</span>
                        <input wire:model="archivos_adjuntos" id="archivos_adjuntos" name="archivos_adjuntos" type="file" class="sr-only" multiple>
                    </label>
                    <p class="pl-1">o arrastrar y soltar</p>
                </div>
                <p class="text-xs text-secondary-500">
                    PDF, JPG, JPEG, PNG hasta 10MB cada uno
                </p>
            </div>
        </div>
        <!-- Progress Bar -->
        <div x-show="isUploading">
            <progress max="100" x-bind:value="progress" class="w-full"></progress>
        </div>
    </div>

    <!-- Campo para descripción general de archivos -->
    <div class="mb-4">
        <label for="archivos_descripcion" class="block text-sm font-medium text-secondary-700 mb-2">
            Descripción de los Documentos (Opcional)
        </label>
        <textarea wire:model.live="archivos_descripcion" id="archivos_descripcion" rows="2" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500" placeholder="Breve descripción de los documentos adjuntos..."></textarea>
    </div>
    @endif

    <!-- Lista de archivos seleccionados/existentes -->
    <div id="lista_archivos_container">
        <label class="block text-sm font-medium text-secondary-700 mb-2">
            {{ $modo == 'show' ? 'Documentos de la Entidad:' : 'Archivos Seleccionados:' }}
        </label>
        <div class="space-y-2">
            <!-- Archivos Existentes -->
            @if (count($archivos_existentes) > 0)
                @foreach ($archivos_existentes as $archivo)
                    <div class="flex items-center justify-between bg-white border border-secondary-200 rounded-lg p-3 mb-2">
                        <div class="flex items-center flex-1">
                            <div class="flex-shrink-0 mr-3">
                                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <a href="{{ Storage::url($archivo->ruta_archivo) }}" target="_blank" class="font-medium text-secondary-900 truncate hover:text-primary-600 transition-colors duration-200">
                                    {{ $archivo->nombre_archivo }}
                                </a>
                                <div class="text-sm text-secondary-600">
                                    {{ round($archivo->tamano / 1024, 2) }} KB
                                    @if($archivo->descripcion)
                                        • {{ $archivo->descripcion }}
                                    @endif
                                </div>
                            </div>
                        </div>
                        @if($modo != 'show')
                        <button wire:click.prevent="eliminarArchivoExistente({{ $archivo->id_archivo }})" type="button" class="text-red-600 hover:text-red-800 p-1 ml-2 transition-colors duration-200" title="Eliminar archivo">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                        @endif
                    </div>
                @endforeach
            @endif

            <!-- Archivos Nuevos -->
            @if (count($archivos_adjuntos) > 0)
                @foreach ($archivos_adjuntos as $index => $archivo)
                    <div class="flex items-center justify-between bg-white border border-secondary-200 rounded-lg p-3 mb-2">
                        <div class="flex items-center flex-1">
                            <div class="flex-1 min-w-0">
                                <div class="font-medium text-secondary-900 truncate">{{ $archivo->getClientOriginalName() }}</div>
                                <div class="text-sm text-secondary-600">{{ round($archivo->getSize() / 1024, 2) }} KB</div>
                            </div>
                        </div>
                        <button wire:click.prevent="removeUpload('archivos_adjuntos', '{{ $archivo->getFilename() }}')" type="button" class="text-red-600 hover:text-red-800 p-1">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                @endforeach
            @endif

            <!-- Mensaje cuando no hay archivos -->
            @if (count($archivos_existentes) == 0 && count($archivos_adjuntos) == 0)
                <div class="text-center py-8 border-2 border-dashed border-secondary-200 rounded-lg">
                    <svg class="mx-auto h-8 w-8 text-secondary-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <p class="text-sm text-secondary-500">{{ $modo == 'show' ? 'No hay documentos adjuntos' : 'No hay archivos seleccionados' }}</p>
                </div>
            @endif
        </div>
    </div>
</div>
```

### **PASO 10: CONFIGURAR ALMACENAMIENTO**

#### 10.1 Verificar Configuración de Storage
**Archivo: `config/filesystems.php`**

```php
// Verificar que el disco 'public' esté configurado
'disks' => [
    'public' => [
        'driver' => 'local',
        'root' => storage_path('app/public'),
        'url' => env('APP_URL').'/storage',
        'visibility' => 'public',
    ],
],
```

#### 10.2 Crear Enlace Simbólico
```bash
# Crear enlace simbólico para acceso público a archivos
php artisan storage:link
```

#### 10.3 Crear Directorios de Archivos
```bash
# Crear directorios para cada tipo de entidad
mkdir -p storage/app/public/archivos_[entidad]
```

### **PASO 11: AGREGAR COLUMNA DE ARCHIVOS EN LISTADO (OPCIONAL)**

#### 11.1 Modificar Vista Index para Mostrar Archivos
**Archivo: `resources/views/livewire/[entidad]/index.blade.php`**

**🔥 AGREGAR COLUMNA EN LA TABLA:**

```blade
<!-- En el header de la tabla -->
<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">
    Archivos
</th>

<!-- En el cuerpo de la tabla -->
<td class="px-6 py-4 whitespace-nowrap text-center">
    @if($entidad->cantidad_archivos > 0)
        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            {{ $entidad->cantidad_archivos }}
        </span>
    @else
        <span class="text-secondary-400 text-sm">Sin archivos</span>
    @endif
</td>
```

### **PASO 12: CONFIGURAR VALIDACIONES DE ARCHIVOS**

#### 12.1 Agregar Validaciones Específicas
**En el componente Form, método `guardarArchivos()`:**

```php
public function guardarArchivos($idEntidad)
{
    // 🔥 VALIDACIONES ESPECÍFICAS PARA ARCHIVOS
    $this->validate([
        'archivos_adjuntos.*' => [
            'file',
            'max:10240', // 10MB máximo
            'mimes:pdf,jpg,jpeg,png,doc,docx', // Tipos permitidos
        ],
    ], [
        'archivos_adjuntos.*.file' => 'Cada archivo debe ser un archivo válido.',
        'archivos_adjuntos.*.max' => 'Cada archivo no puede ser mayor a 10MB.',
        'archivos_adjuntos.*.mimes' => 'Solo se permiten archivos PDF, JPG, JPEG, PNG, DOC y DOCX.',
    ]);

    foreach ($this->archivos_adjuntos as $archivo) {
        // Generar nombre único para evitar conflictos
        $nombreArchivo = time() . '_' . $archivo->getClientOriginalName();
        $rutaArchivo = $archivo->storeAs('archivos_[entidad]', $nombreArchivo, 'public');

        ArchivoAdjunto::create([
            'tipo_entidad' => '[entidad]',
            'id_entidad' => $idEntidad,
            'nombre_archivo' => $archivo->getClientOriginalName(),
            'tipo_archivo' => $archivo->getClientOriginalExtension(),
            'tamano' => $archivo->getSize(),
            'ruta_archivo' => $rutaArchivo,
            'descripcion' => $this->archivos_descripcion,
            'id_usuario_carga' => Auth::id(),
            'fecha_carga' => now(),
        ]);
    }

    // Limpiar archivos después de guardar
    $this->archivos_adjuntos = [];
    $this->archivos_descripcion = '';
}
```

---

## 🔥 **CHECKLIST DE VERIFICACIÓN PARA ARCHIVOS**

### ✅ **Modelo ArchivoAdjunto**
- [ ] Modelo creado con campos correctos
- [ ] Relaciones configuradas
- [ ] Métodos auxiliares implementados (getUrlAttribute, getTamanoFormateadoAttribute)
- [ ] Scopes para filtrar por entidad

### ✅ **Modelo Principal**
- [ ] Relación hasMany con ArchivoAdjunto
- [ ] Método tieneArchivos() implementado
- [ ] Accessor getCantidadArchivosAttribute
- [ ] Boot method para eliminar archivos al borrar entidad

### ✅ **Componente Livewire**
- [ ] WithFileUploads incluido
- [ ] Propiedades para archivos definidas
- [ ] Método mount() carga archivos existentes
- [ ] Método eliminarArchivoExistente() implementado
- [ ] Método guardarArchivos() implementado
- [ ] Método guardar() modificado para incluir archivos

### ✅ **Vista**
- [ ] Sección de archivos agregada al formulario
- [ ] Drag & drop implementado
- [ ] Progress bar para subida
- [ ] Lista de archivos existentes
- [ ] Lista de archivos nuevos
- [ ] Botones de eliminación
- [ ] Enlaces para descargar/ver archivos

### ✅ **Configuración**
- [ ] Storage configurado correctamente
- [ ] Enlace simbólico creado (php artisan storage:link)
- [ ] Directorios de archivos creados
- [ ] Validaciones de archivos implementadas

### ✅ **Seguridad**
- [ ] Validación de tipos de archivo
- [ ] Validación de tamaño máximo
- [ ] Nombres únicos para evitar conflictos
- [ ] Eliminación segura de archivos

---

## 🚨 **ERRORES COMUNES CON ARCHIVOS Y SOLUCIONES**

### Error: "The file could not be uploaded"
**Solución:** Verificar permisos de escritura en `storage/app/public`
```bash
chmod -R 775 storage/app/public
```

### Error: "Storage link not found"
**Solución:** Crear enlace simbólico
```bash
php artisan storage:link
```

### Error: "File not found" al mostrar archivos
**Solución:** Verificar configuración de APP_URL en `.env`
```env
APP_URL=http://localhost:8000
```

### Error: "Max file size exceeded"
**Solución:** Configurar límites en `php.ini`
```ini
upload_max_filesize = 10M
post_max_size = 10M
max_execution_time = 300
```

### Error: "CSRF token mismatch" en subida
**Solución:** Verificar que el formulario tenga `@csrf` y use `wire:submit.prevent`

---

¡Con esta integración de archivos, tu CRUD tendrá funcionalidad completa de gestión de documentos! 📎🚀

---

## 📊 **IMPLEMENTACIÓN DE FUNCIONALIDADES DE EXPORTACIÓN**

### **CUÁNDO USAR ESTA SECCIÓN**
Esta sección es para pantallas que necesitan:
- ✅ Exportar datos a CSV
- ✅ Exportar datos a Excel
- ✅ Exportar datos a PDF
- ✅ Aplicar filtros a las exportaciones
- ✅ Respetar permisos de usuario en exportaciones
### **PASO 12.5: (OBLIGATORIO) CREAR HELPER PARA CODIFICACIÓN**

Para evitar problemas con caracteres especiales (tildes, ñ) en los archivos exportados, es crucial crear una función de ayuda (helper) que asegure la correcta codificación UTF-8.

#### 12.5.1 Crear el archivo de helpers
**Archivo: `app/helpers.php`**

```php
<?php

if (!function_exists('export_clean')) {
    /**
     * Limpia una cadena para exportación, asegurando la codificación UTF-8 correcta.
     *
     * @param string|null $string
     * @return string
     */
    function export_clean($string)
    {
        if ($string === null) {
            return '';
        }
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }
}
```

#### 12.5.2 Registrar el helper en composer.json
**Archivo: `composer.json`**

Agrega la sección `files` dentro de `autoload` para que Laravel cargue automáticamente tu helper.

```json
{
    "autoload": {
        "psr-4": {
            "App\\": "app/",
            "Database\\Factories\\": "database/factories/",
            "Database\\Seeders\\": "database/seeders/"
        },
        "files": [
            "app/helpers.php"
        ]
    },
    "autoload-dev": {
        ...
    }
}
```

#### 12.5.3 Actualizar el autoloader de Composer
Finalmente, ejecuta este comando en tu terminal para que los cambios surtan efecto:

```bash
composer dump-autoload
```

Ahora podrás usar la función `export_clean()` en cualquier parte de tu aplicación, especialmente en los métodos de exportación.

### **PASO 13: CREAR CONTROLADOR DE EXPORTACIÓN**

#### 13.1 Crear Controlador Específico para Exportaciones
```bash
# 🔍 PRIMERO: Crear el controlador de exportación
php artisan make:controller [Entidad]ExportController
```

**Archivo: `app/Http/Controllers/[Entidad]ExportController.php`**

```php
<?php

namespace App\Http\Controllers;

use App\Models\[Entidad];
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;

class [Entidad]ExportController extends Controller
{
    public function exportarCSV(Request $request)
    {
        $entidades = $this->getEntidadesFiltradas($request);
        
        $filename = '[entidad]_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($entidades) {
            $file = fopen('php://output', 'w');
            
            // BOM para UTF-8
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Encabezados usando fputcsv estándar con comas
            fputcsv($file, [
                'Campo 1',
                'Campo 2',
                'Campo 3',
                'Estado',
                'Fecha Creación'
                // ... agregar todos los campos que quieras exportar
            ], ',', '"');

            // Datos
            foreach ($entidades as $entidad) {
                fputcsv($file, [
                    $entidad->campo1,
                    $entidad->campo2,
                    $entidad->campo3,
                    $entidad->activo ? 'Activo' : 'Inactivo',
                    $entidad->created_at ? $entidad->created_at->format('d/m/Y H:i') : 'N/A'
                    // ... agregar todos los campos correspondientes
                ], ',', '"');
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    public function exportarExcel(Request $request)
    {
        $entidades = $this->getEntidadesFiltradas($request);
        $filename = '[entidad]_' . date('Y-m-d_H-i-s') . '.xls';
        
        $headers = [
            'Content-Type' => 'application/vnd.ms-excel; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $html = $this->generarHTMLParaExcel($entidades);
        return Response::make($html, 200, $headers);
    }

    public function exportarPDF(Request $request)
    {
        $entidades = $this->getEntidadesFiltradas($request);
        
        $html = $this->generarHTMLParaPDF($entidades);
        
        $headers = [
            'Content-Type' => 'text/html; charset=UTF-8',
        ];

        return Response::make($html, 200, $headers);
    }

    private function getEntidadesFiltradas(Request $request)
    {
        $query = [Entidad]::query()
            ->with([
                // Agregar relaciones necesarias
                'relacion1',
                'relacion2'
            ]);

        // 🔥 APLICAR FILTROS SI EXISTEN
        if ($request->has('filtro_campo1') && $request->filtro_campo1) {
            $query->where('campo1', 'like', '%' . $request->filtro_campo1 . '%');
        }

        if ($request->has('filtro_campo2') && $request->filtro_campo2) {
            $query->where('campo2', 'like', '%' . $request->filtro_campo2 . '%');
        }

        if ($request->has('filtro_estado') && $request->filtro_estado !== '') {
            $activo = $request->filtro_estado === 'activo';
            $query->where('activo', $activo);
        }

        // 🔥 APLICAR FILTROS POR ROL DE USUARIO (si aplica)
        $usuario = Auth::user();
        if ($usuario && $usuario->id_rol == 1 && $usuario->id_escuela) {
            // Ejemplo: usuarios generales solo ven datos de su escuela
            $query->where('id_escuela', $usuario->id_escuela);
        }

        return $query->orderBy('campo_principal', 'desc')->get();
    }

    private function generarHTMLParaExcel($entidades)
    {
        $html = '<?xml version="1.0" encoding="UTF-8"?>
        <Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"
         xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet">
         <Styles>
          <Style ss:ID="Header"><Font ss:Bold="1"/></Style>
         </Styles>
         <Worksheet ss:Name="[Entidad]">
          <Table>
           <Row>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Campo 1</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Campo 2</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Campo 3</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Estado</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Fecha Creación</Data></Cell>
           </Row>';

        foreach ($entidades as $entidad) {
            $html .= '<Row>
             <Cell><Data ss:Type="String">' . export_clean($entidad->campo1) . '</Data></Cell>
             <Cell><Data ss:Type="String">' . export_clean($entidad->campo2) . '</Data></Cell>
             <Cell><Data ss:Type="String">' . export_clean($entidad->campo3) . '</Data></Cell>
             <Cell><Data ss:Type="String">' . export_clean($entidad->activo ? 'Activo' : 'Inactivo') . '</Data></Cell>
             <Cell><Data ss:Type="String">' . ($entidad->created_at ? $entidad->created_at->format('d/m/Y H:i') : 'N/A') . '</Data></Cell>
            </Row>';
        }

        $html .= '  </Table>
         </Worksheet>
        </Workbook>';

        return $html;
    }

    private function generarHTMLParaPDF($entidades)
    {
        $html = '<!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>Reporte de [Entidad]</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    font-size: 12px;
                    margin: 20px;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-top: 20px;
                }
                th, td {
                    border: 1px solid #ddd;
                    padding: 8px;
                    text-align: left;
                    font-size: 11px;
                }
                th {
                    background-color: #f2f2f2;
                    font-weight: bold;
                }
                .header {
                    text-align: center;
                    margin-bottom: 20px;
                }
                .fecha {
                    text-align: right;
                    margin-bottom: 10px;
                    font-size: 10px;
                }
                .footer {
                    margin-top: 30px;
                    text-align: center;
                    font-size: 10px;
                    color: #666;
                }
                @media print {
                    body { margin: 0; }
                    .no-print { display: none; }
                }
            </style>
        </head>
        <body>
            <div class="fecha">Generado el: ' . date('d/m/Y H:i') . '</div>
            <div class="header">
                <h1>Reporte de [Entidad]</h1>
                <p>Sistema [Nombre del Sistema]</p>
            </div>
            
            <div class="no-print" style="margin-bottom: 20px; text-align: center;">
                <button onclick="window.print()" style="padding: 10px 20px; background: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer;">
                    🖨️ Imprimir / Guardar como PDF
                </button>
            </div>
            
            <table>
                <thead>
                    <tr>
                        <th>Campo 1</th>
                        <th>Campo 2</th>
                        <th>Campo 3</th>
                        <th>Estado</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>';

        foreach ($entidades as $entidad) {
            $html .= '<tr>
                <td>' . htmlspecialchars($entidad->campo1) . '</td>
                <td>' . htmlspecialchars($entidad->campo2) . '</td>
                <td>' . htmlspecialchars($entidad->campo3) . '</td>
                <td>' . ($entidad->activo ? 'Activo' : 'Inactivo') . '</td>
                <td>' . ($entidad->created_at ? $entidad->created_at->format('d/m/Y') : 'N/A') . '</td>
            </tr>';
        }

        $html .= '</tbody>
            </table>
            
            <div class="footer">
                <p>Total de registros: ' . count($entidades) . '</p>
                <p>Sistema [Nombre del Sistema] - ' . date('Y') . '</p>
            </div>
        </body>
        </html>';

        return $html;
    }
}
```

### **PASO 14: AGREGAR RUTAS DE EXPORTACIÓN**

**Archivo: `routes/web.php`**

**🔥 AGREGAR DENTRO DEL GRUPO DE RUTAS DE TU ENTIDAD:**

```php
// Rutas para [Entidad]
Route::prefix('[entidad]')->name('[entidad].')->middleware('auth')->group(function () {
    Route::get('/', \App\Livewire\[Entidad]\Index::class)->name('index');

    Route::get('/create', function () {
        return view('[entidad].form', ['modo' => 'create']);
    })->name('create');

    Route::get('/{id}/edit', function ($id) {
        return view('[entidad].form', ['modo' => 'edit', 'entidad_id' => $id]);
    })->name('edit');

    Route::get('/{id}', function ($id) {
        return view('[entidad].form', ['modo' => 'show', 'entidad_id' => $id]);
    })->name('show');

    // 🔥 AGREGAR: Rutas de exportación
    Route::get('/export/csv', [\App\Http\Controllers\[Entidad]ExportController::class, 'exportarCSV'])->name('export.csv');
    Route::get('/export/excel', [\App\Http\Controllers\[Entidad]ExportController::class, 'exportarExcel'])->name('export.excel');
    Route::get('/export/pdf', [\App\Http\Controllers\[Entidad]ExportController::class, 'exportarPDF'])->name('export.pdf');
});
```

### **PASO 15: AGREGAR BOTONES DE EXPORTACIÓN EN LA VISTA**

#### 15.1 Agregar Dropdown de Exportación en el Header
**Archivo: `resources/views/livewire/[entidad]/index.blade.php`**

**🔥 AGREGAR EN LA SECCIÓN DEL HEADER (junto al botón "Nuevo"):**

```blade
<!-- Header Section -->
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 mb-8">
    <div>
        <h1 class="text-2xl font-semibold text-secondary-900">Gestión de [Entidad]</h1>
        <p class="mt-1 text-sm text-secondary-600">Administra los registros de [entidad] en el sistema</p>
    </div>
    <div class="flex items-center space-x-3">
        <!-- 🔥 AGREGAR: Botón de Exportar -->
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open" class="inline-flex items-center px-4 py-2 bg-white border border-secondary-300 rounded-lg font-medium text-sm text-secondary-700 hover:bg-secondary-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                <i class="fas fa-download mr-2"></i>
                Exportar
                <i class="fas fa-chevron-down ml-2 -mr-1 h-5 w-5"></i>
            </button>
            <div x-show="open"
                 @click.away="open = false"
                 class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-10"
                 style="display:none;"
                 x-transition:enter="transition ease-out duration-100"
                 x-transition:enter-start="transform opacity-0 scale-95"
                 x-transition:enter-end="transform opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="transform opacity-100 scale-100"
                 x-transition:leave-end="transform opacity-0 scale-95">
                <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                    <button onclick="exportar[Entidad]('csv')" class="flex items-center gap-2 px-4 py-2 text-sm text-secondary-700 hover:bg-secondary-100 hover:text-secondary-900 w-full text-left" role="menuitem">
                        <i class="fas fa-file-csv fa-fw text-secondary-400"></i>
                        Exportar a CSV
                    </button>
                    <button onclick="exportar[Entidad]('excel')" class="flex items-center gap-2 px-4 py-2 text-sm text-secondary-700 hover:bg-secondary-100 hover:text-secondary-900 w-full text-left" role="menuitem">
                        <i class="fas fa-file-excel fa-fw text-secondary-400"></i>
                        Exportar a Excel
                    </button>
                    <button onclick="exportar[Entidad]('pdf')" class="flex items-center gap-2 px-4 py-2 text-sm text-secondary-700 hover:bg-secondary-100 hover:text-secondary-900 w-full text-left" role="menuitem">
                        <i class="fas fa-file-pdf fa-fw text-secondary-400"></i>
                        Exportar a PDF
                    </button>
                </div>
            </div>
        </div>
        <!-- Botón Nuevo [Entidad] -->
        <a href="{{ route('[entidad].create') }}" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-lg font-medium text-sm text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Nuevo [Entidad]
        </a>
    </div>
</div>
```

#### 15.2 Agregar JavaScript para Exportación
**🔥 AGREGAR AL FINAL DE LA VISTA, ANTES DEL `@endpush`:**

```blade
@push('scripts')
<script>
    // Función para exportar [entidad]
    function exportar[Entidad](formato) {
        // Obtener los valores actuales de los filtros
        const filtroCampo1 = document.getElementById('filtro_campo1')?.value || '';
        const filtroCampo2 = document.getElementById('filtro_campo2')?.value || '';
        const filtroEstado = document.getElementById('filtro_estado')?.value || '';
        
        // Construir la URL con los parámetros
        const params = new URLSearchParams();
        if (filtroCampo1) params.append('filtro_campo1', filtroCampo1);
        if (filtroCampo2) params.append('filtro_campo2', filtroCampo2);
        if (filtroEstado) params.append('filtro_estado', filtroEstado);
        
        // Determinar la URL según el formato
        let url = '';
        switch(formato) {
            case 'csv':
                url = '{{ route("[entidad].export.csv") }}';
                break;
            case 'excel':
                url = '{{ route("[entidad].export.excel") }}';
                break;
            case 'pdf':
                url = '{{ route("[entidad].export.pdf") }}';
                break;
        }
        
        // Agregar parámetros a la URL
        if (params.toString()) {
            url += '?' + params.toString();
        }
        
        // Abrir la URL en una nueva ventana/pestaña
        window.open(url, '_blank');
    }
</script>
@endpush
```

### **PASO 16: PERSONALIZAR CAMPOS DE EXPORTACIÓN**

#### 16.1 Configurar Campos Específicos por Entidad
**En el controlador de exportación, personalizar los arrays de campos:**

```php
// 🔥 PERSONALIZAR: Encabezados según tu entidad
fputcsv($file, [
    'ID',
    'Nombre',
    'Email',
    'Teléfono',
    'Escuela',
    'Estado',
    'Fecha Registro'
], ',', '"');

// 🔥 PERSONALIZAR: Datos según tu entidad
foreach ($entidades as $entidad) {
    fputcsv($file, [
        $entidad->id_[entidad],
        $entidad->nombre_completo,
        $entidad->email,
        $entidad->telefono,
        $entidad->escuela->nombre ?? 'Sin escuela',
        $entidad->activo ? 'Activo' : 'Inactivo',
        $entidad->created_at ? $entidad->created_at->format('d/m/Y H:i') : 'N/A'
    ], ',', '"');
}
```

#### 16.2 Agregar Filtros Específicos por Entidad
**En el método `getEntidadesFiltradas()`, agregar filtros específicos:**

```php
// 🔥 PERSONALIZAR: Filtros según tu entidad
if ($request->has('filtro_nombre') && $request->filtro_nombre) {
    $query->where('nombre', 'like', '%' . $request->filtro_nombre . '%');
}

if ($request->has('filtro_email') && $request->filtro_email) {
    $query->where('email', 'like', '%' . $request->filtro_email . '%');
}

if ($request->has('filtro_escuela') && $request->filtro_escuela) {
    $query->where('id_escuela', $request->filtro_escuela);
}

if ($request->has('filtro_fecha_desde') && $request->filtro_fecha_desde) {
    $query->whereDate('created_at', '>=', $request->filtro_fecha_desde);
}

if ($request->has('filtro_fecha_hasta') && $request->filtro_fecha_hasta) {
    $query->whereDate('created_at', '<=', $request->filtro_fecha_hasta);
}
```

---

## 🔥 **CHECKLIST DE VERIFICACIÓN PARA EXPORTACIONES**

### ✅ **Controlador de Exportación**
- [ ] Controlador creado con métodos para CSV, Excel y PDF
- [ ] Método getEntidadesFiltradas() implementado
- [ ] Filtros aplicados correctamente
- [ ] Permisos por rol implementados
- [ ] Headers HTTP correctos para cada formato

### ✅ **Rutas**
- [ ] Rutas de exportación agregadas
- [ ] Middleware de autenticación aplicado
- [ ] Nombres de rutas consistentes

### ✅ **Vista**
- [ ] Dropdown de exportación agregado
- [ ] JavaScript para capturar filtros implementado
- [ ] Función de exportación conectada a rutas
- [ ] Iconos y estilos aplicados

### ✅ **Formatos de Exportación**
- [ ] CSV con formato estándar (comas, comillas)
- [ ] Excel con formato XML nativo
- [ ] PDF con HTML optimizado para impresión
- [ ] Nombres de archivo con timestamp

### ✅ **Funcionalidad**
- [ ] Filtros aplicados a exportaciones
- [ ] Datos exportados correctamente
- [ ] Archivos descargables
- [ ] Compatibilidad con aplicaciones externas

---

## 🚨 **ERRORES COMUNES CON EXPORTACIONES Y SOLUCIONES**

### Error: "Headers already sent"
**Solución:** Verificar que no haya salida antes de los headers
```php
// Asegurarse de que no hay espacios o echo antes de Response::stream()
```

### Error: "File not downloading"
**Solución:** Verificar headers de Content-Disposition
```php
'Content-Disposition' => 'attachment; filename="' . $filename . '"',
```

### Error: "Excel file corrupted"
**Solución:** Verificar formato XML y Content-Type
```php
'Content-Type' => 'application/vnd.ms-excel',
```

### Error: "CSV with wrong encoding"
**Solución:** Agregar BOM para UTF-8
```php
fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
```

### Error: "Filters not applied"
**Solución:** Verificar que JavaScript capture correctamente los valores de filtros
```javascript
const filtro = document.getElementById('filtro_campo')?.value || '';
```

---

## 🎯 **RESULTADO ESPERADO CON EXPORTACIONES**

Al completar todos los pasos, tendrás:

✅ **Sistema de exportación completo** en 3 formatos
✅ **Filtros aplicados** a las exportaciones
✅ **Permisos por rol** respetados en exportaciones
✅ **Archivos descargables** con nombres únicos
✅ **Compatibilidad** con Excel, hojas de cálculo y navegadores
✅ **Interfaz profesional** con dropdown de opciones
✅ **JavaScript funcional** que captura filtros actuales

¡Tu CRUD ahora tiene funcionalidad completa de exportación de datos! 📊🚀