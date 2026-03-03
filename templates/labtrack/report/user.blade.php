@extends('layout.main')

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <!-- Filter Sidebar/Header -->
        <div class="col-12 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <form action="{{ $me::url('user') }}" method="POST" class="row g-3 align-items-end">
                        @if(!empty($operators))
                            <div class="col-md-3">
                                <label class="form-label fw-bold">{{ $me->_('select_user') }}</label>
                                <select name="operator_id" class="form-select">
                                    @foreach($operators as $operator)
                                        <option value="{{ $operator->id }}" {{ $operatorId == $operator->id ? 'selected' : '' }}>
                                            {{ $operator->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @else
                            <input type="hidden" name="operator_id" value="{{ $operatorId }}">
                        @endif

                        <div class="col-md-3">
                            <label class="form-label fw-bold">{{ $me->_('date_from') }}</label>
                            <input type="date" name="date_from" class="form-control" value="{{ $dateFrom }}">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-bold">{{ $me->_('date_to') }}</label>
                            <input type="date" name="date_to" class="form-control" value="{{ $dateTo }}">
                        </div>

                        <div class="col-md-3 d-flex gap-2">
                            <button type="submit" name="accept" class="btn btn-primary flex-grow-1">
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
            <!-- Summary Stats -->
            @php
                $totalUnits = $report->sum('units');
                $totalDuration = $report->sum('duration_minutes');
                $avgDuration = $totalUnits > 0 ? round($totalDuration / $totalUnits, 1) : 0;
            @endphp
            <div class="col-12 mb-4">
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="card bg-primary text-white border-0 shadow-sm">
                            <div class="card-body py-4">
                                <h6 class="text-uppercase mb-2">{{ $me->_('total_units') }}</h6>
                                <h2 class="mb-0">{{ $totalUnits }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-success text-white border-0 shadow-sm">
                            <div class="card-body py-4">
                                <h6 class="text-uppercase mb-2">{{ $me->_('total_duration') }}</h6>
                                <h2 class="mb-0">{{ $totalDuration }} min</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-info text-white border-0 shadow-sm">
                            <div class="card-body py-4">
                                <h6 class="text-uppercase mb-2">{{ $me->_('avg_duration') }}</h6>
                                <h2 class="mb-0">{{ $avgDuration }} min</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Report Table -->
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-list me-2"></i>{{ $me->_('production_summary') }}
                        </h5>
                        <button class="btn btn-sm btn-outline-success">
                            <i class="fas fa-file-export me-1"></i>{{ $me->_('export') }}
                        </button>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>{{ $me->_('date') }}</th>
                                        <th>{{ $me->_('order') }}</th>
                                        <th>{{ $me->_('sequence') }} / {{ $me->_('process') }}</th>
                                        <th>{{ $me->_('units') }}</th>
                                        <th>{{ $me->_('duration') }}</th>
                                        <th>{{ $me->_('status') }}</th>
                                        <th class="text-end">{{ $me->_('actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($report as $movement)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($movement->movement_at)->format('d/m/Y H:i') }}</td>
                                            <td>
                                                <a href="{{ $me::url('order', ['order_id' => $movement->order_id]) }}" class="text-decoration-none fw-bold">
                                                    {{ $movement->order->name ?? $movement->order_id }}
                                                </a>
                                            </td>
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
