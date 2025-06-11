<?php

namespace App\Livewire\Perfil;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class PerfilEscuela extends Component
{
    public $escuela;
    public $nombre;
    public $direccion;
    public $telefono;
    public $email;

    public $current_password;
    public $password;
    public $password_confirmation;

    public function mount()
    {
        $user = Auth::user();
        // Carga de datos dummy ya que no hay conexión a BD
        $this->escuela = [
            'nombre' => 'Escuela de Prueba',
            'direccion' => 'Calle Falsa 123',
            'telefono' => '555-1234',
            'email' => 'escuela@prueba.com',
        ];

        $this->nombre = $this->escuela['nombre'];
        $this->direccion = $this->escuela['direccion'];
        $this->telefono = $this->escuela['telefono'];
        $this->email = $this->escuela['email'];
    }

    public function render()
    {
        return view('livewire.perfil.perfil-escuela');
    }

    public function updateProfile()
    {
        // Lógica para actualizar el perfil de la escuela (sin BD)
        session()->flash('message', 'Perfil de la escuela actualizado correctamente.');
    }

    public function updatePassword()
    {
        // Lógica para cambiar la contraseña (sin BD)
        session()->flash('message', 'Contraseña actualizada correctamente.');
    }
}