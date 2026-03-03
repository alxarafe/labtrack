@extends('layout.main')

@section('content')
<div class="container">

    <form action="{{ $me::url('saveSequenceProcesses', ['sequenceId' => $sequence->id]) }}" method="POST">
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <div class="row g-3">
                    @foreach($processes as $process)
                    <div class="col-md-4 col-lg-3">
                        <div class="form-check p-3 border rounded h-100 process-card transition-all">
                            <input class="form-check-input ms-0 me-2" type="checkbox" name="processes[]" value="{{ $process->id }}" id="process_{{ $process->id }}" {{ in_array($process->id, $marked) ? 'checked' : '' }}>
                            <label class="form-check-label w-100 cursor-pointer" for="process_{{ $process->id }}">
                                <span class="d-block fw-bold">{{ $process->name }}</span>
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
            <a href="{{ $me::url('sequences') }}" class="btn btn-secondary shadow-sm px-4 py-2">
                <i class="fas fa-arrow-left me-2"></i>Volver
            </a>
        </div>
    </form>
</div>

<style>
    .process-card { cursor: pointer; border-color: #dee2e6; }
    .process-card:hover { border-color: #3498db; background-color: #f7fbff; }
    .process-card:has(.form-check-input:checked) { border-color: #3498db; background-color: #ebf5fb; }
    .transition-all { transition: all 0.2s ease; }
    .cursor-pointer { cursor: pointer; }
</style>
@endsection
