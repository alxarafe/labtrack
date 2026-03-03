@extends('layout.main')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="display-6 fw-bold mb-0">{{ $title }}</h1>
            <p class="text-muted">Operario: <strong>{{ $_SESSION['labtrack']['operator_name'] }}</strong></p>
        </div>
        <x-component.button variant="outline-danger" :href="$me::url('logout')" class="shadow-sm px-4">
            <i class="fas fa-sign-out-alt me-2"></i>Cerrar Sesión
        </x-component.button>
    </div>

    <x-component.card class="shadow-sm border-0 mb-4" style="border-radius: 15px;">
        <h5 class="card-title mb-4">Seleccione una orden reciente o cree una nueva</h5>
        
        <div class="row g-3">
            @foreach($orders as $order)
            <div class="col-md-6 col-lg-4">
                <x-form.form action="{{ $me::url('selectCenter') }}" method="POST">
                    <x-form.hidden name="order_id" :value="$order->id" />
                    <x-component.button variant="light" type="submit" class="w-100 p-4 text-start border shadow-sm transition-hover">
                        <span class="d-block fs-5 fw-bold mb-1">{{ $order->name }}</span>
                        <small class="text-muted">ID: #{{ $order->id }}</small>
                    </x-component.button>
                </x-form.form>
            </div>
            @endforeach

            <div class="col-md-6 col-lg-4">
                <x-component.button variant="primary" class="w-100 p-4 text-center border shadow-sm transition-hover h-100 d-flex flex-column align-items-center justify-content-center" data-bs-toggle="modal" data-bs-target="#newOrderModal">
                    <i class="fas fa-plus fa-2x mb-2"></i>
                    <span class="fs-5 fw-bold">Nueva Orden</span>
                </x-component.button>
            </div>
        </div>
    </x-component.card>
</div>

<!-- Modal para Nueva Orden -->
<div class="modal fade" id="newOrderModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius: 15px;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Nueva Orden</h5>
                <x-component.closebutton data-bs-dismiss="modal" />
            </div>
            <x-form.form action="{{ $me::url('addOrder') }}" method="POST">
                <div class="modal-body p-4">
                    <x-form.input 
                        name="name" 
                        class="form-control-lg" 
                        required 
                        placeholder="Ej: Pedido #452 / Paciente X" 
                        :label="$me->_('order_name_reference')"
                    />
                </div>
                <div class="modal-footer border-0">
                    <x-component.button variant="light" class="px-4" data-bs-dismiss="modal">Cancelar</x-component.button>
                    <x-component.button variant="primary" type="submit" class="px-4">Crear y Continuar</x-component.button>
                </div>
            </x-form.form>
        </div>
    </div>
</div>

<style>
    .transition-hover:hover {
        transform: translateY(-3px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        border-color: #0d6efd !important;
    }
    .transition-hover { transition: all 0.2s ease; }
</style>
@endsection
