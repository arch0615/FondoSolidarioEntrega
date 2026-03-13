<?php

namespace App\Livewire\Empleados;

use Livewire\Component;
use App\Models\Empleado;
use App\Models\Escuela;
use App\Models\BeneficiarioSvo;
use App\Models\CatParentesco;
use App\Services\AuditoriaService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Form extends Component
{
    public $modo = 'create';
    public $empleado_id;

    // Propiedades del modelo
    public $id_escuela;
    public $nombre;
    public $apellido;
    public $dni;
    public $cuil;
    public $cargo;
    public $fecha_ingreso;
    public $fecha_egreso;
    public $telefono;
    public $email;
    public $direccion;
    public $activo = true;

    public $mensaje = '';
    public $tipoMensaje = '';

    // Propiedades para beneficiarios SVO
    public $beneficiarios = []; // Array temporal de beneficiarios
    public $parentescos = []; // Lista de parentescos disponibles

    // Propiedades para edición en línea de beneficiarios
    public $beneficiarioEditando = null; // Índice del beneficiario que se está editando en línea
    public $nuevoBeneficiario = false; // Indica si se está agregando un nuevo beneficiario

    // Propiedades para validación
    public $errorBeneficiarios = '';

    protected function rules()
    {
        return [
            'id_escuela' => 'required|integer|exists:escuelas,id_escuela',
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'dni' => [
                'required',
                'string',
                'max:10',
                function ($attribute, $value, $fail) {
                    $query = Empleado::where('dni', $value)
                        ->where('id_escuela', $this->id_escuela);

                    // Si estamos editando, excluir el registro actual
                    if ($this->modo === 'edit' && $this->empleado_id) {
                        $query->where('id_empleado', '!=', $this->empleado_id);
                    }

                    if ($query->exists()) {
                        $fail('Ya existe un empleado con este DNI en la escuela seleccionada.');
                    }
                },
            ],
            'cuil' => 'required|string|max:15',
            'cargo' => 'required|string|max:255',
            'fecha_ingreso' => 'required|date',
            'fecha_egreso' => 'nullable|date|after_or_equal:fecha_ingreso',
            'telefono' => 'required|string|max:50',
            'email' => 'required|email|max:100',
            'direccion' => 'required|string|max:300',
            'activo' => 'boolean',
        ];
    }

    protected function messages()
    {
        return [
            'id_escuela.required' => 'La escuela es obligatoria.',
            'nombre.required' => 'El nombre es obligatorio.',
            'apellido.required' => 'El apellido es obligatorio.',
            'dni.required' => 'El DNI es obligatorio.',
            'cuil.required' => 'El CUIL es obligatorio.',
            'cargo.required' => 'El cargo es obligatorio.',
            'fecha_ingreso.required' => 'La fecha de ingreso es obligatoria.',
            'fecha_egreso.after_or_equal' => 'La fecha de egreso no puede ser anterior a la de ingreso.',
            'telefono.required' => 'El teléfono es obligatorio.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El formato del correo electrónico no es válido.',
            'direccion.required' => 'La dirección es obligatoria.',
        ];
    }

    public function mount($modo = 'create', $empleado_id = null)
    {
        $this->modo = $modo;

        // Cargar datos de parentescos
        $this->parentescos = CatParentesco::orderBy('nombre_parentesco')->get();

        if ($empleado_id) {
            $this->empleado_id = $empleado_id;
            $empleado = Empleado::findOrFail($empleado_id);
            $this->id_escuela = $empleado->id_escuela;
            $this->nombre = $empleado->nombre;
            $this->apellido = $empleado->apellido;
            $this->dni = $empleado->dni;
            $this->cuil = $empleado->cuil;
            $this->cargo = $empleado->cargo;
            $this->fecha_ingreso = $empleado->fecha_ingreso ? $empleado->fecha_ingreso->format('Y-m-d') : null;
            $this->fecha_egreso = $empleado->fecha_egreso ? $empleado->fecha_egreso->format('Y-m-d') : null;
            $this->telefono = $empleado->telefono;
            $this->email = $empleado->email;
            $this->direccion = $empleado->direccion;
            $this->activo = $empleado->activo;

            // Cargar beneficiarios existentes
            $this->cargarBeneficiariosExistentes();
        } else {
            $usuario = Auth::user();
            if ($usuario && $usuario->id_rol == 1) {
                $this->id_escuela = $usuario->id_escuela;
            }
        }
    }

    public function render()
    {
        $escuelas = Escuela::orderBy('nombre')->get();
        return view('livewire.empleados.form', compact('escuelas'));
    }

    public function guardar()
    {
        if ($this->modo == 'show') return;

        $this->validate();

        // Validar porcentajes de beneficiarios
        if (!$this->validarPorcentajesTotales()) {
            return;
        }

        // Calcular total de porcentajes para actualizar la vista
        $this->calcularTotalPorcentajes();

        $data = [
            'id_escuela' => $this->id_escuela,
            'nombre' => $this->nombre,
            'apellido' => $this->apellido,
            'dni' => $this->dni,
            'cuil' => $this->cuil,
            'cargo' => $this->cargo,
            'fecha_ingreso' => $this->fecha_ingreso,
            'fecha_egreso' => $this->fecha_egreso,
            'telefono' => $this->telefono,
            'email' => $this->email,
            'direccion' => $this->direccion,
            'activo' => $this->activo,
        ];

        DB::beginTransaction();
        try {
            if ($this->modo == 'create') {
                $empleado = Empleado::create($data);
                $this->empleado_id = $empleado->id_empleado;
                AuditoriaService::registrarCreacion('empleados', $empleado->id_empleado, $data);

                $this->mensaje = 'Empleado creado exitosamente.';
                $this->tipoMensaje = 'success';

            } else {
                $empleado = Empleado::findOrFail($this->empleado_id);
                $datosAnteriores = $empleado->getOriginal();
                $empleado->update($data);
                AuditoriaService::registrarActualizacion('empleados', $empleado->id_empleado, $datosAnteriores, $data);

                $this->mensaje = 'Empleado actualizado exitosamente.';
                $this->tipoMensaje = 'success';
            }

            // Sincronizar beneficiarios
            $this->sincronizarBeneficiarios($this->empleado_id);

            DB::commit();

            // Calcular total y emitir evento después de guardar exitosamente
            $total = $this->calcularTotalPorcentajes();
            $this->dispatch('totalPorcentajesActualizado', total: $total);

            if ($this->modo == 'create') {
                $this->dispatch('mostrar-mensaje-y-redirigir');
            } else {
                $this->dispatch('mostrar-mensaje');
            }

        } catch (\Exception $e) {
            DB::rollback();
            $this->mensaje = 'Error al guardar: ' . $e->getMessage();
            $this->tipoMensaje = 'error';
            $this->dispatch('mostrar-mensaje');
        }
    }

    public function buscarEmpleadoPorDni()
    {
        if (empty($this->dni) || $this->modo !== 'create') {
            return;
        }

        // Buscar empleado existente con este DNI (sin importar la escuela)
        $empleadoExistente = Empleado::where('dni', $this->dni)->first();

        if ($empleadoExistente) {
            // Pre-cargar solo la información personal
            $this->nombre = $empleadoExistente->nombre;
            $this->apellido = $empleadoExistente->apellido;
            $this->telefono = $empleadoExistente->telefono;
            $this->email = $empleadoExistente->email;
            $this->direccion = $empleadoExistente->direccion;

            // Mostrar mensaje informativo
            $this->mostrarMensajeInfo('Se encontraron datos existentes para este DNI. Se han pre-cargado los datos personales.');
        }
    }

    public function limpiarMensaje()
    {
        $this->mensaje = '';
        $this->tipoMensaje = '';
    }

    public function mostrarMensajeInfo($mensaje)
    {
        $this->mensaje = $mensaje;
        $this->tipoMensaje = 'info';
        $this->dispatch('mostrar-mensaje');
    }

    public function redirigirAlListado()
    {
        return redirect()->route('empleados.index');
    }

    // Métodos para gestión de beneficiarios SVO
    private function cargarBeneficiariosExistentes()
    {
        if (!$this->empleado_id) return;

        $beneficiariosExistentes = BeneficiarioSvo::where('id_empleado', $this->empleado_id)
            ->where('activo', true)
            ->with('parentesco')
            ->get();

        foreach ($beneficiariosExistentes as $beneficiario) {
            $this->beneficiarios[] = [
                'id_beneficiario' => $beneficiario->id_beneficiario,
                'nombre' => $beneficiario->nombre,
                'apellido' => $beneficiario->apellido,
                'dni' => $beneficiario->dni,
                'id_parentesco' => $beneficiario->id_parentesco,
                'porcentaje' => (float) $beneficiario->porcentaje, // Mantener como decimal
                'activo' => $beneficiario->activo,
                'parentesco' => $beneficiario->parentesco ? $beneficiario->parentesco->nombre_parentesco : '',
                'es_nuevo' => false, // Indica que ya existe en BD
            ];
        }
    }

    public function agregarFilaBeneficiario()
    {
        $this->beneficiarios[] = [
            'id_beneficiario' => null,
            'nombre' => '',
            'apellido' => '',
            'dni' => '',
            'id_parentesco' => '',
            'porcentaje' => 0.0, // Inicializar como decimal
            'activo' => true,
            'parentesco' => '',
            'es_nuevo' => true,
            'modo_edicion' => true, // Nueva fila siempre en modo edición
        ];
        $this->beneficiarioEditando = count($this->beneficiarios) - 1;
        $this->nuevoBeneficiario = true;
    }

    public function editarBeneficiario($indice)
    {
        if (!isset($this->beneficiarios[$indice])) return;

        // Si hay otra fila en edición, guardarla primero
        if ($this->beneficiarioEditando !== null && $this->beneficiarioEditando !== $indice) {
            $this->guardarEdicionBeneficiario($this->beneficiarioEditando);
        }

        $this->beneficiarios[$indice]['modo_edicion'] = true;
        $this->beneficiarioEditando = $indice;
        $this->nuevoBeneficiario = false;
    }

    public function guardarEdicionBeneficiario($indice)
    {
        if (!isset($this->beneficiarios[$indice])) return;

        $beneficiario = $this->beneficiarios[$indice];

        // Validar campos requeridos
        if (empty($beneficiario['nombre']) || empty($beneficiario['apellido']) ||
            empty($beneficiario['dni']) || empty($beneficiario['id_parentesco']) ||
            $beneficiario['porcentaje'] === '') {
            return; // No guardar si faltan campos requeridos
        }


        // Obtener nombre del parentesco
        $parentesco = collect($this->parentescos)->where('id_parentesco', $beneficiario['id_parentesco'])->first();
        $this->beneficiarios[$indice]['parentesco'] = $parentesco ? $parentesco->nombre_parentesco : '';
        $this->beneficiarios[$indice]['modo_edicion'] = false;
        $this->beneficiarios[$indice]['dni_original'] = $beneficiario['dni']; // Guardar DNI original para validaciones futuras

        $this->beneficiarioEditando = null;
        $this->nuevoBeneficiario = false;
        $this->limpiarErroresBeneficiarios();

        // Calcular porcentajes después de actualizar beneficiario
        $this->actualizarTotalPorcentajes();

        // Emitir evento para recalcular porcentajes en el frontend
        $this->dispatch('beneficiarioActualizado');
    }

    public function cancelarEdicionBeneficiario($indice)
    {
        if (!isset($this->beneficiarios[$indice])) return;

        // Si es un beneficiario nuevo, eliminarlo
        if ($this->beneficiarios[$indice]['es_nuevo']) {
            unset($this->beneficiarios[$indice]);
            $this->beneficiarios = array_values($this->beneficiarios);
        } else {
            // Restaurar valores originales si existen
            $this->beneficiarios[$indice]['modo_edicion'] = false;
        }

        $this->beneficiarioEditando = null;
        $this->nuevoBeneficiario = false;
        $this->limpiarErroresBeneficiarios();
    }

    public function eliminarBeneficiario($indice)
    {
        if (!isset($this->beneficiarios[$indice])) return;

        // Si hay una edición en curso, cancelarla
        if ($this->beneficiarioEditando === $indice) {
            $this->beneficiarioEditando = null;
            $this->nuevoBeneficiario = false;
        }

        // Si es un beneficiario existente en BD, marcarlo como inactivo
        if (isset($this->beneficiarios[$indice]['id_beneficiario']) && !$this->beneficiarios[$indice]['es_nuevo']) {
            $this->beneficiarios[$indice]['activo'] = false;
            $this->beneficiarios[$indice]['marcado_para_eliminar'] = true;
        } else {
            // Si es nuevo, simplemente removerlo del array
            unset($this->beneficiarios[$indice]);
            $this->beneficiarios = array_values($this->beneficiarios); // Reindexar
        }
    }

    private function limpiarErroresBeneficiarios()
    {
        $this->errorBeneficiarios = '';
        $this->resetValidation([
            'beneficiario_nombre',
            'beneficiario_apellido',
            'beneficiario_dni',
            'beneficiario_id_parentesco',
            'beneficiario_porcentaje'
        ]);
    }

    private function validarPorcentajesTotales()
    {
        $totalPorcentaje = 0;
        foreach ($this->beneficiarios as $beneficiario) {
            if (($beneficiario['activo'] ?? true) && !($beneficiario['marcado_para_eliminar'] ?? false)) {
                $totalPorcentaje += (float) $beneficiario['porcentaje'];
            }
        }

        if ($totalPorcentaje != 100) {
            $this->errorBeneficiarios = "La suma de los porcentajes de los beneficiarios debe ser exactamente 100%. Actualmente es: {$totalPorcentaje}%.";
            return false;
        }

        return true;
    }

    private function sincronizarBeneficiarios($idEmpleado)
    {
        foreach ($this->beneficiarios as $beneficiario) {
            $datosBeneficiario = [
                'id_empleado' => $idEmpleado,
                'id_escuela' => $this->id_escuela,
                'nombre' => $beneficiario['nombre'],
                'apellido' => $beneficiario['apellido'],
                'dni' => $beneficiario['dni'],
                'id_parentesco' => $beneficiario['id_parentesco'],
                'porcentaje' => $beneficiario['porcentaje'],
                'activo' => $beneficiario['activo'] ?? true,
            ];

            if (isset($beneficiario['marcado_para_eliminar']) && $beneficiario['marcado_para_eliminar']) {
                // Marcar como inactivo en BD
                if (isset($beneficiario['id_beneficiario'])) {
                    $beneficiarioExistente = BeneficiarioSvo::find($beneficiario['id_beneficiario']);
                    if ($beneficiarioExistente) {
                        $datosAnteriores = $beneficiarioExistente->getOriginal();
                        $beneficiarioExistente->update(['activo' => false]);
                        AuditoriaService::registrarActualizacion('beneficiarios_svo', $beneficiario['id_beneficiario'], $datosAnteriores, ['activo' => false]);
                    }
                }
            } elseif (isset($beneficiario['id_beneficiario']) && !$beneficiario['es_nuevo']) {
                // Actualizar beneficiario existente
                $beneficiarioExistente = BeneficiarioSvo::find($beneficiario['id_beneficiario']);
                if ($beneficiarioExistente) {
                    $datosAnteriores = $beneficiarioExistente->getOriginal();
                    $beneficiarioExistente->update($datosBeneficiario);
                    AuditoriaService::registrarActualizacion('beneficiarios_svo', $beneficiario['id_beneficiario'], $datosAnteriores, $datosBeneficiario);
                }
            } elseif ($beneficiario['es_nuevo']) {
                // Crear nuevo beneficiario
                $datosBeneficiario['fecha_alta'] = now();
                $nuevoBeneficiario = BeneficiarioSvo::create($datosBeneficiario);
                AuditoriaService::registrarCreacion('beneficiarios_svo', $nuevoBeneficiario->id_beneficiario, $datosBeneficiario);
            }
        }
    }

    private function calcularTotalPorcentajes()
    {
        $total = 0;
        foreach ($this->beneficiarios as $beneficiario) {
            if (($beneficiario['activo'] ?? true) && !($beneficiario['marcado_para_eliminar'] ?? false)) {
                $total += (float) $beneficiario['porcentaje'];
            }
        }

        return $total;
    }

    private function actualizarTotalPorcentajes()
    {
        $total = $this->calcularTotalPorcentajes();
        // Actualizar el indicador del total en el JavaScript
        $this->dispatch('totalPorcentajesActualizado', total: $total);
    }
}
