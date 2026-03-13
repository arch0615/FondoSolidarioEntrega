@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <livewire:prestadores.form :modo="$modo" :prestador_id="$prestador_id ?? null" />
</div>
@endsection