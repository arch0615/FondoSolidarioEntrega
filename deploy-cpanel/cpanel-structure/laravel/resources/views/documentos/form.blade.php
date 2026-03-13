@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <livewire:documentos.form :modo="$modo" :documento_id="$documento_id ?? null" />
</div>
@endsection