<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Livewire\GestionPagos\Index as GestionPagosIndex;
use App\Livewire\Documentos\Repositorio as DocumentosRepositorio;

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

    // Rutas para Escuelas (conectado a BD)
    Route::prefix('escuelas')->name('escuelas.')->middleware('auth')->group(function () {
        Route::get('/', \App\Livewire\Escuelas\Index::class)->name('index');

        Route::get('/create', function () {
            return view('escuelas.form', ['modo' => 'create']);
        })->name('create');

        Route::get('/{id}/edit', function ($id) {
            return view('escuelas.form', ['modo' => 'edit', 'escuela_id' => $id]);
        })->name('edit');

        Route::get('/{id}', function ($id) {
            return view('escuelas.form', ['modo' => 'show', 'escuela_id' => $id]);
        })->name('show');

        // Rutas de exportación
        Route::get('/export/csv', [\App\Http\Controllers\EscuelaExportController::class, 'exportarCSV'])->name('export.csv');
        Route::get('/export/excel', [\App\Http\Controllers\EscuelaExportController::class, 'exportarExcel'])->name('export.excel');
        Route::get('/export/pdf', [\App\Http\Controllers\EscuelaExportController::class, 'exportarPDF'])->name('export.pdf');
    });

    // Rutas para Empleados (conectado a BD)
    Route::prefix('empleados')->name('empleados.')->middleware('auth')->group(function () {
        Route::get('/', \App\Livewire\Empleados\Index::class)->name('index');

        Route::get('/create', function () {
            return view('empleados.form', ['modo' => 'create']);
        })->name('create');

        Route::get('/{id}/edit', function ($id) {
            return view('empleados.form', ['modo' => 'edit', 'empleado_id' => $id]);
        })->name('edit');

        // Ruta de impresión debe ir antes de la ruta show para evitar conflictos
        Route::get('/{id}/print-beneficiarios', [App\Http\Controllers\EmpleadoController::class, 'printBeneficiarios'])->name('print.beneficiarios');

        // Ruta de prueba para verificar que funciona
        Route::get('/{id}/test-print', function ($id) {
            return "Ruta de prueba funcionando para empleado ID: {$id}";
        })->name('test.print');

        Route::get('/{id}', function ($id) {
            return view('empleados.form', ['modo' => 'show', 'empleado_id' => $id]);
        })->name('show');

        // Rutas de exportación
        Route::get('/export/csv', [\App\Http\Controllers\EmpleadosExportController::class, 'exportarCSV'])->name('export.csv');
        Route::get('/export/excel', [\App\Http\Controllers\EmpleadosExportController::class, 'exportarExcel'])->name('export.excel');
        Route::get('/export/pdf', [\App\Http\Controllers\EmpleadosExportController::class, 'exportarPDF'])->name('export.pdf');
    });

    // Mockup de rutas para Prestadores (sin controlador real aún)
    Route::prefix('prestadores')->name('prestadores.')->middleware('auth')->group(function () {
        Route::get('/', \App\Livewire\Prestadores\Index::class)->name('index');

        Route::get('/create', function () {
            return view('prestadores.form', ['modo' => 'create']);
        })->name('create');

        Route::get('/{id}/edit', function ($id) {
            return view('prestadores.form', ['modo' => 'edit', 'prestador_id' => $id]);
        })->name('edit');

        Route::get('/{id}', function ($id) {
            return view('prestadores.form', ['modo' => 'show', 'prestador_id' => $id]);
        })->name('show');

        // Rutas de exportación
        Route::get('/export/csv', [\App\Http\Controllers\PrestadorExportController::class, 'exportarCSV'])->name('export.csv');
        Route::get('/export/excel', [\App\Http\Controllers\PrestadorExportController::class, 'exportarExcel'])->name('export.excel');
        Route::get('/export/pdf', [\App\Http\Controllers\PrestadorExportController::class, 'exportarPDF'])->name('export.pdf');
    });

    // Rutas para Usuarios usando componentes Livewire - Admin y Usuario General
    Route::prefix('usuarios')->name('usuarios.')->middleware(['auth', 'role:admin,usuario_general'])->group(function () {
        Route::get('/', \App\Livewire\Usuarios\Index::class)->name('index');

        Route::get('/create', function () {
            return view('usuarios.form', ['modo' => 'create']);
        })->name('create');

        Route::get('/{id}/edit', function ($id) {
            return view('usuarios.form', ['modo' => 'edit', 'usuario_id' => $id]);
        })->name('edit');

        Route::get('/{id}', function ($id) {
            return view('usuarios.form', ['modo' => 'show', 'usuario_id' => $id]);
        })->name('show');

        // Rutas de exportación
        Route::get('/export/csv', [\App\Http\Controllers\UsuariosExportController::class, 'exportarCSV'])->name('export.csv');
        Route::get('/export/excel', [\App\Http\Controllers\UsuariosExportController::class, 'exportarExcel'])->name('export.excel');
    });

    // Rutas para Alumnos (conectado a BD)
    Route::prefix('alumnos')->name('alumnos.')->middleware('auth')->group(function () {
        Route::get('/', \App\Livewire\Alumnos\Index::class)->name('index');

        Route::get('/create', \App\Livewire\Alumnos\Form::class)->name('create');
        Route::get('/{alumno_id}/edit', \App\Livewire\Alumnos\Form::class)->name('edit');
        Route::get('/{alumno_id}', \App\Livewire\Alumnos\Form::class)->name('show');

        // Rutas de exportación
        Route::get('/export/csv', [\App\Http\Controllers\AlumnosExportController::class, 'exportarCSV'])->name('export.csv');
        Route::get('/export/excel', [\App\Http\Controllers\AlumnosExportController::class, 'exportarExcel'])->name('export.excel');
        Route::get('/export/pdf', [\App\Http\Controllers\AlumnosExportController::class, 'exportarPDF'])->name('export.pdf');
    });

    // Rutas para Accidentes (conectado a BD)
    Route::prefix('accidentes')->name('accidentes.')->middleware('auth')->group(function () {
        Route::get('/', \App\Livewire\Accidentes\Index::class)->name('index');

        Route::get('/create', function () {
            return view('accidentes.form', ['modo' => 'create']);
        })->name('create');

        Route::get('/{id}/edit', function ($id) {
            return view('accidentes.form', ['modo' => 'edit', 'accidente_id' => $id]);
        })->name('edit');

        Route::get('/{id}', function ($id) {
            return view('accidentes.form', ['modo' => 'show', 'accidente_id' => $id]);
        })->name('show');

        Route::get('/{id}/print', function ($id) {
            $accidente = \App\Models\Accidente::with(['escuela', 'alumnos.alumno', 'estado'])->findOrFail($id);
            $archivos = \App\Models\ArchivoAdjunto::paraEntidad('accidente', $id)->recientes()->get();
            return view('accidentes.print', compact('accidente', 'archivos'));
        })->name('print');

        Route::get('/{id}/dossier', function ($id) {
            $accidente = \App\Models\Accidente::with([
                'escuela', 'alumnos.alumno', 'estado',
                'derivaciones.alumno', 'derivaciones.prestador',
                'reintegros.alumno', 'reintegros.estadoReintegro', 'reintegros.tiposGastos'
            ])->findOrFail($id);
            $archivos = \App\Models\ArchivoAdjunto::paraEntidad('accidente', $id)->recientes()->get();
            return view('accidentes.dossier', compact('accidente', 'archivos'));
        })->name('dossier');

        // Rutas de exportación
        Route::get('/export/csv', [\App\Http\Controllers\AccidentesExportController::class, 'exportarCSV'])->name('export.csv');
        Route::get('/export/excel', [\App\Http\Controllers\AccidentesExportController::class, 'exportarExcel'])->name('export.excel');
        Route::get('/export/pdf', [\App\Http\Controllers\AccidentesExportController::class, 'exportarPDF'])->name('export.pdf');
    });

    // Rutas para Salidas Educativas (conectado a BD)
    Route::prefix('salidas-educativas')->name('salidas-educativas.')->middleware('auth')->group(function () {
        Route::get('/', \App\Livewire\SalidasEducativas\Index::class)->name('index');

        Route::get('/create', function () {
            return view('salidas_educativas.form', ['modo' => 'create']);
        })->name('create');

        Route::get('/{id}/edit', function ($id) {
            return view('salidas_educativas.form', ['modo' => 'edit', 'salida_id' => $id]);
        })->name('edit');

        Route::get('/{id}', function ($id) {
            return view('salidas_educativas.form', ['modo' => 'show', 'salida_id' => $id]);
        })->name('show');

        Route::get('/{id}/print', function ($id) {
            $salida = \App\Models\SalidaEducativa::with('escuela')->findOrFail($id);
            $archivos = \App\Models\ArchivoAdjunto::paraEntidad('salida_educativa', $id)->recientes()->get();
            return view('salidas_educativas.print', compact('salida', 'archivos'));
        })->name('print');

        // Rutas de exportación
        Route::get('/export/csv', [\App\Http\Controllers\SalidaEducativaExportController::class, 'exportarCSV'])->name('export.csv');
        Route::get('/export/excel', [\App\Http\Controllers\SalidaEducativaExportController::class, 'exportarExcel'])->name('export.excel');
        Route::get('/export/pdf', [\App\Http\Controllers\SalidaEducativaExportController::class, 'exportarPDF'])->name('export.pdf');
    });

    // Rutas para Pasantías (conectado a BD)
    Route::prefix('pasantias')->name('pasantias.')->middleware('auth')->group(function () {
        Route::get('/', \App\Livewire\Pasantias\Index::class)->name('index');

        Route::get('/create', function () {
            return view('pasantias.form', ['modo' => 'create']);
        })->name('create');

        Route::get('/{id}/edit', function ($id) {
            return view('pasantias.form', ['modo' => 'edit', 'pasantia_id' => $id]);
        })->name('edit');

        Route::get('/{id}', function ($id) {
            return view('pasantias.form', ['modo' => 'show', 'pasantia_id' => $id]);
        })->name('show');

        Route::get('/{id}/print', function ($id) {
            $pasantia = \App\Models\Pasantia::with(['escuela', 'alumno'])->findOrFail($id);
            return view('pasantias.print', compact('pasantia'));
        })->name('print');

        // Rutas de exportación
        Route::get('/export/csv', [App\Http\Controllers\PasantiaExportController::class, 'exportCsv'])->name('export.csv');
        Route::get('/export/excel', [App\Http\Controllers\PasantiaExportController::class, 'exportExcel'])->name('export.excel');
        Route::get('/export/pdf', [App\Http\Controllers\PasantiaExportController::class, 'exportPdf'])->name('export.pdf');
    });

    // Rutas para Beneficiarios SVO (conectado a BD)
    Route::prefix('beneficiarios-svo')->name('beneficiarios_svo.')->middleware('auth')->group(function () {
        Route::get('/', \App\Livewire\BeneficiariosSvo\Index::class)->name('index');

        Route::get('/create', function () {
            return view('beneficiarios_svo.form', ['modo' => 'create']);
        })->name('create');

        Route::get('/{id}/edit', function ($id) {
            return view('beneficiarios_svo.form', ['modo' => 'edit', 'beneficiario_id' => $id]);
        })->name('edit');

        Route::get('/{id}', function ($id) {
            return view('beneficiarios_svo.form', ['modo' => 'show', 'beneficiario_id' => $id]);
        })->name('show');

        // Rutas de exportación
        Route::get('/export/csv', [\App\Http\Controllers\BeneficiarioSvoExportController::class, 'exportarCSV'])->name('export.csv');
        Route::get('/export/excel', [\App\Http\Controllers\BeneficiarioSvoExportController::class, 'exportarExcel'])->name('export.excel');
        Route::get('/export/pdf', [\App\Http\Controllers\BeneficiarioSvoExportController::class, 'exportarPDF'])->name('export.pdf');
    });

    // Rutas para Derivaciones (conectado a BD)
    Route::prefix('derivaciones')->name('derivaciones.')->middleware('auth')->group(function () {
        Route::get('/', \App\Livewire\Derivaciones\Index::class)->name('index');

        Route::get('/create/{id_accidente?}', function ($id_accidente = null) {
            return view('derivaciones.form', ['modo' => 'create', 'accidente_id' => $id_accidente]);
        })->name('create');

        Route::get('/{id}/edit', function ($id) {
            return view('derivaciones.form', ['modo' => 'edit', 'derivacion_id' => $id]);
        })->name('edit');

        Route::get('/{id}', function ($id) {
            return view('derivaciones.form', ['modo' => 'show', 'derivacion_id' => $id]);
        })->name('show');

        Route::get('/{id}/print', [\App\Http\Controllers\DerivacionController::class, 'print'])->name('print');

        // Rutas de exportación
        Route::get('/export/csv', [\App\Http\Controllers\DerivacionesExportController::class, 'exportarCSV'])->name('export.csv');
        Route::get('/export/excel', [\App\Http\Controllers\DerivacionesExportController::class, 'exportarExcel'])->name('export.excel');
        Route::get('/export/pdf', [\App\Http\Controllers\DerivacionesExportController::class, 'exportarPDF'])->name('export.pdf');
    });

    // Rutas para Reintegros (conectado a BD)
    Route::prefix('reintegros')->name('reintegros.')->middleware('auth')->group(function () {
        // Ruta principal accesible para admin, usuario_general y medico_auditor
        Route::get('/', \App\Livewire\Reintegros\Index::class)->name('index')->middleware('role:admin,usuario_general,medico_auditor');
        Route::get('/pendientes', \App\Livewire\Reintegros\Pendientes::class)->name('pendientes');

        Route::get('/create', function () {
            $id_accidente = request()->query('id_accidente');
            return view('reintegros.form', ['modo' => 'create', 'id_accidente' => $id_accidente]);
        })->name('create');

        Route::get('/{id}/edit', function ($id) {
            return view('reintegros.form', ['modo' => 'edit', 'reintegro_id' => $id]);
        })->name('edit');

        Route::get('/{id}', function ($id) {
            return view('reintegros.form', ['modo' => 'show', 'reintegro_id' => $id]);
        })->name('show');

        // Rutas de exportación
        Route::get('/export/csv', [\App\Http\Controllers\ReintegroExportController::class, 'exportarCSV'])->name('export.csv');
        Route::get('/export/excel', [\App\Http\Controllers\ReintegroExportController::class, 'exportarExcel'])->name('export.excel');
        Route::get('/export/pdf', [\App\Http\Controllers\ReintegroExportController::class, 'exportarPDF'])->name('export.pdf');
    });

    // Rutas para Documentos Institucionales (conectado a BD)
    Route::prefix('documentos')->name('documentos.')->middleware('auth')->group(function () {
        Route::get('/', \App\Livewire\Documentos\Index::class)->name('index');

        Route::get('/create', function () {
            return view('documentos.form', ['modo' => 'create']);
        })->name('create');

        Route::get('/{id}/edit', function ($id) {
            return view('documentos.form', ['modo' => 'edit', 'documento_id' => $id]);
        })->name('edit');

        Route::get('/{id}', function ($id) {
            return view('documentos.form', ['modo' => 'show', 'documento_id' => $id]);
        })->name('show');

        // Rutas de exportación
        Route::get('/export/csv', [\App\Http\Controllers\DocumentosExportController::class, 'exportarCSV'])->name('export.csv');
        Route::get('/export/excel', [\App\Http\Controllers\DocumentosExportController::class, 'exportarExcel'])->name('export.excel');
        Route::get('/export/pdf', [\App\Http\Controllers\DocumentosExportController::class, 'exportarPDF'])->name('export.pdf');

        // Ruta para descargar archivos de documentos
        Route::get('/{id}/download', [\App\Http\Controllers\DocumentoController::class, 'descargarArchivo'])->name('download');

        // Ruta para descargar archivo individual por ID de archivo
        Route::get('/archivo/{archivoId}/download', [\App\Http\Controllers\DocumentoController::class, 'descargarArchivoIndividual'])->name('archivo.download');
    });

    // Rutas para Documentos de Escuela (conectado a BD)
    Route::prefix('documentos-escuela')->name('documentos-escuela.')->middleware('auth')->group(function () {
        Route::get('/', \App\Livewire\DocumentosEscuela\Index::class)->name('index');

        Route::get('/create', function () {
            return view('documentos-escuela.form', ['modo' => 'create']);
        })->name('create');

        Route::get('/{id}/edit', function ($id) {
            return view('documentos-escuela.form', ['modo' => 'edit', 'documento_id' => $id]);
        })->name('edit');

        Route::get('/{id}', function ($id) {
            return view('documentos-escuela.form', ['modo' => 'show', 'documento_id' => $id]);
        })->name('show');

        // Rutas de exportación
        Route::get('/export/csv', [\App\Http\Controllers\DocumentosExportController::class, 'exportarCSV'])->name('export.csv');
        Route::get('/export/excel', [\App\Http\Controllers\DocumentosExportController::class, 'exportarExcel'])->name('export.excel');
        Route::get('/export/pdf', [\App\Http\Controllers\DocumentosExportController::class, 'exportarPDF'])->name('export.pdf');

        // Ruta para descargar archivos de documentos
        Route::get('/{id}/download', [\App\Http\Controllers\DocumentoController::class, 'descargarArchivo'])->name('download');
    });

    // Ruta del repositorio para usuarios generales (ruta aislada)
    Route::get('/repositorio', function () {
        return view('documentos.repositorio');
    })->name('repositorio')
      ->middleware(['auth', 'role:usuario_general']);
    
    // Rutas de Auditoría
    Route::prefix('auditoria')->name('auditoria.')->middleware(['auth', 'role:admin'])->group(function () {
        Route::get('/accesos', \App\Livewire\Auditoria\AccesosSistema::class)->name('accesos');
        Route::get('/operaciones', \App\Livewire\Auditoria\OperacionesSistema::class)->name('operaciones');

        // Rutas de exportación de auditoría
        Route::prefix('export')->name('export.')->group(function () {
            Route::get('/accesos/csv', [\App\Http\Controllers\AuditoriaExportController::class, 'exportarAccesosCSV'])->name('accesos.csv');
            Route::get('/accesos/excel', [\App\Http\Controllers\AuditoriaExportController::class, 'exportarAccesosExcel'])->name('accesos.excel');
            Route::get('/accesos/pdf', [\App\Http\Controllers\AuditoriaExportController::class, 'exportarAccesosPDF'])->name('accesos.pdf');
            Route::get('/operaciones/csv', [\App\Http\Controllers\AuditoriaExportController::class, 'exportarOperacionesCSV'])->name('operaciones.csv');
            Route::get('/operaciones/excel', [\App\Http\Controllers\AuditoriaExportController::class, 'exportarOperacionesExcel'])->name('operaciones.excel');
            Route::get('/operaciones/pdf', [\App\Http\Controllers\AuditoriaExportController::class, 'exportarOperacionesPDF'])->name('operaciones.pdf');
        });
    });

    // Ruta de Historial de Auditorías para múltiples roles
    Route::prefix('auditoria')->name('auditoria.')->middleware(['auth', 'role:admin,medico_auditor,usuario_general'])->group(function () {
        Route::get('/historial-auditorias', function () {
            // Redirigir a la pantalla de reintegros
            return redirect()->route('reintegros.index');
        })->name('historial-auditorias');
        
        Route::get('/detalle/{type}/{id}', function ($type, $id) {
            $item = null;
            if ($type === 'auditoria') {
                $item = \App\Models\AuditoriaSistema::with(['reintegro.accidente.alumnos.alumno', 'reintegro.accidente.escuela', 'usuario'])->findOrFail($id);
            } elseif ($type === 'solicitud') {
                $item = \App\Models\SolicitudInfoAuditor::with(['reintegro.accidente.alumnos.alumno', 'reintegro.accidente.escuela', 'auditor', 'estadoSolicitud', 'usuarioResponde'])->findOrFail($id);
            } else {
                abort(404);
            }
            return view('auditoria.detalle', ['item' => $item, 'itemType' => $type]);
        })->name('detalle');
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
