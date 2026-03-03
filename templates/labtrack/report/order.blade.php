@extends('layout.main')

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <!-- Filter Card -->
        <div class="col-12 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <form action="{{ $me::url('order') }}" method="POST" class="row g-3 align-items-end">
                        <div class="col-md-4">
                            <label class="form-label fw-bold">{{ $me->_('order_number') }}</label>
                            <input type="text" name="order_id" class="form-control" value="{{ $orderId }}" placeholder="{{ $me->_('enter_order_number') }}" required>
                        </div>
                        <div class="col-md-3 d-flex gap-2">
                            <button type="submit" name="accept" class="btn btn-info flex-grow-1 text-dark">
                                <i class="fas fa-search me-1"></i>{{ $me->_('accept') }}
                            </button>
                            <a href="{{ $me::url('index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left"></i>
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @if(!empty($report))
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-file-invoice me-2"></i>{{ $me->_('order') }}: {{ $orderId }}
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>{{ $me->_('date') }}</th>
                                        <th>{{ $me->_('operator') }}</th>
                                        <th>{{ $me->_('sequence') }} / {{ $me->_('process') }}</th>
                                        <th>{{ $me->_('units') }}</th>
                                        <th>{{ $me->_('duration') }}</th>
                                        <th>{{ $me->_('status') }}</th>
                                        <th class="text-end">{{ $me->_('actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $totalDuration = 0; @endphp
                                    @foreach($report as $movement)
                                        @php $totalDuration += $movement->duration_minutes; @endphp
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($movement->movement_at)->format('d/m/Y H:i') }}</td>
                                            <td>{{ $movement->operator->name ?? $movement->operator_id }}</td>
                                            <td>
                                                <div>{{ $movement->sequence->name ?? $movement->sequence_id }}</div>
                                                <small class="text-muted">{{ $movement->process->name ?? '' }}</small>
                                            </td>
                                            <td>{{ $movement->units }}</td>
                                            <td>{{ $movement->duration_minutes }}'</td>
                                            <td>
                                                @if($movement->supervised_by > 0)
                                                    <span class="badge bg-success">{{ $me->_('verified') }}</span>
                                                @else
                                                    <span class="badge bg-warning text-dark">{{ $me->_('pending') }}</span>
                                                @endif
                                            </td>
                                            <td class="text-end">
                                                @if(!$movement->supervised_by && $isSupervisor)
                                                    <a href="{{ $me::url('validate', ['id' => $movement->id]) }}" class="btn btn-sm btn-success">
                                                        {{ $me->_('validate') }}
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="table-light fw-bold">
                                    <tr>
                                        <td colspan="4" class="text-end">{{ $me->_('total_duration') }}:</td>
                                        <td colspan="3">{{ $totalDuration }}'</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @elseif(isset($_POST['accept']))
            <div class="col-12 text-center py-5">
                <div class="alert alert-secondary">
                    {{ $me->_('no_data_found') }}
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
