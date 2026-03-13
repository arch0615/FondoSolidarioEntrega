<?php

namespace App\Livewire\Perfil;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class PerfilUsuario extends Component
{
    public $nombre;
    public $email;
    public $current_password;
    public $password;
    public $password_confirmation;

    public function mount()
    {
        $user = User::find(Auth::id());
        $this->nombre = $user->nombre;
        $this->email = $user->email;
    }

    public function render()
    {
        return view('livewire.perfil.perfil-usuario');
    }

    public function updateProfile()
    {
        $user = User::find(Auth::id());

        $this->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:usuarios,email,' . $user->id_usuario . ',id_usuario',
        ]);

        $user->nombre = $this->nombre;
        $user->email = $this->email;
        $user->save();

        session()->flash('message', 'Perfil actualizado exitosamente.');
    }

    public function updatePassword()
    {
        $user = User::find(Auth::id());

        $this->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|min:8|confirmed',
        ]);

        $user->password = Hash::make($this->password);
        $user->save();

        $this->current_password = '';
        $this->password = '';
        $this->password_confirmation = '';

        session()->flash('message', 'Contraseña actualizada exitosamente.');
    }
}