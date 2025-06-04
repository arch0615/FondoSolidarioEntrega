<?php

namespace App\Livewire\Auditoria;

use Livewire\Component;
use App\Models\AuditoriaSistema;
use App\Models\User;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class AccesosSistema extends Component
{
    use WithPagination;

    public $filtro_usuario = '';
    public $filtro_fecha_desde = '';
    public $filtro_fecha_hasta = '';
    public $filtro_ip = '';
    public $sortField = 'fecha_hora';
    public $sortDirection = 'desc';

    protected $queryString = [
        'filtro_usuario' => ['except' => '', 'as' => 'u'],
        'filtro_fecha_desde' => ['except' => '', 'as' => 'fd'],
        'filtro_fecha_hasta' => ['except' => '', 'as' => 'fh'],
        'filtro_ip' => ['except' => '', 'as' => 'ip'],
        'sortField' => ['except' => 'fecha_hora', 'as' => 'sf'],
        'sortDirection' => ['except' => 'desc', 'as' => 'sd'],
        'page' => ['except' => 1, 'as' => 'p'],
    ];

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

    public function aplicarFiltros()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = AuditoriaSistema::query()
            ->whereIn('accion', ['LOGIN', 'LOGOUT'])
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

        $accesos = $query->paginate(15); // 15 registros por página

        return view('livewire.auditoria.accesos-sistema', [
            'accesos' => $accesos,
        ]);
    }

    // TODO: Implementar lógica de exportación
    public function exportar($formato)
    {
        // Lógica para generar y descargar el archivo
        session()->flash('info', 'La funcionalidad de exportar a ' . strtoupper($formato) . ' se implementará próximamente.');
    }
}