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

    public function render()
    {
        return view('livewire.notification-bell');
    }
}