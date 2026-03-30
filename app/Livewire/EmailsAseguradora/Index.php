<?php

namespace App\Livewire\EmailsAseguradora;

use App\Models\EmailAseguradora;
use App\Services\AuditoriaService;
use Livewire\Component;

class Index extends Component
{
    public $email = '';
    public $descripcion = '';
    public $editingId = null;
    public $editEmail = '';
    public $editDescripcion = '';
    public $showDeleteModal = false;
    public $deletingId = null;

    protected function rules()
    {
        return [
            'email' => 'required|email|max:255|unique:emails_aseguradora,email',
            'descripcion' => 'nullable|string|max:255',
        ];
    }

    protected function messages()
    {
        return [
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Ingrese un correo electrónico válido.',
            'email.unique' => 'Este correo ya está registrado.',
            'editEmail.required' => 'El correo electrónico es obligatorio.',
            'editEmail.email' => 'Ingrese un correo electrónico válido.',
        ];
    }

    public function agregar()
    {
        $this->validate();

        $emailAseguradora = EmailAseguradora::create([
            'email' => $this->email,
            'descripcion' => $this->descripcion,
            'activo' => true,
        ]);

        AuditoriaService::registrarAccionPersonalizada('CREAR_EMAIL_ASEGURADORA', 'emails_aseguradora', $emailAseguradora->id_email_aseguradora, [
            'email' => $this->email,
            'descripcion' => $this->descripcion,
        ]);

        $this->reset(['email', 'descripcion']);
        session()->flash('message', 'Correo de aseguradora agregado exitosamente.');
    }

    public function editar($id)
    {
        $emailAseguradora = EmailAseguradora::findOrFail($id);
        $this->editingId = $id;
        $this->editEmail = $emailAseguradora->email;
        $this->editDescripcion = $emailAseguradora->descripcion;
    }

    public function actualizar()
    {
        $this->validate([
            'editEmail' => 'required|email|max:255|unique:emails_aseguradora,email,' . $this->editingId . ',id_email_aseguradora',
            'editDescripcion' => 'nullable|string|max:255',
        ]);

        $emailAseguradora = EmailAseguradora::findOrFail($this->editingId);
        $anterior = ['email' => $emailAseguradora->email, 'descripcion' => $emailAseguradora->descripcion];

        $emailAseguradora->update([
            'email' => $this->editEmail,
            'descripcion' => $this->editDescripcion,
        ]);

        AuditoriaService::registrarActualizacion('emails_aseguradora', $this->editingId, $anterior, [
            'email' => $this->editEmail,
            'descripcion' => $this->editDescripcion,
        ]);

        $this->cancelarEdicion();
        session()->flash('message', 'Correo de aseguradora actualizado exitosamente.');
    }

    public function cancelarEdicion()
    {
        $this->reset(['editingId', 'editEmail', 'editDescripcion']);
    }

    public function toggleActivo($id)
    {
        $emailAseguradora = EmailAseguradora::findOrFail($id);
        $emailAseguradora->activo = !$emailAseguradora->activo;
        $emailAseguradora->save();

        $estado = $emailAseguradora->activo ? 'activado' : 'desactivado';
        session()->flash('message', "Correo {$estado} exitosamente.");
    }

    public function confirmarEliminar($id)
    {
        $this->deletingId = $id;
        $this->showDeleteModal = true;
    }

    public function eliminar()
    {
        $emailAseguradora = EmailAseguradora::findOrFail($this->deletingId);

        AuditoriaService::registrarAccionPersonalizada('ELIMINAR_EMAIL_ASEGURADORA', 'emails_aseguradora', $this->deletingId, [
            'email' => $emailAseguradora->email,
            'descripcion' => $emailAseguradora->descripcion,
        ]);

        $emailAseguradora->delete();

        $this->showDeleteModal = false;
        $this->deletingId = null;
        session()->flash('message', 'Correo de aseguradora eliminado exitosamente.');
    }

    public function render()
    {
        $emails = EmailAseguradora::orderBy('activo', 'desc')->orderBy('email')->get();

        return view('livewire.emails-aseguradora.index', [
            'emails' => $emails,
        ]);
    }
}
