@extends('layout.main')

@section('content')
<div class="container py-4">
    <div class="mb-5">
        <h1 class="display-5 fw-bold">{{ $title }}</h1>
        <div class="d-flex gap-3 flex-wrap">
             <span class="badge bg-secondary py-2 px-3 fs-6">Orden: #{{ $_SESSION['labtrack']['order_id'] }}</span>
             <span class="badge bg-info text-white py-2 px-3 fs-6">Operario: {{ $_SESSION['labtrack']['operator_name'] }}</span>
             <span class="badge bg-primary py-2 px-3 fs-6">Paso 1: Centro Seleccionado</span>
        </div>
    </div>

    <div class="row g-4">
        @foreach($families as $family)
        <div class="col-6 col-md-4 col-lg-3">
            <a href="/family/{{ $family->id }}/processes" class="btn btn-outline-info w-100 py-5 fs-4 shadow-sm border-2 rounded-4 transition-hover d-flex align-items-center justify-content-center text-decoration-none text-dark">
                {{ $family->button_text ?: $family->name }}
            </a>
        </div>
        @endforeach
    </div>

    <div class="mt-5 pt-4 border-top">
        <a href="/center" class="btn btn-secondary px-5 py-3 fs-5 shadow-sm rounded-pill">
            <i class="fas fa-arrow-left me-2"></i>Volver
        </a>
    </div>
</div>

<style>
    .transition-hover:hover {
        background-color: #0dcaf0 !important;
        color: white !important;
        transform: scale(1.05);
        box-shadow: 0 1rem 2rem rgba(13, 202, 240, 0.2) !important;
        border-color: #0dcaf0 !important;
    }
    .transition-hover { transition: all 0.2s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
    .rounded-4 { border-radius: 1.5rem; }
</style>
@endsection
