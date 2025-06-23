<?php

namespace App\Livewire\SalidasEducativas;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\SalidaEducativa;
use App\Models\Escuela;
use App\Services\AuditoriaService;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination;

    // Filtros
    public $filtro_destino = '';
    public $filtro_escuela = '';
    public $filtro_fecha = '';

    // Ordenamiento
    public $sortField = 'fecha_salida';
    public $sortDirection = 'desc';

    // Paginación
    public $perPage = 10;

    // Query String para mantener filtros en URL
    protected $queryString = [
        'filtro_destino' => ['except' => ''],
        'filtro_escuela' => ['except' => ''],
        'filtro_fecha' => ['except' => ''],
        'sortField' => ['except' => 'fecha_salida'],
        'sortDirection' => ['except' => 'desc'],
        'perPage' => ['except' => 10],
    ];

    public function render()
    {
        $salidas = $this->getSalidasEducativas();
        $escuelas = Escuela::orderBy('nombre')->get();
        
        return view('livewire.salidas-educativas.index', compact('salidas', 'escuelas'));
    }

    public function getSalidasEducativas()
    {
        $query = SalidaEducativa::query()->with('escuela');
        $user = Auth::user();

        // Si es usuario general, filtrar por su escuela
        if ($user->id_rol == 1) {
            $query->where('id_escuela', $user->id_escuela);
        } else {
            // Si es admin u otro rol, aplicar el filtro de la vista
            $query->when($this->filtro_escuela, function ($query) {
                $query->where('id_escuela', $this->filtro_escuela);
            });
        }

        $query->when($this->filtro_destino, function ($query) {
            $query->where('destino', 'like', '%' . $this->filtro_destino . '%');
        })
        ->when($this->filtro_fecha, function ($query) {
            $query->where('fecha_salida', $this->filtro_fecha);
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
        $this->reset(['filtro_destino', 'filtro_escuela', 'filtro_fecha']);
        $this->resetPage();
    }

    public function eliminar($salidaId)
    {
        $salida = SalidaEducativa::findOrFail($salidaId);
        $datosSalida = $salida->toArray();
        $salida->delete();

        AuditoriaService::registrarEliminacion('salidas_educativas', $salidaId, $datosSalida);
        session()->flash('message', 'Salida Educativa eliminada exitosamente.');
    }

    // Métodos para resetear página en filtros
    public function updatingFiltroDestino() { $this->resetPage(); }
    public function updatingFiltroEscuela() { $this->resetPage(); }
    public function updatingFiltroFecha() { $this->resetPage(); }
}
