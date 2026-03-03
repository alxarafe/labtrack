@extends('layout.main')

@section('content')
<div class="container">

    <div class="row g-4 justify-content-center">
        <div class="col-md-4 col-lg-3">
            <a href="{{ $me::url('users') }}" class="btn btn-primary w-100 py-5 shadow-sm d-flex flex-column align-items-center justify-content-center h-100">
                <i class="fas fa-users fa-3x mb-3"></i>
                <span class="fs-4 fw-bold">Usuarios</span>
            </a>
        </div>
        <div class="col-md-4 col-lg-3">
            <a href="{{ $me::url('centers') }}" class="btn btn-primary w-100 py-5 shadow-sm d-flex flex-column align-items-center justify-content-center h-100">
                <i class="fas fa-building fa-3x mb-3"></i>
                <span class="fs-4 fw-bold">Centros de costes</span>
            </a>
        </div>
        <div class="col-md-4 col-lg-3">
            <a href="{{ $me::url('families') }}" class="btn btn-primary w-100 py-5 shadow-sm d-flex flex-column align-items-center justify-content-center h-100">
                <i class="fas fa-tags fa-3x mb-3"></i>
                <span class="fs-4 fw-bold">Familias</span>
            </a>
        </div>
        <div class="col-md-4 col-lg-3">
            <a href="{{ $me::url('processes') }}" class="btn btn-primary w-100 py-5 shadow-sm d-flex flex-column align-items-center justify-content-center h-100">
                <i class="fas fa-cogs fa-3x mb-3"></i>
                <span class="fs-4 fw-bold">Procesos</span>
            </a>
        </div>
        <div class="col-md-4 col-lg-3">
            <a href="{{ $me::url('sequences') }}" class="btn btn-primary w-100 py-5 shadow-sm d-flex flex-column align-items-center justify-content-center h-100">
                <i class="fas fa-list-ol fa-3x mb-3"></i>
                <span class="fs-4 fw-bold">Secuencias</span>
            </a>
        </div>
        <div class="col-md-4 col-lg-3">
            <a href="{{ $me::url('index', [], 'Main') }}" class="btn btn-danger w-100 py-5 shadow-sm d-flex flex-column align-items-center justify-content-center h-100">
                <i class="fas fa-sign-out-alt fa-3x mb-3"></i>
                <span class="fs-4 fw-bold">Salir</span>
            </a>
        </div>
    </div>
</div>

<style>
    .btn-primary {
        background-color: #3498db;
        border-color: #3498db;
        transition: transform 0.2s, background-color 0.2s;
    }
    .btn-primary:hover {
        background-color: #2980b9;
        transform: scale(1.05);
    }
    .btn-danger {
        transition: transform 0.2s;
    }
    .btn-danger:hover {
        transform: scale(1.05);
    }
</style>
@endsection
