<?php

namespace App\Livewire\GestionPagos;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class Index extends Component
{
    use WithPagination;

    public $pendientes = [];
    public $historial = [];
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
        // Datos de ejemplo para reintegros pendientes
        $this->pendientes = [
            [
                'id_reintegro' => 101,
                'id_accidente' => 202,
                'nombre_alumno' => 'Ana García',
                'escuela' => 'Escuela Primaria N°1',
                'fecha_autorizacion' => '2025-06-10',
                'monto' => 1500.50,
            ],
            [
                'id_reintegro' => 102,
                'id_accidente' => 205,
                'nombre_alumno' => 'Luis Fernández',
                'escuela' => 'Colegio San Martín',
                'fecha_autorizacion' => '2025-06-09',
                'monto' => 850.00,
            ],
            [
                'id_reintegro' => 103,
                'id_accidente' => 210,
                'nombre_alumno' => 'Sofía Martínez',
                'escuela' => 'Instituto Belgrano',
                'fecha_autorizacion' => '2025-06-11',
                'monto' => 2300.75,
            ],
        ];

        // Datos de ejemplo para el historial de pagos
        $this->historial = [
            [
                'id_reintegro' => 98,
                'id_accidente' => 190,
                'nombre_alumno' => 'Carlos Rodríguez',
                'escuela' => 'Escuela Primaria N°1',
                'fecha_pago' => '2025-05-20',
                'monto' => 1200.00,
                'numero_transferencia' => 'TR-987654',
            ],
            [
                'id_reintegro' => 99,
                'id_accidente' => 195,
                'nombre_alumno' => 'Laura Pérez',
                'escuela' => 'Colegio San Martín',
                'fecha_pago' => '2025-05-22',
                'monto' => 750.25,
                'numero_transferencia' => 'TR-987655',
            ],
            [
                'id_reintegro' => 97,
                'id_accidente' => 180,
                'nombre_alumno' => 'Mariana Diaz',
                'escuela' => 'Instituto Belgrano',
                'fecha_pago' => '2025-05-18',
                'monto' => 300.00,
                'numero_transferencia' => 'TR-987653',
            ],
            [
                'id_reintegro' => 96,
                'id_accidente' => 170,
                'nombre_alumno' => 'Jorge Gomez',
                'escuela' => 'Escuela Primaria N°1',
                'fecha_pago' => '2025-05-15',
                'monto' => 500.00,
                'numero_transferencia' => 'TR-987652',
            ],
            [
                'id_reintegro' => 95,
                'id_accidente' => 160,
                'nombre_alumno' => 'Lucia Fernandez',
                'escuela' => 'Colegio San Martín',
                'fecha_pago' => '2025-05-12',
                'monto' => 950.00,
                'numero_transferencia' => 'TR-987651',
            ],
            [
                'id_reintegro' => 94,
                'id_accidente' => 150,
                'nombre_alumno' => 'Pedro Martinez',
                'escuela' => 'Instituto Belgrano',
                'fecha_pago' => '2025-05-10',
                'monto' => 1100.00,
                'numero_transferencia' => 'TR-987650',
            ],
        ];

        // Obtener lista única de escuelas para el filtro
        $this->escuelas = array_unique(array_merge(
            array_column($this->pendientes, 'escuela'),
            array_column($this->historial, 'escuela')
        ));
    }

    public function iniciarPago($id)
    {
        $this->reintegroSeleccionado = null;
        foreach ($this->pendientes as $reintegro) {
            if ($reintegro['id_reintegro'] == $id) {
                $this->reintegroSeleccionado = $reintegro;
                break;
            }
        }

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

        $reintegroPagado = $this->reintegroSeleccionado;
        $pendientesActualizado = [];

        foreach ($this->pendientes as $reintegro) {
            if ($reintegro['id_reintegro'] != $reintegroPagado['id_reintegro']) {
                $pendientesActualizado[] = $reintegro;
            }
        }

        if ($reintegroPagado) {
            $reintegroPagado['fecha_pago'] = $this->fecha_pago;
            $reintegroPagado['numero_transferencia'] = $this->numero_transferencia;
            array_unshift($this->historial, $reintegroPagado);
            $this->pendientes = $pendientesActualizado;
            $this->showPagoModal = false;
            $this->reset(['reintegroSeleccionado', 'fecha_pago', 'numero_transferencia']);
        }
    }

    public function render()
    {
        $historialFiltrado = collect($this->historial)->filter(function ($pago) {
            $pasaFiltro = true;

            if ($this->filtroEscuela && $pago['escuela'] !== $this->filtroEscuela) {
                $pasaFiltro = false;
            }

            if ($this->filtroFechaDesde && $pago['fecha_pago'] < $this->filtroFechaDesde) {
                $pasaFiltro = false;
            }

            if ($this->filtroFechaHasta && $pago['fecha_pago'] > $this->filtroFechaHasta) {
                $pasaFiltro = false;
            }

            return $pasaFiltro;
        });

        // Paginación manual de la colección
        $perPage = 5;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentPageItems = $historialFiltrado->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $historialPaginado = new LengthAwarePaginator($currentPageItems, $historialFiltrado->count(), $perPage, $currentPage, [
            'path' => LengthAwarePaginator::resolveCurrentPath(),
        ]);

        return view('livewire.gestion-pagos.index', [
            'historialPaginado' => $historialPaginado
        ]);
    }
}
