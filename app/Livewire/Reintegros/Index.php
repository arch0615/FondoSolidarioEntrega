<?php

namespace App\Livewire\Reintegros;

use App\Models\CatEstadoReintegro;
use App\Models\Escuela;
use App\Models\Reintegro;
use App\Models\HistorialReintegro;
use App\Models\ArchivoAdjunto;
use App\Models\Notificacion;
use App\Services\AuditoriaService;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class Index extends Component
{
    use WithPagination, WithFileUploads;

    public $showingObservationModal = false;
    public $observationToShow = '';
    public $estadoRechazadoId;
    public $estadoAutorizadoId;
    public $estadoPagadoId;
    public $showingPagoInfoModal = false;
    public $pagoInfoToShow;
    
    // Modal de historial
    public $showingHistorialModal = false;
    public $historialReintegro = [];
    public $reintegroHistorialId;
    
    // Modal de contestar
    public $showingContestModal = false;
    public $contestMessage = '';
    public $contestFiles = [];
    public $contestFilesDescription = '';
    public $reintegroParaContestar;
    
    // Modal de enviar mensaje
    public $showingMessageModal = false;
    public $messageText = '';
    public $reintegroParaMensaje;

    // Filtros
    public $filtro_id_accidente = '';
    public $filtro_escuela = '';
    public $filtro_fecha_solicitud = '';
    public $filtro_estado = '';
    public $filtro_alumno = '';

    // Catálogos para filtros
    public $escuelas;
    public $estados;

    // Ordenamiento
    public $sortField = 'id_reintegro';
    public $sortDirection = 'desc';

    // Paginación
    public $perPage = 10;

    // Query String
    protected $queryString = [
        'filtro_id_accidente' => ['except' => ''],
        'filtro_escuela' => ['except' => ''],
        'filtro_fecha_solicitud' => ['except' => ''],
        'filtro_estado' => ['except' => ''],
        'filtro_alumno' => ['except' => ''],
        'sortField' => ['except' => 'id_reintegro'],
        'sortDirection' => ['except' => 'desc'],
        'perPage' => ['except' => 10],
    ];

    public function mount()
    {
        $this->escuelas = Escuela::orderBy('nombre')->get();
        $this->estados = CatEstadoReintegro::orderBy('descripcion')->get();
        $this->estadoRechazadoId = CatEstadoReintegro::where('nombre_estado', 'Rechazado')->first()->id_estado_reintegro ?? 4;
        $this->estadoAutorizadoId = CatEstadoReintegro::where('nombre_estado', 'Autorizado')->first()->id_estado_reintegro ?? 3;
        $this->estadoPagadoId = CatEstadoReintegro::where('nombre_estado', 'Pagado')->first()->id_estado_reintegro ?? 5;
    }

    public function render()
    {
        $reintegros = $this->getReintegros();
        
        return view('livewire.reintegros.index', compact('reintegros'));
    }

    public function getReintegros()
    {
        $usuario = \Illuminate\Support\Facades\Auth::user();
        $query = Reintegro::query()
            ->with(['accidente.escuela', 'alumno', 'estadoReintegro', 'tiposGastos'])
            ->when($this->filtro_id_accidente, function ($query) {
                $query->whereHas('accidente', function($q) {
                    $q->where('numero_expediente', 'like', '%' . $this->filtro_id_accidente . '%')
                      ->orWhere('id_accidente_entero', 'like', '%' . $this->filtro_id_accidente . '%');
                });
            })
            ->when($this->filtro_escuela, function ($query) {
                $query->whereHas('accidente.escuela', function($q) {
                    $q->where('id_escuela', $this->filtro_escuela);
                });
            })
            ->when($this->filtro_fecha_solicitud, function ($query) {
                $query->where('fecha_solicitud', 'like', '%' . $this->filtro_fecha_solicitud . '%');
            })
            ->when($this->filtro_estado, function ($query) {
                $query->where('id_estado_reintegro', $this->filtro_estado);
            })
            ->when($this->filtro_alumno, function ($query) {
                $query->whereHas('alumno', function ($q) {
                    $q->where('nombre', 'like', '%' . $this->filtro_alumno . '%')
                      ->orWhere('apellido', 'like', '%' . $this->filtro_alumno . '%')
                      ->orWhere('dni', 'like', '%' . $this->filtro_alumno . '%');
                });
            });

        // Filtrar por escuela para rol de usuario general
        if ($usuario && $usuario->id_rol == 1 && $usuario->id_escuela) {
            $query->whereHas('accidente', function ($q) use ($usuario) {
                $q->where('id_escuela', $usuario->id_escuela);
            });
        }
        
        // Filtrar para rol de Médico Auditor (rol=3): solo ver reintegros cerrados
        if ($usuario && $usuario->id_rol == 3) {
            $query->whereIn('id_estado_reintegro', [3, 4, 5, 6]); // 3=Autorizado, 4=Rechazado, 5=Pagado, 6=Enviado a Aseguradora
        }

        $query->orderBy($this->sortField, $this->sortDirection);

        return $query->paginate($this->perPage);
    }

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
        $this->reset(['filtro_id_accidente', 'filtro_escuela', 'filtro_fecha_solicitud', 'filtro_estado', 'filtro_alumno']);
        $this->resetPage();
    }

    public function eliminar($idReintegro)
    {
        $reintegro = Reintegro::findOrFail($idReintegro);
        $datosReintegro = $reintegro->toArray();
        
        // La lógica de eliminación de archivos adjuntos está en el boot() del modelo
        $reintegro->delete();

        AuditoriaService::registrarEliminacion('reintegros', $idReintegro, $datosReintegro);
        session()->flash('message', 'Reintegro eliminado exitosamente.');
    }

    public function showObservation($reintegroId)
    {
        $reintegro = Reintegro::findOrFail($reintegroId);
        $this->observationToShow = $reintegro->observaciones_auditor;
        $this->showingObservationModal = true;
    }

    public function closeObservationModal()
    {
        $this->showingObservationModal = false;
        $this->observationToShow = '';
    }

    public function showPagoInfo($reintegroId)
    {
        $this->pagoInfoToShow = Reintegro::findOrFail($reintegroId);
        $this->showingPagoInfoModal = true;
    }

    public function closePagoInfoModal()
    {
        $this->showingPagoInfoModal = false;
        $this->pagoInfoToShow = null;
    }

    public function showHistorial($reintegroId)
    {
        $this->reintegroHistorialId = $reintegroId;
        
        // Cargar el reintegro para verificar su estado
        $this->reintegroParaContestar = Reintegro::with(['accidente.escuela', 'alumno', 'estadoReintegro'])->findOrFail($reintegroId);
        
        $this->historialReintegro = HistorialReintegro::with('usuario')
            ->where('id_reintegro', $reintegroId)
            ->orderBy('fecha_hora', 'desc')
            ->get()
            ->map(function ($entrada) {
                return [
                    'fecha_hora' => $entrada->fecha_hora,
                    'usuario' => $entrada->usuario ? $entrada->usuario->nombre : 'Sistema',
                    'accion' => $entrada->accion,
                    'mensaje' => $entrada->mensaje,
                    'texto_accion' => $entrada->getTextoAccionAttribute(),
                    'color_accion' => $entrada->getColorAccionAttribute()
                ];
            })->toArray();
        
        $this->showingHistorialModal = true;
    }

    public function closeHistorialModal()
    {
        $this->showingHistorialModal = false;
        $this->historialReintegro = [];
        $this->reintegroHistorialId = null;
    }

    public function showContestModal($reintegroId)
    {
        $this->reintegroParaContestar = Reintegro::with(['accidente.escuela', 'alumno', 'estadoReintegro'])->findOrFail($reintegroId);
        $this->showingContestModal = true;
    }

    public function closeContestModal()
    {
        $this->showingContestModal = false;
        $this->contestMessage = '';
        $this->contestFiles = [];
        $this->contestFilesDescription = '';
        $this->reintegroParaContestar = null;
    }

    public function enviarRespuesta()
    {
        $this->validate([
            'contestMessage' => 'required|string|max:1000',
            'contestFiles.*' => 'nullable|file|max:10240'
        ], [
            'contestMessage.required' => 'El mensaje es obligatorio.',
            'contestMessage.max' => 'El mensaje no debe exceder los 1000 caracteres.',
            'contestFiles.*.max' => 'Cada archivo no debe exceder los 10MB.'
        ]);

        $reintegro = $this->reintegroParaContestar;
        $datosAnteriores = $reintegro->getOriginal();

        // Si el estado es "Requiere Información" (2), cambiarlo a "En Proceso" (1)
        if ($reintegro->id_estado_reintegro == 2) {
            $reintegro->update(['id_estado_reintegro' => 1]);
        }

        // Guardar archivos adjuntos si los hay
        if (!empty($this->contestFiles)) {
            $this->guardarArchivosRespuesta($reintegro->id_reintegro);
        }

        // Registrar en el historial
        HistorialReintegro::create([
            'id_reintegro' => $reintegro->id_reintegro,
            'id_usuario' => Auth::id(),
            'fecha_hora' => now(),
            'mensaje' => $this->contestMessage,
            'accion' => 'respuesta_escuela',
        ]);

        // Notificar al médico auditor
        $titulo = "Nueva respuesta para Reintegro REI-{$reintegro->id_reintegro}";
        $mensaje = "La escuela {$reintegro->accidente->escuela->nombre} ha enviado una respuesta para el reintegro del alumno {$reintegro->alumno->nombre_completo}: {$this->contestMessage}";
        
        // Notificar al médico auditor específico si existe, sino a todos los médicos auditores
        if ($reintegro->id_medico_auditor) {
            Notificacion::create([
                'id_usuario_destino' => $reintegro->id_medico_auditor,
                'tipo_notificacion' => 'reintegro_respuesta',
                'titulo' => $titulo,
                'mensaje' => $mensaje,
                'id_entidad_referencia' => $reintegro->id_reintegro,
                'tipo_entidad' => 'reintegro',
                'fecha_creacion' => now(),
                'leida' => false,
            ]);
        } else {
            NotificationService::notificarRol('Médico Auditor', $titulo, $mensaje, 'reintegro', $reintegro->id_reintegro);
        }

        // Registrar auditoría si cambió el estado
        if ($datosAnteriores['id_estado_reintegro'] != $reintegro->id_estado_reintegro) {
            AuditoriaService::registrarActualizacion('reintegros', $reintegro->id_reintegro, $datosAnteriores, $reintegro->toArray());
        }

        session()->flash('message', 'Respuesta enviada correctamente para el reintegro: ' . $reintegro->id_reintegro);
        $this->closeContestModal();
    }

    private function guardarArchivosRespuesta($idReintegro)
    {
        foreach ($this->contestFiles as $archivo) {
            $rutaArchivo = $archivo->store('archivos_reintegros', 'public');
            ArchivoAdjunto::create([
                'tipo_entidad' => 'reintegro',
                'id_entidad' => $idReintegro,
                'nombre_archivo' => $archivo->getClientOriginalName(),
                'tipo_archivo' => $archivo->getClientOriginalExtension(),
                'tamano' => $archivo->getSize(),
                'ruta_archivo' => $rutaArchivo,
                'descripcion' => $this->contestFilesDescription ?: 'Archivo adjunto en respuesta',
                'id_usuario_carga' => Auth::id(),
                'fecha_carga' => now(),
            ]);
        }
    }

    public function showMessageModal($reintegroId)
    {
        $this->reintegroParaMensaje = Reintegro::with(['accidente.escuela', 'alumno', 'estadoReintegro'])->findOrFail($reintegroId);
        $this->showingMessageModal = true;
    }

    public function closeMessageModal()
    {
        $this->showingMessageModal = false;
        $this->messageText = '';
        $this->reintegroParaMensaje = null;
    }

    public function enviarMensaje()
    {
        $this->validate([
            'messageText' => 'required|string|max:1000'
        ], [
            'messageText.required' => 'El mensaje es obligatorio.',
            'messageText.max' => 'El mensaje no debe exceder los 1000 caracteres.'
        ]);

        $reintegro = $this->reintegroParaMensaje;

        // Registrar en el historial
        HistorialReintegro::create([
            'id_reintegro' => $reintegro->id_reintegro,
            'id_usuario' => Auth::id(),
            'fecha_hora' => now(),
            'mensaje' => $this->messageText,
            'accion' => 'mensaje',
        ]);

        // Notificar al médico auditor
        $titulo = "Nuevo mensaje para Reintegro REI-{$reintegro->id_reintegro}";
        $mensaje = "La escuela {$reintegro->accidente->escuela->nombre} ha enviado un mensaje para el reintegro del alumno {$reintegro->alumno->nombre_completo}: {$this->messageText}";
        
        // Notificar al médico auditor específico si existe, sino a todos los médicos auditores
        if ($reintegro->id_medico_auditor) {
            Notificacion::create([
                'id_usuario_destino' => $reintegro->id_medico_auditor,
                'tipo_notificacion' => 'reintegro_mensaje',
                'titulo' => $titulo,
                'mensaje' => $mensaje,
                'id_entidad_referencia' => $reintegro->id_reintegro,
                'tipo_entidad' => 'reintegro',
                'fecha_creacion' => now(),
                'leida' => false,
            ]);
        } else {
            NotificationService::notificarRol('Médico Auditor', $titulo, $mensaje, 'reintegro', $reintegro->id_reintegro);
        }

        session()->flash('message', 'Mensaje enviado correctamente para el reintegro: ' . $reintegro->id_reintegro);
        $this->closeMessageModal();
    }

    // Hooks para resetear paginación
    public function updatingFiltroIdAccidente() { $this->resetPage(); }
    public function updatingFiltroEscuela() { $this->resetPage(); }
    public function updatingFiltroFechaSolicitud() { $this->resetPage(); }
    public function updatingFiltroEstado() { $this->resetPage(); }
    public function updatingFiltroAlumno() { $this->resetPage(); }
    public function updatingPerPage() { $this->resetPage(); }
}