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
        // Insertar datos en escuelas
        DB::table('escuelas')->updateOrInsert(
            ['id_escuela' => 1],
            [
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
        DB::table('escuelas')->updateOrInsert(
            ['id_escuela' => 2],
            [
                'codigo_escuela' => 'ESC002',
                'nombre' => 'Instituto Belgrano',
                'direccion' => 'Calle Secundaria 456',
                'telefono' => '987-654321',
                'email' => 'escuela2@jaec.edu.ar',
                'aporte_por_alumno' => 65.00,
                'fecha_alta' => '2025-05-29',
                'activo' => 1
            ]
        );

        // Insertar datos en prestadores
        $prestadores = [
            [
                'id_prestador' => 1, 'nombre' => 'Clínica del Sol', 'es_sistema_emergencias' => 0, 'direccion' => 'Calle Falsa 123', 'telefono' => '111-222333', 'email' => 'info@clinicasol.com', 'especialidades' => 'Pediatría, Traumatología', 'activo' => 1, 'id_tipo_prestador' => 1
            ],
            [
                'id_prestador' => 2, 'nombre' => 'Emergencias JAEC', 'es_sistema_emergencias' => 1, 'direccion' => 'Av. Siempreviva 742', 'telefono' => '0800-EMER-JAEC', 'email' => 'emergencias@jaec.com.ar', 'especialidades' => 'Atención Primaria de Urgencias', 'activo' => 1, 'id_tipo_prestador' => 7
            ]
        ];
        foreach ($prestadores as $prestador) {
            DB::table('prestadores')->updateOrInsert(['id_prestador' => $prestador['id_prestador']], $prestador);
        }

        // Insertar datos en usuarios
        $usuarios = [
            ['id_usuario' => 1, 'email' => 'admin@prueba.com', 'password' => Hash::make('password123'), 'nombre' => 'Admin', 'apellido' => 'Sistema', 'id_rol' => 2, 'id_escuela' => null, 'fecha_registro' => now(), 'email_verificado' => 1, 'activo' => 1],
            ['id_usuario' => 2, 'email' => 'medico@prueba.com', 'password' => Hash::make('password123'), 'nombre' => 'Medico', 'apellido' => 'Auditor', 'id_rol' => 3, 'id_escuela' => null, 'fecha_registro' => now(), 'email_verificado' => 1, 'activo' => 1],
            ['id_usuario' => 3, 'email' => 'user@prueba.com', 'password' => Hash::make('password123'), 'nombre' => 'Usuario', 'apellido' => 'Escuela1', 'id_rol' => 1, 'id_escuela' => 1, 'fecha_registro' => now(), 'email_verificado' => 1, 'activo' => 1],
            ['id_usuario' => 4, 'email' => 'user2@prueba.com', 'password' => Hash::make('password123'), 'nombre' => 'Usuario2', 'apellido' => 'Escuela2', 'id_rol' => 1, 'id_escuela' => 2, 'fecha_registro' => now(), 'email_verificado' => 1, 'activo' => 1],
        ];
        foreach ($usuarios as $usuario) {
            DB::table('usuarios')->updateOrInsert(['email' => $usuario['email']], $usuario);
        }

        // Insertar datos en alumnos
        $alumnos = [
            ['id_alumno' => 1, 'id_escuela' => 1, 'nombre' => 'Juan', 'apellido' => 'Perez', 'dni' => '12345678', 'cuil' => '20-12345678-1', 'sala_grado_curso' => '5to Grado A', 'familiar1' => 'Maria Lopez', 'parentesco1' => 'Madre', 'telefono_contacto1' => '111-111111', 'familiar2' => 'Pedro Lopez', 'parentesco2' => 'Padre', 'telefono_contacto2' => '111-111112', 'familiar3' => 'Ana Lopez', 'parentesco3' => 'Tía', 'telefono_contacto3' => '111-111113', 'fecha_nacimiento' => '2010-05-15', 'activo' => 1],
            ['id_alumno' => 2, 'id_escuela' => 1, 'nombre' => 'Ana', 'apellido' => 'Gomez', 'dni' => '23456789', 'cuil' => '27-23456789-5', 'sala_grado_curso' => '5to Grado A', 'familiar1' => 'Carlos Gomez', 'parentesco1' => 'Padre', 'telefono_contacto1' => '222-222222', 'familiar2' => 'Laura Gomez', 'parentesco2' => 'Madre', 'telefono_contacto2' => '222-222223', 'familiar3' => 'Roberto Gomez', 'parentesco3' => 'Abuelo', 'telefono_contacto3' => '222-222224', 'fecha_nacimiento' => '2010-08-20', 'activo' => 1],
            ['id_alumno' => 3, 'id_escuela' => 2, 'nombre' => 'Luis', 'apellido' => 'Martinez', 'dni' => '34567890', 'cuil' => '20-34567890-3', 'sala_grado_curso' => '6to Grado B', 'familiar1' => 'Laura Torres', 'parentesco1' => 'Madre', 'telefono_contacto1' => '333-333333', 'familiar2' => 'Miguel Martinez', 'parentesco2' => 'Padre', 'telefono_contacto2' => '333-333334', 'familiar3' => 'Carmen Torres', 'parentesco3' => 'Abuela', 'telefono_contacto3' => '333-333335', 'fecha_nacimiento' => '2009-03-10', 'activo' => 1],
            ['id_alumno' => 4, 'id_escuela' => 2, 'nombre' => 'Sofia', 'apellido' => 'Rodriguez', 'dni' => '45678901', 'cuil' => '27-45678901-9', 'sala_grado_curso' => '6to Grado B', 'familiar1' => 'Roberto Rodriguez', 'parentesco1' => 'Padre', 'telefono_contacto1' => '444-444444', 'familiar2' => 'Maria Rodriguez', 'parentesco2' => 'Madre', 'telefono_contacto2' => '444-444445', 'familiar3' => 'Luis Rodriguez', 'parentesco3' => 'Tío', 'telefono_contacto3' => '444-444446', 'fecha_nacimiento' => '2009-11-25', 'activo' => 1],
        ];
        foreach ($alumnos as $alumno) {
            DB::table('alumnos')->updateOrInsert(['id_alumno' => $alumno['id_alumno']], $alumno);
        }

        // Insertar datos en accidentes
        $accidentes = [
            ['id_accidente' => 1, 'id_escuela' => 1, 'fecha_accidente' => now()->subDays(10), 'hora_accidente' => '10:30:00', 'lugar_accidente' => 'Patio de juegos', 'descripcion_accidente' => 'Caída durante el recreo.', 'tipo_lesion' => 'Raspadura en rodilla', 'protocolo_activado' => 1, 'llamada_emergencia' => 1, 'hora_llamada' => '10:35:00', 'servicio_emergencia' => 'Emergencias JAEC', 'id_estado_accidente' => 1, 'fecha_carga' => now(), 'id_usuario_carga' => 3],
            ['id_accidente' => 2, 'id_escuela' => 2, 'fecha_accidente' => now()->subDays(5), 'hora_accidente' => '14:15:00', 'lugar_accidente' => 'Gimnasio', 'descripcion_accidente' => 'Golpe con una pelota en clase de educación física.', 'tipo_lesion' => 'Contusión en el brazo', 'protocolo_activado' => 1, 'llamada_emergencia' => 1, 'hora_llamada' => '14:20:00', 'servicio_emergencia' => 'Emergencias JAEC', 'id_estado_accidente' => 1, 'fecha_carga' => now(), 'id_usuario_carga' => 4],
        ];
        foreach ($accidentes as $accidente) {
            DB::table('accidentes')->updateOrInsert(['id_accidente' => $accidente['id_accidente']], $accidente);
        }

        // Insertar relaciones accidente_alumnos
        $accidente_alumnos = [
            ['id_accidente' => 1, 'id_alumno' => 1],
            ['id_accidente' => 1, 'id_alumno' => 2],
            ['id_accidente' => 2, 'id_alumno' => 3],
            ['id_accidente' => 2, 'id_alumno' => 4],
        ];
        foreach ($accidente_alumnos as $relacion) {
            DB::table('accidente_alumnos')->updateOrInsert($relacion);
        }
    }
}
