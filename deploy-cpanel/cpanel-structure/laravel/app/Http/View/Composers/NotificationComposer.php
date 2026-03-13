<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Notificacion;

class NotificationComposer
{
    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $reintegrosPendientesCount = 0;

            if ($user->id_rol == 1 && $user->id_escuela) { // Rol Usuario General
                $estadoRequiereInfoId = \App\Models\CatEstadoReintegro::where('nombre_estado', 'Requiere Información')->first()->id_estado_reintegro ?? 2;
                
                $reintegrosPendientesCount = \App\Models\Reintegro::whereHas('accidente', function ($query) use ($user) {
                    $query->where('id_escuela', $user->id_escuela);
                })
                ->where('id_estado_reintegro', $estadoRequiereInfoId)
                ->count();
            }
            
            $view->with('reintegrosPendientesCount', $reintegrosPendientesCount);
        } else {
            $view->with('reintegrosPendientesCount', 0);
        }
    }
}