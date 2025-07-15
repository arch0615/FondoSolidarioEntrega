@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <livewire:beneficiarios-svo.form :modo="$modo" :beneficiario_id="$beneficiario_id ?? null" />
</div>
@endsection