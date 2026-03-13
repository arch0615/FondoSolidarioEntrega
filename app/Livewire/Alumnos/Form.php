<?php

namespace App\Livewire\Alumnos;

use Livewire\Component;
use App\Models\Alumno;
use App\Models\Escuela;
use App\Services\AuditoriaService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Form extends Component
{
    public $modo = 'create';
    public $alumno_id;

    // Propiedades del modelo Alumno
    public $id_escuela;
    public $nombre;
    public $apellido;
    public $dni;
    public $cuil;
    public $sala_grado_curso;
    public $familiar1;
    public $parentesco1;
    public $telefono_contacto1;
    public $familiar2;
    public $parentesco2;
    public $telefono_contacto2;
    public $familiar3;
    public $parentesco3;
    public $telefono_contacto3;
    public $fecha_nacimiento;
    public $activo = true;
    public $posee_obra_social = false;
    public $obra_social;
    public $deportes;

    // Propiedades para la vista
    public $escuelas;

    // Mensajes de retroalimentación
    public $mensaje = '';
    public $tipoMensaje = '';

    protected function rules()
    {
        return [
            'id_escuela' => 'required|integer|exists:escuelas,id_escuela',
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'dni' => 'required|string|max:10|unique:alumnos,dni,' . $this->alumno_id . ',id_alumno',
            'cuil' => 'nullable|string|max:15|unique:alumnos,cuil,' . $this->alumno_id . ',id_alumno',
            'sala_grado_curso' => 'nullable|string|max:50',
            'familiar1' => 'nullable|string|max:200',
            'parentesco1' => 'nullable|string|max:100',
            'telefono_contacto1' => 'nullable|string|max:50',
            'familiar2' => 'nullable|string|max:200',
            'parentesco2' => 'nullable|string|max:100',
            'telefono_contacto2' => 'nullable|string|max:50',
            'familiar3' => 'nullable|string|max:200',
            'parentesco3' => 'nullable|string|max:100',
            'telefono_contacto3' => 'nullable|string|max:50',
            'fecha_nacimiento' => 'required|date',
            'activo' => 'boolean',
        ];
    }

    protected function messages()
    {
        return [
            'id_escuela.required' => 'La escuela es obligatoria.',
            'nombre.required' => 'El nombre es obligatorio.',
            'apellido.required' => 'El apellido es obligatorio.',
            'dni.required' => 'El DNI es obligatorio.',
            'dni.unique' => 'El DNI ingresado ya existe.',
            'cuil.unique' => 'El CUIL ingresado ya existe.',
            'fecha_nacimiento.required' => 'La fecha de nacimiento es obligatoria.',
        ];
    }

    public function mount($alumno_id = null)
    {
        // Determinar el modo basado en la ruta actual
        $currentRoute = request()->route()->getName();
        
        if ($currentRoute === 'alumnos.create') {
            $this->modo = 'create';
        } elseif ($currentRoute === 'alumnos.edit') {
            $this->modo = 'edit';
        } elseif ($currentRoute === 'alumnos.show') {
            $this->modo = 'show';
        } else {
            $this->modo = 'create'; // fallback
        }
        
        $this->escuelas = Escuela::where('activo', true)->orderBy('nombre')->get();
        $user = Auth::user();

        if ($this->modo === 'create' && $user->id_rol == 1) {
            $this->id_escuela = $user->id_escuela;
        }

        if ($alumno_id) {
            $this->alumno_id = $alumno_id;
            $alumno = Alumno::findOrFail($alumno_id);
            $this->id_escuela = $alumno->id_escuela;
            $this->nombre = $alumno->nombre;
            $this->apellido = $alumno->apellido;
            $this->dni = $alumno->dni;
            $this->cuil = $alumno->cuil;
            $this->sala_grado_curso = $alumno->sala_grado_curso;
            $this->familiar1 = $alumno->familiar1;
            $this->parentesco1 = $alumno->parentesco1;
            $this->telefono_contacto1 = $alumno->telefono_contacto1;
            $this->familiar2 = $alumno->familiar2;
            $this->parentesco2 = $alumno->parentesco2;
            $this->telefono_contacto2 = $alumno->telefono_contacto2;
            $this->familiar3 = $alumno->familiar3;
            $this->parentesco3 = $alumno->parentesco3;
            $this->telefono_contacto3 = $alumno->telefono_contacto3;
            $this->fecha_nacimiento = $alumno->fecha_nacimiento ? $alumno->fecha_nacimiento->format('Y-m-d') : null;
            $this->activo = $alumno->activo;
            $this->obra_social = $alumno->obra_social;
            $this->posee_obra_social = !empty($alumno->obra_social);
            $this->deportes = $alumno->deportes;
        }
    }

    public function render()
    {
        return view('livewire.alumnos.form');
    }

    public function guardar()
    {
        $this->validate();

        $data = [
            'id_escuela' => $this->id_escuela,
            'nombre' => $this->nombre,
            'apellido' => $this->apellido,
            'dni' => $this->dni,
            'cuil' => $this->cuil,
            'sala_grado_curso' => $this->sala_grado_curso,
            'familiar1' => $this->familiar1,
            'parentesco1' => $this->parentesco1,
            'telefono_contacto1' => $this->telefono_contacto1,
            'familiar2' => $this->familiar2,
            'parentesco2' => $this->parentesco2,
            'telefono_contacto2' => $this->telefono_contacto2,
            'familiar3' => $this->familiar3,
            'parentesco3' => $this->parentesco3,
            'telefono_contacto3' => $this->telefono_contacto3,
            'fecha_nacimiento' => $this->fecha_nacimiento,
            'activo' => $this->activo,
            'obra_social' => $this->obra_social,
            'deportes' => $this->deportes,
        ];

        $auditoriaService = new AuditoriaService();

        if ($this->modo == 'create') {
            $alumno = Alumno::create($data);
            $auditoriaService->registrarCreacion('alumnos', $alumno->id_alumno, $data);
            
            $this->mensaje = 'Alumno creado exitosamente.';
            $this->tipoMensaje = 'success';
            $this->dispatch('mostrar-mensaje-y-redirigir');

        } else {
            $alumno = Alumno::findOrFail($this->alumno_id);
            $datosAnteriores = $alumno->getOriginal();
            $alumno->update($data);
            $auditoriaService->registrarActualizacion('alumnos', $alumno->id_alumno, $datosAnteriores, $data);
            
            $this->mensaje = 'Alumno actualizado exitosamente.';
            $this->tipoMensaje = 'success';
            $this->dispatch('mostrar-mensaje');
        }
    }

    public function limpiarMensaje()
    {
        $this->mensaje = '';
        $this->tipoMensaje = '';
    }

    public function redirigirAlListado()
    {
        return redirect()->route('alumnos.index');
    }
}
