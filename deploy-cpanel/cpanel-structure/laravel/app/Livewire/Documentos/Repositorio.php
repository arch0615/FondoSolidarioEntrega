<?php

namespace App\Livewire\Documentos;

use App\Models\DocumentoInstitucional;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Repositorio extends Component
{
    use WithPagination;

    public $filtro_descripcion = '';

    protected $queryString = [
        'filtro_descripcion' => ['except' => '']
    ];

    public function updatingFiltroDescripcion()
    {
        $this->resetPage();
    }

    public function getDocumentosParaEscuelaProperty()
    {
        $query = DocumentoInstitucional::query()
            ->with(['tipoDocumento', 'usuarioCarga', 'escuelas', 'archivos'])
            ->whereHas('escuelas', function ($query) {
                $query->where('escuelas.id_escuela', Auth::user()->id_escuela);
            })
            ->when($this->filtro_descripcion, function ($query, $descripcion) {
                $query->where('descripcion', 'like', '%' . $descripcion . '%');
            })
            ->orderBy('fecha_carga', 'desc');

        return $query->paginate(12);
    }


    public function render()
    {
        return view('livewire.documentos.repositorio', [
            'documentos' => $this->getDocumentosParaEscuelaProperty()
        ]);
    }
}