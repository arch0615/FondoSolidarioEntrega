<table>
    <thead>
        <tr>
            <th>Empleado Titular</th>
            <th>DNI Empleado</th>
            <th>Escuela</th>
            <th>Beneficiario</th>
            <th>DNI Beneficiario</th>
            <th>Parentesco</th>
            <th>Porcentaje</th>
            <th>Estado</th>
            <th>Fecha de Alta</th>
        </tr>
    </thead>
    <tbody>
        @foreach($beneficiarios as $beneficiario)
            <tr>
                <td>{{ $beneficiario->empleado->nombre_completo ?? 'N/A' }}</td>
                <td>{{ $beneficiario->empleado->dni ?? 'N/A' }}</td>
                <td>{{ $beneficiario->escuela->nombre ?? 'N/A' }}</td>
                <td>{{ $beneficiario->nombre }} {{ $beneficiario->apellido }}</td>
                <td>{{ $beneficiario->dni }}</td>
                <td>{{ $beneficiario->parentesco->nombre_parentesco ?? 'N/A' }}</td>
                <td>{{ $beneficiario->porcentaje }}%</td>
                <td>{{ $beneficiario->activo ? 'Activo' : 'Inactivo' }}</td>
                <td>{{ $beneficiario->fecha_alta ? $beneficiario->fecha_alta->format('d/m/Y') : 'N/A' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>