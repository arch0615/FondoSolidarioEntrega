<?php

namespace App\Livewire\Perfil;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class PerfilUsuario extends Component
{
    public $nombre;
    public $email;
    public $current_password;
    public $password;
    public $password_confirmation;

    public function mount()
    {
        $user = Auth::user();
        // Carga de datos dummy ya que no hay conexión a BD
        $this->nombre = 'Usuario de Prueba';
        $this->email = 'usuario@prueba.com';
    }

    public function render()
    {
        return view('livewire.perfil.perfil-usuario');
    }

    public function updateProfile()
    {
        // Lógica para actualizar el perfil del usuario (sin BD)
        session()->flash('message', 'Perfil actualizado correctamente.');
    }

    public function updatePassword()
    {
        // Lógica para cambiar la contraseña (sin BD)
        session()->flash('message', 'Contraseña actualizada correctamente.');
    }
}