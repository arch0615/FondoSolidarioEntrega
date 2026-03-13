<?php

namespace App\Livewire\SalidasEducativas;

use Livewire\Component;
use App\Models\SalidaEducativa;
use App\Models\Escuela;
use App\Services\AuditoriaService;
use Illuminate\Support\Facades\Auth;

class Form extends Component
{
    public $modo = 'create';
    public $salida_id;

    // Propiedades del modelo
    public $id_escuela;
    public $fecha_salida;
    public $hora_salida;
    public $hora_regreso;
    public $destino;
    public $proposito;
    public $grado_curso;
    public $cantidad_alumnos;
    public $docentes_acompanantes;
    public $transporte;

    // Mensajes de retroalimentación
    public $mensaje = '';
    public $tipoMensaje = '';

    public $esUsuarioGeneral = false;

    protected function rules()
    {
        return [
            'id_escuela' => 'required|exists:escuelas,id_escuela',
            'fecha_salida' => 'required|date',
            'hora_salida' => 'required',
            'hora_regreso' => 'required|after:hora_salida',
            'destino' => 'required|string|max:255',
            'proposito' => 'required|string',
            'grado_curso' => 'nullable|string|max:100',
            'cantidad_alumnos' => 'required|integer|min:1',
            'docentes_acompanantes' => 'required|string|max:255',
            'transporte' => 'required|string|max:255',
        ];
    }

    protected function messages()
    {
        return [
            'id_escuela.required' => 'El campo escuela es obligatorio.',
            'fecha_salida.required' => 'La fecha de salida es obligatoria.',
            'hora_salida.required' => 'La hora de salida es obligatoria.',
            'hora_regreso.required' => 'La hora de regreso es obligatoria.',
            'hora_regreso.after' => 'La hora de regreso debe ser posterior a la hora de salida.',
            'destino.required' => 'El destino es obligatorio.',
            'proposito.required' => 'El propósito es obligatorio.',
            'grado_curso.required' => 'El grado/curso es opcional.',
            'cantidad_alumnos.required' => 'La cantidad de alumnos es obligatoria.',
            'cantidad_alumnos.integer' => 'La cantidad de alumnos debe ser un número.',
            'cantidad_alumnos.min' => 'Debe haber al menos un alumno.',
            'docentes_acompanantes.required' => 'Los docentes acompañantes son obligatorios.',
            'transporte.required' => 'El medio de transporte es obligatorio.',
        ];
    }

    public function mount($modo = 'create', $salida_id = null)
    {
        $this->modo = $modo;
        $user = Auth::user();
        $this->esUsuarioGeneral = ($user->id_rol == 1);

        if ($this->esUsuarioGeneral) {
            $this->id_escuela = $user->id_escuela;
        }

        if ($salida_id) {
            $this->salida_id = $salida_id;
            // Asegurarse que el usuario general solo edite salidas de su escuela
            if ($this->esUsuarioGeneral) {
                $salida = SalidaEducativa::where('id_salida', $salida_id)->where('id_escuela', $user->id_escuela)->firstOrFail();
            } else {
                $salida = SalidaEducativa::findOrFail($salida_id);
            }
            
            $this->id_escuela = $salida->id_escuela;
            $this->fecha_salida = $salida->fecha_salida->format('Y-m-d');
            $this->hora_salida = $salida->hora_salida->format('H:i');
            $this->hora_regreso = $salida->hora_regreso->format('H:i');
            $this->destino = $salida->destino;
            $this->proposito = $salida->proposito;
            $this->grado_curso = $salida->grado_curso;
            $this->cantidad_alumnos = $salida->cantidad_alumnos;
            $this->docentes_acompanantes = $salida->docentes_acompanantes;
            $this->transporte = $salida->transporte;
        }
    }

    public function render()
    {
        $escuelas = Escuela::orderBy('nombre')->get();
        return view('livewire.salidas_educativas.form', compact('escuelas'));
    }

    public function guardar()
    {
        try {
            $this->validate();

            $data = [
            'id_escuela' => $this->id_escuela,
            'fecha_salida' => $this->fecha_salida,
            'hora_salida' => $this->hora_salida,
            'hora_regreso' => $this->hora_regreso,
            'destino' => $this->destino,
            'proposito' => $this->proposito,
            'grado_curso' => $this->grado_curso,
            'cantidad_alumnos' => $this->cantidad_alumnos,
            'docentes_acompanantes' => $this->docentes_acompanantes,
            'transporte' => $this->transporte,
            'id_usuario_carga' => Auth::id(),
            'fecha_carga' => now(),
        ];

        if ($this->modo == 'create') {
            $salida = SalidaEducativa::create($data);
            AuditoriaService::registrarCreacion('salidas_educativas', $salida->id_salida, $data);
            
            $this->mensaje = 'Salida Educativa creada exitosamente.';
            $this->tipoMensaje = 'success';
            $this->dispatch('mostrar-mensaje-y-redirigir');

        } else {
            $salida = SalidaEducativa::findOrFail($this->salida_id);
            $datosAnteriores = $salida->getOriginal();
            $salida->update($data);
            AuditoriaService::registrarActualizacion('salidas_educativas', $salida->id_salida, $datosAnteriores, $data);
            
            $this->mensaje = 'Salida Educativa actualizada exitosamente.';
            $this->tipoMensaje = 'success';
            $this->dispatch('mostrar-mensaje');
        }

        } catch (\Exception $e) {
            $this->mensaje = 'Error al guardar: ' . $e->getMessage();
            $this->tipoMensaje = 'error';
        }
    }

    public function limpiarMensaje()
    {
        $this->mensaje = '';
        $this->tipoMensaje = '';
    }

    public function redirigirAlListado()
    {
        return redirect()->route('salidas-educativas.index');
    }
}
