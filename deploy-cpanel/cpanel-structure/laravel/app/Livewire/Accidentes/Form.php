<?php

namespace App\Livewire\Accidentes;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Accidente;
use App\Models\Escuela;
use App\Models\CatEstadoAccidente;
use App\Models\Alumno;
use App\Models\AccidenteAlumno;
use App\Models\ArchivoAdjunto;
use App\Models\User;
use App\Services\AuditoriaService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class Form extends Component
{
    use WithFileUploads;
    
    public $modo = 'create';
    public $accidente_id;

    // PROPIEDADES: Una por cada campo del formulario
    public $id_escuela;
    public $fecha_accidente;
    public $hora_accidente;
    public $lugar_accidente;
    public $descripcion_accidente;
    public $tipo_lesion;
    public $protocolo_activado = false;
    public $llamada_emergencia = false;
    public $hora_llamada;
    public $servicio_emergencia;
    public $numero_expediente;
    public $id_estado_accidente;
    public $id_usuario_carga; // Se llenará automáticamente

    // ALUMNOS SELECCIONADOS
    public $alumnos_seleccionados = [];
    public $buscar_alumno = '';
    public $grado_seccion_actual = '';
    public $mostrar_dropdown = false;

    // MENSAJES DE RETROALIMENTACIÓN
    public $mensaje = '';
    public $tipoMensaje = '';

    // CONTROL DE ROL DE USUARIO
    public $es_usuario_general = false;
    
    // NUEVOS ALUMNOS
    public $mostrar_modal_alumno = false;
    public $nuevo_alumno = [
        'nombre' => '',
        'apellido' => '',
        'dni' => '',
        'cuil' => '',
        'fecha_nacimiento' => '',
        'familiar1' => '',
        'telefono_contacto1' => ''
    ];

    // ARCHIVOS
    public $archivos_descripcion = '';
    public $archivos_adjuntos = [];
    public $archivos_existentes = [];

    // VALIDACIONES
    protected function rules()
    {
        return [
            'id_escuela' => 'required|integer|exists:escuelas,id_escuela',
            'fecha_accidente' => 'required|date|before_or_equal:today',
            'hora_accidente' => 'required|date_format:H:i',
            'lugar_accidente' => 'required|string|max:200',
            'descripcion_accidente' => 'required|string',
            'tipo_lesion' => 'required|string|max:200',
            'protocolo_activado' => 'boolean',
            'llamada_emergencia' => 'boolean',
            'hora_llamada' => 'nullable|date_format:H:i',
            'servicio_emergencia' => 'nullable|string|max:100',
            'numero_expediente' => 'nullable|string|max:50',
            'id_estado_accidente' => 'required|integer|exists:cat_estados_accidentes,id_estado_accidente',
            'alumnos_seleccionados' => 'required|array|min:1',
            'alumnos_seleccionados.*.id_alumno' => 'required|integer|exists:alumnos,id_alumno',
            'alumnos_seleccionados.*.grado_seccion' => 'nullable|string|max:100',
        ];
    }

    // MENSAJES EN ESPAÑOL
    protected function messages()
    {
        return [
            'id_escuela.required' => 'La escuela es obligatoria.',
            'id_escuela.integer' => 'El ID de la escuela debe ser un número entero.',
            'id_escuela.exists' => 'La escuela seleccionada no es válida.',
            'fecha_accidente.required' => 'La fecha del accidente es obligatoria.',
            'fecha_accidente.date' => 'La fecha del accidente debe ser una fecha válida.',
            'fecha_accidente.before_or_equal' => 'La fecha del accidente no puede ser futura.',
            'hora_accidente.required' => 'La hora del accidente es obligatoria.',
            'hora_accidente.date_format' => 'La hora del accidente debe tener el formato HH:MM.',
            'lugar_accidente.required' => 'El lugar del accidente es obligatorio.',
            'lugar_accidente.max' => 'El lugar del accidente no puede exceder los 200 caracteres.',
            'descripcion_accidente.required' => 'La descripción del accidente es obligatoria.',
            'tipo_lesion.required' => 'El tipo de lesión es obligatorio.',
            'tipo_lesion.max' => 'El tipo de lesión no puede exceder los 200 caracteres.',
            'hora_llamada.date_format' => 'La hora de llamada debe tener el formato HH:MM.',
            'servicio_emergencia.max' => 'El servicio de emergencia no puede exceder los 100 caracteres.',
            'numero_expediente.max' => 'El número de expediente no puede exceder los 50 caracteres.',
            'id_estado_accidente.required' => 'El estado del accidente es obligatorio.',
            'id_estado_accidente.integer' => 'El ID del estado debe ser un número entero.',
            'id_estado_accidente.exists' => 'El estado seleccionado no es válido.',
            'alumnos_seleccionados.required' => 'Debe seleccionar al menos un alumno.',
            'alumnos_seleccionados.min' => 'Debe seleccionar al menos un alumno.',
            'alumnos_seleccionados.*.id_alumno.required' => 'El ID del alumno es obligatorio.',
            'alumnos_seleccionados.*.id_alumno.exists' => 'Uno de los alumnos seleccionados no es válido.',
            'alumnos_seleccionados.*.grado_seccion.max' => 'El grado/sección no puede exceder los 100 caracteres.',
        ];
    }

    public function mount($modo = 'create', $accidente_id = null)
    {
        $this->modo = $modo;
        $this->id_usuario_carga = Auth::id(); // Asignar el ID del usuario autenticado

        // Obtener la escuela del usuario y verificar su rol
        $usuario = Auth::user();
        if ($usuario) {
            // Verificar si es usuario general (rol ID = 1)
            $this->es_usuario_general = $usuario->id_rol == 1;
            
            // Si es usuario general y tiene escuela asignada, establecerla automáticamente
            if ($this->es_usuario_general && $usuario->id_escuela) {
                $this->id_escuela = $usuario->id_escuela;
            }
        }

        // Establecer estado por defecto (asumiendo que existe un estado "Activo" con ID 1)
        $this->id_estado_accidente = 1;

        if ($accidente_id) {
            $this->accidente_id = $accidente_id;
            $accidente = Accidente::with(['alumnos.alumno', 'archivos'])->findOrFail($accidente_id);
            
            $this->id_escuela = $accidente->id_escuela;
            $this->fecha_accidente = $accidente->fecha_accidente->format('Y-m-d');
            $this->hora_accidente = $accidente->hora_accidente ? $accidente->hora_accidente->format('H:i') : null;
            $this->lugar_accidente = $accidente->lugar_accidente;
            $this->descripcion_accidente = $accidente->descripcion_accidente;
            $this->tipo_lesion = $accidente->tipo_lesion;
            $this->protocolo_activado = $accidente->protocolo_activado;
            $this->llamada_emergencia = $accidente->llamada_emergencia;
            $this->hora_llamada = $accidente->hora_llamada ? $accidente->hora_llamada->format('H:i') : null;
            $this->servicio_emergencia = $accidente->servicio_emergencia;
            $this->numero_expediente = $accidente->numero_expediente;
            $this->id_estado_accidente = $accidente->id_estado_accidente;
            
            // Cargar alumnos asociados con sus grados
            $this->alumnos_seleccionados = $accidente->alumnos->map(function ($accidenteAlumno) {
                return [
                    'id_alumno' => $accidenteAlumno->id_alumno,
                    'grado_seccion' => $accidenteAlumno->grado_seccion ?? ''
                ];
            })->toArray();

            // Cargar archivos existentes
            $this->archivos_existentes = $accidente->archivos;
        }
    }

    public function render()
    {
        $escuelas = Escuela::where('activo', true)->orderBy('nombre')->get();
        $estados = CatEstadoAccidente::orderBy('nombre_estado')->get();
        
        // Cargar alumnos de la escuela seleccionada para el autocompletado
        $alumnos = [];
        if ($this->id_escuela) {
            $alumnos = Alumno::where('id_escuela', $this->id_escuela)
                           ->where('activo', true)
                           ->orderBy('nombre')
                           ->orderBy('apellido')
                           ->get();
        }
        
        return view('livewire.accidentes.form', compact('escuelas', 'estados', 'alumnos'));
    }

    public function guardar()
    {
        // Validación personalizada para grados/secciones
        if (!$this->validarGradosSecciones()) {
            return; // Si la validación falla, no continuar
        }

        $this->validate();

        $data = [
            'id_escuela' => $this->id_escuela,
            'fecha_accidente' => $this->fecha_accidente,
            'hora_accidente' => $this->hora_accidente,
            'lugar_accidente' => $this->lugar_accidente,
            'descripcion_accidente' => $this->descripcion_accidente,
            'tipo_lesion' => $this->tipo_lesion,
            'protocolo_activado' => $this->protocolo_activado,
            'llamada_emergencia' => $this->llamada_emergencia,
            'hora_llamada' => $this->hora_llamada,
            'servicio_emergencia' => $this->servicio_emergencia,
            'numero_expediente' => $this->numero_expediente,
            'id_estado_accidente' => $this->id_estado_accidente,
            'id_usuario_carga' => $this->id_usuario_carga,
        ];

        if ($this->modo == 'create') {
            $accidente = Accidente::create($data);
            
            // Asociar alumnos al accidente con sus grados/secciones
            foreach ($this->alumnos_seleccionados as $alumnoSeleccionado) {
                AccidenteAlumno::create([
                    'id_accidente' => $accidente->id_accidente,
                    'id_alumno' => $alumnoSeleccionado['id_alumno'],
                    'grado_seccion' => $alumnoSeleccionado['grado_seccion']
                ]);
            }
            
            // Guardar archivos adjuntos
            $this->guardarArchivos($accidente->id_accidente);
            
            AuditoriaService::registrarCreacion('accidentes', $accidente->id_accidente, $data);
            
            $this->mensaje = 'Accidente creado exitosamente.';
            $this->tipoMensaje = 'success';
            $this->dispatch('mostrar-mensaje-y-redirigir');
        } else {
            $accidente = Accidente::findOrFail($this->accidente_id);
            $datosAnteriores = $accidente->getOriginal();
            $accidente->update($data);
            
            // Actualizar relación de alumnos
            AccidenteAlumno::where('id_accidente', $accidente->id_accidente)->delete();
            foreach ($this->alumnos_seleccionados as $alumnoSeleccionado) {
                AccidenteAlumno::create([
                    'id_accidente' => $accidente->id_accidente,
                    'id_alumno' => $alumnoSeleccionado['id_alumno'],
                    'grado_seccion' => $alumnoSeleccionado['grado_seccion']
                ]);
            }
            
            // Guardar archivos adjuntos nuevos
            $this->guardarArchivos($accidente->id_accidente);
            
            AuditoriaService::registrarActualizacion('accidentes', $accidente->id_accidente, $datosAnteriores, $data);
            
            $this->mensaje = 'Accidente actualizado exitosamente.';
            $this->tipoMensaje = 'success';
            $this->dispatch('mostrar-mensaje');
        }
    }

    public function validarGradosSecciones()
    {
        if (empty($this->alumnos_seleccionados)) {
            return true;
        }

        $alumnosSinGrado = [];
        $alumnosDetalle = $this->getAlumnosSeleccionadosDetalle();

        foreach ($this->alumnos_seleccionados as $index => $alumnoSeleccionado) {
            $gradoSeccion = trim($alumnoSeleccionado['grado_seccion'] ?? '');

            if (empty($gradoSeccion)) {
                // Encontrar el nombre del alumno para el mensaje de error
                $alumnoDetalle = $alumnosDetalle->firstWhere('id_alumno', $alumnoSeleccionado['id_alumno']);
                $nombreAlumno = $alumnoDetalle ? $alumnoDetalle->nombre_completo : "Alumno #" . ($index + 1);
                $alumnosSinGrado[] = $nombreAlumno;
            }
        }

        if (!empty($alumnosSinGrado)) {
            $listaAlumnos = implode(', ', $alumnosSinGrado);
            $mensajeError = "Los siguientes alumnos necesitan grado/sección asignado: {$listaAlumnos}. Haga clic en el campo de grado/sección de cada alumno para completarlo.";

            $this->addError('alumnos_seleccionados', $mensajeError);

            // Disparar evento para mostrar modal y hacer scroll
            $this->dispatch('mostrar-error-validacion', [
                'mensaje' => $mensajeError,
                'tipo' => 'alumnos_sin_grado'
            ]);

            return false;
        }

        return true;
    }

    public function limpiarMensaje()
    {
        $this->mensaje = '';
        $this->tipoMensaje = '';
    }

    public function redirigirAlListado()
    {
        return redirect()->route('accidentes.index');
    }

    // MÉTODOS PARA MANEJO DE ALUMNOS
    public function seleccionarAlumno($idAlumno)
    {
        $alumno = Alumno::find($idAlumno);
        if ($alumno) {
            $this->buscar_alumno = $alumno->nombre_completo;
            $this->grado_seccion_actual = ''; // Limpiar grado para que el usuario ingrese uno nuevo
            $this->mostrar_dropdown = false; // Ocultar el dropdown después de seleccionar

            // Hacer foco en el campo de grado/sección
            $this->dispatch('focus-grado-seccion');
        }
    }

    public function removerAlumno($idAlumno)
    {
        $this->alumnos_seleccionados = array_filter(
            $this->alumnos_seleccionados,
            function($alumno) use ($idAlumno) {
                return $alumno['id_alumno'] != $idAlumno;
            }
        );
        $this->alumnos_seleccionados = array_values($this->alumnos_seleccionados);
    }

    public function buscarAlumnos()
    {
        if (!$this->id_escuela) {
            return collect();
        }

        // Si no hay texto de búsqueda, mostrar los primeros 20 alumnos
        if (empty($this->buscar_alumno)) {
            return Alumno::where('id_escuela', $this->id_escuela)
                          ->where('activo', true)
                          ->orderBy('nombre')
                          ->orderBy('apellido')
                          ->limit(20)
                          ->get();
        }

        // Si hay texto de búsqueda pero es muy corto, no buscar
        if (strlen($this->buscar_alumno) < 2) {
            return collect();
        }

        return Alumno::where('id_escuela', $this->id_escuela)
                      ->where('activo', true)
                      ->where(function($query) {
                          $termino = '%' . $this->buscar_alumno . '%';
                          $query->whereRaw("CONCAT(nombre, ' ', apellido) LIKE ?", [$termino])
                                ->orWhere('nombre', 'like', $termino)
                                ->orWhere('apellido', 'like', $termino)
                                ->orWhere('dni', 'like', $termino);
                      })
                      ->limit(10)
                      ->get();
    }

    public function getAlumnosSeleccionadosDetalle()
    {
        if (empty($this->alumnos_seleccionados)) {
            return collect();
        }

        $alumnosIds = collect($this->alumnos_seleccionados)->pluck('id_alumno')->toArray();
        $alumnos = Alumno::whereIn('id_alumno', $alumnosIds)->get();

        // Agregar el grado_seccion a cada alumno y el índice real
        return $alumnos->map(function ($alumno) {
            $alumnoSeleccionado = collect($this->alumnos_seleccionados)->firstWhere('id_alumno', $alumno->id_alumno);
            $alumno->grado_seccion_seleccionado = $alumnoSeleccionado['grado_seccion'] ?? '';
            
            // Encontrar el índice real del alumno en el array alumnos_seleccionados
            $indiceReal = array_search($alumno->id_alumno, array_column($this->alumnos_seleccionados, 'id_alumno'));
            $alumno->indice_real = $indiceReal !== false ? $indiceReal : 0;
            
            return $alumno;
        });
    }


    public function agregarAlumnoSeleccionado()
    {
        $this->validate([
            'buscar_alumno' => 'required|string|min:2',
            'grado_seccion_actual' => 'required|string|max:100',
        ], [
            'buscar_alumno.required' => 'Debe seleccionar un alumno del listado.',
            'buscar_alumno.min' => 'El nombre del alumno debe tener al menos 2 caracteres.',
            'grado_seccion_actual.required' => 'El grado/sección es obligatorio.',
            'grado_seccion_actual.max' => 'El grado/sección no puede exceder los 100 caracteres.',
        ]);

        // Buscar el alumno por nombre completo
        $alumno = Alumno::where('id_escuela', $this->id_escuela)
                        ->where('activo', true)
                        ->whereRaw("CONCAT(nombre, ' ', apellido) LIKE ?", [$this->buscar_alumno])
                        ->first();

        if (!$alumno) {
            $this->addError('buscar_alumno', 'El alumno seleccionado no es válido. Seleccione un alumno del listado.');
            return;
        }

        // Verificar si el alumno ya está seleccionado
        $alumnoYaSeleccionado = collect($this->alumnos_seleccionados)->contains('id_alumno', $alumno->id_alumno);

        if ($alumnoYaSeleccionado) {
            $this->addError('buscar_alumno', 'Este alumno ya está agregado al accidente.');
            
            // Mostrar mensaje de retroalimentación
            $this->mensaje = "El alumno {$alumno->nombre_completo} ya está agregado al accidente.";
            $this->tipoMensaje = 'error';
            $this->dispatch('mostrar-mensaje');
            return;
        }

        // Agregar el alumno con su grado
        $this->alumnos_seleccionados[] = [
            'id_alumno' => $alumno->id_alumno,
            'grado_seccion' => $this->grado_seccion_actual
        ];

        // Limpiar campos
        $this->buscar_alumno = '';
        $this->grado_seccion_actual = '';
        $this->mostrar_dropdown = false;
        
        // Solo mostrar mensaje si no estamos en modo create
        if ($this->modo != 'create') {
            $this->mensaje = "Alumno {$alumno->nombre_completo} agregado exitosamente.";
            $this->tipoMensaje = 'success';
            $this->dispatch('mostrar-mensaje');
        }
    }

    // Método para actualizar alumnos cuando cambia la escuela
    public function updatedIdEscuela()
    {
        $this->alumnos_seleccionados = [];
        $this->buscar_alumno = '';
        $this->grado_seccion_actual = '';
        $this->mostrar_dropdown = false;
    }

    // Método para limpiar búsqueda cuando cambia el texto
    public function updatedBuscarAlumno()
    {
        // Limpiar grado cuando se cambia la búsqueda
        if (empty($this->buscar_alumno)) {
            $this->grado_seccion_actual = '';
            // Mostrar dropdown con los primeros 20 alumnos cuando el campo está vacío
            $this->mostrar_dropdown = $this->id_escuela ? true : false;
        } else {
            // Mostrar dropdown cuando hay texto suficiente
            $this->mostrar_dropdown = strlen($this->buscar_alumno) >= 2 && $this->id_escuela;
        }
    }

    // Método para mostrar dropdown al hacer clic en el campo
    public function mostrarDropdownAlumnos()
    {
        if ($this->id_escuela) {
            $this->mostrar_dropdown = true;
        }
    }

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

    public function guardarArchivos($idAccidente)
    {
        $this->validate([
            'archivos_adjuntos.*' => 'file|max:10240', // 10MB Max
        ]);

        foreach ($this->archivos_adjuntos as $archivo) {
            $rutaArchivo = $archivo->store('archivos_accidentes', 'public');

            ArchivoAdjunto::create([
                'tipo_entidad' => 'accidente',
                'id_entidad' => $idAccidente,
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

    // MÉTODOS PARA NUEVO ALUMNO
    public function abrirModalAlumno()
    {
        // Limpiar cualquier mensaje que pueda interferir
        $this->mensaje = '';
        $this->tipoMensaje = '';
        
        // Limpiar errores de validación
        $this->resetErrorBag();
        
        $this->mostrar_modal_alumno = true;
        $this->nuevo_alumno = [
            'nombre' => '',
            'apellido' => '',
            'dni' => '',
            'cuil' => '',
            'fecha_nacimiento' => '',
            'familiar1' => '',
            'telefono_contacto1' => ''
        ];
        $this->mostrar_dropdown = false;
    }

    public function cerrarModalAlumno()
    {
        $this->mostrar_modal_alumno = false;
        $this->nuevo_alumno = [
            'nombre' => '',
            'apellido' => '',
            'dni' => '',
            'cuil' => '',
            'fecha_nacimiento' => '',
            'familiar1' => '',
            'telefono_contacto1' => ''
        ];
        $this->mostrar_dropdown = false;
    }

    public function guardarNuevoAlumno()
    {
        // Validar que haya una escuela seleccionada
        if (!$this->id_escuela) {
            $this->addError('id_escuela', 'Debe seleccionar una escuela antes de agregar un alumno.');
            return;
        }

        // Validar datos del nuevo alumno
        $this->validate([
            'nuevo_alumno.nombre' => 'required|string|max:50',
            'nuevo_alumno.apellido' => 'required|string|max:50',
            'nuevo_alumno.dni' => 'required|string|max:8|unique:alumnos,dni',
            'nuevo_alumno.cuil' => 'nullable|string|max:13',
            'nuevo_alumno.fecha_nacimiento' => 'required|date',
            'nuevo_alumno.familiar1' => 'required|string|max:100',
            'nuevo_alumno.telefono_contacto1' => 'required|string|max:20',
        ], [
            'nuevo_alumno.nombre.required' => 'El nombre es obligatorio.',
            'nuevo_alumno.apellido.required' => 'El apellido es obligatorio.',
            'nuevo_alumno.dni.required' => 'El DNI es obligatorio.',
            'nuevo_alumno.dni.unique' => 'Ya existe un alumno con este DNI.',
            'nuevo_alumno.cuil.required' => 'El CUIL es obligatorio.',
            'nuevo_alumno.fecha_nacimiento.required' => 'La fecha de nacimiento es obligatoria.',
            'nuevo_alumno.familiar1.required' => 'El nombre del familiar es obligatorio.',
            'nuevo_alumno.telefono_contacto1.required' => 'El teléfono de contacto es obligatorio.',
        ]);

        // Crear el nuevo alumno
        $nuevoAlumno = Alumno::create([
            'id_escuela' => $this->id_escuela,
            'nombre' => $this->nuevo_alumno['nombre'],
            'apellido' => $this->nuevo_alumno['apellido'],
            'dni' => $this->nuevo_alumno['dni'],
            'cuil' => empty($this->nuevo_alumno['cuil']) ? null : $this->nuevo_alumno['cuil'],
            'fecha_nacimiento' => $this->nuevo_alumno['fecha_nacimiento'],
            'familiar1' => $this->nuevo_alumno['familiar1'],
            'telefono_contacto1' => $this->nuevo_alumno['telefono_contacto1'],
            'activo' => true
        ]);

        // Agregar automáticamente a la lista de seleccionados (grado/sección se asignará después)
        $this->alumnos_seleccionados[] = [
            'id_alumno' => $nuevoAlumno->id_alumno,
            'grado_seccion' => ''
        ];
        $this->buscar_alumno = ''; // Limpiar campo de búsqueda
        $this->mostrar_dropdown = false; // Ocultar dropdown

        // Cerrar modal y mostrar mensaje de éxito específico para nuevo alumno
        $this->cerrarModalAlumno();
        
        // No usar el sistema de mensajes global para evitar conflictos
        // En su lugar, mostrar un mensaje temporal o usar una notificación diferente
        session()->flash('alumno_creado', "Alumno {$nuevoAlumno->nombre_completo} creado y agregado exitosamente.");
    }
}
