<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Reintegro;

class ReintegroPendienteComposer
{
    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $reintegrosPendientesCount = 0;
        $user = Auth::user();

        if ($user && $user->id_rol == 1 && $user->id_escuela) {
            $reintegrosPendientesCount = Reintegro::where('id_estado_reintegro', 2) // 2 = Requiere Información
                ->whereHas('accidente', function ($query) use ($user) {
                    $query->where('id_escuela', $user->id_escuela);
                })
                ->count();
        }

        $view->with('reintegrosPendientesCount', $reintegrosPendientesCount);
    }
}