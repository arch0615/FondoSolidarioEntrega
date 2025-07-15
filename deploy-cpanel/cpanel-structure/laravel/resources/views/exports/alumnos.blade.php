<table>
    <thead>
        <tr>
            <th>Apellido</th>
            <th>Nombre</th>
            <th>DNI</th>
            <th>CUIL</th>
            <th>Grado/Curso</th>
            <th>Escuela</th>
            <th>Estado</th>
        </tr>
    </thead>
    <tbody>
        @foreach($alumnos as $alumno)
            <tr>
                <td>{{ $alumno->apellido }}</td>
                <td>{{ $alumno->nombre }}</td>
                <td>{{ $alumno->dni }}</td>
                <td>{{ $alumno->cuil }}</td>
                <td>{{ $alumno->sala_grado_curso }}</td>
                <td>{{ $alumno->escuela->nombre ?? 'N/A' }}</td>
                <td>{{ $alumno->activo ? 'Activo' : 'Inactivo' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>