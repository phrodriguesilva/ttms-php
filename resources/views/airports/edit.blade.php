@extends('layouts.app')

@section('title', 'Editar Aeroporto')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Editar Aeroporto</h1>

    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('airports.update', $airport) }}" method="POST">
                @method('PUT')
                @include('airports.form')
            </form>
        </div>
    </div>
</div>
@endsection
