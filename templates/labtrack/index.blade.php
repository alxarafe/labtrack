@extends('layout.main')

@section('content')
<div class="container mt-5">
    <div class="jumbotron">
        <h1 class="display-4">{{ $title }}</h1>
        <p class="lead">{{ $message }}</p>
        <hr class="my-4">
        <p>Este es el punto de partida de la nueva versión de LabTrack basada en el Alxarafe Microframework.</p>
        <a class="btn btn-primary btn-lg" href="#" role="button">Comenzar</a>
    </div>
</div>
@endsection
