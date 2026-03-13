@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <livewire:accidentes.form :modo="$modo" :accidente_id="$accidente_id ?? null" />
</div>
@endsection