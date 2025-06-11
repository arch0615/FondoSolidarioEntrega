<?php

namespace App\Livewire\Reintegros;

use Livewire\Component;
use Livewire\WithFileUploads;

class Form extends Component
{
    use WithFileUploads;

    public $modo = 'create'; // 'create', 'edit', 'show'
    public $reintegro_id;

    // Campos del formulario basados en diccionario-datos-fondo-solidario.md
    public $id_accidente;
    public $id_usuario_solicita;
    public $fecha_solicitud;
    public $tipo_gasto;
    public $descripcion_gasto;
    public $monto_solicitado;
    public $estado = 'En Proceso';
    public $requiere_mas_info;
    public $id_medico_auditor;
    public $fecha_auditoria;
    public $observaciones_auditor;
    public $monto_autorizado;
    public $fecha_autorizacion;
    public $fecha_pago;
    public $numero_transferencia;

    // Para la subida de archivos
    public $archivos = [];
    public $archivos_existentes = [];

    protected $rules = [
        'id_accidente' => 'required|integer',
        'fecha_solicitud' => 'required|date',
        'tipo_gasto' => 'required|string|max:50',
        'descripcion_gasto' => 'required|string|max:500',
        'monto_solicitado' => 'required|numeric|min:0',
        'archivos.*' => 'nullable|file|max:10240', // 10MB max
    ];

    public function mount($modo = 'create', $reintegro_id = null)
    {
        $this->modo = $modo;
        $this->reintegro_id = $reintegro_id;
        $this->fecha_solicitud = now()->format('Y-m-d');

        if ($this->reintegro_id) {
            // NOTE: Lógica para cargar datos de un reintegro existente.
            // Se omite en este paso y se usarán datos de mockup en la vista.
            // Ejemplo:
            // $reintegro = Reintegro::findOrFail($this->reintegro_id);
            // $this->id_accidente = $reintegro->id_accidente;
            // ...etc.
        } else {
            $this->archivos = [];
            $this->archivos_existentes = [];
        }
    }

    public function save()
    {
        $this->validate();

        // NOTE: Lógica para guardar el reintegro y los archivos.
        // Se omite en este paso.
        
        // Ejemplo de manejo de archivos:
        // foreach ($this->archivos as $archivo) {
        //     $archivo->store('reintegros');
        // }

        session()->flash('message', 'Reintegro guardado exitosamente.');
        return redirect()->route('reintegros.index');
    }

    public function render()
    {
        return view('livewire.reintegros.form');
    }
}