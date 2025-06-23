<?php

namespace App\Livewire\Reintegros;

use App\Models\Accidente;
use App\Models\ArchivoAdjunto;
use App\Models\CatTipoGasto;
use App\Models\Reintegro;
use App\Services\AuditoriaService;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Form extends Component
{
    use WithFileUploads;

    public $modo = 'create';
    public $reintegro_id;

    // Campos del modelo
    public $id_accidente;
    public $id_alumno;
    public $id_usuario_solicita;
    public $fecha_solicitud;
    public $id_tipo_gasto;
    public $descripcion_gasto;
    public $monto_solicitado;
    public $id_estado_reintegro;
    
    // Propiedades para UI
    public $accidentes;
    public $tiposGasto;
    public $alumnosDelAccidente = [];
    public $reintegro;

    // Archivos
    public $archivos_adjuntos = [];
    public $archivos_existentes;
    public $archivos_descripcion = '';

    // Mensajes
    public $mensaje = '';
    public $tipoMensaje = '';

    protected function rules()
    {
        return [
            'id_accidente' => 'required|integer|exists:accidentes,id_accidente',
            'id_alumno' => 'required|integer|exists:alumnos,id_alumno',
            'fecha_solicitud' => 'required|date',
            'id_tipo_gasto' => 'required|integer|exists:cat_tipos_gastos,id_tipo_gasto',
            'descripcion_gasto' => 'required|string|max:500',
            'monto_solicitado' => 'required|numeric|min:0',
            'archivos_adjuntos.*' => 'nullable|file|max:10240',
        ];
    }

    protected function messages()
    {
        return [
            'id_accidente.required' => 'Debe seleccionar un accidente.',
            'id_alumno.required' => 'Debe seleccionar un alumno.',
            'fecha_solicitud.required' => 'La fecha de solicitud es obligatoria.',
            'id_tipo_gasto.required' => 'El tipo de gasto es obligatorio.',
            'descripcion_gasto.required' => 'La descripción del gasto es obligatoria.',
            'monto_solicitado.required' => 'El monto solicitado es obligatorio.',
        ];
    }

    public function mount($modo = 'create', $reintegro_id = null)
    {
        $this->modo = $modo;
        $this->cargarCatalogos();
        $this->fecha_solicitud = now()->format('Y-m-d');
        $this->archivos_existentes = collect();

        if ($reintegro_id) {
            $this->reintegro_id = $reintegro_id;
            $this->reintegro = Reintegro::with('archivos', 'alumno')->findOrFail($reintegro_id);
            
            $this->id_accidente = $this->reintegro->id_accidente;
            $this->id_alumno = $this->reintegro->id_alumno;
            $this->id_usuario_solicita = $this->reintegro->id_usuario_solicita;
            $this->fecha_solicitud = $this->reintegro->fecha_solicitud->format('Y-m-d');
            $this->id_tipo_gasto = $this->reintegro->id_tipo_gasto;
            $this->descripcion_gasto = $this->reintegro->descripcion_gasto;
            $this->monto_solicitado = $this->reintegro->monto_solicitado;
            $this->id_estado_reintegro = $this->reintegro->id_estado_reintegro;
            
            $this->archivos_existentes = $this->reintegro->archivos;

            // Cargar alumnos del accidente para el modo edición
            if ($this->id_accidente) {
                $this->updatedIdAccidente($this->id_accidente);
                $this->id_alumno = $this->reintegro->id_alumno;
            }
        }
    }

    public function cargarCatalogos()
    {
        $usuario = Auth::user();
        $queryAccidentes = Accidente::with('alumnos.alumno');

        if ($usuario && $usuario->id_rol == 1 && $usuario->id_escuela) {
            $queryAccidentes->where('id_escuela', $usuario->id_escuela);
        }

        $this->accidentes = $queryAccidentes->get();
        $this->tiposGasto = CatTipoGasto::orderBy('descripcion')->get();
    }

    public function updatedIdAccidente($idAccidente)
    {
        if ($idAccidente) {
            $accidente = Accidente::with('alumnos.alumno')->find($idAccidente);
            $this->alumnosDelAccidente = $accidente ? $accidente->alumnos : [];
        } else {
            $this->alumnosDelAccidente = [];
        }
        $this->reset('id_alumno');
    }

    public function render()
    {
        return view('livewire.reintegros.form');
    }

    public function guardar()
    {
        $this->validate();

        $data = [
            'id_accidente' => $this->id_accidente,
            'id_alumno' => $this->id_alumno,
            'fecha_solicitud' => $this->fecha_solicitud,
            'id_tipo_gasto' => $this->id_tipo_gasto,
            'descripcion_gasto' => $this->descripcion_gasto,
            'monto_solicitado' => $this->monto_solicitado,
            'id_usuario_solicita' => Auth::id(),
        ];

        if ($this->modo == 'create') {
            $data['id_estado_reintegro'] = 1; // Estado inicial "En Proceso"
            $reintegro = Reintegro::create($data);
            $this->guardarArchivos($reintegro->id_reintegro);
            
            AuditoriaService::registrarCreacion('reintegros', $reintegro->id_reintegro, $data);

            // Notificar a Médicos Auditores
            $titulo = "Nueva Solicitud de Reintegro: REI-{$reintegro->id_reintegro}";
            $mensaje = "Se ha registrado una nueva solicitud de reintegro para el alumno {$reintegro->alumno->nombre_completo} de la escuela {$reintegro->accidente->escuela->nombre}.";
            NotificationService::notificarRol('Médico Auditor', $titulo, $mensaje, 'reintegro', $reintegro->id_reintegro);
            
            $this->mensaje = 'Solicitud de reintegro creada exitosamente.';
            $this->tipoMensaje = 'success';
            $this->dispatch('mostrar-mensaje-y-redirigir');

        } else {
            $reintegro = Reintegro::findOrFail($this->reintegro_id);
            $datosAnteriores = $reintegro->getOriginal();

            // Si el reintegro requería información, se actualiza el estado a "En proceso"
            if ($reintegro->id_estado_reintegro == 2) { // 2 = Requiere Información
                $data['id_estado_reintegro'] = 1; // 1 = En proceso
            }

            $reintegro->update($data);
            $this->guardarArchivos($reintegro->id_reintegro);

            AuditoriaService::registrarActualizacion('reintegros', $reintegro->id_reintegro, $datosAnteriores, $data);

            // Si se actualizó la información, notificar a los médicos
            if ($datosAnteriores['id_estado_reintegro'] == 2) {
                $titulo = "Información Actualizada para Reintegro: REI-{$reintegro->id_reintegro}";
                $mensaje = "La escuela {$reintegro->accidente->escuela->nombre} ha actualizado la información para la solicitud de reintegro del alumno {$reintegro->alumno->nombre_completo}.";
                NotificationService::notificarRol('Médico Auditor', $titulo, $mensaje, 'reintegro', $reintegro->id_reintegro);
            }

            $this->mensaje = 'Solicitud de reintegro actualizada exitosamente.';
            $this->tipoMensaje = 'success';
            $this->dispatch('mostrar-mensaje');
        }
    }

    public function guardarArchivos($idReintegro)
    {
        if (empty($this->archivos_adjuntos)) return;
        $this->validate(['archivos_adjuntos.*' => 'file|max:10240']);

        foreach ($this->archivos_adjuntos as $archivo) {
            $rutaArchivo = $archivo->store('archivos_reintegros', 'public');
            ArchivoAdjunto::create([
                'tipo_entidad' => 'reintegro', 'id_entidad' => $idReintegro,
                'nombre_archivo' => $archivo->getClientOriginalName(),
                'tipo_archivo' => $archivo->getClientOriginalExtension(),
                'tamano' => $archivo->getSize(), 'ruta_archivo' => $rutaArchivo,
                'descripcion' => $this->archivos_descripcion,
                'id_usuario_carga' => Auth::id(), 'fecha_carga' => now(),
            ]);
        }
        $this->archivos_adjuntos = [];
        $this->archivos_descripcion = '';
    }

    public function eliminarArchivoExistente($idArchivo)
    {
        $archivo = ArchivoAdjunto::findOrFail($idArchivo);
        $datosArchivo = $archivo->toArray();
        Storage::disk('public')->delete($archivo->ruta_archivo);
        $archivo->delete();
        $this->archivos_existentes = $this->archivos_existentes->where('id_archivo', '!=', $idArchivo)->values();
        AuditoriaService::registrarEliminacion('archivos_adjuntos', $idArchivo, $datosArchivo);
        $this->mensaje = 'Archivo eliminado exitosamente.';
        $this->tipoMensaje = 'success';
        $this->dispatch('mostrar-mensaje');
    }

    public function limpiarMensaje()
    {
        $this->reset(['mensaje', 'tipoMensaje']);
    }

    public function redirigirAlListado()
    {
        return redirect()->route('reintegros.index');
    }
}