@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <livewire:usuarios.form :modo="$modo" :usuario_id="$usuario_id ?? null" />
</div>
@endsection