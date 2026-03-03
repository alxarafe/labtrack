@extends('layout.main')

@section('content')
<div class="container-fluid px-4">

    <form action="{{ $me::url('saveSequences') }}" method="POST">
        <div class="card shadow-sm mb-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="sequencesTable">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 80px;">ID</th>
                                <th style="width: 100px;">Orden</th>
                                <th style="width: 150px;">Procesos</th>
                                <th>Nombre</th>
                                <th>Texto Botón</th>
                                <th style="width: 100px;">Minutos</th>
                                <th class="text-center" style="width: 100px;">Editable</th>
                                <th class="text-center" style="width: 100px;">Desactivado</th>
                                <th style="width: 50px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sequences as $sequence)
                            <tr>
                                <td>
                                    <input type="text" name="id[]" class="form-control text-center" value="{{ $sequence->id }}" readonly>
                                </td>
                                <td>
                                    <input type="number" name="sort_order[]" class="form-control text-center" value="{{ $sequence->sort_order }}" required>
                                </td>
                                <td>
                                    <a href="{{ $me::url('sequences', ['sequenceId' => $sequence->id]) }}" class="btn btn-outline-primary btn-sm w-100">
                                        <i class="fas fa-cogs me-1"></i>Procesos
                                    </a>
                                </td>
                                <td>
                                    <input type="text" name="name[]" class="form-control" value="{{ $sequence->name }}" required>
                                </td>
                                <td>
                                    <input type="text" name="button_text[]" class="form-control" value="{{ $sequence->button_text }}" placeholder="{{ $sequence->name }}">
                                </td>
                                <td>
                                    <input type="number" name="duration_minutes[]" class="form-control text-center" value="{{ $sequence->duration_minutes }}" required>
                                </td>
                                <td class="text-center">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="duration_editable[]" value="1" {{ $sequence->duration_editable ? 'checked' : '' }}>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="form-check form-check-inline text-danger">
                                        <input class="form-check-input border-danger" type="checkbox" name="off[]" value="1" {{ !$sequence->active ? 'checked' : '' }}>
                                    </div>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-link text-danger p-0 delete-row">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between">
            <div>
                <button type="button" id="addRow" class="btn btn-info text-white shadow-sm px-4 py-2">
                    <i class="fas fa-plus me-2"></i>Nueva línea
                </button>
            </div>
            <div>
                <button type="submit" name="guardar" class="btn btn-success shadow-sm px-5 py-2 me-2">
                    <i class="fas fa-check me-2"></i>Aceptar
                </button>
                <a href="{{ $me::url('index') }}" class="btn btn-secondary shadow-sm px-4 py-2">
                    <i class="fas fa-times me-2"></i>Cancelar
                </a>
            </div>
        </div>
    </form>
</div>

<template id="sequenceRowTemplate">
    <tr>
        <td>
            <input type="text" name="id[]" class="form-control text-center" value="0" readonly>
        </td>
        <td>
            <input type="number" name="sort_order[]" class="form-control text-center" value="0" required>
        </td>
        <td>
            <button type="button" class="btn btn-outline-secondary btn-sm w-100" disabled>
                <i class="fas fa-tags me-1"></i>(Guardar primero)
            </button>
        </td>
        <td>
            <input type="text" name="name[]" class="form-control" value="" required>
        </td>
        <td>
            <input type="text" name="button_text[]" class="form-control" value="" placeholder="Nombre del botón">
        </td>
        <td>
            <input type="number" name="duration_minutes[]" class="form-control text-center" value="0" required>
        </td>
        <td class="text-center">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="duration_editable[]" value="1">
            </div>
        </td>
        <td class="text-center">
            <div class="form-check form-check-inline text-danger">
                <input class="form-check-input border-danger" type="checkbox" name="off[]" value="1">
            </div>
        </td>
        <td>
            <button type="button" class="btn btn-link text-danger p-0 delete-row">
                <i class="fas fa-trash"></i>
            </button>
        </td>
    </tr>
</template>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tableBody = document.querySelector('#sequencesTable tbody');
    const template = document.getElementById('sequenceRowTemplate');

    document.getElementById('addRow').addEventListener('click', function() {
        const clone = template.content.cloneNode(true);
        tableBody.appendChild(clone);
    });

    tableBody.addEventListener('click', function(e) {
        if (e.target.closest('.delete-row')) {
            if (confirm('¿Está seguro de que desea eliminar esta fila?')) {
                e.target.closest('tr').remove();
            }
        }
    });
});
</script>
@endsection
