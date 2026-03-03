@extends('layout.main')

@section('content')
<div class="container-fluid px-4">

    <form action="{{ $me::url('saveUsers') }}" method="POST">
        <div class="card shadow-sm mb-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="operatorsTable">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 100px;">ID / PIN</th>
                                <th>Nombre</th>
                                <th class="text-center" style="width: 120px;">Admin</th>
                                <th class="text-center" style="width: 120px;">Supervisor</th>
                                <th class="text-center" style="width: 120px;">Desactivado</th>
                                <th style="width: 50px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($operators as $operator)
                            <tr>
                                <td>
                                    <input type="text" name="id[]" class="form-control text-center" value="{{ $operator->id }}" readonly>
                                    <input type="hidden" name="pin[]" value="{{ $operator->pin }}">
                                </td>
                                <td>
                                    <input type="text" name="name[]" class="form-control" value="{{ $operator->name }}" required>
                                </td>
                                <td class="text-center">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="admin[]" value="1" {{ $operator->isAdmin ? 'checked' : '' }}>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="supervisor[]" value="1" {{ $operator->isSupervisor ? 'checked' : '' }}>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="form-check form-check-inline text-danger">
                                        <input class="form-check-input border-danger" type="checkbox" name="off[]" value="1" {{ !$operator->active ? 'checked' : '' }}>
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
                    <i class="fas fa-plus me-2"></i>Nuevo Operario
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

<template id="operatorRowTemplate">
    <tr>
        <td>
            <input type="text" name="id[]" class="form-control text-center" value="0" placeholder="Auto">
            <input type="hidden" name="pin[]" value="">
        </td>
        <td>
            <input type="text" name="name[]" class="form-control" value="" required placeholder="Nombre completo">
        </td>
        <td class="text-center">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="admin[]" value="1">
            </div>
        </td>
        <td class="text-center">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="supervisor[]" value="1">
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
    const tableBody = document.querySelector('#operatorsTable tbody');
    const template = document.getElementById('operatorRowTemplate');

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
