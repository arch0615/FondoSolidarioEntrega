<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Livewire\GestionPagos\Index as GestionPagosIndex;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Redireccionar la raíz al login
Route::get('/', function () {
    return redirect()->route('login');
});

// Rutas de autenticación
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('forgot-password');
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
});

// Rutas protegidas por autenticación
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    // Mockup de rutas para Escuelas (sin controlador real aún)
    Route::prefix('escuelas')->name('escuelas.')->group(function () {
        Route::get('/', function () {
            // Simular datos para el mockup de la lista
            return view('livewire.escuelas.index');
        })->name('index');

        Route::get('/create', function () {
            return view('livewire.escuelas.form', ['modo' => 'create']);
        })->name('create');

        Route::get('/{id}/edit', function ($id) {
            // Simular carga de escuela para edición
            return view('livewire.escuelas.form', ['modo' => 'edit', 'escuela_id' => $id]);
        })->name('edit');

        Route::get('/{id}', function ($id) {
            // Simular carga de escuela para visualización
            return view('livewire.escuelas.form', ['modo' => 'show', 'escuela_id' => $id]);
        })->name('show');
    });

    // Mockup de rutas para Empleados (sin controlador real aún)
    Route::prefix('empleados')->name('empleados.')->group(function () {
        Route::get('/', function () {
            // Simular datos para el mockup de la lista
            return view('livewire.empleados.index');
        })->name('index');

        Route::get('/create', function () {
            return view('livewire.empleados.form', ['modo' => 'create']);
        })->name('create');

        Route::get('/{id}/edit', function ($id) {
            // Simular carga de empleado para edición
            return view('livewire.empleados.form', ['modo' => 'edit', 'empleado_id' => $id]);
        })->name('edit');

        Route::get('/{id}', function ($id) {
            // Simular carga de empleado para visualización
            return view('livewire.empleados.form', ['modo' => 'show', 'empleado_id' => $id]);
        })->name('show');
    });

    // Mockup de rutas para Prestadores (sin controlador real aún)
    Route::prefix('prestadores')->name('prestadores.')->group(function () {
        Route::get('/', function () {
            // Simular datos para el mockup de la lista
            return view('livewire.prestadores.index');
        })->name('index');

        Route::get('/create', function () {
            return view('livewire.prestadores.form', ['modo' => 'create']);
        })->name('create');

        Route::get('/{id}/edit', function ($id) {
            // Simular carga de prestador para edición
            return view('livewire.prestadores.form', ['modo' => 'edit', 'prestador_id' => $id]);
        })->name('edit');

        Route::get('/{id}', function ($id) {
            // Simular carga de prestador para visualización
            return view('livewire.prestadores.form', ['modo' => 'show', 'prestador_id' => $id]);
        })->name('show');
    });

    // Mockup de rutas para Usuarios (sin controlador real aún) - Solo Admin
    Route::prefix('usuarios')->name('usuarios.')->middleware(['auth', 'role:admin'])->group(function () {
        Route::get('/', function () {
            // Simular datos para el mockup de la lista
            return view('livewire.usuarios.index');
        })->name('index');

        Route::get('/create', function () {
            return view('livewire.usuarios.form', ['modo' => 'create']);
        })->name('create');

        Route::get('/{id}/edit', function ($id) {
            // Simular carga de usuario para edición
            return view('livewire.usuarios.form', ['modo' => 'edit', 'usuario_id' => $id]);
        })->name('edit');

        Route::get('/{id}', function ($id) {
            // Simular carga de usuario para visualización
            return view('livewire.usuarios.form', ['modo' => 'show', 'usuario_id' => $id]);
        })->name('show');
    });

    // Mockup de rutas para Alumnos (sin controlador real aún)
    Route::prefix('alumnos')->name('alumnos.')->group(function () {
        Route::get('/', function () {
            // Simular datos para el mockup de la lista
            return view('livewire.alumnos.index');
        })->name('index');

        Route::get('/create', function () {
            return view('livewire.alumnos.form', ['modo' => 'create']);
        })->name('create');

        Route::get('/{id}/edit', function ($id) {
            // Simular carga de alumno para edición
            return view('livewire.alumnos.form', ['modo' => 'edit', 'alumno_id' => $id]);
        })->name('edit');

        Route::get('/{id}', function ($id) {
            // Simular carga de alumno para visualización
            return view('livewire.alumnos.form', ['modo' => 'show', 'alumno_id' => $id]);
        })->name('show');
    });

    // Mockup de rutas para Accidentes (sin controlador real aún)
    Route::prefix('accidentes')->name('accidentes.')->group(function () {
        Route::get('/', function () {
            // Simular datos para el mockup de la lista
            return view('livewire.accidentes.index');
        })->name('index');

        Route::get('/create', function () {
            return view('livewire.accidentes.form', ['modo' => 'create']);
        })->name('create');

        Route::get('/{id}/edit', function ($id) {
            // Simular carga de accidente para edición
            return view('livewire.accidentes.form', ['modo' => 'edit', 'accidente_id' => $id]);
        })->name('edit');

        Route::get('/{id}', function ($id) {
            // Simular carga de accidente para visualización
            return view('livewire.accidentes.form', ['modo' => 'show', 'accidente_id' => $id]);
        })->name('show');
    });

    // Mockup de rutas para Salidas Educativas (sin controlador real aún)
    Route::prefix('salidas-educativas')->name('salidas_educativas.')->group(function () {
        Route::get('/', function () {
            // Simular datos para el mockup de la lista
            return view('livewire.salidas_educativas.index');
        })->name('index');

        Route::get('/create', function () {
            return view('livewire.salidas_educativas.form', ['modo' => 'create']);
        })->name('create');

        Route::get('/{id}/edit', function ($id) {
            // Simular carga de salida educativa para edición
            return view('livewire.salidas_educativas.form', ['modo' => 'edit', 'salida_id' => $id]);
        })->name('edit');

        Route::get('/{id}', function ($id) {
            // Simular carga de salida educativa para visualización
            return view('livewire.salidas_educativas.form', ['modo' => 'show', 'salida_id' => $id]);
        })->name('show');
    });

    // Mockup de rutas para Pasantías (sin controlador real aún)
    Route::prefix('pasantias')->name('pasantias.')->group(function () {
        Route::get('/', function () {
            // Simular datos para el mockup de la lista
            return view('livewire.pasantias.index');
        })->name('index');

        Route::get('/create', function () {
            return view('livewire.pasantias.form', ['modo' => 'create']);
        })->name('create');

        Route::get('/{id}/edit', function ($id) {
            // Simular carga de pasantía para edición
            return view('livewire.pasantias.form', ['modo' => 'edit', 'pasantia_id' => $id]);
        })->name('edit');

        Route::get('/{id}', function ($id) {
            // Simular carga de pasantía para visualización
            return view('livewire.pasantias.form', ['modo' => 'show', 'pasantia_id' => $id]);
        })->name('show');
    });

    // Mockup de rutas para Beneficiarios SVO (sin controlador real aún)
    Route::prefix('beneficiarios-svo')->name('beneficiarios_svo.')->group(function () {
        Route::get('/', function () {
            // Simular datos para el mockup de la lista
            return view('livewire.beneficiarios_svo.index');
        })->name('index');

        Route::get('/create', function () {
            return view('livewire.beneficiarios_svo.form', ['modo' => 'create']);
        })->name('create');

        Route::get('/{id}/edit', function ($id) {
            // Simular carga de beneficiario para edición
            return view('livewire.beneficiarios_svo.form', ['modo' => 'edit', 'beneficiario_id' => $id]);
        })->name('edit');

        Route::get('/{id}', function ($id) {
            // Simular carga de beneficiario para visualización
            return view('livewire.beneficiarios_svo.form', ['modo' => 'show', 'beneficiario_id' => $id]);
        })->name('show');
    });

    // Mockup de rutas para Derivaciones (sin controlador real aún)
    Route::prefix('derivaciones')->name('derivaciones.')->group(function () {
        Route::get('/', function () {
            // Simular datos para el mockup de la lista
            return view('livewire.derivaciones.index');
        })->name('index');

        Route::get('/create', function () { // Usualmente se crea desde un accidente
            return view('livewire.derivaciones.form', ['modo' => 'create']);
        })->name('create');

        Route::get('/{id}/edit', function ($id) {
            // Simular carga de derivacion para edición
            return view('livewire.derivaciones.form', ['modo' => 'edit', 'derivacion_id' => $id]);
        })->name('edit');

        Route::get('/{id}', function ($id) {
            // Simular carga de derivacion para visualización
            return view('livewire.derivaciones.form', ['modo' => 'show', 'derivacion_id' => $id]);
        })->name('show');
    });

    // Mockup de rutas para Reintegros
    Route::prefix('reintegros')->name('reintegros.')->group(function () {
        Route::get('/', function () {
            $reintegrosMockup = collect([
                [
                    'id_reintegro' => 'REI-001',
                    'id_accidente' => 'ACC-001',
                    'nombre_alumno' => 'Juan Pérez',
                    'escuela' => 'Colegio San Martín',
                    'fecha_solicitud' => '2024-05-20',
                    'monto_solicitado' => 1500.00,
                    'estado' => 'En Proceso',
                    'solicitud_informacion' => null,
                ],
                [
                    'id_reintegro' => 'REI-002',
                    'id_accidente' => 'ACC-002',
                    'nombre_alumno' => 'Ana López',
                    'escuela' => 'Instituto Belgrano',
                    'fecha_solicitud' => '2024-05-22',
                    'monto_solicitado' => 8250.50,
                    'estado' => 'Autorizado',
                    'solicitud_informacion' => null,
                ],
                [
                    'id_reintegro' => 'REI-003',
                    'id_accidente' => 'ACC-003',
                    'nombre_alumno' => 'Carlos Sanchez',
                    'escuela' => 'Colegio San Martín',
                    'fecha_solicitud' => '2024-05-25',
                    'monto_solicitado' => 3100.00,
                    'estado' => 'Solicitud de Información',
                    'solicitud_informacion' => 'Falta el comprobante de la farmacia. Por favor, adjúntelo.',
                ],
                 [
                    'id_reintegro' => 'REI-004',
                    'id_accidente' => 'ACC-004',
                    'nombre_alumno' => 'Laura Gomez',
                    'escuela' => 'Instituto Belgrano',
                    'fecha_solicitud' => '2024-05-28',
                    'monto_solicitado' => 500.00,
                    'estado' => 'Rechazado',
                    'solicitud_informacion' => null,
                ],
            ]);
            return view('livewire.reintegros.index', ['reintegros' => $reintegrosMockup]);
        })->name('index');

        Route::get('/pendientes', \App\Livewire\Reintegros\Pendientes::class)->name('pendientes');

        Route::get('/create', function () {
            return view('livewire.reintegros.form', ['modo' => 'create', 'estado' => 'En Proceso']);
        })->name('create');

        Route::get('/{id}/edit', function ($id) {
            // Mockup: En un caso real, se cargaría el estado del reintegro
            return view('livewire.reintegros.form', ['modo' => 'edit', 'reintegro_id' => $id, 'estado' => 'En Proceso']);
        })->name('edit');

        Route::get('/{id}', function ($id) {
            // Mockup: En un caso real, se cargaría el estado del reintegro
            return view('livewire.reintegros.form', ['modo' => 'show', 'reintegro_id' => $id, 'estado' => 'Autorizado']);
        })->name('show');
    });

    // Mockup de rutas para Documentos (sin controlador real aún)
    Route::prefix('documentos')->name('documentos.')->group(function () {
        Route::get('/', function () {
            // Simular datos para el mockup de la lista
            return view('livewire.documentos.index');
        })->name('index');

        Route::get('/create', function () {
            return view('livewire.documentos.form', ['modo' => 'create']);
        })->name('create');

        Route::get('/{id}/edit', function ($id) {
            // Simular carga de documento para edición
            return view('livewire.documentos.form', ['modo' => 'edit', 'documento_id' => $id]);
        })->name('edit');

        Route::get('/{id}', function ($id) {
            // Simular carga de documento para visualización
            return view('livewire.documentos.form', ['modo' => 'show', 'documento_id' => $id]);
        })->name('show');
    });
    
    // Rutas de Auditoría
    Route::prefix('auditoria')->name('auditoria.')->middleware(['auth', 'role:admin'])->group(function () {
        Route::get('/accesos', function () {
            return view('livewire.auditoria.accesos-sistema');
        })->name('accesos');
        Route::get('/operaciones', function () {
            return view('livewire.auditoria.operaciones-sistema');
        })->name('operaciones');
    });

    // Ruta de Historial de Auditorías para múltiples roles
    Route::prefix('auditoria')->name('auditoria.')->middleware(['auth', 'role:admin,medico_auditor,usuario_general'])->group(function () {
        Route::get('/historial-auditorias', \App\Livewire\Auditoria\HistorialAuditorias::class)->name('historial-auditorias');
    });

    // Rutas de Perfil
    Route::prefix('perfil')->name('perfil.')->middleware('auth')->group(function () {
        Route::get('/escuela', \App\Livewire\Perfil\PerfilEscuela::class)->name('escuela')->middleware('role:usuario_general');
        Route::get('/usuario', \App\Livewire\Perfil\PerfilUsuario::class)->name('usuario')->middleware('role:admin,medico_auditor');
    });

    // Rutas de Administración
    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::get('gestion-pagos', GestionPagosIndex::class)->name('gestion-pagos');
    });

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Ruta para mostrar la página welcome (opcional)
Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');