<?php

namespace App\Livewire\Reintegros;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class Pendientes extends Component
{
    public $reintegros = [];
    public $reintegroSeleccionado;
    public $solicitandoInformacion = false;
    public $solicitudInfoTexto = '';
    public $rechazandoReintegro = false;
    public $motivoRechazo = '';

    public function mount()
    {
        $this->reintegros = [
            [
                'id' => 'REI-001',
                'accidente_id' => 'ACC-001',
                'alumno' => 'Juan Pérez',
                'escuela' => 'Colegio San Martín',
                'fecha_solicitud' => '2024-05-20',
                'monto' => 1500.00,
                'estado' => 'Pendiente Información',
                'documentos' => [
                    ['nombre' => 'Factura Farmacia.pdf', 'url' => '#'],
                    ['nombre' => 'Informe Médico.pdf', 'url' => '#'],
                ],
                'es_nuevo' => false,
            ],
            [
                'id' => 'REI-002',
                'accidente_id' => 'ACC-002',
                'alumno' => 'Ana López',
                'escuela' => 'Instituto Belgrano',
                'fecha_solicitud' => '2024-05-22',
                'monto' => 8250.50,
                'estado' => 'Nuevo',
                'documentos' => [
                    ['nombre' => 'Factura Consulta.pdf', 'url' => '#'],
                ],
                'es_nuevo' => true,
            ],
            [
                'id' => 'REI-003',
                'accidente_id' => 'ACC-003',
                'alumno' => 'Carlos Sanchez',
                'escuela' => 'Colegio San Martín',
                'fecha_solicitud' => '2024-05-25',
                'monto' => 3100.00,
                'estado' => 'Nuevo',
                'documentos' => [
                    ['nombre' => 'Factura Radiografía.pdf', 'url' => '#'],
                    ['nombre' => 'Receta Médica.pdf', 'url' => '#'],
                ],
                'es_nuevo' => true,
            ],
        ];
    }

    public function verDetalle($reintegroId)
    {
        $this->reintegroSeleccionado = collect($this->reintegros)->firstWhere('id', $reintegroId);
    }

    public function cerrarDetalle()
    {
        $this->reintegroSeleccionado = null;
    }

    public function solicitarInformacion()
    {
        $this->solicitandoInformacion = true;
    }

    public function enviarSolicitud()
    {
        // Aquí iría la lógica para guardar la solicitud en la BD
        // Por ahora, solo mostramos una alerta y reseteamos.
        session()->flash('message', 'Solicitud de información enviada para el reintegro: ' . $this->reintegroSeleccionado['id']);
        $this->cancelarSolicitud();
        $this->cerrarDetalle(); // Opcional: cerrar también el panel de detalle
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

    public function confirmarRechazo()
    {
        // Lógica para guardar el rechazo
        session()->flash('message', 'Reintegro ' . $this->reintegroSeleccionado['id'] . ' ha sido rechazado.');
        $this->cancelarRechazo();
        $this->cerrarDetalle();
    }

    public function cancelarRechazo()
    {
        $this->rechazandoReintegro = false;
        $this->motivoRechazo = '';
    }

    public function render()
    {
        return view('livewire.reintegros.pendientes');
    }
}