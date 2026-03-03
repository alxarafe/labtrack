@extends('layout.main')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <x-component.card class="shadow">
                <x-slot:header>
                    <h3 class="card-title">
                        <i class="fas fa-search me-2"></i>{{ $me->_('order_search') }}
                    </h3>
                </x-slot:header>

                <x-form.form method="POST" :action="$me::url('index')">
                    <x-form.input 
                        name="order" 
                        id="order" 
                        :label="$me->_('order_number')"
                        class="form-control-lg" 
                        :placeholder="$me->_('enter_order_number')" 
                        required 
                        autofocus 
                    />
                    <div class="d-grid gap-2">
                        <x-component.button variant="primary" type="submit" name="search" class="btn-lg">
                            {{ $me->_('search') }}
                        </x-component.button>
                        <x-component.button variant="outline-danger" :href="$me::url('logout')">
                            {{ $me->_('exit') }}
                        </x-component.button>
                    </div>
                </x-form.form>
            </x-component.card>
        </div>
    </div>
</div>
@endsection
