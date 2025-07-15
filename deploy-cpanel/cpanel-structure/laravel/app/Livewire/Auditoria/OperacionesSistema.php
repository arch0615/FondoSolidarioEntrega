<?php

namespace App\Livewire\Auditoria;

use Livewire\Component;
use App\Models\AuditoriaSistema;
use App\Models\User;
use Livewire\WithPagination;

class OperacionesSistema extends Component
{
    use WithPagination;

    public $filtro_usuario = '';
    public $filtro_accion = '';
    public $filtro_tabla = '';
    public $filtro_id_registro = '';
    public $filtro_fecha_desde = '';
    public $filtro_fecha_hasta = '';
    public $filtro_ip = '';
    public $sortField = 'fecha_hora';
    public $sortDirection = 'desc';
    public $perPage = 15;
 
    protected $queryString = [
        'filtro_usuario' => ['except' => '', 'as' => 'u_op'],
        'filtro_accion' => ['except' => '', 'as' => 'ac_op'],
        'filtro_tabla' => ['except' => '', 'as' => 'tb_op'],
        'filtro_id_registro' => ['except' => '', 'as' => 'id_op'],
        'filtro_fecha_desde' => ['except' => '', 'as' => 'fd_op'],
        'filtro_fecha_hasta' => ['except' => '', 'as' => 'fh_op'],
        'filtro_ip' => ['except' => '', 'as' => 'ip_op'],
        'sortField' => ['except' => 'fecha_hora', 'as' => 'sf_op'],
        'sortDirection' => ['except' => 'desc', 'as' => 'sd_op'],
        'page' => ['except' => 1, 'as' => 'p_op'],
    ];

    public $showModal = false;
    public $datosAnteriores = '';
    public $datosNuevos = '';

    public function mostrarDetalles($datosAnteriores, $datosNuevos)
    {
        $this->datosAnteriores = json_decode($datosAnteriores) ? json_encode(json_decode($datosAnteriores), JSON_PRETTY_PRINT) : 'Sin datos';
        $this->datosNuevos = json_decode($datosNuevos) ? json_encode(json_decode($datosNuevos), JSON_PRETTY_PRINT) : 'Sin datos';
        $this->showModal = true;
    }

    public function cerrarModal()
    {
        $this->showModal = false;
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortField = $field;
        $this->resetPage();
    }

    public function limpiarFiltros()
    {
        $this->reset([
            'filtro_usuario',
            'filtro_accion',
            'filtro_tabla',
            'filtro_id_registro',
            'filtro_fecha_desde',
            'filtro_fecha_hasta',
            'filtro_ip',
        ]);
        $this->resetPage();
    }

    public function render()
    {
        $query = AuditoriaSistema::query()
            ->whereNotIn('accion', ['LOGIN', 'LOGOUT'])
            ->with(['usuario' => function ($q) {
                $q->select('id_usuario', 'nombre', 'apellido', 'email'); // Optimizar consulta
            }]);

        if (!empty($this->filtro_usuario)) {
            $query->whereHas('usuario', function ($q) {
                $q->where('nombre', 'like', '%' . $this->filtro_usuario . '%')
                  ->orWhere('apellido', 'like', '%' . $this->filtro_usuario . '%')
                  ->orWhere('email', 'like', '%' . $this->filtro_usuario . '%');
            });
        }

        if (!empty($this->filtro_accion)) {
            $query->where('accion', 'like', '%' . $this->filtro_accion . '%');
        }

        if (!empty($this->filtro_tabla)) {
            $query->where('tabla_afectada', 'like', '%' . $this->filtro_tabla . '%');
        }

        if (!empty($this->filtro_id_registro)) {
            $query->where('id_registro', $this->filtro_id_registro);
        }

        if (!empty($this->filtro_fecha_desde)) {
            $query->where('fecha_hora', '>=', $this->filtro_fecha_desde . ' 00:00:00');
        }

        if (!empty($this->filtro_fecha_hasta)) {
            $query->where('fecha_hora', '<=', $this->filtro_fecha_hasta . ' 23:59:59');
        }

        if (!empty($this->filtro_ip)) {
            $query->where('ip_usuario', 'like', '%' . $this->filtro_ip . '%');
        }

        // Ordenamiento
        if ($this->sortField === 'usuarios.email') {
             $query->join('usuarios', 'auditoria_sistema.id_usuario', '=', 'usuarios.id_usuario')
                   ->orderBy('usuarios.email', $this->sortDirection)
                   ->select('auditoria_sistema.*');
        } else {
            $query->orderBy($this->sortField, $this->sortDirection);
        }

        $operaciones = $query->paginate($this->perPage);
 
        return view('livewire.auditoria.operaciones-sistema', [
            'operaciones' => $operaciones,
        ]);
    }

    public function updatingFiltroUsuario() { $this->resetPage('p_op'); }
    public function updatingFiltroAccion() { $this->resetPage('p_op'); }
    public function updatingFiltroTabla() { $this->resetPage('p_op'); }
    public function updatingFiltroIdRegistro() { $this->resetPage('p_op'); }
    public function updatingFiltroFechaDesde() { $this->resetPage('p_op'); }
    public function updatingFiltroFechaHasta() { $this->resetPage('p_op'); }
    public function updatingFiltroIp() { $this->resetPage('p_op'); }
 
    // TODO: Implementar lógica de exportación
    public function exportar($formato)
    {
        // Lógica para generar y descargar el archivo
        session()->flash('info', 'La funcionalidad de exportar a ' . strtoupper($formato) . ' se implementará próximamente.');
    }
}