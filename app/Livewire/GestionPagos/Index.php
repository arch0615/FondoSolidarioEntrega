<?php

namespace App\Livewire\GestionPagos;

use App\Models\Escuela;
use App\Models\Notificacion;
use App\Models\Reintegro;
use App\Models\User;
use App\Services\AuditoriaService;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $escuelas = [];

    // Modal state
    public $showPagoModal = false;
    public $reintegroSeleccionado;
    public $fecha_pago;
    public $numero_transferencia;

    // Filtros
    public $filtroEscuela = '';
    public $filtroFechaDesde = '';
    public $filtroFechaHasta = '';

    public function mount()
    {
        $this->escuelas = Escuela::orderBy('nombre')->get();
    }

    public function iniciarPago($id)
    {
        $this->reintegroSeleccionado = Reintegro::with('alumno', 'accidente.escuela')->find($id);

        if ($this->reintegroSeleccionado) {
            $this->fecha_pago = now()->format('Y-m-d');
            $this->numero_transferencia = '';
            $this->showPagoModal = true;
        }
    }

    public function confirmarPago()
    {
        $this->validate([
            'fecha_pago' => 'required|date',
            'numero_transferencia' => 'required|string|max:50',
        ]);

        $reintegro = Reintegro::find($this->reintegroSeleccionado['id_reintegro']);

        if ($reintegro) {
            $reintegro->fecha_pago = $this->fecha_pago;
            $reintegro->numero_transferencia = $this->numero_transferencia;
            $reintegro->id_estado_reintegro = 5; // 5 = Pagado
            $reintegro->save();

            // Registrar auditoría
            AuditoriaService::registrarAccionPersonalizada('PAGO_REINTEGRO', 'reintegros', $reintegro->id_reintegro, [
                'fecha_pago' => $this->fecha_pago,
                'numero_transferencia' => $this->numero_transferencia,
                'estado' => 'Pagado'
            ]);

            // Enviar notificación a la escuela
            $this->enviarNotificacionEscuela($reintegro);

            $this->showPagoModal = false;
            $this->reset(['reintegroSeleccionado', 'fecha_pago', 'numero_transferencia']);
            session()->flash('message', 'Reintegro marcado como pagado exitosamente.');
        }
    }

    protected function enviarNotificacionEscuela(Reintegro $reintegro)
    {
        $escuela = $reintegro->accidente->escuela;
        $usuarioEscuela = User::where('id_escuela', $escuela->id_escuela)->first();

        if ($usuarioEscuela) {
            Notificacion::create([
                'id_usuario_destino' => $usuarioEscuela->id_usuario,
                'tipo_notificacion' => 'Reintegro Pagado',
                'titulo' => 'Reintegro Pagado',
                'mensaje' => "Se ha registrado el pago del reintegro #{$reintegro->id_reintegro} para el alumno {$reintegro->alumno->nombre_completo}. Monto: {$reintegro->monto_autorizado}",
                'id_entidad_referencia' => $reintegro->id_reintegro,
                'tipo_entidad' => 'reintegro',
                'fecha_creacion' => now(),
                'leida' => false,
            ]);
        }
    }

    public function render()
    {
        // Reintegros pendientes de pago (Estado Autorizado = 3)
        $pendientes = Reintegro::with('alumno', 'accidente.escuela')
            ->where('id_estado_reintegro', 3) // 3 = Autorizado
            ->orderBy('fecha_autorizacion', 'asc')
            ->get();

        // Historial de pagos (Estado Pagado = 5)
        $historialQuery = Reintegro::with('alumno', 'accidente.escuela')
            ->where('id_estado_reintegro', 5) // 5 = Pagado
            ->when($this->filtroEscuela, function ($query) {
                $query->whereHas('accidente.escuela', function ($q) {
                    $q->where('id_escuela', $this->filtroEscuela);
                });
            })
            ->when($this->filtroFechaDesde, function ($query) {
                $query->where('fecha_pago', '>=', $this->filtroFechaDesde);
            })
            ->when($this->filtroFechaHasta, function ($query) {
                $query->where('fecha_pago', '<=', $this->filtroFechaHasta);
            })
            ->orderBy('fecha_pago', 'desc');

        $historialPaginado = $historialQuery->paginate(5);

        return view('livewire.gestion-pagos.index', [
            'pendientes' => $pendientes,
            'historialPaginado' => $historialPaginado
        ]);
    }
}
