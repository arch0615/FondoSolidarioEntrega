<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuariosEscuelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Insertar datos en escuelas (solo si no existen)
        DB::table('escuelas')->updateOrInsert(
            ['id_escuela' => 1],
            [
                'id_escuela' => 1,
                'codigo_escuela' => 'ESC001',
                'nombre' => 'Escuela Primaria N° 1',
                'direccion' => 'Av. Principal 123',
                'telefono' => '123-456789',
                'email' => 'escuela1@jaec.edu.ar',
                'aporte_por_alumno' => 50.00,
                'fecha_alta' => '2025-05-29',
                'activo' => 1
            ]
        );

        // Insertar datos en prestadores (solo si no existen)
        $prestadores = [
            [
                'id_prestador' => 1,
                'nombre' => 'Clínica del Sol',
                'es_sistema_emergencias' => 0,
                'direccion' => 'Calle Falsa 123',
                'telefono' => '111-222333',
                'email' => 'info@clinicasol.com',
                'especialidades' => 'Pediatría, Traumatología',
                'activo' => 1,
                'id_tipo_prestador' => 1
            ],
            [
                'id_prestador' => 2,
                'nombre' => 'Emergencias JAEC',
                'es_sistema_emergencias' => 1,
                'direccion' => 'Av. Siempreviva 742',
                'telefono' => '0800-EMER-JAEC',
                'email' => 'emergencias@jaec.com.ar',
                'especialidades' => 'Atención Primaria de Urgencias',
                'activo' => 1,
                'id_tipo_prestador' => 7
            ]
        ];
        foreach ($prestadores as $prestador) {
            DB::table('prestadores')->updateOrInsert(
                ['id_prestador' => $prestador['id_prestador']],
                $prestador
            );
        }

        // Insertar datos en usuarios (solo si no existen)
        $usuarios = [
            [
                'id_usuario' => 1,
                'email' => 'admin@prueba.com',
                'password' => Hash::make('password123'),
                'nombre' => 'Admin',
                'apellido' => 'Sistema',
                'id_rol' => 2,
                'id_escuela' => null,
                'fecha_registro' => '2025-05-29 15:09:35',
                'email_verificado' => 1,
                'token_verificacion' => null,
                'activo' => 1
            ],
            [
                'id_usuario' => 2,
                'email' => 'medico@prueba.com',
                'password' => Hash::make('password123'),
                'nombre' => 'Medico',
                'apellido' => 'Auditor',
                'id_rol' => 3,
                'id_escuela' => null,
                'fecha_registro' => '2025-05-29 15:09:35',
                'email_verificado' => 1,
                'token_verificacion' => null,
                'activo' => 1
            ],
            [
                'id_usuario' => 3,
                'email' => 'user@prueba.com',
                'password' => Hash::make('password123'),
                'nombre' => 'Usuario',
                'apellido' => 'Escuela1',
                'id_rol' => 1,
                'id_escuela' => 1,
                'fecha_registro' => '2025-05-29 15:09:35',
                'email_verificado' => 1,
                'token_verificacion' => null,
                'activo' => 1
            ],
            [
                'id_usuario' => 4,
                'email' => 'test@prueba.com',
                'password' => Hash::make('password123'),
                'nombre' => 'Usuario',
                'apellido' => 'Prueba',
                'id_rol' => 1,
                'id_escuela' => 1,
                'fecha_registro' => '2025-05-31 14:38:35',
                'email_verificado' => 1,
                'token_verificacion' => null,
                'activo' => 1
            ]
        ];
        foreach ($usuarios as $usuario) {
            DB::table('usuarios')->updateOrInsert(
                ['email' => $usuario['email']], // Usar email como clave única
                $usuario
            );
        }

        // Insertar datos en alumnos (solo si no existe)
        DB::table('alumnos')->updateOrInsert(
            ['id_alumno' => 1],
            [
                'id_alumno' => 1,
                'id_escuela' => 1,
                'nombre' => 'Juan',
                'apellido' => 'Perez',
                'dni' => '12345678',
                'cuil' => '20-12345678-1',
                'sala_grado_curso' => '5to Grado',
                'nombre_padre_madre' => 'Maria Lopez',
                'telefono_contacto' => '987-654321',
                'fecha_nacimiento' => '2010-05-15',
                'activo' => 1,
                'id_seccion' => 1
            ]
        );
    }
}
