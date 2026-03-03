@extends('layout.main')

@section('content')
<div class="container d-flex align-items-center justify-content-center" style="min-height: 80vh;">
    <x-component.card class="shadow-lg border-0" style="width: 100%; max-width: 400px; border-radius: 20px;">
        <div class="p-5 text-center">
            <div class="mb-4">
                <i class="fas fa-microscope fa-4x text-primary mb-3"></i>
                <h2 class="fw-bold">{{ $me->_('station_identification') }}</h2>
                <p class="text-muted">Introduce tu PIN para comenzar</p>
            </div>

            @if(isset($error))
                <x-component.alert type="danger" class="mb-4 py-2 small">
                    {{ $error }}
                </x-component.alert>
            @endif

            <x-form.form action="/login" method="POST" id="pinForm">
                <x-form.input 
                    type="password" 
                    name="pin" 
                    id="pinInput" 
                    class="text-center mb-4 tracking-widest fw-bold border-0 bg-light" 
                    placeholder="••••" 
                    maxlength="10" 
                    readonly 
                />
                
                <div class="row g-2 mb-4">
                    @for($i = 1; $i <= 9; $i++)
                    <div class="col-4">
                        <x-component.button variant="light" class="w-100 py-3 fs-3 rounded-4 pin-btn border shadow-sm" data-val="{{ $i }}">
                            {{ $i }}
                        </x-component.button>
                    </div>
                    @endfor
                    <div class="col-4">
                        <x-component.button variant="danger" class="w-100 py-3 rounded-4 pin-btn d-flex flex-column align-items-center justify-content-center h-100 shadow-sm" data-val="C">
                            <i class="fas fa-backspace mb-1"></i>
                            <small class="fw-bold text-uppercase" style="font-size: 0.65rem;">{{ $me->_('clear') }}</small>
                        </x-component.button>
                    </div>
                    <div class="col-4">
                        <x-component.button variant="light" class="w-100 py-4 fs-4 rounded-4 pin-btn border shadow-sm" data-val="0">
                            0
                        </x-component.button>
                    </div>
                    <div class="col-4">
                        <x-component.button variant="primary" type="submit" class="w-100 py-3 rounded-4 d-flex flex-column align-items-center justify-content-center h-100">
                            <i class="fas fa-check mb-1"></i>
                            <small class="fw-bold text-uppercase" style="font-size: 0.65rem;">{{ $me->_('enter') }}</small>
                        </x-component.button>
                    </div>
                </div>
            </x-form.form>
        </div>
    </x-component.card>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const input = document.getElementById('pinInput');
    const btns = document.querySelectorAll('.pin-btn');

    btns.forEach(btn => {
        btn.addEventListener('click', () => {
            const val = btn.getAttribute('data-val');
            if (val === 'C') {
                input.value = input.value.slice(0, -1);
            } else {
                if (input.value.length < 10) {
                    input.value += val;
                }
            }
        });
    });
});
</script>

<style>
    #pinInput { letter-spacing: 0.5rem; font-size: 2rem; box-shadow: none !important; }
    .pin-btn:active { background-color: #0d6efd !important; color: white !important; }
    .tracking-widest { letter-spacing: 0.5em; }
</style>
@endsection
