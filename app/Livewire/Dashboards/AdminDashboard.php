<?php

namespace App\Livewire\Dashboards;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Escuela;
use App\Models\Accidente;
use App\Models\Reintegro;
use App\Models\AuditoriaSistema;
use App\Models\User;
use App\Models\Prestador;
use App\Models\Pasantia;
use App\Models\BeneficiarioSvo;
use App\Models\Derivacion;
use App\Models\DocumentoInstitucional;
use Carbon\Carbon;

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
        $totalEscuelas = Escuela::count();
        $totalAccidentes = Accidente::count();
        
        $reintegrosAutorizados = Reintegro::join('cat_estados_reintegros', 'reintegros.id_estado_reintegro', '=', 'cat_estados_reintegros.id_estado_reintegro')
                                        ->whereIn('cat_estados_reintegros.nombre_estado', ['Autorizado', 'Pagado'])
                                        ->count();
        
        $montoTotalPagado = Reintegro::join('cat_estados_reintegros', 'reintegros.id_estado_reintegro', '=', 'cat_estados_reintegros.id_estado_reintegro')
                                    ->where('cat_estados_reintegros.nombre_estado', 'Pagado')
                                    ->sum('monto_autorizado'); // Usar monto_autorizado para pagos

        // Calcular incrementos
        $escuelasEsteAno = Escuela::whereYear('fecha_alta', Carbon::now()->year)->count();
        $accidentesEsteMes = Accidente::whereMonth('fecha_carga', Carbon::now()->month)
                                    ->whereYear('fecha_carga', Carbon::now()->year)
                                    ->count();
        $reintegrosEstaSemana = Reintegro::join('cat_estados_reintegros', 'reintegros.id_estado_reintegro', '=', 'cat_estados_reintegros.id_estado_reintegro')
                                        ->whereBetween('reintegros.fecha_auditoria', [Carbon::now()->subDays(7), Carbon::now()])
                                        ->whereIn('cat_estados_reintegros.nombre_estado', ['Autorizado', 'Pagado'])
                                        ->count();
        $montoPagadoEsteMes = Reintegro::join('cat_estados_reintegros', 'reintegros.id_estado_reintegro', '=', 'cat_estados_reintegros.id_estado_reintegro')
                                    ->whereMonth('reintegros.fecha_solicitud', Carbon::now()->month)
                                    ->whereYear('reintegros.fecha_solicitud', Carbon::now()->year)
                                    ->where('cat_estados_reintegros.nombre_estado', 'Pagado')
                                    ->sum('monto_autorizado'); // Usar monto_autorizado para pagos

        $this->stats = [
            'total_escuelas' => [
                'total' => $totalEscuelas,
                'incremento' => '↑ ' . $escuelasEsteAno . ' este año',
                'color' => 'blue'
            ],
            'total_accidentes' => [
                'total' => $totalAccidentes,
                'incremento' => '↑ ' . $accidentesEsteMes . ' este mes',
                'color' => 'red'
            ],
            'reintegros_autorizados' => [
                'total' => $reintegrosAutorizados,
                'incremento' => '↑ ' . $reintegrosEstaSemana . ' últimos 7 días',
                'color' => 'green'
            ],
            'monto_total_pagado' => [
                'total' => '$' . number_format($montoTotalPagado, 2),
                'incremento' => '↑ $' . number_format($montoPagadoEsteMes, 2) . ' este mes',
                'color' => 'purple'
            ]
        ];
    }
    
    private function loadRecentActivity()
    {
        $this->recentActivity = AuditoriaSistema::whereIn('accion', ['CREATE', 'UPDATE', 'DELETE']) // Filtrar por acciones específicas
            ->with('usuario') // Cargar la relación con el usuario
            ->orderBy('fecha_hora', 'desc')
            ->take(4)
            ->get()
            ->map(function ($activity) {
                $color = 'gray';
                $icono = 'fas fa-info-circle';
                $titulo = 'Actividad del sistema';
                $descripcion = '';
                $usuarioNombre = $activity->usuario ? $activity->usuario->nombre . ' ' . $activity->usuario->apellido : 'Usuario Desconocido';

                switch ($activity->accion) {
                    case 'CREATE':
                        $color = 'blue';
                        $icono = 'fas fa-plus-circle';
                        $titulo = 'Nuevo registro';
                        $descripcion = "Se creó un nuevo registro en {$activity->tabla_afectada} por {$usuarioNombre}.";
                        break;
                    case 'UPDATE':
                        $color = 'yellow';
                        $icono = 'fas fa-edit';
                        $titulo = 'Registro actualizado';
                        $descripcion = "Se actualizó un registro en {$activity->tabla_afectada} por {$usuarioNombre}.";
                        break;
                    case 'DELETE':
                        $color = 'red';
                        $icono = 'fas fa-trash-alt';
                        $titulo = 'Registro eliminado';
                        $descripcion = "Se eliminó un registro en {$activity->tabla_afectada} por {$usuarioNombre}.";
                        break;
                    default:
                        // Esto no debería ocurrir si el filtro whereIn funciona correctamente
                        $titulo = ucfirst(strtolower($activity->accion)) . ' en ' . $activity->tabla_afectada;
                        $descripcion = 'Operación: ' . $activity->accion . ' en tabla: ' . $activity->tabla_afectada . ' por ' . $usuarioNombre;
                        break;
                }

                return [
                    'tipo' => $activity->accion,
                    'titulo' => $titulo,
                    'descripcion' => $descripcion,
                    'tiempo' => Carbon::parse($activity->fecha_hora)->diffForHumans(),
                    'icono' => $icono,
                    'color' => $color
                ];
            })->toArray();
    }
    
    private function loadEscuelasStats()
    {
        $this->escuelasStats = Escuela::withCount('accidentes')
            ->get()
            ->map(function ($escuela) {
                // Contar reintegros asociados a la escuela a través de los alumnos
                $reintegrosCount = Reintegro::whereHas('alumno', function ($query) use ($escuela) {
                    $query->where('id_escuela', $escuela->id_escuela);
                })->count();

                // Sumar monto pendiente de reintegros asociados a la escuela (todos los que no estén en estado 'Pagado')
                $montoPendiente = Reintegro::join('cat_estados_reintegros', 'reintegros.id_estado_reintegro', '=', 'cat_estados_reintegros.id_estado_reintegro')
                                            ->where('cat_estados_reintegros.nombre_estado', '!=', 'Pagado') // Excluir los que ya están pagados
                                            ->whereHas('alumno', function ($query) use ($escuela) {
                                                $query->where('id_escuela', $escuela->id_escuela);
                                            })
                                            ->sum('monto_solicitado'); // Usar monto_solicitado para pendientes

                return [
                    'nombre' => $escuela->nombre,
                    'accidentes' => $escuela->accidentes_count,
                    'reintegros' => $reintegrosCount,
                    'monto_pendiente' => '$' . number_format($montoPendiente, 2)
                ];
            })->toArray();
    }
    
    public function render()
    {
        return view('livewire.dashboards.admin-dashboard');
    }
}