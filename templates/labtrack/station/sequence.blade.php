@extends('layout.main')

@section('content')
<div class="container py-4">
    <div class="mb-5">
        <h1 class="display-5 fw-bold">{{ $title }}</h1>
        <div class="d-flex gap-3 flex-wrap">
             <span class="badge bg-secondary py-2 px-3 fs-6">Orden: #{{ $_SESSION['labtrack']['order_id'] }}</span>
             <span class="badge bg-info text-white py-2 px-3 fs-6">Operario: {{ $_SESSION['labtrack']['operator_name'] }}</span>
             <span class="badge bg-primary py-2 px-3 fs-6">Paso 3: Proceso Seleccionado</span>
        </div>
    </div>

    <form action="/record" method="POST" id="recordForm">
        <div class="row g-4 mb-5">
            @foreach($sequences as $sequence)
            <div class="col-6 col-md-4 col-lg-3">
                <input type="radio" class="btn-check" name="sequence_id" id="seq_{{ $sequence->id }}" value="{{ $sequence->id }}" required 
                       data-duration="{{ $sequence->duration_minutes }}" data-editable="{{ $sequence->duration_editable ? '1' : '0' }}">
                <label class="btn btn-outline-warning w-100 py-5 fs-4 shadow-sm border-2 rounded-4 transition-hover d-flex align-items-center justify-content-center text-dark" for="seq_{{ $sequence->id }}">
                    {{ $sequence->button_text ?: $sequence->name }}
                </label>
            </div>
            @endforeach
        </div>

        <div class="card shadow-lg border-0 bg-light rounded-4 mb-5 d-none" id="detailsSection">
            <div class="card-body p-4">
                <div class="row align-items-end g-4">
                    <div class="col-md-4">
                        <label class="form-label fs-5 fw-bold">Unidades Terminadas</label>
                        <div class="input-group input-group-lg">
                            <button class="btn btn-outline-secondary" type="button" onclick="changeVal('units', -1)">-</button>
                            <input type="number" name="units" id="units" class="form-control text-center fs-2 fw-bold" value="1" min="1">
                            <button class="btn btn-outline-secondary" type="button" onclick="changeVal('units', 1)">+</button>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fs-5 fw-bold">Duración (Minutos)</label>
                        <div class="input-group input-group-lg">
                            <button class="btn btn-outline-secondary" type="button" onclick="changeVal('duration', -5)">-</button>
                            <input type="number" name="duration" id="duration" class="form-control text-center fs-2 fw-bold" value="0">
                            <button class="btn btn-outline-secondary" type="button" onclick="changeVal('duration', 5)">+</button>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-success w-100 py-3 fs-3 shadow rounded-pill">
                            <i class="fas fa-save me-2"></i>REGISTRAR
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div class="mt-4 pt-4 border-top">
        <a href="/family/{{ $_SESSION['labtrack']['family_id'] }}/processes" class="btn btn-secondary px-5 py-3 fs-5 shadow-sm rounded-pill">
            <i class="fas fa-arrow-left me-2"></i>Volver
        </a>
    </div>
</div>

<script>
function changeVal(id, delta) {
    const el = document.getElementById(id);
    el.value = Math.max(0, parseInt(el.value) + delta);
}

document.addEventListener('DOMContentLoaded', function() {
    const checks = document.querySelectorAll('.btn-check');
    const section = document.getElementById('detailsSection');
    const durationInput = document.getElementById('duration');

    checks.forEach(check => {
        check.addEventListener('change', function() {
            if (this.checked) {
                section.classList.remove('d-none');
                const defaultDuration = this.getAttribute('data-duration');
                const isEditable = this.getAttribute('data-editable') === '1';
                
                durationInput.value = defaultDuration;
                durationInput.readOnly = !isEditable;

                // Scroll to section
                section.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        });
    });
});
</script>

<style>
    .btn-check:checked + .btn-outline-warning {
        background-color: #ffc107 !important;
        color: white !important;
        transform: scale(1.1);
        border-color: #ffc107 !important;
        z-index: 10;
        box-shadow: 0 1rem 2rem rgba(255, 193, 7, 0.3) !important;
    }
    .transition-hover { transition: all 0.2s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
    .rounded-4 { border-radius: 1.5rem; }
</style>
@endsection
