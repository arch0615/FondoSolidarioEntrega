<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\AuditoriaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Mostrar el formulario de login
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Procesar el login
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico debe tener un formato válido.',
            'password.required' => 'La contraseña es obligatoria.',
        ]);

        // Buscar usuario por email
        $user = User::where('email', $request->email)->first();

        // Verificar que el usuario existe y la contraseña es correcta
        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Las credenciales proporcionadas no coinciden con nuestros registros.'],
            ]);
        }

        // Verificar si el usuario está activo
        if (!$user->isActive()) {
            throw ValidationException::withMessages([
                'email' => ['Tu cuenta está inactiva. Contacta al administrador.'],
            ]);
        }

        // Verificar si el email está verificado (opcional, puedes comentar esta sección si no es necesario)
        // if (!$user->hasVerifiedEmail()) {
        //     throw ValidationException::withMessages([
        //         'email' => ['Su correo electrónico aún no ha sido verificado.'],
        //     ]);
        // }

        // Iniciar sesión
        Auth::login($user, $request->boolean('remember'));

        $request->session()->regenerate();

        // Registrar en auditoría
        AuditoriaService::registrarLogin($user);

        return redirect()->intended(route('dashboard'));
    }

    /**
     * Cerrar sesión
     */
    public function logout(Request $request)
    {
        $user = Auth::user();
        
        // Registrar en auditoría antes de cerrar sesión
        if ($user) {
            AuditoriaService::registrarLogout($user);
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    /**
     * Mostrar formulario de recuperación de contraseña
     */
    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    /**
     * Procesar solicitud de recuperación de contraseña
     */
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ], [
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico debe tener un formato válido.',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            // Por seguridad, siempre mostrar el mismo mensaje
            return back()->with('status', 'Si el correo existe en nuestro sistema, recibirá un enlace de recuperación.');
        }

        // Aquí iría la lógica para enviar el email de recuperación
        // Por ahora solo simulamos el éxito
        
        return back()->with('status', 'Si el correo existe en nuestro sistema, recibirá un enlace de recuperación.');
    }
}