@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <livewire:reintegros.form :modo="$modo" :reintegro_id="$reintegro_id ?? null" :id_accidente="$id_accidente ?? null" />
</div>
@endsection