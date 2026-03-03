@extends('layout.main')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title">
                        <i class="fas fa-chart-bar me-2"></i>{{ $me->_('reports') }}
                    </h3>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-3">
                        <a href="{{ $me::url('user') }}" class="btn btn-outline-primary btn-lg p-4">
                            <i class="fas fa-user-chart fa-2x mb-2 d-block"></i>
                            {{ $me->_('user_report') }}
                        </a>
                        <a href="{{ $me::url('order') }}" class="btn btn-outline-info btn-lg p-4 text-dark">
                            <i class="fas fa-file-invoice fa-2x mb-2 d-block"></i>
                            {{ $me->_('order_report') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
