<?php

namespace App\Livewire\Escuelas;

use Livewire\Component;
use App\Models\Escuela;
use App\Services\AuditoriaService;

class Form extends Component
{
    public $modo = 'create';
    public $escuela_id;

    // Propiedades del modelo
    public $codigo_escuela;
    public $nombre;
    public $direccion;
    public $telefono;
    public $email;
    public $aporte_por_alumno;
    public $fecha_alta;
    public $cantidad_empleados;
    public $cantidad_alumnos;
    public $activo = true;

    // Mensajes de retroalimentación
    public $mensaje = '';
    public $tipoMensaje = '';

    protected function rules()
    {
        return [
            'codigo_escuela' => 'required|string|max:20|unique:escuelas,codigo_escuela,' . $this->escuela_id . ',id_escuela',
            'nombre' => 'required|string|max:200',
            'direccion' => 'nullable|string|max:300',
            'telefono' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:100',
            'aporte_por_alumno' => 'nullable|numeric|min:0',
            'fecha_alta' => 'nullable|date',
            'cantidad_empleados' => 'nullable|integer|min:0',
            'cantidad_alumnos' => 'nullable|integer|min:0',
            'activo' => 'boolean',
        ];
    }

    protected function messages()
    {
        return [
            'codigo_escuela.required' => 'El CUIT es obligatorio.',
            'codigo_escuela.unique' => 'El CUIT ya está en uso.',
            'nombre.required' => 'El nombre es obligatorio.',
        ];
    }

    public function mount($modo = 'create', $escuela_id = null)
    {
        $this->modo = $modo;
        if ($escuela_id) {
            $this->escuela_id = $escuela_id;
            $escuela = Escuela::findOrFail($escuela_id);
            $this->codigo_escuela = $escuela->codigo_escuela;
            $this->nombre = $escuela->nombre;
            $this->direccion = $escuela->direccion;
            $this->telefono = $escuela->telefono;
            $this->email = $escuela->email;
            $this->aporte_por_alumno = $escuela->aporte_por_alumno;
            $this->fecha_alta = $escuela->fecha_alta ? $escuela->fecha_alta->format('Y-m-d') : null;
            $this->cantidad_empleados = $escuela->cantidad_empleados;
            $this->cantidad_alumnos = $escuela->cantidad_alumnos;
            $this->activo = $escuela->activo;
        } else {
            $this->fecha_alta = now()->format('Y-m-d');
        }
    }

    public function render()
    {
        return view('livewire.escuelas.form');
    }

    public function guardar()
    {
        $this->validate();

        $data = [
            'codigo_escuela' => $this->codigo_escuela,
            'nombre' => $this->nombre,
            'direccion' => $this->direccion,
            'telefono' => $this->telefono,
            'email' => $this->email,
            'aporte_por_alumno' => $this->aporte_por_alumno,
            'fecha_alta' => $this->fecha_alta,
            'cantidad_empleados' => $this->cantidad_empleados,
            'cantidad_alumnos' => $this->cantidad_alumnos,
            'activo' => $this->activo,
        ];

        if ($this->modo == 'create') {
            $escuela = Escuela::create($data);
            AuditoriaService::registrarCreacion('escuelas', $escuela->id_escuela, $data);
            
            $this->mensaje = 'Escuela creada exitosamente.';
            $this->tipoMensaje = 'success';
            $this->dispatch('mostrar-mensaje-y-redirigir');

        } else {
            $escuela = Escuela::findOrFail($this->escuela_id);
            $datosAnteriores = $escuela->getOriginal();
            $escuela->update($data);
            AuditoriaService::registrarActualizacion('escuelas', $escuela->id_escuela, $datosAnteriores, $data);
            
            $this->mensaje = 'Escuela actualizada exitosamente.';
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
        return redirect()->route('escuelas.index');
    }
}
