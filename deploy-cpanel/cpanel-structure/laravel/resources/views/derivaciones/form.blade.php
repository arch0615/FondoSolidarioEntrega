@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <livewire:derivaciones.form :modo="$modo" :derivacion_id="$derivacion_id ?? null" :accidente_id="$accidente_id ?? null" />
</div>
@endsection