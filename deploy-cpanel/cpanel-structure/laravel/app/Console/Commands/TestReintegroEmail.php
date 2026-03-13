<?php

namespace App\Console\Commands;

use App\Models\Reintegro;
use App\Services\ReintegroMailService;
use Illuminate\Console\Command;

class TestReintegroEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:reintegro-email {reintegro_id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Prueba el envío de correos de notificación de reintegros';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $reintegroId = $this->argument('reintegro_id');
        
        if (!$reintegroId) {
            // Obtener el último reintegro si no se especifica uno
            $reintegro = Reintegro::with([
                'alumno',
                'accidente.escuela',
                'usuarioSolicita',
                'tiposGastos',
                'estadoReintegro'
            ])->orderBy('id_reintegro', 'desc')->first();
            
            if (!$reintegro) {
                $this->error('No se encontraron reintegros en la base de datos.');
                return 1;
            }
            
            $this->info("Usando el último reintegro registrado (ID: {$reintegro->id_reintegro})");
        } else {
            $reintegro = Reintegro::with([
                'alumno',
                'accidente.escuela',
                'usuarioSolicita',
                'tiposGastos',
                'estadoReintegro'
            ])->find($reintegroId);
            
            if (!$reintegro) {
                $this->error("No se encontró el reintegro con ID: {$reintegroId}");
                return 1;
            }
        }

        $this->info("Probando envío de correos para el reintegro REI-{$reintegro->id_reintegro}");
        $this->info("Alumno: {$reintegro->alumno->nombre_completo}");
        $this->info("Escuela: {$reintegro->accidente->escuela->nombre}");
        $this->info("Monto: $" . number_format($reintegro->monto_solicitado, 2));
        
        // Mostrar usuarios que recibirán el correo
        $usuarios = ReintegroMailService::obtenerUsuariosNotificacion();
        $this->info("\nUsuarios que recibirán la notificación:");
        
        if ($usuarios->isEmpty()) {
            $this->warn('No hay usuarios administradores o médicos auditores activos.');
            return 1;
        }
        
        foreach ($usuarios as $usuario) {
            $this->line("- {$usuario['nombre_completo']} ({$usuario['email']}) - {$usuario['rol']}");
        }
        
        if ($this->confirm("\n¿Desea proceder con el envío de los correos?")) {
            $this->info("\nEnviando correos...");
            
            $resultado = ReintegroMailService::enviarNotificacionNuevoReintegro($reintegro);
            
            if ($resultado['exito']) {
                $this->info("✅ Proceso completado exitosamente!");
                $this->info("Correos enviados: {$resultado['correos_enviados']} de {$resultado['total_usuarios']}");
                
                if (!empty($resultado['errores'])) {
                    $this->warn("\nErrores encontrados:");
                    foreach ($resultado['errores'] as $error) {
                        $this->line("❌ {$error}");
                    }
                }
            } else {
                $this->error("❌ Error en el envío de correos:");
                $this->error($resultado['mensaje']);
                
                if (!empty($resultado['errores'])) {
                    foreach ($resultado['errores'] as $error) {
                        $this->line("❌ {$error}");
                    }
                }
                return 1;
            }
        } else {
            $this->info('Envío cancelado por el usuario.');
        }
        
        return 0;
    }
}
