<?php

namespace App\Livewire\Documentos;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\DocumentoInstitucional;
use App\Models\ArchivoAdjunto;
use App\Models\Escuela;
use App\Models\CatTipoDocumento;
use App\Services\AuditoriaService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Form extends Component
{
    use WithFileUploads;

    public $modo = 'create';
    public $documento_id;

    // Propiedades del modelo
    public $id_escuela;
    public $nombre_documento;
    public $descripcion;
    public $fecha_documento;
    public $fecha_vencimiento;
    public $id_tipo_documento;

    // Propiedades para archivos
    public $archivos_descripcion = '';
    public $archivos_adjuntos = [];
    public $archivos_existentes = [];

    // Mensajes
    public $mensaje = '';
    public $tipoMensaje = '';

    protected function rules()
    {
        return [
            'id_escuela' => 'required|integer|exists:escuelas,id_escuela',
            'nombre_documento' => 'required|string|max:200',
            'descripcion' => 'nullable|string|max:500',
            'fecha_documento' => 'nullable|date',
            'fecha_vencimiento' => 'nullable|date|after_or_equal:fecha_documento',
            'id_tipo_documento' => 'nullable|integer|exists:cat_tipos_documentos,id_tipo_documento',
            'archivos_adjuntos.*' => 'file|max:10240|mimes:pdf,jpg,jpeg,png', // 10MB Max
        ];
    }

    protected function messages()
    {
        return [
            'id_escuela.required' => 'La escuela es obligatoria.',
            'nombre_documento.required' => 'El nombre del documento es obligatorio.',
            'fecha_vencimiento.after_or_equal' => 'La fecha de vencimiento debe ser posterior o igual a la fecha del documento.',
            'archivos_adjuntos.*.max' => 'Cada archivo no puede superar los 10MB.',
            'archivos_adjuntos.*.mimes' => 'Solo se permiten archivos de tipo PDF, JPG, JPEG, PNG.',
        ];
    }

    public function mount($modo = 'create', $documento_id = null)
    {
        $this->modo = $modo;
        $user = auth()->user();

        if ($documento_id) {
            $this->documento_id = $documento_id;
            $documento = DocumentoInstitucional::with('archivos')->findOrFail($documento_id);
            
            $this->id_escuela = $documento->id_escuela;
            $this->nombre_documento = $documento->nombre_documento;
            $this->descripcion = $documento->descripcion;
            $this->fecha_documento = $documento->fecha_documento ? $documento->fecha_documento->format('Y-m-d') : null;
            $this->fecha_vencimiento = $documento->fecha_vencimiento ? $documento->fecha_vencimiento->format('Y-m-d') : null;
            $this->id_tipo_documento = $documento->id_tipo_documento;
            
            $this->archivos_existentes = $documento->archivos;
        } elseif ($modo === 'create' && $user->id_rol == 1) {
            $this->id_escuela = $user->id_escuela;
        }
    }

    public function render()
    {
        $escuelas = Escuela::where('activo', 1)->orderBy('nombre')->get();
        $tipos_documento = CatTipoDocumento::orderBy('nombre_tipo_documento')->get();
        return view('livewire.documentos.form', compact('escuelas', 'tipos_documento'));
    }

    public function guardar()
    {
        $this->validate();

        $data = [
            'id_escuela' => $this->id_escuela,
            'nombre_documento' => $this->nombre_documento,
            'descripcion' => $this->descripcion,
            'fecha_documento' => $this->fecha_documento,
            'fecha_vencimiento' => $this->fecha_vencimiento,
            'id_tipo_documento' => null, // Enviamos null por el momento
            'id_usuario_carga' => Auth::id(),
            'fecha_carga' => now(),
        ];

        if ($this->modo == 'create') {
            $documento = DocumentoInstitucional::create($data);
            $this->guardarArchivos($documento->id_documento);
            
            AuditoriaService::registrarCreacion('documentos_institucionales', $documento->id_documento, $data);
            
            $this->mensaje = 'Documento creado exitosamente.';
            $this->tipoMensaje = 'success';
            $this->dispatch('mostrar-mensaje-y-redirigir');

        } else {
            $documento = DocumentoInstitucional::findOrFail($this->documento_id);
            $datosAnteriores = $documento->getOriginal();
            $documento->update($data);
            
            $this->guardarArchivos($documento->id_documento);
            
            AuditoriaService::registrarActualizacion('documentos_institucionales', $documento->id_documento, $datosAnteriores, $data);
            
            $this->mensaje = 'Documento actualizado exitosamente.';
            $this->tipoMensaje = 'success';
            $this->dispatch('mostrar-mensaje');
        }
    }

    public function guardarArchivos($idEntidad)
    {
        foreach ($this->archivos_adjuntos as $archivo) {
            $rutaArchivo = $archivo->store('archivos_documentos', 'public');

            ArchivoAdjunto::create([
                'tipo_entidad' => 'documento_institucional',
                'id_entidad' => $idEntidad,
                'nombre_archivo' => $archivo->getClientOriginalName(),
                'tipo_archivo' => $archivo->getClientOriginalExtension(),
                'tamano' => $archivo->getSize(),
                'ruta_archivo' => $rutaArchivo,
                'descripcion' => $this->archivos_descripcion,
                'id_usuario_carga' => Auth::id(),
                'fecha_carga' => now(),
            ]);
        }
        $this->archivos_adjuntos = [];
        $this->archivos_descripcion = '';
    }

    public function eliminarArchivoExistente($idArchivo)
    {
        $archivo = ArchivoAdjunto::findOrFail($idArchivo);
        $datosArchivo = $archivo->toArray();
        
        $archivo->eliminarArchivo();
        $archivo->delete();
        
        $this->archivos_existentes = collect($this->archivos_existentes)->where('id_archivo', '!=', $idArchivo)->values();
        
        AuditoriaService::registrarEliminacion('archivos_adjuntos', $idArchivo, $datosArchivo);
        
        $this->mensaje = 'Archivo eliminado exitosamente.';
        $this->tipoMensaje = 'success';
        $this->dispatch('mostrar-mensaje');
    }

    public function limpiarMensaje()
    {
        $this->mensaje = '';
        $this->tipoMensaje = '';
    }

    public function redirigirAlListado()
    {
        return redirect()->route('documentos.index');
    }
}
