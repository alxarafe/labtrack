@extends('layout.main')

@section('content')
<div class="container">

    <form action="{{ $me::url('saveProcessFamilies', ['processId' => $process->id]) }}" method="POST">
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <div class="row g-3">
                    @foreach($families as $family)
                    <div class="col-md-4 col-lg-3">
                        <div class="form-check p-3 border rounded h-100 family-card transition-all">
                            <input class="form-check-input ms-0 me-2" type="checkbox" name="families[]" value="{{ $family->id }}" id="family_{{ $family->id }}" {{ in_array($family->id, $marked) ? 'checked' : '' }}>
                            <label class="form-check-label w-100 cursor-pointer" for="family_{{ $family->id }}">
                                <span class="d-block fw-bold">{{ $family->name }}</span>
                                <small class="text-muted">{{ $family->costCenter->name ?? '' }}</small>
                            </label>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-success shadow-sm px-5 py-2 me-2">
                <i class="fas fa-save me-2"></i>Guardar Cambios
            </button>
            <a href="{{ $me::url('processes') }}" class="btn btn-secondary shadow-sm px-4 py-2">
                <i class="fas fa-arrow-left me-2"></i>Volver
            </a>
        </div>
    </form>
</div>
@endsection
