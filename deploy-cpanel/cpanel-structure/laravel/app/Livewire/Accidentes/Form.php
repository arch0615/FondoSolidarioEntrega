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
    public $id_estado_accidente;
    public $id_usuario_carga; // Se llenará automáticamente

    // ALUMNOS SELECCIONADOS
    public $alumnos_seleccionados = [];
    public $buscar_alumno = '';

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
        'sala_grado_curso' => '',
        'nombre_padre_madre' => '',
        'telefono_contacto' => ''
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
            'id_estado_accidente' => 'required|integer|exists:cat_estados_accidentes,id_estado_accidente',
            'alumnos_seleccionados' => 'required|array|min:1',
            'alumnos_seleccionados.*' => 'integer|exists:alumnos,id_alumno',
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
            'id_estado_accidente.required' => 'El estado del accidente es obligatorio.',
            'id_estado_accidente.integer' => 'El ID del estado debe ser un número entero.',
            'id_estado_accidente.exists' => 'El estado seleccionado no es válido.',
            'alumnos_seleccionados.required' => 'Debe seleccionar al menos un alumno.',
            'alumnos_seleccionados.min' => 'Debe seleccionar al menos un alumno.',
            'alumnos_seleccionados.*.exists' => 'Uno de los alumnos seleccionados no es válido.',
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
            $this->id_estado_accidente = $accidente->id_estado_accidente;
            
            // Cargar alumnos asociados
            $this->alumnos_seleccionados = $accidente->alumnos->pluck('id_alumno')->toArray();

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
            'id_estado_accidente' => $this->id_estado_accidente,
            'id_usuario_carga' => $this->id_usuario_carga,
        ];

        if ($this->modo == 'create') {
            $accidente = Accidente::create($data);
            
            // Asociar alumnos al accidente
            foreach ($this->alumnos_seleccionados as $idAlumno) {
                AccidenteAlumno::create([
                    'id_accidente' => $accidente->id_accidente,
                    'id_alumno' => $idAlumno
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
            foreach ($this->alumnos_seleccionados as $idAlumno) {
                AccidenteAlumno::create([
                    'id_accidente' => $accidente->id_accidente,
                    'id_alumno' => $idAlumno
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
    public function agregarAlumno($idAlumno)
    {
        if (!in_array($idAlumno, $this->alumnos_seleccionados)) {
            $this->alumnos_seleccionados[] = $idAlumno;
            $this->buscar_alumno = '';
        }
    }

    public function removerAlumno($idAlumno)
    {
        $this->alumnos_seleccionados = array_filter(
            $this->alumnos_seleccionados,
            function($id) use ($idAlumno) {
                return $id != $idAlumno;
            }
        );
        $this->alumnos_seleccionados = array_values($this->alumnos_seleccionados);
    }

    public function buscarAlumnos()
    {
        if (!$this->id_escuela || strlen($this->buscar_alumno) < 2) {
            return collect();
        }

        return Alumno::where('id_escuela', $this->id_escuela)
                    ->where('activo', true)
                    ->whereNotIn('id_alumno', $this->alumnos_seleccionados)
                    ->where(function($query) {
                        $termino = '%' . $this->buscar_alumno . '%';
                        $query->where('nombre', 'like', $termino)
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

        return Alumno::whereIn('id_alumno', $this->alumnos_seleccionados)->get();
    }

    // Método para actualizar alumnos cuando cambia la escuela
    public function updatedIdEscuela()
    {
        $this->alumnos_seleccionados = [];
        $this->buscar_alumno = '';
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
        $this->mostrar_modal_alumno = true;
        $this->nuevo_alumno = [
            'nombre' => '',
            'apellido' => '',
            'dni' => '',
            'cuil' => '',
            'fecha_nacimiento' => '',
            'sala_grado_curso' => '',
            'nombre_padre_madre' => '',
            'telefono_contacto' => ''
        ];
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
            'sala_grado_curso' => '',
            'nombre_padre_madre' => '',
            'telefono_contacto' => ''
        ];
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
            'nuevo_alumno.cuil' => 'required|string|max:13',
            'nuevo_alumno.fecha_nacimiento' => 'required|date',
            'nuevo_alumno.sala_grado_curso' => 'required|string|max:50',
            'nuevo_alumno.nombre_padre_madre' => 'required|string|max:100',
            'nuevo_alumno.telefono_contacto' => 'required|string|max:20',
        ], [
            'nuevo_alumno.nombre.required' => 'El nombre es obligatorio.',
            'nuevo_alumno.apellido.required' => 'El apellido es obligatorio.',
            'nuevo_alumno.dni.required' => 'El DNI es obligatorio.',
            'nuevo_alumno.dni.unique' => 'Ya existe un alumno con este DNI.',
            'nuevo_alumno.cuil.required' => 'El CUIL es obligatorio.',
            'nuevo_alumno.fecha_nacimiento.required' => 'La fecha de nacimiento es obligatoria.',
            'nuevo_alumno.sala_grado_curso.required' => 'La sala/grado/curso es obligatorio.',
            'nuevo_alumno.nombre_padre_madre.required' => 'El nombre del padre/madre es obligatorio.',
            'nuevo_alumno.telefono_contacto.required' => 'El teléfono de contacto es obligatorio.',
        ]);

        // Crear el nuevo alumno
        $nuevoAlumno = Alumno::create([
            'id_escuela' => $this->id_escuela,
            'nombre' => $this->nuevo_alumno['nombre'],
            'apellido' => $this->nuevo_alumno['apellido'],
            'dni' => $this->nuevo_alumno['dni'],
            'cuil' => $this->nuevo_alumno['cuil'],
            'fecha_nacimiento' => $this->nuevo_alumno['fecha_nacimiento'],
            'sala_grado_curso' => $this->nuevo_alumno['sala_grado_curso'],
            'nombre_padre_madre' => $this->nuevo_alumno['nombre_padre_madre'],
            'telefono_contacto' => $this->nuevo_alumno['telefono_contacto'],
            'activo' => true
        ]);

        // Agregar automáticamente a la lista de seleccionados
        $this->alumnos_seleccionados[] = $nuevoAlumno->id_alumno;

        // Cerrar modal y mostrar mensaje de éxito
        $this->cerrarModalAlumno();
        $this->mensaje = "Alumno {$nuevoAlumno->nombre_completo} creado y agregado exitosamente.";
        $this->tipoMensaje = 'success';
        $this->dispatch('mostrar-mensaje');
    }
}
