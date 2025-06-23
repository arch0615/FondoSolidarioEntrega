<?php

namespace App\Livewire\Prestadores;

use Livewire\Component;
use App\Models\Prestador;
use App\Models\CatTipoPrestador;
use App\Services\AuditoriaService;

class Form extends Component
{
    public $modo = 'create';
    public $prestador_id;

    // Propiedades del modelo
    public $nombre;
    public $es_sistema_emergencias = false;
    public $direccion;
    public $telefono;
    public $email;
    public $especialidades;
    public $activo = true;
    public $id_tipo_prestador;

    // Mensajes de retroalimentación
    public $mensaje = '';
    public $tipoMensaje = '';

    protected function rules()
    {
        return [
            'nombre' => 'required|string|max:200',
            'id_tipo_prestador' => 'required|integer|exists:cat_tipos_prestadores,id_tipo_prestador',
            'es_sistema_emergencias' => 'boolean',
            'direccion' => 'required|string|max:300',
            'telefono' => 'required|string|max:50',
            'email' => 'required|email|max:100',
            'especialidades' => 'required|string|max:500',
            'activo' => 'boolean',
        ];
    }

    protected function messages()
    {
        return [
            'nombre.required' => 'El nombre del prestador es obligatorio.',
            'nombre.max' => 'El nombre no puede tener más de 200 caracteres.',
            'id_tipo_prestador.required' => 'Debe seleccionar un tipo de prestador.',
            'id_tipo_prestador.integer' => 'El tipo de prestador no es válido.',
            'id_tipo_prestador.exists' => 'El tipo de prestador seleccionado no es válido.',
            'direccion.required' => 'La dirección es obligatoria.',
            'direccion.max' => 'La dirección no puede tener más de 300 caracteres.',
            'telefono.required' => 'El teléfono es obligatorio.',
            'telefono.max' => 'El teléfono no puede tener más de 50 caracteres.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El formato del correo electrónico no es válido.',
            'email.max' => 'El correo electrónico no puede tener más de 100 caracteres.',
            'especialidades.required' => 'Debe ingresar al menos una especialidad.',
            'especialidades.max' => 'Las especialidades no pueden tener más de 500 caracteres.',
        ];
    }

    public function mount($modo = 'create', $prestador_id = null)
    {
        $this->modo = $modo;
        if ($prestador_id) {
            $this->prestador_id = $prestador_id;
            $prestador = Prestador::findOrFail($prestador_id);
            
            $this->nombre = $prestador->nombre;
            $this->es_sistema_emergencias = $prestador->es_sistema_emergencias;
            $this->direccion = $prestador->direccion;
            $this->telefono = $prestador->telefono;
            $this->email = $prestador->email;
            $this->especialidades = $prestador->especialidades;
            $this->activo = $prestador->activo;
            $this->id_tipo_prestador = $prestador->id_tipo_prestador;
        }
    }

    public function render()
    {
        $tiposPrestador = CatTipoPrestador::orderBy('descripcion')->get();
        return view('livewire.prestadores.form', compact('tiposPrestador'));
    }

    public function guardar()
    {
        $this->validate();

        $data = [
            'nombre' => $this->nombre,
            'es_sistema_emergencias' => $this->es_sistema_emergencias,
            'direccion' => $this->direccion,
            'telefono' => $this->telefono,
            'email' => $this->email,
            'especialidades' => $this->especialidades,
            'activo' => $this->activo,
            'id_tipo_prestador' => $this->id_tipo_prestador,
        ];

        if ($this->modo == 'create') {
            $prestador = Prestador::create($data);
            AuditoriaService::registrarCreacion('prestadores', $prestador->id_prestador, $data);
            
            $this->mensaje = 'Prestador creado exitosamente.';
            $this->tipoMensaje = 'success';
            $this->dispatch('mostrar-mensaje-y-redirigir');

        } else {
            $prestador = Prestador::findOrFail($this->prestador_id);
            $datosAnteriores = $prestador->getOriginal();
            $prestador->update($data);
            
            AuditoriaService::registrarActualizacion('prestadores', $prestador->id_prestador, $datosAnteriores, $data);
            
            $this->mensaje = 'Prestador actualizado exitosamente.';
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
        return redirect()->route('prestadores.index');
    }
}
