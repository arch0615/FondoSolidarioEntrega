<?php

namespace App\Livewire\Perfil;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Escuela;
use App\Models\User;

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
        $user = User::find(Auth::id());
        $this->escuela = $user->escuela;
        $this->nombre = $this->escuela->nombre;
        $this->direccion = $this->escuela->direccion;
        $this->telefono = $this->escuela->telefono;
        $this->email = $user->email;
    }

    public function render()
    {
        return view('livewire.perfil.perfil-escuela');
    }

    public function updateProfile()
    {
        $user = User::find(Auth::id());

        $this->validate([
            'nombre' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'email' => 'required|email|max:255|unique:usuarios,email,' . $user->id_usuario . ',id_usuario',
        ]);

        $this->escuela->nombre = $this->nombre;
        $this->escuela->direccion = $this->direccion;
        $this->escuela->telefono = $this->telefono;
        $this->escuela->save();

        $user->email = $this->email;
        $user->save();

        session()->flash('message', 'Perfil de la escuela actualizado exitosamente.');
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