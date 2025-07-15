@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <livewire:pasantias.form :modo="$modo" :pasantia_id="$pasantia_id ?? null" />
</div>
@endsection