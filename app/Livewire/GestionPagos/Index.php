<?php

namespace App\Livewire\GestionPagos;

use App\Mail\ReintegroAseguradoraMail;
use App\Models\EmailAseguradora;
use App\Models\Escuela;
use App\Models\Notificacion;
use App\Models\Reintegro;
use App\Models\User;
use App\Services\AuditoriaService;
use App\Services\ReintegroMailService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
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

            // Enviar notificación a la escuela (in-app)
            $this->enviarNotificacionEscuela($reintegro);

            // Enviar notificación por email a la escuela
            try {
                $detalle = "Fecha de pago: {$this->fecha_pago}\nN° Transferencia: {$this->numero_transferencia}\nMonto autorizado: $" . number_format($reintegro->monto_autorizado ?? 0, 2);
                ReintegroMailService::enviarNotificacionEstadoAEscuela($reintegro, 'Pago', $detalle);
            } catch (\Exception $e) {
                Log::warning('Error al enviar email de pago de reintegro: ' . $e->getMessage());
            }

            $this->showPagoModal = false;
            $this->reset(['reintegroSeleccionado', 'fecha_pago', 'numero_transferencia']);
            $this->dispatch('toast-success', message: 'Reintegro marcado como pagado exitosamente.');
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

    public function enviarAseguradora($id)
    {
        try {
            $reintegro = Reintegro::with(['alumno', 'accidente.escuela'])->find($id);

            if (!$reintegro) {
                $this->dispatch('toast-error', message: 'No se encontró el reintegro.');
                return;
            }

            // Verificar que hay correos de aseguradora configurados
            $emailsAseguradora = EmailAseguradora::activos()->get();

            if ($emailsAseguradora->isEmpty()) {
                $this->dispatch('toast-error', message: 'No hay correos de aseguradora configurados. Configure al menos uno en Gestión > Correos Aseguradora.');
                return;
            }

            $estadoAnterior = $reintegro->id_estado_reintegro;
            $reintegro->id_estado_reintegro = 6; // 6 = Enviado a Aseguradora
            $reintegro->save();

            AuditoriaService::registrarActualizacion('reintegros', $reintegro->id_reintegro,
                ['id_estado_reintegro' => $estadoAnterior],
                ['id_estado_reintegro' => 6]
            );

            // Notificar a la escuela (in-app)
            $escuela = $reintegro->accidente->escuela ?? null;
            $usuarioEscuela = $escuela ? User::where('id_escuela', $escuela->id_escuela)->first() : null;

            if ($usuarioEscuela) {
                Notificacion::create([
                    'id_usuario_destino' => $usuarioEscuela->id_usuario,
                    'tipo_notificacion' => 'Reintegro Enviado a Aseguradora',
                    'titulo' => 'Reintegro Enviado a Aseguradora',
                    'mensaje' => "El reintegro #{$reintegro->id_reintegro} para el alumno {$reintegro->alumno->nombre_completo} ha sido enviado a la compañía aseguradora.",
                    'id_entidad_referencia' => $reintegro->id_reintegro,
                    'tipo_entidad' => 'reintegro',
                    'fecha_creacion' => now(),
                    'leida' => false,
                ]);
            }

            // Enviar notificación por email a la escuela
            try {
                ReintegroMailService::enviarNotificacionEstadoAEscuela($reintegro, 'Enviado a Aseguradora');
            } catch (\Exception $e) {
                Log::warning('Error al enviar email de estado a escuela: ' . $e->getMessage());
            }

            // Enviar email a la aseguradora con los detalles del reintegro
            $reintegro->load(['alumno', 'accidente.escuela', 'tiposGastos', 'archivos']);
            $enviados = 0;
            $errores = [];

            $errorMessages = [];
            foreach ($emailsAseguradora as $emailAseg) {
                try {
                    Mail::to($emailAseg->email)->send(new ReintegroAseguradoraMail($reintegro));
                    $enviados++;
                } catch (\Exception $e) {
                    Log::warning("Error al enviar email a aseguradora ({$emailAseg->email}): " . $e->getMessage());
                    $errores[] = $emailAseg->email;
                    $errorMessages[] = $e->getMessage();
                }
            }

            if ($enviados > 0 && empty($errores)) {
                $this->dispatch('toast-success', message: "Reintegro enviado a aseguradora exitosamente. Se enviaron {$enviados} correo(s).");
            } elseif ($enviados > 0 && !empty($errores)) {
                $this->dispatch('toast-error', message: "Reintegro enviado parcialmente. {$enviados} correo(s) enviado(s). Fallaron: " . implode(', ', $errores));
            } else {
                $detail = !empty($errorMessages) ? ' Detalle: ' . $errorMessages[0] : '';
                $this->dispatch('toast-error', message: 'No se pudieron enviar los correos a la aseguradora.' . $detail);
            }
        } catch (\Exception $e) {
            Log::error('Error al enviar a aseguradora: ' . $e->getMessage());
            $this->dispatch('toast-error', message: 'Ocurrió un error al enviar a la aseguradora: ' . $e->getMessage());
        }
    }

    public function render()
    {
        // Reintegros pendientes de pago (Estado Autorizado = 3)
        $pendientes = Reintegro::with('alumno', 'accidente.escuela')
            ->where('id_estado_reintegro', 3) // 3 = Autorizado
            ->orderBy('fecha_autorizacion', 'asc')
            ->get();

        // Reintegros enviados a aseguradora (Estado = 6)
        $enviadosAseguradora = Reintegro::with('alumno', 'accidente.escuela')
            ->where('id_estado_reintegro', 6)
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
            'enviadosAseguradora' => $enviadosAseguradora,
            'historialPaginado' => $historialPaginado
        ]);
    }
}
