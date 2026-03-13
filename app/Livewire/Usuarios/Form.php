<?php

namespace App\Livewire\Usuarios;

use Livewire\Component;
use App\Models\User;
use App\Models\Role;
use App\Models\Escuela;
use App\Services\AuditoriaService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class Form extends Component
{
    public $modo = 'create';
    public $usuario_id;

    // Propiedades del modelo
    public $nombre;
    public $apellido;
    public $email;
    public $password;
    public $password_confirmation;
    public $id_rol;
    public $id_escuela;
    public $activo = true;
    public $email_verificado = false;

    // Mensajes de retroalimentación
    public $mensaje = '';
    public $tipoMensaje = '';

    protected function rules()
    {
        $rules = [
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:usuarios,email,' . $this->usuario_id . ',id_usuario',
            'id_rol' => 'required|integer|exists:roles,id_rol',
            'id_escuela' => 'nullable|integer|exists:escuelas,id_escuela',
            'activo' => 'boolean',
        ];

        // Solo validar contraseña si es creación o si se está cambiando
        if ($this->modo == 'create') {
            $rules['password'] = 'required|string|min:8|confirmed';
        } elseif (!empty($this->password)) {
            $rules['password'] = 'string|min:8|confirmed';
        }

        return $rules;
    }

    protected function messages()
    {
        return [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.max' => 'El nombre no puede tener más de 100 caracteres.',
            'apellido.required' => 'El apellido es obligatorio.',
            'apellido.max' => 'El apellido no puede tener más de 100 caracteres.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico debe tener un formato válido.',
            'email.max' => 'El correo electrónico no puede tener más de 100 caracteres.',
            'email.unique' => 'Este correo electrónico ya está registrado.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'La confirmación de contraseña no coincide.',
            'id_rol.required' => 'El rol es obligatorio.',
            'id_rol.exists' => 'El rol seleccionado no es válido.',
            'id_escuela.exists' => 'La escuela seleccionada no es válida.',
        ];
    }

    public function mount($modo = 'create', $usuario_id = null)
    {
        $this->modo = $modo;

        // Obtener el usuario actual
        $userActual = Auth::user();
        $esUsuarioGeneral = $userActual && $userActual->id_rol == 1;

        if ($usuario_id) {
            $this->usuario_id = $usuario_id;
            $usuario = User::findOrFail($usuario_id);
            $this->nombre = $usuario->nombre;
            $this->apellido = $usuario->apellido;
            $this->email = $usuario->email;
            $this->id_rol = $usuario->id_rol;
            $this->id_escuela = $usuario->id_escuela;
            $this->activo = $usuario->activo;
            $this->email_verificado = $usuario->email_verificado;
        } else {
            // Para creación de nuevos usuarios
            if ($esUsuarioGeneral) {
                // Si el usuario actual es usuario_general, forzar rol y escuela
                $this->id_rol = 1; // Usuario General
                $this->id_escuela = $userActual->id_escuela;
            }
        }
    }

    public function render()
    {
        $roles = Role::where('activo', true)->get();
        $escuelas = Escuela::where('activo', true)->get();

        // Determinar si el usuario actual es usuario_general
        $user = Auth::user();
        $esUsuarioGeneral = $user && $user->id_rol == 1;

        return view('livewire.usuarios.form', [
            'roles' => $roles,
            'escuelas' => $escuelas,
            'esUsuarioGeneral' => $esUsuarioGeneral,
        ]);
    }

    public function guardar()
    {
        $this->validate();

        // Obtener el usuario actual
        $userActual = Auth::user();
        $esUsuarioGeneral = $userActual && $userActual->id_rol == 1;

        $data = [
            'nombre' => $this->nombre,
            'apellido' => $this->apellido,
            'email' => $this->email,
            'id_rol' => $this->id_rol,
            'activo' => $this->activo,
        ];

        // Para usuarios generales, forzar rol y escuela
        if ($esUsuarioGeneral) {
            $data['id_rol'] = 1; // Usuario General
            $data['id_escuela'] = $userActual->id_escuela;
        } else {
            $data['id_escuela'] = $this->id_rol == 1 ? $this->id_escuela : null;
        }

        if ($this->password) {
            $data['password'] = Hash::make($this->password);
        }

        if ($this->modo == 'create') {
            $usuario = User::create($data);
            AuditoriaService::registrarCreacion('usuarios', $usuario->id_usuario, $data);

            // Mostrar modal de confirmación antes de redirigir
            $this->mensaje = 'Usuario creado exitosamente.';
            $this->tipoMensaje = 'success';
            $this->dispatch('mostrar-mensaje-y-redirigir');
        } else {
            $usuario = User::findOrFail($this->usuario_id);
            $datosAnteriores = $usuario->getOriginal();
            $usuario->update($data);
            AuditoriaService::registrarActualizacion('usuarios', $usuario->id_usuario, $datosAnteriores, $data);

            // Para modo edición, mostrar mensaje sin redireccionar
            $this->mensaje = 'Usuario actualizado exitosamente.';
            $this->tipoMensaje = 'success';

            // Limpiar el mensaje después de 5 segundos
            $this->dispatch('mostrar-mensaje');
        }
    }

    public function limpiarMensaje()
    {
        $this->mensaje = '';
        $this->tipoMensaje = '';
    }

    public function redirigirAlListado()
    {
        return redirect()->route('usuarios.index');
    }
}