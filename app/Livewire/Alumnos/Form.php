<?php

namespace App\Livewire\Alumnos;

use Livewire\Component;
use App\Models\Alumno;
use App\Models\Escuela;
use App\Services\AuditoriaService;
use Illuminate\Support\Facades\Auth;

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
    public $nombre_padre_madre;
    public $telefono_contacto;
    public $fecha_nacimiento;
    public $activo = true;

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
            'sala_grado_curso' => 'required|string|max:50',
            'nombre_padre_madre' => 'nullable|string|max:200',
            'telefono_contacto' => 'nullable|string|max:50',
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
            'sala_grado_curso.required' => 'La sala/grado/curso es obligatoria.',
            'fecha_nacimiento.required' => 'La fecha de nacimiento es obligatoria.',
        ];
    }

    public function mount($modo = 'create', $alumno_id = null)
    {
        $this->modo = $modo;
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
            $this->nombre_padre_madre = $alumno->nombre_padre_madre;
            $this->telefono_contacto = $alumno->telefono_contacto;
            $this->fecha_nacimiento = $alumno->fecha_nacimiento ? $alumno->fecha_nacimiento->format('Y-m-d') : null;
            $this->activo = $alumno->activo;
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
            'nombre_padre_madre' => $this->nombre_padre_madre,
            'telefono_contacto' => $this->telefono_contacto,
            'fecha_nacimiento' => $this->fecha_nacimiento,
            'activo' => $this->activo,
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
