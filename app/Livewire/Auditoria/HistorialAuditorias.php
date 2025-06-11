<?php

namespace App\Livewire\Auditoria;

use Livewire\Component;

class HistorialAuditorias extends Component
{
    public $reintegros = [];
    public $showModal = false;
    public $selectedReintegro;
    public $escuelas = [];
    public $filtro_fecha_desde = '';
    public $filtro_fecha_hasta = '';
    public $filtro_escuela = '';

    public function mount()
    {
        $this->escuelas = [
            'Escuela Normal N°5',
            'Colegio San José',
            'Instituto Belgrano',
        ];

        $this->reintegros = [
            [
                'id' => 1,
                'nombre_alumno' => 'Juan Pérez',
                'escuela' => 'Escuela Normal N°5',
                'estado' => 'Aprobado',
                'monto_solicitado' => 1500.00,
                'codigo_accidente' => 'ACC-001',
                'fecha_aprobacion' => '2025-05-15',
                'motivo_rechazo' => null,
                'fecha_rechazo' => null,
                'solicitud_informacion' => null,
                'fecha_solicitud' => '2025-05-10',
                'dias_transcurridos' => null,
                'documentos' => [
                    ['nombre' => 'Factura_medica.pdf', 'url' => '#'],
                    ['nombre' => 'Informe_accidente.pdf', 'url' => '#'],
                ],
                'info_accidente' => 'Caída en el patio durante el recreo.'
            ],
            [
                'id' => 2,
                'nombre_alumno' => 'María García',
                'escuela' => 'Colegio San José',
                'estado' => 'Rechazado',
                'monto_solicitado' => 850.50,
                'codigo_accidente' => 'ACC-002',
                'fecha_aprobacion' => null,
                'motivo_rechazo' => 'Factura no válida',
                'fecha_rechazo' => '2025-05-12',
                'solicitud_informacion' => null,
                'fecha_solicitud' => '2025-05-08',
                'dias_transcurridos' => null,
                'documentos' => [
                    ['nombre' => 'Factura_invalida.jpg', 'url' => '#'],
                ],
                'info_accidente' => 'Lesión durante la clase de educación física.'
            ],
            [
                'id' => 3,
                'nombre_alumno' => 'Carlos López',
                'escuela' => 'Instituto Belgrano',
                'estado' => 'Solicitud de Información',
                'monto_solicitado' => 2300.00,
                'codigo_accidente' => 'ACC-003',
                'fecha_aprobacion' => null,
                'motivo_rechazo' => null,
                'fecha_rechazo' => null,
                'solicitud_informacion' => 'Falta certificado médico',
                'fecha_solicitud' => '2025-05-20',
                'dias_transcurridos' => 5,
                'documentos' => [],
                'info_accidente' => 'Accidente leve en el laboratorio de química.'
            ],
        ];
    }

    public function showReintegroModal($id)
    {
        $this->selectedReintegro = collect($this->reintegros)->firstWhere('id', $id);
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedReintegro = null;
    }

    public function render()
    {
        return view('livewire.auditoria.historial-auditorias');
    }
}