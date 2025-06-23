<?php

namespace App\Livewire\Empleados;

use Livewire\Component;
use App\Models\Empleado;
use App\Models\Escuela;
use App\Services\AuditoriaService;
use Illuminate\Support\Facades\Auth;

class Form extends Component
{
    public $modo = 'create';
    public $empleado_id;

    // Propiedades del modelo
    public $id_escuela;
    public $nombre;
    public $apellido;
    public $dni;
    public $cuil;
    public $cargo;
    public $fecha_ingreso;
    public $fecha_egreso;
    public $telefono;
    public $email;
    public $direccion;
    public $activo = true;

    public $mensaje = '';
    public $tipoMensaje = '';

    protected function rules()
    {
        return [
            'id_escuela' => 'required|integer|exists:escuelas,id_escuela',
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'dni' => 'required|string|max:10|unique:empleados,dni,' . $this->empleado_id . ',id_empleado',
            'cuil' => 'required|string|max:15|unique:empleados,cuil,' . $this->empleado_id . ',id_empleado',
            'cargo' => 'required|string|max:100',
            'fecha_ingreso' => 'required|date',
            'fecha_egreso' => 'nullable|date|after_or_equal:fecha_ingreso',
            'telefono' => 'required|string|max:50',
            'email' => 'required|email|max:100|unique:empleados,email,' . $this->empleado_id . ',id_empleado',
            'direccion' => 'required|string|max:300',
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
            'dni.unique' => 'El DNI ya está registrado.',
            'cuil.required' => 'El CUIL es obligatorio.',
            'cuil.unique' => 'El CUIL ya está registrado.',
            'cargo.required' => 'El cargo es obligatorio.',
            'fecha_ingreso.required' => 'La fecha de ingreso es obligatoria.',
            'fecha_egreso.after_or_equal' => 'La fecha de egreso no puede ser anterior a la de ingreso.',
            'telefono.required' => 'El teléfono es obligatorio.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El formato del correo electrónico no es válido.',
            'email.unique' => 'El correo electrónico ya está registrado.',
            'direccion.required' => 'La dirección es obligatoria.',
        ];
    }

    public function mount($modo = 'create', $empleado_id = null)
    {
        $this->modo = $modo;
        if ($empleado_id) {
            $this->empleado_id = $empleado_id;
            $empleado = Empleado::findOrFail($empleado_id);
            $this->id_escuela = $empleado->id_escuela;
            $this->nombre = $empleado->nombre;
            $this->apellido = $empleado->apellido;
            $this->dni = $empleado->dni;
            $this->cuil = $empleado->cuil;
            $this->cargo = $empleado->cargo;
            $this->fecha_ingreso = $empleado->fecha_ingreso ? $empleado->fecha_ingreso->format('Y-m-d') : null;
            $this->fecha_egreso = $empleado->fecha_egreso ? $empleado->fecha_egreso->format('Y-m-d') : null;
            $this->telefono = $empleado->telefono;
            $this->email = $empleado->email;
            $this->direccion = $empleado->direccion;
            $this->activo = $empleado->activo;
        } else {
            $usuario = Auth::user();
            if ($usuario && $usuario->id_rol == 1) {
                $this->id_escuela = $usuario->id_escuela;
            }
        }
    }

    public function render()
    {
        $escuelas = Escuela::orderBy('nombre')->get();
        return view('livewire.empleados.form', compact('escuelas'));
    }

    public function guardar()
    {
        if ($this->modo == 'show') return;

        $this->validate();

        $data = [
            'id_escuela' => $this->id_escuela,
            'nombre' => $this->nombre,
            'apellido' => $this->apellido,
            'dni' => $this->dni,
            'cuil' => $this->cuil,
            'cargo' => $this->cargo,
            'fecha_ingreso' => $this->fecha_ingreso,
            'fecha_egreso' => $this->fecha_egreso,
            'telefono' => $this->telefono,
            'email' => $this->email,
            'direccion' => $this->direccion,
            'activo' => $this->activo,
        ];

        if ($this->modo == 'create') {
            $empleado = Empleado::create($data);
            AuditoriaService::registrarCreacion('empleados', $empleado->id_empleado, $data);
            
            $this->mensaje = 'Empleado creado exitosamente.';
            $this->tipoMensaje = 'success';
            $this->dispatch('mostrar-mensaje-y-redirigir');

        } else {
            $empleado = Empleado::findOrFail($this->empleado_id);
            $datosAnteriores = $empleado->getOriginal();
            $empleado->update($data);
            AuditoriaService::registrarActualizacion('empleados', $empleado->id_empleado, $datosAnteriores, $data);
            
            $this->mensaje = 'Empleado actualizado exitosamente.';
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
        return redirect()->route('empleados.index');
    }
}
