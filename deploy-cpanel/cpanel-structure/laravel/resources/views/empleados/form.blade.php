@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <livewire:empleados.form :modo="$modo" :empleado_id="$empleado_id ?? null" />
</div>
@endsection