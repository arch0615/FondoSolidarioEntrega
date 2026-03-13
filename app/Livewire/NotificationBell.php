<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Notificacion;

class NotificationBell extends Component
{
    public $unreadNotificationsCount = 0;
    public $notifications = [];

    public function mount()
    {
        if (Auth::check()) {
            $this->unreadNotificationsCount = Notificacion::where('id_usuario_destino', Auth::id())
                                                        ->where('leida', false)
                                                        ->count();
        }
    }

    public function loadNotifications()
    {
        if (Auth::check()) {
            $this->notifications = Notificacion::where('id_usuario_destino', Auth::id())
                                               ->orderBy('fecha_creacion', 'desc')
                                               ->take(10)
                                               ->get();
        }
    }

    public function markAsRead()
    {
        if (Auth::check()) {
            Notificacion::where('id_usuario_destino', Auth::id())
                        ->where('leida', false)
                        ->update(['leida' => true, 'fecha_lectura' => now()]);
            
            $this->unreadNotificationsCount = 0;
        }
    }

    public function redirectToNotification($notificationId)
    {
        $notification = Notificacion::findOrFail($notificationId);

        // Marcar como leída si no lo está
        if (!$notification->leida) {
            $notification->update(['leida' => true, 'fecha_lectura' => now()]);
            $this->unreadNotificationsCount = max(0, $this->unreadNotificationsCount - 1);
        }

        // Redirigir según el tipo de entidad
        if ($notification->tipo_entidad === 'reintegro') {
            // Verificar el rol del usuario actual
            $user = Auth::user();

            // Si el rol es usuario general (escuela), redirigir a reintegros
            if ($user && $user->id_rol == 1) {
                return redirect()->route('reintegros.index');
            }

            // Para otros roles (admin, médico auditor), redirigir a reintegros/pendientes
            return redirect()->route('reintegros.pendientes');
        }

        // Redirigir a documentos-escuela si es id_entidad_referencia=6
        if ($notification->id_entidad_referencia == 6) {
            return redirect()->route('documentos-escuela.index');
        }

        // Para otros tipos de entidades, redirigir al dashboard por defecto
        return redirect()->route('dashboard');
    }

    public function render()
    {
        return view('livewire.notification-bell');
    }
}