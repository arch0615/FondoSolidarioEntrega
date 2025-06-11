<?php

namespace App\Livewire\Reintegros;

use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search;
    public $sortBy = 'id_reintegro';
    public $sortDirection = 'desc';

    public function render()
    {
        // NOTE: La lógica de consulta a la base de datos no se implementa en este paso.
        // Se asume que se conectará a un modelo Reintegro más adelante.
        // Por ahora, se devuelve la vista con datos de mockup.
        $reintegrosMockup = collect([
            [
                'id_reintegro' => 'REI-001',
                'id_accidente' => 'ACC-001',
                'nombre_alumno' => 'Juan Pérez',
                'escuela' => 'Colegio San Martín',
                'fecha_solicitud' => '2024-05-20',
                'monto_solicitado' => 1500.00,
                'estado' => 'En Proceso',
                'solicitud_informacion' => null,
            ],
            [
                'id_reintegro' => 'REI-002',
                'id_accidente' => 'ACC-002',
                'nombre_alumno' => 'Ana López',
                'escuela' => 'Instituto Belgrano',
                'fecha_solicitud' => '2024-05-22',
                'monto_solicitado' => 8250.50,
                'estado' => 'Autorizado',
                'solicitud_informacion' => null,
            ],
            [
                'id_reintegro' => 'REI-003',
                'id_accidente' => 'ACC-003',
                'nombre_alumno' => 'Carlos Sanchez',
                'escuela' => 'Colegio San Martín',
                'fecha_solicitud' => '2024-05-25',
                'monto_solicitado' => 3100.00,
                'estado' => 'Solicitud de Información',
                'solicitud_informacion' => 'Falta el comprobante de la farmacia. Por favor, adjúntelo.',
            ],
             [
                'id_reintegro' => 'REI-004',
                'id_accidente' => 'ACC-004',
                'nombre_alumno' => 'Laura Gomez',
                'escuela' => 'Instituto Belgrano',
                'fecha_solicitud' => '2024-05-28',
                'monto_solicitado' => 500.00,
                'estado' => 'Rechazado',
                'solicitud_informacion' => null,
            ],
        ]);

        return view('livewire.reintegros.index', [
            'reintegros' => $reintegrosMockup
        ]);
    }

    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
    }
}