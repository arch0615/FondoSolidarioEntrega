<?php

namespace App\Livewire\Reintegros;

use App\Models\CatEstadoReintegro;
use App\Models\Reintegro;
use App\Models\SolicitudInfoAuditor;
use App\Models\HistorialReintegro;
use App\Services\AuditoriaService;
use App\Services\NotificationService;
use App\Services\ReintegroMailService;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class Pendientes extends Component
{
    use WithPagination;

    // Filtros
    public $filtro_id_accidente = '';
    public $filtro_escuela = '';
    public $filtro_fecha_solicitud = '';

    // Catálogos para filtros
    public $escuelas;

    // Ordenamiento
    public $sortField = 'id_reintegro';
    public $sortDirection = 'asc';

    // Paginación
    public $perPage = 10;

    // Query String
    protected $queryString = [
        'filtro_id_accidente' => ['except' => ''],
        'filtro_escuela' => ['except' => ''],
        'filtro_fecha_solicitud' => ['except' => ''],
        'sortField' => ['except' => 'id_reintegro'],
        'sortDirection' => ['except' => 'asc'],
        'perPage' => ['except' => 10],
    ];

    // Propiedades para la gestión de reintegros
    public $reintegroSeleccionadoId;
    public $reintegroSeleccionado;
    public $showDetailModal = false;
    public $solicitandoInformacion = false;
    public $solicitudInfoTexto = '';
    public $rechazandoReintegro = false;
    public $motivoRechazo = '';
    public $aprobandoReintegro = false;
    public $montoAutorizado = 0;
    public $observacionesAuditor = '';
    public $pagandoReintegro = false;
    public $numeroTransferencia = '';
    
    // Nuevas propiedades para mensajes e historial
    public $enviandoMensaje = false;
    public $textoMensaje = '';
    public $historialReintegro = [];

    // IDs de estados de reintegro
    public $estadoNuevoId;
    public $estadoPendienteInfoId;
    public $estadoAutorizadoId;
    public $estadoRechazadoId;
    public $estadoPagadoId;

    public function mount()
    {
        $this->loadCatalogos();
        $this->loadEstadoIds();
    }

    private function loadCatalogos()
    {
        $this->escuelas = \App\Models\Escuela::orderBy('nombre')->get();
    }

    private function loadEstadoIds()
    {
        $this->estadoNuevoId = CatEstadoReintegro::where('nombre_estado', 'En proceso')->first()->id_estado_reintegro ?? 1;
        $this->estadoPendienteInfoId = CatEstadoReintegro::where('nombre_estado', 'Requiere Información')->first()->id_estado_reintegro ?? 2;
        $this->estadoAutorizadoId = CatEstadoReintegro::where('nombre_estado', 'Autorizado')->first()->id_estado_reintegro ?? 3;
        $this->estadoRechazadoId = CatEstadoReintegro::where('nombre_estado', 'Rechazado')->first()->id_estado_reintegro ?? 4;
        $this->estadoPagadoId = CatEstadoReintegro::where('nombre_estado', 'Pagado')->first()->id_estado_reintegro ?? 5;
    }

    protected function rules()
    {
        return [
            'solicitudInfoTexto' => 'required_if:solicitandoInformacion,true|string|max:500',
            'motivoRechazo' => 'required_if:rechazandoReintegro,true|string|max:500',
            'montoAutorizado' => 'required_if:aprobandoReintegro,true|numeric|min:0',
            'observacionesAuditor' => 'nullable|string|max:500',
            'numeroTransferencia' => 'required_if:pagandoReintegro,true|string|max:255',
            'textoMensaje' => 'required_if:enviandoMensaje,true|string|max:1000',
        ];
    }

    protected function messages()
    {
        return [
            'solicitudInfoTexto.required_if' => 'Debe ingresar el texto de la solicitud de información.',
            'solicitudInfoTexto.string' => 'El texto de la solicitud debe ser una cadena de texto.',
            'solicitudInfoTexto.max' => 'El texto de la solicitud no debe exceder los 500 caracteres.',
            'motivoRechazo.required_if' => 'Debe ingresar el motivo del rechazo.',
            'motivoRechazo.string' => 'El motivo del rechazo debe ser una cadena de texto.',
            'motivoRechazo.max' => 'El motivo del rechazo no debe exceder los 500 caracteres.',
            'montoAutorizado.required_if' => 'Debe ingresar el monto autorizado.',
            'montoAutorizado.numeric' => 'El monto autorizado debe ser un número.',
            'montoAutorizado.min' => 'El monto autorizado debe ser mayor o igual a 0.',
            'observacionesAuditor.string' => 'Las observaciones deben ser una cadena de texto.',
            'observacionesAuditor.max' => 'Las observaciones no deben exceder los 500 caracteres.',
            'numeroTransferencia.required_if' => 'Debe ingresar el número de transferencia.',
            'numeroTransferencia.string' => 'El número de transferencia debe ser una cadena de texto.',
            'numeroTransferencia.max' => 'El número de transferencia no debe exceder los 255 caracteres.',
            'textoMensaje.required_if' => 'Debe ingresar el texto del mensaje.',
            'textoMensaje.string' => 'El mensaje debe ser una cadena de texto.',
            'textoMensaje.max' => 'El mensaje no debe exceder los 1000 caracteres.',
        ];
    }

    public function render()
    {
        $reintegros = $this->getReintegrosPendientes();
        return view('livewire.reintegros.pendientes', compact('reintegros'));
    }

    public function getReintegrosPendientes()
    {
        $query = Reintegro::query()
            ->with(['accidente.escuela', 'accidente.alumnos.alumno', 'alumno', 'estadoReintegro', 'usuarioSolicita', 'tiposGastos'])
            ->where('id_estado_reintegro', $this->estadoNuevoId)
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
                $query->whereDate('fecha_solicitud', $this->filtro_fecha_solicitud);
            });

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
        $this->reset(['filtro_id_accidente', 'filtro_escuela', 'filtro_fecha_solicitud']);
        $this->resetPage();
    }

    public function verDetalle($reintegroId)
    {
        $this->reintegroSeleccionado = Reintegro::with([
            'accidente.escuela',
            'accidente.alumnos.alumno',
            'alumno',
            'estadoReintegro',
            'usuarioSolicita',
            'archivos',
            'tiposGastos',
            'historial.usuario'
        ])->findOrFail($reintegroId);
        
        $this->reintegroSeleccionadoId = $reintegroId;
        $this->montoAutorizado = $this->reintegroSeleccionado->monto_solicitado; // Valor por defecto al aprobar
        $this->observacionesAuditor = $this->reintegroSeleccionado->observaciones_auditor;
        $this->numeroTransferencia = $this->reintegroSeleccionado->numero_transferencia;
        
        // Cargar historial
        $this->cargarHistorial();
        
        $this->showDetailModal = true;
    }

    public function cerrarDetalle()
    {
        $this->reintegroSeleccionado = null;
        $this->reintegroSeleccionadoId = null;
        $this->showDetailModal = false;
        $this->historialReintegro = [];
        $this->reset(['solicitandoInformacion', 'solicitudInfoTexto', 'rechazandoReintegro', 'motivoRechazo', 'aprobandoReintegro', 'montoAutorizado', 'observacionesAuditor', 'pagandoReintegro', 'numeroTransferencia', 'enviandoMensaje', 'textoMensaje']);
    }

    /**
     * Cargar historial del reintegro
     */
    public function cargarHistorial()
    {
        if ($this->reintegroSeleccionadoId) {
            $this->historialReintegro = HistorialReintegro::with('usuario')
                ->where('id_reintegro', $this->reintegroSeleccionadoId)
                ->orderBy('fecha_hora', 'desc')
                ->get()
                ->toArray();
        }
    }

    /**
     * Guardar entrada en el historial
     */
    private function guardarHistorial($accion, $mensaje)
    {
        HistorialReintegro::create([
            'id_reintegro' => $this->reintegroSeleccionadoId,
            'id_usuario' => Auth::id(),
            'fecha_hora' => now(),
            'mensaje' => $mensaje,
            'accion' => $accion,
        ]);
        
        // Recargar historial
        $this->cargarHistorial();
    }

    public function solicitarInformacion()
    {
        $this->validateOnly('solicitudInfoTexto');
        
        $reintegro = Reintegro::findOrFail($this->reintegroSeleccionadoId);
        $datosAnteriores = $reintegro->getOriginal();

        $reintegro->update([
            'id_estado_reintegro' => $this->estadoPendienteInfoId,
            'requiere_mas_info' => true,
            'observaciones_auditor' => $this->solicitudInfoTexto,
            'id_medico_auditor' => Auth::id(),
            'fecha_auditoria' => now(),
        ]);

        AuditoriaService::registrarActualizacion('reintegros', $reintegro->id_reintegro, $datosAnteriores, $reintegro->toArray());

        // Guardar en historial
        $this->guardarHistorial('solicitar_informacion', $this->solicitudInfoTexto);
        
        // Notificar a la escuela
        $titulo = "Información requerida para Reintegro REI-{$reintegro->id_reintegro}";
        $mensaje = "Se ha solicitado información adicional para el reintegro del alumno {$reintegro->alumno->nombre_completo}. Motivo: {$this->solicitudInfoTexto}";
        NotificationService::notificarEscuela($reintegro->accidente->escuela->id_escuela, $titulo, $mensaje, 'reintegro', $reintegro->id_reintegro);
 
        // Enviar correo a usuarios de la escuela (rol Usuario General)
        try {
            ReintegroMailService::enviarNotificacionEstadoAEscuela($reintegro, 'Solicitud de Información', $this->solicitudInfoTexto);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::warning("Error enviando correo a escuela para reintegro {$reintegro->id_reintegro}: " . $e->getMessage());
        }
 
        session()->flash('message', 'Solicitud de información enviada para el reintegro: ' . $reintegro->id_reintegro);
        $this->cerrarDetalle();
    }

    public function mostrarModalSolicitudInfo()
    {
        $this->solicitandoInformacion = true;
    }

    public function cancelarSolicitud()
    {
        $this->solicitandoInformacion = false;
        $this->solicitudInfoTexto = '';
    }

    public function mostrarModalRechazo()
    {
        $this->rechazandoReintegro = true;
    }

    public function rechazarReintegro()
    {
        $this->validateOnly('motivoRechazo');

        $reintegro = Reintegro::findOrFail($this->reintegroSeleccionadoId);
        $datosAnteriores = $reintegro->getOriginal();

        $reintegro->update([
            'id_estado_reintegro' => $this->estadoRechazadoId,
            'observaciones_auditor' => $this->motivoRechazo,
            'id_medico_auditor' => Auth::id(),
            'fecha_auditoria' => now(),
        ]);

        AuditoriaService::registrarActualizacion('reintegros', $reintegro->id_reintegro, $datosAnteriores, $reintegro->toArray());

        // Guardar en historial
        $this->guardarHistorial('rechazar', $this->motivoRechazo);
 
        // Notificar a la escuela
        $titulo = "Reintegro Rechazado: REI-{$reintegro->id_reintegro}";
        $mensaje = "La solicitud de reintegro para el alumno {$reintegro->alumno->nombre_completo} ha sido rechazada. Motivo: {$this->motivoRechazo}";
        NotificationService::notificarEscuela($reintegro->accidente->escuela->id_escuela, $titulo, $mensaje, 'reintegro', $reintegro->id_reintegro);
 
        // Enviar correo a usuarios de la escuela (rol Usuario General)
        try {
            ReintegroMailService::enviarNotificacionEstadoAEscuela($reintegro, 'Rechazo', $this->motivoRechazo);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::warning("Error enviando correo a escuela para reintegro {$reintegro->id_reintegro}: " . $e->getMessage());
        }
 
        session()->flash('message', 'Reintegro ' . $reintegro->id_reintegro . ' ha sido rechazado.');
        $this->cerrarDetalle();
    }

    public function cancelarRechazo()
    {
        $this->rechazandoReintegro = false;
        $this->motivoRechazo = '';
    }

    public function mostrarModalAprobacion()
    {
        $this->aprobandoReintegro = true;
    }

    public function aprobarReintegro()
    {
        $this->validateOnly('montoAutorizado');
        $this->validateOnly('observacionesAuditor');

        $reintegro = Reintegro::findOrFail($this->reintegroSeleccionadoId);
        $datosAnteriores = $reintegro->getOriginal();

        $reintegro->update([
            'id_estado_reintegro' => $this->estadoAutorizadoId,
            'monto_autorizado' => $this->montoAutorizado,
            'observaciones_auditor' => $this->observacionesAuditor,
            'id_medico_auditor' => Auth::id(),
            'fecha_auditoria' => now(),
            'fecha_autorizacion' => now(),
        ]);

        AuditoriaService::registrarActualizacion('reintegros', $reintegro->id_reintegro, $datosAnteriores, $reintegro->toArray());

        // Guardar en historial
        $mensajeHistorial = "Aprobado por un monto de $ {$this->montoAutorizado}";
        if ($this->observacionesAuditor) {
            $mensajeHistorial .= ". Observaciones: {$this->observacionesAuditor}";
        }
        $this->guardarHistorial('aceptar', $mensajeHistorial);

        // Notificar a la escuela
        $tituloEscuela = "Reintegro Aprobado: REI-{$reintegro->id_reintegro}";
        $mensajeEscuela = "La solicitud de reintegro para el alumno {$reintegro->alumno->nombre_completo} ha sido aprobada por un monto de $ {$this->montoAutorizado}.";
        NotificationService::notificarEscuela($reintegro->accidente->escuela->id_escuela, $tituloEscuela, $mensajeEscuela, 'reintegro', $reintegro->id_reintegro);
 
        // Enviar correo a usuarios de la escuela (rol Usuario General)
        try {
            $detalle = "Aprobado por un monto de $ {$this->montoAutorizado}";
            if ($this->observacionesAuditor) {
                $detalle .= ". Observaciones: {$this->observacionesAuditor}";
            }
            ReintegroMailService::enviarNotificacionEstadoAEscuela($reintegro, 'Aprobación', $detalle);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::warning("Error enviando correo a escuela para reintegro {$reintegro->id_reintegro}: " . $e->getMessage());
        }
 
        // Notificar a los administradores
        $tituloAdmin = "Reintegro Aprobado para Pago: REI-{$reintegro->id_reintegro}";
        $mensajeAdmin = "El reintegro para el alumno {$reintegro->alumno->nombre_completo} de la escuela {$reintegro->accidente->escuela->nombre} ha sido aprobado por un monto de $ {$this->montoAutorizado} y está listo para gestionar el pago.";
        NotificationService::notificarAdmins($tituloAdmin, $mensajeAdmin, 'reintegro', $reintegro->id_reintegro);

        session()->flash('message', 'Reintegro ' . $reintegro->id_reintegro . ' ha sido aprobado.');
        $this->cerrarDetalle();
    }

    public function cancelarAprobacion()
    {
        $this->aprobandoReintegro = false;
        $this->montoAutorizado = 0;
        $this->observacionesAuditor = '';
    }

    public function mostrarModalPago()
    {
        $this->pagandoReintegro = true;
    }

    public function marcarComoPagado()
    {
        $this->validateOnly('numeroTransferencia');

        $reintegro = Reintegro::findOrFail($this->reintegroSeleccionadoId);
        $datosAnteriores = $reintegro->getOriginal();

        $reintegro->update([
            'id_estado_reintegro' => $this->estadoPagadoId,
            'fecha_pago' => now(),
            'numero_transferencia' => $this->numeroTransferencia,
            'id_medico_auditor' => Auth::id(), // Asumiendo que el pago lo registra un auditor o admin
            'fecha_auditoria' => now(),
        ]);

        AuditoriaService::registrarActualizacion('reintegros', $reintegro->id_reintegro, $datosAnteriores, $reintegro->toArray());
        session()->flash('message', 'Reintegro ' . $reintegro->id_reintegro . ' marcado como pagado.');
        $this->cerrarDetalle();
    }

    public function cancelarPago()
    {
        $this->pagandoReintegro = false;
        $this->numeroTransferencia = '';
    }

    /**
     * Mostrar modal para enviar mensaje
     */
    public function mostrarModalMensaje()
    {
        $this->enviandoMensaje = true;
    }

    /**
     * Enviar mensaje a la escuela
     */
    public function enviarMensaje()
    {
        $this->validateOnly('textoMensaje');

        $reintegro = Reintegro::findOrFail($this->reintegroSeleccionadoId);

        // Guardar en historial
        $this->guardarHistorial('mensaje', $this->textoMensaje);

        // Notificar a la escuela
        $titulo = "Nuevo mensaje para Reintegro REI-{$reintegro->id_reintegro}";
        $mensaje = "Ha recibido un nuevo mensaje sobre el reintegro del alumno {$reintegro->alumno->nombre_completo}: {$this->textoMensaje}";
        NotificationService::notificarEscuela($reintegro->accidente->escuela->id_escuela, $titulo, $mensaje, 'reintegro', $reintegro->id_reintegro);
 
        // Enviar correo a usuarios de la escuela (rol Usuario General)
        try {
            ReintegroMailService::enviarNotificacionEstadoAEscuela($reintegro, 'Mensaje', $this->textoMensaje);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::warning("Error enviando correo a escuela para reintegro {$reintegro->id_reintegro}: " . $e->getMessage());
        }
 
        session()->flash('message', 'Mensaje enviado correctamente para el reintegro: ' . $reintegro->id_reintegro);
        $this->cancelarMensaje();
    }

    /**
     * Cancelar envío de mensaje
     */
    public function cancelarMensaje()
    {
        $this->enviandoMensaje = false;
        $this->textoMensaje = '';
    }

    // Hooks para resetear paginación
    public function updatingFiltroIdAccidente() { $this->resetPage(); }
    public function updatingFiltroEscuela() { $this->resetPage(); }
    public function updatingFiltroFechaSolicitud() { $this->resetPage(); }
    public function updatingPerPage() { $this->resetPage(); }
}