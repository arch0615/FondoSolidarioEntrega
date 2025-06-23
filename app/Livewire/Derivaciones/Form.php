<?php

namespace App\Livewire\Derivaciones;

use App\Models\Accidente;
use App\Models\Derivacion;
use App\Models\Prestador;
use App\Services\AuditoriaService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Form extends Component
{
    public $modo = 'create';
    public $derivacion_id;

    // Propiedades del modelo
    public $id_accidente;
    public $id_alumno;
    public $id_prestador;
    public $fecha_derivacion;
    public $hora_derivacion;
    public $medico_deriva;
    public $diagnostico_inicial;
    public $acompanante;
    public $observaciones;
    public $impresa = false;
    public $fecha_impresion;

    // Propiedades para lógica de UI
    public $alumnosDelAccidente = [];

    // Mensajes de retroalimentación
    public $mensaje = '';
    public $tipoMensaje = '';

    protected function rules()
    {
        return [
            'id_accidente' => 'required|integer|exists:accidentes,id_accidente',
            'id_alumno' => 'required|integer|exists:alumnos,id_alumno',
            'id_prestador' => 'required|integer|exists:prestadores,id_prestador',
            'fecha_derivacion' => 'required|date',
            'hora_derivacion' => 'required',
            'medico_deriva' => 'nullable|string|max:255',
            'diagnostico_inicial' => 'required|string|max:1000',
            'acompanante' => 'required|string|max:255',
            'observaciones' => 'nullable|string|max:2000',
            'impresa' => 'boolean',
        ];
    }

    protected function messages()
    {
        return [
            'id_accidente.required' => 'El accidente relacionado es obligatorio.',
            'id_alumno.required' => 'El alumno es obligatorio.',
            'id_prestador.required' => 'El prestador médico es obligatorio.',
            'fecha_derivacion.required' => 'La fecha de derivación es obligatoria.',
            'hora_derivacion.required' => 'La hora de derivación es obligatoria.',
            'diagnostico_inicial.required' => 'El diagnóstico inicial es obligatorio.',
            'acompanante.required' => 'El acompañante es obligatorio.',
        ];
    }

    public function mount($modo = 'create', $derivacion_id = null, $accidente_id = null)
    {
        $this->modo = $modo;

        if ($accidente_id) {
            $this->id_accidente = $accidente_id;
            $this->updatedIdAccidente($accidente_id);
        }

        if ($derivacion_id) {
            $this->derivacion_id = $derivacion_id;
            $derivacion = Derivacion::findOrFail($derivacion_id);
            $this->id_accidente = $derivacion->id_accidente;
            $this->id_alumno = $derivacion->id_alumno;
            $this->id_prestador = $derivacion->id_prestador;
            $this->fecha_derivacion = $derivacion->fecha_derivacion->format('Y-m-d');
            $this->hora_derivacion = \Carbon\Carbon::parse($derivacion->hora_derivacion)->format('H:i');
            $this->medico_deriva = $derivacion->medico_deriva;
            $this->diagnostico_inicial = $derivacion->diagnostico_inicial;
            $this->acompanante = $derivacion->acompanante;
            $this->observaciones = $derivacion->observaciones;
            $this->impresa = $derivacion->impresa;
            $this->fecha_impresion = $derivacion->fecha_impresion;

            // Cargar alumnos del accidente para el modo edición
            if ($this->id_accidente && !$accidente_id) { // Evitar recargar si ya se hizo por el parametro de ruta
                $accidente = Accidente::with('alumnos.alumno')->find($this->id_accidente);
                $this->alumnosDelAccidente = $accidente ? $accidente->alumnos : [];
            }
        } else {
            $this->fecha_derivacion = now()->format('Y-m-d');
            $this->hora_derivacion = now()->format('H:i');
        }
    }

    public function render()
    {
        $usuario = Auth::user();
        $accidentesQuery = Accidente::with('alumnos.alumno');

        if ($usuario->id_rol == 1 && $usuario->id_escuela) {
            $accidentesQuery->where('id_escuela', $usuario->id_escuela);
        }

        $accidentes = $accidentesQuery->get();
        $prestadores = Prestador::where('activo', 1)->orderBy('nombre')->get();
        return view('livewire.derivaciones.form', compact('accidentes', 'prestadores'));
    }

    public function updatedIdAccidente($accidente_id)
    {
        if ($accidente_id) {
            $accidente = Accidente::with('alumnos.alumno')->find($accidente_id);
            $this->alumnosDelAccidente = $accidente ? $accidente->alumnos : [];
        } else {
            $this->alumnosDelAccidente = [];
        }
        // Resetear el alumno seleccionado SOLO cuando el accidente cambia desde la UI
        $this->reset('id_alumno');
    }

    public function guardar()
    {
        $this->validate();

        $data = [
            'id_accidente' => $this->id_accidente,
            'id_alumno' => $this->id_alumno,
            'id_prestador' => $this->id_prestador,
            'fecha_derivacion' => $this->fecha_derivacion,
            'hora_derivacion' => $this->hora_derivacion,
            'medico_deriva' => $this->medico_deriva,
            'diagnostico_inicial' => $this->diagnostico_inicial,
            'acompanante' => $this->acompanante,
            'observaciones' => $this->observaciones,
            'impresa' => $this->impresa,
        ];

        if ($this->modo == 'create') {
            $derivacion = Derivacion::create($data);
            AuditoriaService::registrarCreacion('derivaciones', $derivacion->id_derivacion, $data);
            
            session()->flash('message', 'Derivación creada exitosamente.');
            $this->redirigirAlListado();

        } else {
            $derivacion = Derivacion::findOrFail($this->derivacion_id);
            $datosAnteriores = $derivacion->getOriginal();
            $derivacion->update($data);
            AuditoriaService::registrarActualizacion('derivaciones', $derivacion->id_derivacion, $datosAnteriores, $data);
            
            $this->mensaje = 'Derivación actualizada exitosamente.';
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
        return redirect()->route('derivaciones.index');
    }
}
