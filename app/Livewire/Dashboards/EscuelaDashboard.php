<?php

namespace App\Livewire\Dashboards;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class EscuelaDashboard extends Component
{
    public $stats = [];
    public $recentActivity = [];
    
    public function mount()
    {
        $this->loadStats();
        $this->loadRecentActivity();
    }
    
    private function loadStats()
    {
        $user = Auth::user();
        
        // TODO: Obtener datos reales de la base de datos según la escuela del usuario
        $this->stats = [
            'accidentes_reportados' => [
                'total' => 12,
                'incremento' => '↑ 2 este mes',
                'color' => 'red'
            ],
            'alumnos_registrados' => [
                'total' => 450,
                'incremento' => '↑ 15 este mes',
                'color' => 'primary'
            ],
            'reintegros_pendientes' => [
                'total' => 3,
                'incremento' => 'En proceso',
                'color' => 'amber'
            ],
            'documentos_subidos' => [
                'total' => 28,
                'incremento' => '↑ 8 esta semana',
                'color' => 'primary'
            ]
        ];
    }
    
    private function loadRecentActivity()
    {
        // TODO: Obtener actividad reciente real de la base de datos
        $this->recentActivity = [
            [
                'tipo' => 'accidente',
                'titulo' => 'Accidente reportado',
                'descripcion' => 'Juan Pérez - 5to A',
                'tiempo' => 'Hace 2 horas',
                'icono' => 'fas fa-shield-alt',
                'color' => 'red'
            ],
            [
                'tipo' => 'reintegro',
                'titulo' => 'Reintegro autorizado',
                'descripcion' => 'Farmacia Central - $1,200',
                'tiempo' => 'Hace 4 horas',
                'icono' => 'fas fa-check-circle',
                'color' => 'primary'
            ],
            [
                'tipo' => 'derivacion',
                'titulo' => 'Derivación generada',
                'descripcion' => 'María González - Clínica Norte',
                'tiempo' => 'Ayer',
                'icono' => 'fas fa-file-medical',
                'color' => 'primary'
            ]
        ];
    }
    
    public function render()
    {
        return view('livewire.dashboards.escuela-dashboard');
    }
}