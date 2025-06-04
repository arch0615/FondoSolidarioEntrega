<?php

namespace App\Livewire\Dashboards;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class AdminDashboard extends Component
{
    public $stats = [];
    public $recentActivity = [];
    public $escuelasStats = [];
    
    public function mount()
    {
        $this->loadStats();
        $this->loadRecentActivity();
        $this->loadEscuelasStats();
    }
    
    private function loadStats()
    {
        // TODO: Obtener datos reales de todas las escuelas del sistema
        $this->stats = [
            'total_escuelas' => [
                'total' => 25,
                'incremento' => '↑ 2 este año',
                'color' => 'blue'
            ],
            'total_accidentes' => [
                'total' => 340,
                'incremento' => '↑ 45 este mes',
                'color' => 'red'
            ],
            'reintegros_autorizados' => [
                'total' => 28,
                'incremento' => '↑ 8 esta semana',
                'color' => 'green'
            ],
            'monto_total_pagado' => [
                'total' => '$125,400',
                'incremento' => '↑ $15,200 este mes',
                'color' => 'purple'
            ]
        ];
    }
    
    private function loadRecentActivity()
    {
        // TODO: Obtener actividad reciente de todo el sistema
        $this->recentActivity = [
            [
                'tipo' => 'escuela_nueva',
                'titulo' => 'Nueva escuela registrada',
                'descripcion' => 'Colegio San José - Zona Norte',
                'tiempo' => 'Hace 1 hora',
                'icono' => 'fas fa-school',
                'color' => 'blue'
            ],
            [
                'tipo' => 'pago_procesado',
                'titulo' => 'Reintegro pagado',
                'descripcion' => 'Escuela Santa María - $2,500',
                'tiempo' => 'Hace 3 horas',
                'icono' => 'fas fa-money-bill-wave',
                'color' => 'green'
            ],
            [
                'tipo' => 'usuario_creado',
                'titulo' => 'Nuevo usuario creado',
                'descripcion' => 'Ana García - Instituto San Pedro',
                'tiempo' => 'Hace 5 horas',
                'icono' => 'fas fa-user-plus',
                'color' => 'indigo'
            ],
            [
                'tipo' => 'prestador_actualizado',
                'titulo' => 'Prestador actualizado',
                'descripcion' => 'Clínica Norte - Nuevos servicios',
                'tiempo' => 'Ayer',
                'icono' => 'fas fa-hospital',
                'color' => 'gray'
            ]
        ];
    }
    
    private function loadEscuelasStats()
    {
        // TODO: Obtener estadísticas por escuela
        $this->escuelasStats = [
            [
                'nombre' => 'Colegio San José',
                'accidentes' => 15,
                'reintegros' => 8,
                'monto_pendiente' => '$3,200'
            ],
            [
                'nombre' => 'Instituto Santa María',
                'accidentes' => 12,
                'reintegros' => 5,
                'monto_pendiente' => '$1,800'
            ],
            [
                'nombre' => 'Escuela San Pedro',
                'accidentes' => 8,
                'reintegros' => 3,
                'monto_pendiente' => '$900'
            ]
        ];
    }
    
    public function render()
    {
        return view('livewire.dashboards.admin-dashboard');
    }
}