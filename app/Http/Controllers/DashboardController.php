<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Mostrar el dashboard según el rol del usuario
     */
    public function index()
    {
        $user = Auth::user();
        
        // Redireccionar según el rol del usuario
        switch ($user->rol) {
            case 'admin':
                return view('dashboards.admin');
                
            case 'medico_auditor':
                return view('dashboards.medico');
                
            case 'usuario_general':
            default:
                return view('dashboards.escuela');
        }
    }
}