<?php

namespace App\Livewire\Dashboards;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class MedicoDashboard extends Component
{
    public $stats = [];
    public $recentActivity = [];
    public $reintegrosPendientes = [];
    public $urgentes = [];
    
    public function mount()
    {
        $this->loadStats();
        $this->loadRecentActivity();
        $this->loadReintegrosPendientes();
        $this->loadUrgentes();
    }
    
    private function loadStats()
    {
        // TODO: Obtener datos reales de auditoría médica
        $this->stats = [
            'reintegros_pendientes' => [
                'total' => 15,
                'incremento' => '↑ 5 nuevos hoy',
                'color' => 'amber'
            ],
            'reintegros_autorizados' => [
                'total' => 28,
                'incremento' => '↑ 8 esta semana',
                'color' => 'green'
            ],
            'reintegros_rechazados' => [
                'total' => 7,
                'incremento' => '↑ 2 esta semana',
                'color' => 'red'
            ],
            'solicitudes_informacion' => [
                'total' => 12,
                'incremento' => '↑ 3 pendientes',
                'color' => 'blue'
            ],
            'tiempo_promedio_revision' => [
                'total' => '2.5 días',
                'incremento' => '↓ 0.5 días vs mes anterior',
                'color' => 'indigo'
            ]
        ];
    }
    
    private function loadRecentActivity()
    {
        // TODO: Obtener actividad reciente médica
        $this->recentActivity = [
            [
                'tipo' => 'autorizacion',
                'titulo' => 'Reintegro autorizado',
                'descripcion' => 'Colegio San José - Fractura brazo - $2,500',
                'tiempo' => 'Hace 1 hora',
                'icono' => 'fas fa-check-circle',
                'color' => 'green'
            ],
            [
                'tipo' => 'solicitud_info',
                'titulo' => 'Información solicitada',
                'descripcion' => 'Instituto Santa María - Falta radiografía',
                'tiempo' => 'Hace 2 horas',
                'icono' => 'fas fa-info-circle',
                'color' => 'blue'
            ],
            [
                'tipo' => 'rechazo',
                'titulo' => 'Reintegro rechazado',
                'descripcion' => 'Escuela San Pedro - No relacionado con accidente',
                'tiempo' => 'Hace 4 horas',
                'icono' => 'fas fa-times-circle',
                'color' => 'red'
            ],
            [
                'tipo' => 'revision',
                'titulo' => 'Caso en revisión',
                'descripcion' => 'Colegio La Inmaculada - Lesión deportiva',
                'tiempo' => 'Ayer',
                'icono' => 'fas fa-eye',
                'color' => 'amber'
            ]
        ];
    }
    
    private function loadReintegrosPendientes()
    {
        // TODO: Obtener reintegros pendientes de autorización
        $this->reintegrosPendientes = [
            [
                'id' => 'REI-2025-001',
                'escuela' => 'Colegio San José',
                'alumno' => 'María González',
                'monto' => '$1,800',
                'fecha' => '2025-05-30',
                'tipo' => 'Consulta médica'
            ],
            [
                'id' => 'REI-2025-002',
                'escuela' => 'Instituto Santa María',
                'alumno' => 'Carlos Rodríguez',
                'monto' => '$950',
                'fecha' => '2025-05-29',
                'tipo' => 'Medicamentos'
            ],
            [
                'id' => 'REI-2025-003',
                'escuela' => 'Escuela San Pedro',
                'alumno' => 'Ana López',
                'monto' => '$3,200',
                'fecha' => '2025-05-28',
                'tipo' => 'Estudios médicos'
            ]
        ];
    }
    
    private function loadUrgentes()
    {
        // Los casos urgentes se quitaron del sistema
        $this->urgentes = [];
    }
    
    public function render()
    {
        return view('livewire.dashboards.medico-dashboard');
    }
}