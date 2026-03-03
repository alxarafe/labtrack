@extends('layout.main')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h3 class="card-title">
                        <i class="fas fa-plus-circle me-2"></i>{{ $me->_('new_order') }}
                    </h3>
                </div>
                <div class="card-body">
                    <form action="{{ $me::url('save') }}" method="POST">
                        <div class="mb-3">
                            <label for="id" class="form-label">{{ $me->_('order_number') }}</label>
                            <input type="text" name="id" id="id" class="form-control" value="{{ $orderId }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">{{ $me->_('order_name_customer') }}</label>
                            <input type="text" name="name" id="name" class="form-control form-control-lg" 
                                   placeholder="{{ $me->_('enter_order_name') }}" required autofocus>
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="{{ $me::url('index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-1"></i>{{ $me->_('back') }}
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save me-1"></i>{{ $me->_('save_order') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
