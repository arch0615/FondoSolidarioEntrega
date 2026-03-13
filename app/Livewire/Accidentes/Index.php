<?php

namespace App\Livewire\Accidentes;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Accidente;
use App\Models\CatEstadoAccidente;
use App\Models\Escuela;
use App\Services\AuditoriaService;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination;

    // FILTROS
    public $filtro_escuela = '';
    public $filtro_fecha = '';
    public $filtro_estado = '';
    public $filtro_expediente = '';
    public $filtro_alumno = '';

    // CONTROL DE ROL DE USUARIO
    public $es_usuario_general = false;

    // ORDENAMIENTO
    public $sortField = 'fecha_accidente';
    public $sortDirection = 'desc';

    // PAGINACIÓN
    public $perPage = 10;

    // QUERY STRING para mantener filtros en URL
    protected $queryString = [
        'filtro_escuela' => ['except' => ''],
        'filtro_fecha' => ['except' => ''],
        'filtro_estado' => ['except' => ''],
        'filtro_expediente' => ['except' => ''],
        'filtro_alumno' => ['except' => ''],
        'sortField' => ['except' => 'fecha_accidente'],
        'sortDirection' => ['except' => 'desc'],
        'perPage' => ['except' => 10],
    ];

    public function mount()
    {
        // Verificar el rol del usuario
        $usuario = Auth::user();
        if ($usuario) {
            $this->es_usuario_general = $usuario->id_rol == 1;
            
            // Si es usuario general, establecer automáticamente su escuela en el filtro
            if ($this->es_usuario_general && $usuario->id_escuela) {
                $this->filtro_escuela = $usuario->id_escuela;
            }
        }
    }

    public function render()
    {
        $accidentes = $this->getAccidentes();
        $escuelas = Escuela::orderBy('nombre')->get();
        $estados = CatEstadoAccidente::orderBy('nombre_estado')->get();
        
        return view('livewire.accidentes.index', compact('accidentes', 'escuelas', 'estados'));
    }

    public function getAccidentes()
    {
        $query = Accidente::query()
            ->with([
                'escuela',
                'estado',
                'alumnos.alumno',
                'derivaciones',
                'reintegros'
            ])
            ->when($this->filtro_escuela, function ($query) {
                $query->where('id_escuela', $this->filtro_escuela);
            })
            ->when($this->filtro_fecha, function ($query) {
                $query->whereDate('fecha_accidente', $this->filtro_fecha);
            })
            ->when($this->filtro_estado, function ($query) {
                $query->where('id_estado_accidente', $this->filtro_estado);
            })
            ->when($this->filtro_expediente, function ($query) {
                $query->where('numero_expediente', 'like', '%' . $this->filtro_expediente . '%');
            })
            ->when($this->filtro_alumno, function ($query) {
                $query->whereHas('alumnos.alumno', function ($q) {
                    $q->where('nombre', 'like', '%' . $this->filtro_alumno . '%')
                      ->orWhere('apellido', 'like', '%' . $this->filtro_alumno . '%')
                      ->orWhere('dni', 'like', '%' . $this->filtro_alumno . '%');
                });
            });

        // Aplicar ordenamiento
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
        // Para usuarios generales, no limpiar el filtro de escuela
        if ($this->es_usuario_general) {
            $this->reset(['filtro_fecha', 'filtro_estado', 'filtro_expediente', 'filtro_alumno']);
        } else {
            $this->reset(['filtro_escuela', 'filtro_fecha', 'filtro_estado', 'filtro_expediente', 'filtro_alumno']);
        }
        $this->resetPage();
    }

    public function cambiarEstado($accidenteId)
    {
        $accidente = Accidente::findOrFail($accidenteId);
        $estadoAnterior = $accidente->id_estado_accidente;
        
        // Lógica para cambiar el estado, asumiendo que hay un estado "activo" o similar
        // Esto dependerá de los estados definidos en CatEstadoAccidente
        // Por ahora, solo como ejemplo, se podría cambiar a un estado predefinido
        // O se podría requerir un modal para seleccionar el nuevo estado
        // Para este prototipo, asumiremos un cambio simple de estado si existe un campo booleano 'activo'
        // Si no, se necesitaría una lógica más compleja o un campo de estado específico.
        // Dado que la migración tiene 'id_estado_accidente', se debería cambiar a otro ID de estado.
        // Por simplicidad, si el estado actual es 1, lo cambia a 2, y viceversa.
        $nuevoEstado = ($estadoAnterior == 1) ? 2 : 1; 
        $accidente->id_estado_accidente = $nuevoEstado;
        $accidente->save();

        // Auditoría
        AuditoriaService::registrarActualizacion(
            'accidentes',
            $accidenteId,
            ['id_estado_accidente' => $estadoAnterior],
            ['id_estado_accidente' => $accidente->id_estado_accidente]
        );

        session()->flash('message', "Accidente actualizado a estado ID {$nuevoEstado} exitosamente.");
    }

    public function eliminar($accidenteId)
    {
        $accidente = Accidente::findOrFail($accidenteId);
        $datosAccidente = $accidente->toArray();
        $accidente->delete();

        AuditoriaService::registrarEliminacion('accidentes', $accidenteId, $datosAccidente);
        session()->flash('message', 'Accidente eliminado exitosamente.');
    }
    public function getAlumnosDelAccidente($accidenteId)
    {
        try {
            $accidente = Accidente::with(['alumnos.alumno', 'escuela'])->findOrFail($accidenteId);
            
            $alumnos = $accidente->alumnos->map(function ($accidenteAlumno) {
                return [
                    'nombre_completo' => $accidenteAlumno->alumno->nombre_completo ?? 'Sin nombre',
                    'dni' => $accidenteAlumno->alumno->dni ?? 'Sin DNI',
                    'sala_grado_curso' => $accidenteAlumno->alumno->sala_grado_curso ?? 'Sin curso',
                    'grado_seccion' => $accidenteAlumno->grado_seccion ?? 'Sin grado/sección',
                ];
            })->toArray();

            $this->dispatch('alumnosModal',
                alumnos: $alumnos,
                expediente: $accidente->numero_expediente ?? 'Sin número de expediente',
                escuela: $accidente->escuela->nombre ?? 'Sin escuela'
            );
            
        } catch (\Exception $e) {
            session()->flash('error', 'Error al cargar los alumnos del accidente.');
        }
    }

    // MÉTODOS PARA RESETEAR PÁGINA EN FILTROS
    public function updatingFiltroEscuela() { $this->resetPage(); }
    public function updatingFiltroFecha() { $this->resetPage(); }
    public function updatingFiltroEstado() { $this->resetPage(); }
    public function updatingFiltroExpediente() { $this->resetPage(); }
    public function updatingFiltroAlumno() { $this->resetPage(); }
    public function updatingPerPage() { $this->resetPage(); }

}
