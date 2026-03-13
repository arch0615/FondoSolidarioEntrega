<?php

namespace App\Livewire\DocumentosEscuela;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\DocumentoInstitucional;
use App\Models\ArchivoAdjunto;
use App\Models\Escuela;
use App\Models\CatTipoDocumento;
use App\Services\AuditoriaService;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Form extends Component
{
    use WithFileUploads;

    public $modo = 'create';
    public $documento_id;

    // Propiedades del modelo
    public $nombre_documento;
    public $descripcion;
    public $fecha_carga;
    public $id_escuela;

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
            'nombre_documento' => 'required|string|max:200',
            'descripcion' => 'nullable|string|max:500',
            'fecha_carga' => 'nullable|date',
            'archivos_adjuntos.*' => [
                'file',
                'max:20480', // 20MB Max
                function ($attribute, $value, $fail) {
                    // Extensiones prohibidas por seguridad
                    $extensionesProhibidas = [
                        'exe', 'bat', 'cmd', 'com', 'pif', 'scr', 'vbs', 'vbe', 'js', 'jse', 
                        'jar', 'msi', 'dll', 'scf', 'lnk', 'inf', 'reg', 'ps1', 'ps2', 
                        'psc1', 'psc2', 'msh', 'msh1', 'msh2', 'mshxml', 'msh1xml', 'msh2xml',
                        'json', 'php', 'asp', 'aspx', 'jsp', 'py', 'rb', 'pl', 'sh'
                    ];
                    
                    $extension = strtolower($value->getClientOriginalExtension());
                    
                    if (in_array($extension, $extensionesProhibidas)) {
                        $fail('El tipo de archivo .' . $extension . ' no está permitido por razones de seguridad.');
                    }
                }
            ],
        ];
    }

    protected function messages()
    {
        return [
            'nombre_documento.required' => 'El nombre del documento es obligatorio.',
            'nombre_documento.max' => 'El nombre del documento no puede superar los 200 caracteres.',
            'descripcion.max' => 'La descripción no puede superar los 500 caracteres.',
            'fecha_carga.date' => 'La fecha de carga debe ser una fecha válida.',
            'archivos_adjuntos.*.max' => 'Cada archivo no puede superar los 20MB.',
        ];
    }

    public function mount($modo = 'create', $documento_id = null)
    {
        $this->modo = $modo;
        $user = Auth::user();
        $this->id_escuela = $user->id_escuela;

        if ($documento_id) {
            $this->documento_id = $documento_id;
            $documento = DocumentoInstitucional::with(['archivos'])
                ->where('id_documento', $documento_id)
                ->where('id_escuela', $user->id_escuela)
                ->firstOrFail();

            $this->nombre_documento = $documento->nombre_documento;
            $this->descripcion = $documento->descripcion;
            $this->fecha_carga = $documento->fecha_carga ? $documento->fecha_carga->format('Y-m-d') : null;

            $this->archivos_existentes = $documento->archivos ?? collect([]);
        } else {
            // Para documentos nuevos, establecer la fecha de carga como hoy
            $this->fecha_carga = now()->format('Y-m-d');
        }
    }

    public function render()
    {
        $tipos_documento = CatTipoDocumento::orderBy('nombre_tipo_documento')->get();
        $escuela = Escuela::find($this->id_escuela);
        
        return view('livewire.documentos-escuela.form', compact('tipos_documento', 'escuela'));
    }

    public function guardar()
    {
        $this->validate();

        $data = [
            'nombre_documento' => $this->nombre_documento,
            'descripcion' => $this->descripcion,
            'fecha_carga' => $this->fecha_carga,
            'id_escuela' => $this->id_escuela,
        ];

        if ($this->modo == 'create') {
            $data['id_usuario_carga'] = Auth::id();
            $documento = DocumentoInstitucional::create($data);
            $this->guardarArchivos($documento->id_documento);

            AuditoriaService::registrarCreacion('documentos_institucionales', $documento->id_documento, $data);

            // Crear notificaciones para administradores
            NotificationService::notificarRol(
                'Administrador',
                'Nuevo documento de escuela',
                'Se ha creado un nuevo documento: ' . $documento->nombre_documento,
                'documento_escuela',
                6
            );

            $this->mensaje = 'Documento creado exitosamente.';
            $this->tipoMensaje = 'success';
            $this->dispatch('mostrar-mensaje-y-redirigir');

        } else {
            $documento = DocumentoInstitucional::where('id_documento', $this->documento_id)
                ->where('id_escuela', $this->id_escuela)
                ->firstOrFail();
            
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
            $rutaArchivo = $archivo->store('documentos_institucionales', 'public');

            // Para DocumentosEscuela, guardamos el archivo directamente en el campo archivo_path
            $documento = DocumentoInstitucional::find($idEntidad);
            if ($documento) {
                // Si ya hay un archivo, eliminamos el anterior
                if ($documento->archivo_path && Storage::disk('public')->exists($documento->archivo_path)) {
                    Storage::disk('public')->delete($documento->archivo_path);
                }
                
                $documento->update(['archivo_path' => $rutaArchivo]);
            }
        }
        $this->archivos_adjuntos = [];
        $this->archivos_descripcion = '';
    }

    public function eliminarArchivoExistente()
    {
        $documento = DocumentoInstitucional::where('id_documento', $this->documento_id)
            ->where('id_escuela', $this->id_escuela)
            ->firstOrFail();
        
        if ($documento->archivo_path && Storage::disk('public')->exists($documento->archivo_path)) {
            Storage::disk('public')->delete($documento->archivo_path);
            $documento->update(['archivo_path' => null]);
            
            $this->mensaje = 'Archivo eliminado exitosamente.';
            $this->tipoMensaje = 'success';
            $this->dispatch('mostrar-mensaje');
            
            // Recargar el documento
            $this->mount($this->modo, $this->documento_id);
        }
    }

    public function limpiarMensaje()
    {
        $this->mensaje = '';
        $this->tipoMensaje = '';
    }

    public function redirigirAlListado()
    {
        return redirect()->route('documentos-escuela.index');
    }
}
