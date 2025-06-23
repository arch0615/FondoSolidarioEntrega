@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <livewire:reintegros.form :modo="$modo" :reintegro_id="$reintegro_id ?? null" />
</div>
@endsection