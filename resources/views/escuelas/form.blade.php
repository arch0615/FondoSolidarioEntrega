@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <livewire:escuelas.form :modo="$modo" :escuela_id="$escuela_id ?? null" />
</div>
@endsection