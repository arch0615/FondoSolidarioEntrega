<?php

namespace App\Livewire\BeneficiariosSvo;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\BeneficiarioSvo;
use App\Models\Escuela;
use App\Services\AuditoriaService;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination;

    // Filtros
    public $filtro_nombre = '';
    public $filtro_dni = '';
    public $filtro_escuela = '';
    public $filtro_estado = '';

    // Ordenamiento
    public $sortField = 'apellido';
    public $sortDirection = 'asc';

    // Paginación
    public $perPage = 10;

    // QueryString para mantener filtros en URL
    protected $queryString = [
        'filtro_nombre' => ['except' => ''],
        'filtro_dni' => ['except' => ''],
        'filtro_escuela' => ['except' => ''],
        'filtro_estado' => ['except' => ''],
        'sortField' => ['except' => 'apellido'],
        'sortDirection' => ['except' => 'asc'],
    ];

    public function render()
    {
        $beneficiarios = $this->getBeneficiarios();
        $escuelas = Auth::user()->rol !== 'Usuario General' ? Escuela::where('activo', true)->orderBy('nombre')->get() : [];

        return view('livewire.beneficiarios_svo.index', compact('beneficiarios', 'escuelas'));
    }

    public function getBeneficiarios()
    {
        $query = BeneficiarioSvo::query()
            ->with(['empleado', 'escuela', 'parentesco'])
            ->when($this->filtro_nombre, function ($query) {
                $query->where(function ($q) {
                    $q->where('nombre', 'like', '%' . $this->filtro_nombre . '%')
                      ->orWhere('apellido', 'like', '%' . $this->filtro_nombre . '%');
                });
            })
            ->when($this->filtro_dni, function ($query) {
                $query->where('dni', 'like', '%' . $this->filtro_dni . '%');
            })
            ->when($this->filtro_escuela, function ($query) {
                $query->where('id_escuela', $this->filtro_escuela);
            })
            ->when($this->filtro_estado !== '', function ($query) {
                $query->where('activo', $this->filtro_estado === '1');
            });

        if (Auth::user()->rol === 'Usuario General') {
            $query->where('id_escuela', Auth::user()->id_escuela);
        }

        // Aplicar ordenamiento
        if ($this->sortField === 'escuela.nombre') {
            $query->join('escuelas', 'beneficiarios_svo.id_escuela', '=', 'escuelas.id_escuela')
                  ->orderBy('escuelas.nombre', $this->sortDirection)
                  ->select('beneficiarios_svo.*');
        } elseif ($this->sortField === 'empleado.nombre') {
            $query->join('empleados', 'beneficiarios_svo.id_empleado', '=', 'empleados.id_empleado')
                  ->orderBy('empleados.apellido', $this->sortDirection)
                  ->orderBy('empleados.nombre', $this->sortDirection)
                  ->select('beneficiarios_svo.*');
        } else {
            $query->orderBy($this->sortField, $this->sortDirection);
        }

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
        $this->reset(['filtro_nombre', 'filtro_dni', 'filtro_escuela', 'filtro_estado']);
        $this->resetPage();
    }

    public function cambiarEstado($beneficiarioId)
    {
        $beneficiario = BeneficiarioSvo::findOrFail($beneficiarioId);
        $estadoAnterior = $beneficiario->activo;
        
        $beneficiario->activo = !$beneficiario->activo;
        $beneficiario->save();

        AuditoriaService::registrarActualizacion(
            'beneficiarios_svo',
            $beneficiario->id_beneficiario,
            ['activo' => $estadoAnterior],
            ['activo' => $beneficiario->activo]
        );

        $estado = $beneficiario->activo ? 'activado' : 'desactivado';
        session()->flash('message', "Beneficiario {$beneficiario->nombre} {$beneficiario->apellido} {$estado} exitosamente.");
    }

    public function eliminar($beneficiarioId)
    {
        $beneficiario = BeneficiarioSvo::findOrFail($beneficiarioId);
        $datosBeneficiario = $beneficiario->toArray();
        $beneficiario->delete();

        AuditoriaService::registrarEliminacion('beneficiarios_svo', $beneficiarioId, $datosBeneficiario);
        session()->flash('message', 'Beneficiario eliminado exitosamente.');
    }

    // Métodos para resetear página en filtros
    public function updatingFiltroNombre() { $this->resetPage(); }
    public function updatingFiltroDni() { $this->resetPage(); }
    public function updatingFiltroEscuela() { $this->resetPage(); }
    public function updatingFiltroEstado() { $this->resetPage(); }
}