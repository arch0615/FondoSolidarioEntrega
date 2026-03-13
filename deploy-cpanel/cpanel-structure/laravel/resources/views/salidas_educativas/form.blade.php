@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <livewire:salidas-educativas.form :modo="$modo" :salida_id="$salida_id ?? null" />
</div>
@endsection