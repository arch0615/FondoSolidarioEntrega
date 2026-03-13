<?php

namespace App\Livewire\BeneficiariosSvo;

use Livewire\Component;
use App\Models\BeneficiarioSvo;
use App\Models\Empleado;
use App\Models\Escuela;
use App\Models\CatParentesco;
use App\Services\AuditoriaService;
use Illuminate\Support\Facades\Auth;

class Form extends Component
{
    public $modo = 'create';
    public $beneficiario_id;

    // Propiedades del modelo
    public $id_empleado;
    public $id_escuela;
    public $nombre;
    public $apellido;
    public $dni;
    public $porcentaje;
    public $id_parentesco;
    public $activo = true;

    // Para cargar datos en los selects
    public $escuelas = [];
    public $empleados = [];
    public $parentescos = [];

    // Mensajes de retroalimentación
    public $mensaje = '';
    public $tipoMensaje = '';

    protected function rules()
    {
        return [
            'id_escuela' => 'required|integer|exists:escuelas,id_escuela',
            'id_empleado' => 'required|integer|exists:empleados,id_empleado',
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'dni' => 'required|string|max:10|unique:beneficiarios_svo,dni,' . $this->beneficiario_id . ',id_beneficiario',
            'id_parentesco' => 'required|integer|exists:cat_parentescos,id_parentesco',
            'porcentaje' => 'required|numeric|min:0|max:100',
            'activo' => 'boolean',
        ];
    }

    protected function messages()
    {
        return [
            'id_escuela.required' => 'La escuela es obligatoria.',
            'id_empleado.required' => 'El empleado titular es obligatorio.',
            'nombre.required' => 'El nombre del beneficiario es obligatorio.',
            'apellido.required' => 'El apellido del beneficiario es obligatorio.',
            'dni.required' => 'El DNI del beneficiario es obligatorio.',
            'dni.unique' => 'El DNI ingresado ya está registrado.',
            'id_parentesco.required' => 'El parentesco es obligatorio.',
            'porcentaje.required' => 'El porcentaje es obligatorio.',
            'porcentaje.numeric' => 'El porcentaje debe ser un número.',
            'porcentaje.min' => 'El porcentaje no puede ser menor a 0.',
            'porcentaje.max' => 'El porcentaje no puede ser mayor a 100.',
        ];
    }

    public function mount($modo = 'create', $beneficiario_id = null)
    {
        $this->modo = $modo;
        $this->cargarDatosSelect();

        $user = Auth::user();

        if ($user->rol === 'usuario_general') {
            $this->id_escuela = $user->id_escuela;
            $this->empleados = Empleado::where('id_escuela', $this->id_escuela)->where('activo', true)->get();
        }

        if ($beneficiario_id) {
            $this->beneficiario_id = $beneficiario_id;
            $beneficiario = BeneficiarioSvo::findOrFail($beneficiario_id);
            
            $this->id_escuela = $beneficiario->id_escuela;
            if ($user->rol !== 'usuario_general') {
                $this->empleados = Empleado::where('id_escuela', $this->id_escuela)->where('activo', true)->get();
            }
            $this->id_empleado = $beneficiario->id_empleado;
            $this->nombre = $beneficiario->nombre;
            $this->apellido = $beneficiario->apellido;
            $this->dni = $beneficiario->dni;
            $this->id_parentesco = $beneficiario->id_parentesco;
            $this->porcentaje = $beneficiario->porcentaje;
            $this->activo = $beneficiario->activo;
        }
    }

    public function render()
    {
        return view('livewire.beneficiarios_svo.form');
    }

    public function guardar()
    {
        $this->validate();

        $data = [
            'id_escuela' => $this->id_escuela,
            'id_empleado' => $this->id_empleado,
            'nombre' => $this->nombre,
            'apellido' => $this->apellido,
            'dni' => $this->dni,
            'id_parentesco' => $this->id_parentesco,
            'porcentaje' => $this->porcentaje,
            'activo' => $this->activo,
        ];

        if ($this->modo == 'create') {
            $data['fecha_alta'] = now();
            $beneficiario = BeneficiarioSvo::create($data);
            AuditoriaService::registrarCreacion('beneficiarios_svo', $beneficiario->id_beneficiario, $data);
            
            $this->mensaje = 'Beneficiario SVO creado exitosamente.';
            $this->tipoMensaje = 'success';
            $this->dispatch('mostrar-mensaje-y-redirigir');
        } else {
            $beneficiario = BeneficiarioSvo::findOrFail($this->beneficiario_id);
            $datosAnteriores = $beneficiario->getOriginal();
            $beneficiario->update($data);
            AuditoriaService::registrarActualizacion('beneficiarios_svo', $beneficiario->id_beneficiario, $datosAnteriores, $data);
            
            $this->mensaje = 'Beneficiario SVO actualizado exitosamente.';
            $this->tipoMensaje = 'success';
            $this->dispatch('mostrar-mensaje');
        }
    }

    public function updatedIdEscuela($value)
    {
        $this->empleados = Empleado::where('id_escuela', $value)->where('activo', true)->get();
        $this->id_empleado = null; // Resetear empleado al cambiar de escuela
    }

    private function cargarDatosSelect()
    {
        $this->escuelas = Escuela::where('activo', true)->orderBy('nombre')->get();
        $this->parentescos = CatParentesco::orderBy('nombre_parentesco')->get();
    }

    public function limpiarMensaje()
    {
        $this->mensaje = '';
        $this->tipoMensaje = '';
    }

    public function redirigirAlListado()
    {
        return redirect()->route('beneficiarios_svo.index');
    }
}