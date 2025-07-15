@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <livewire:alumnos.form :modo="$modo" :alumno_id="$alumno_id ?? null" />
</div>
@endsection