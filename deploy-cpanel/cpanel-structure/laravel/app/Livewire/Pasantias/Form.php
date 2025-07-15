<?php

namespace App\Livewire\Pasantias;

use Livewire\Component;
use App\Models\Pasantia;
use App\Models\Escuela;
use App\Models\Alumno;
use App\Services\AuditoriaService;
use Illuminate\Support\Facades\Auth;

class Form extends Component
{
    public $modo = 'create';
    public $pasantia_id;

    // 🔥 PROPIEDADES: Una por cada campo del formulario
    public $id_escuela;
    public $id_alumno;
    public $empresa;
    public $direccion_empresa;
    public $tutor_empresa;
    public $fecha_inicio;
    public $fecha_fin;
    public $horario;
    public $descripcion_tareas;

    // 🔥 MENSAJES DE RETROALIMENTACIÓN
    public $mensaje = '';
    public $tipoMensaje = '';

    // 🔥 CONTROL DE ROLES
    public $esUsuarioGeneral = false;

    // 🔥 VALIDACIONES
    protected function rules()
    {
        return [
            'id_escuela' => 'required|exists:escuelas,id_escuela',
            'id_alumno' => 'required|exists:alumnos,id_alumno',
            'empresa' => 'required|string|max:200',
            'direccion_empresa' => 'nullable|string|max:300',
            'tutor_empresa' => 'nullable|string|max:200',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'horario' => 'nullable|string|max:100',
            'descripcion_tareas' => 'nullable|string',
        ];
    }

    // 🔥 MENSAJES EN ESPAÑOL
    protected function messages()
    {
        return [
            'id_escuela.required' => 'La escuela es obligatoria.',
            'id_escuela.exists' => 'La escuela seleccionada no es válida.',
            'id_alumno.required' => 'El alumno es obligatorio.',
            'id_alumno.exists' => 'El alumno seleccionado no es válido.',
            'empresa.required' => 'El nombre de la empresa es obligatorio.',
            'empresa.max' => 'El nombre de la empresa no puede tener más de 200 caracteres.',
            'direccion_empresa.max' => 'La dirección no puede tener más de 300 caracteres.',
            'tutor_empresa.max' => 'El nombre del tutor no puede tener más de 200 caracteres.',
            'fecha_inicio.required' => 'La fecha de inicio es obligatoria.',
            'fecha_inicio.date' => 'La fecha de inicio debe ser una fecha válida.',
            'fecha_fin.date' => 'La fecha de fin debe ser una fecha válida.',
            'fecha_fin.after_or_equal' => 'La fecha de fin debe ser posterior o igual a la fecha de inicio.',
            'horario.max' => 'El horario no puede tener más de 100 caracteres.',
        ];
    }

    // 🔥 MOUNT: Cargar datos en modo edición
    public function mount($modo = 'create', $pasantia_id = null)
    {
        $this->modo = $modo;
        $user = Auth::user();
        $this->esUsuarioGeneral = ($user->id_rol == 1);

        // 🔥 TAREA 2: Asignar automáticamente la escuela para usuario general
        if ($this->esUsuarioGeneral) {
            $this->id_escuela = $user->id_escuela;
        }

        if ($pasantia_id) {
            $this->pasantia_id = $pasantia_id;
            // 🔥 Asegurarse que el usuario general solo edite pasantías de su escuela
            if ($this->esUsuarioGeneral) {
                $pasantia = Pasantia::where('id_pasantia', $pasantia_id)->where('id_escuela', $user->id_escuela)->firstOrFail();
            } else {
                $pasantia = Pasantia::with(['escuela', 'alumno'])->findOrFail($pasantia_id);
            }
            
            $this->id_escuela = $pasantia->id_escuela;
            $this->id_alumno = $pasantia->id_alumno;
            $this->empresa = $pasantia->empresa;
            $this->direccion_empresa = $pasantia->direccion_empresa;
            $this->tutor_empresa = $pasantia->tutor_empresa;
            $this->fecha_inicio = $pasantia->fecha_inicio ? $pasantia->fecha_inicio->format('Y-m-d') : '';
            $this->fecha_fin = $pasantia->fecha_fin ? $pasantia->fecha_fin->format('Y-m-d') : '';
            $this->horario = $pasantia->horario;
            $this->descripcion_tareas = $pasantia->descripcion_tareas;
        }
    }

    // 🔥 RENDER
    public function render()
    {
        $escuelas = Escuela::orderBy('nombre')->get();
        $alumnos = collect();
        
        // Cargar alumnos si hay una escuela seleccionada
        if ($this->id_escuela) {
            $alumnos = Alumno::where('id_escuela', $this->id_escuela)
                           ->orderBy('apellido')
                           ->orderBy('nombre')
                           ->get();
        }
        
        return view('livewire.pasantias.form', compact('escuelas', 'alumnos'));
    }

    // 🔥 GUARDAR: Crear o actualizar
    public function guardar()
    {
        $this->validate();

        $data = [
            'id_escuela' => $this->id_escuela,
            'id_alumno' => $this->id_alumno,
            'empresa' => $this->empresa,
            'direccion_empresa' => $this->direccion_empresa,
            'tutor_empresa' => $this->tutor_empresa,
            'fecha_inicio' => $this->fecha_inicio,
            'fecha_fin' => $this->fecha_fin,
            'horario' => $this->horario,
            'descripcion_tareas' => $this->descripcion_tareas,
            'id_usuario_carga' => Auth::id(),
            'fecha_carga' => now(),
        ];

        if ($this->modo == 'create') {
            $pasantia = Pasantia::create($data);
            AuditoriaService::registrarCreacion('pasantias', $pasantia->id_pasantia, $data);
            
            $this->mensaje = 'Pasantía creada exitosamente.';
            $this->tipoMensaje = 'success';
            $this->dispatch('mostrar-mensaje-y-redirigir');

        } else {
            $pasantia = Pasantia::findOrFail($this->pasantia_id);
            $datosAnteriores = $pasantia->getOriginal();
            $pasantia->update($data);
            AuditoriaService::registrarActualizacion('pasantias', $pasantia->id_pasantia, $datosAnteriores, $data);
            
            $this->mensaje = 'Pasantía actualizada exitosamente.';
            $this->tipoMensaje = 'success';
            $this->dispatch('mostrar-mensaje');
        }
    }

    // 🔥 MÉTODO PARA CARGAR ALUMNOS CUANDO CAMBIA LA ESCUELA
    public function updatedIdEscuela()
    {
        $this->id_alumno = null; // Resetear alumno seleccionado
    }

    // 🔥 MÉTODOS AUXILIARES
    public function limpiarMensaje()
    {
        $this->mensaje = '';
        $this->tipoMensaje = '';
    }

    public function redirigirAlListado()
    {
        return redirect()->route('pasantias.index');
    }
}