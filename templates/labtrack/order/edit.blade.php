@extends('layout.main')

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <!-- Order Header Info -->
        <div class="col-12 mb-4">
            <div class="card shadow-sm border-0 bg-light">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="mb-0 text-primary">
                            <i class="fas fa-file-invoice me-2"></i>{{ $me->_('order') }}: {{ $order->id }}
                        </h2>
                        <span class="text-muted fs-5">{{ $order->name }}</span>
                    </div>
                    <div>
                        <a href="{{ $me::url('index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-search me-1"></i>{{ $me->_('search_another') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Production Selection Grid -->
        <div class="col-12 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-dark text-white py-3">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-tasks me-2"></i>{{ $me->_('new_record') }}
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <!-- Cost Centers -->
                        <div class="col-md-3">
                            <h6 class="text-uppercase text-muted small fw-bold mb-3">{{ $me->_('cost_centers') }}</h6>
                            <div class="d-grid gap-2 overflow-auto" style="max-height: 300px;">
                                @foreach($centers as $center)
                                    <a href="{{ $me::url('index', ['order' => $order->id, 'center' => $center->id]) }}" 
                                       class="btn {{ $centerId == $center->id ? 'btn-primary' : 'btn-outline-primary' }} text-start">
                                        {!! $center->button_text ?: $center->name !!}
                                    </a>
                                @endforeach
                            </div>
                        </div>

                        <!-- Families -->
                        <div class="col-md-3">
                            <h6 class="text-uppercase text-muted small fw-bold mb-3">{{ $me->_('families') }}</h6>
                            <div class="d-grid gap-2 overflow-auto" style="max-height: 300px;">
                                @foreach($families as $family)
                                    <a href="{{ $me::url('index', ['order' => $order->id, 'center' => $centerId, 'family' => $family->id]) }}" 
                                       class="btn {{ $familyId == $family->id ? 'btn-info text-white' : 'btn-outline-info' }} text-start">
                                        {!! $family->button_text ?: $family->name !!}
                                    </a>
                                @endforeach
                                @if(empty($families) && $centerId)
                                    <div class="alert alert-secondary small">{{ $me->_('no_families_found') }}</div>
                                @endif
                            </div>
                        </div>

                        <!-- Processes -->
                        <div class="col-md-3">
                            <h6 class="text-uppercase text-muted small fw-bold mb-3">{{ $me->_('processes') }}</h6>
                            <div class="d-grid gap-2 overflow-auto" style="max-height: 300px;">
                                @foreach($processes as $process)
                                    <a href="{{ $me::url('index', ['order' => $order->id, 'center' => $centerId, 'family' => $familyId, 'process' => $process->id]) }}" 
                                       class="btn {{ $processId == $process->id ? 'btn-warning text-white' : 'btn-outline-warning' }} text-start">
                                        {!! $process->button_text ?: $process->name !!}
                                    </a>
                                @endforeach
                            </div>
                        </div>

                        <!-- Sequences -->
                        <div class="col-md-3">
                            <h6 class="text-uppercase text-muted small fw-bold mb-3">{{ $me->_('sequences') }}</h6>
                            <div class="d-grid gap-2 overflow-auto" style="max-height: 300px;">
                                @foreach($sequences as $sequence)
                                    <button class="btn btn-outline-success text-start" 
                                            onclick="confirmRecord({{ $sequence->id }}, '{{ addslashes($sequence->name) }}', {{ $sequence->duration_minutes }})">
                                        {!! $sequence->button_text ?: $sequence->name !!}
                                        @if($sequence->duration_minutes > 0)
                                            <span class="badge bg-success float-end">{{ $sequence->duration_minutes }}'</span>
                                        @endif
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Movements List -->
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-history me-2"></i>{{ $me->_('production_history') }}
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>{{ $me->_('date') }}</th>
                                    <th>{{ $me->_('sequence') }}</th>
                                    <th>{{ $me->_('units') }}</th>
                                    <th>{{ $me->_('duration') }}</th>
                                    <th>{{ $me->_('operator') }}</th>
                                    <th>{{ $me->_('status') }}</th>
                                    <th class="text-end">{{ $me->_('actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($movements as $movement)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($movement->movement_at)->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <strong>{{ $movement->sequence->name ?? $movement->sequence_id }}</strong>
                                        </td>
                                        <td>{{ $movement->units }}</td>
                                        <td>{{ $movement->duration_minutes }}'</td>
                                        <td>{{ $movement->operator->name ?? $movement->operator_id }}</td>
                                        <td>
                                            @if($movement->supervised_by > 0)
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check-circle me-1"></i>{{ $me->_('verified') }}
                                                </span>
                                            @else
                                                <span class="badge bg-warning text-dark">
                                                    <i class="fas fa-clock me-1"></i>{{ $me->_('pending') }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-outline-secondary" title="{{ $me->_('edit') }}">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-5 text-muted">
                                            <i class="fas fa-box-open fa-3x mb-3 d-block"></i>
                                            {{ $me->_('no_movements_found') }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Recording Movement -->
<div class="modal fade" id="recordModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ $me::url('addRecord') }}" method="POST">
            <input type="hidden" name="order_id" value="{{ $order->id }}">
            <input type="hidden" name="center_id" value="{{ $centerId }}">
            <input type="hidden" name="family_id" value="{{ $familyId }}">
            <input type="hidden" name="process_id" value="{{ $processId }}">
            <input type="hidden" name="sequence_id" id="modal_sequence_id">
            
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">{{ $me->_('confirm_record') }}</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <h4 id="modal_sequence_name" class="text-center mb-4"></h4>
                    <div class="row g-3">
                        <div class="col-6">
                            <label class="form-label">{{ $me->_('units') }}</label>
                            <input type="number" name="units" class="form-control" value="1" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">{{ $me->_('duration') }} (min)</label>
                            <input type="number" name="duration" id="modal_duration" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">{{ $me->_('notes') }}</label>
                            <textarea name="notes" class="form-control" rows="2"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ $me->_('cancel') }}</button>
                    <button type="submit" class="btn btn-success">{{ $me->_('save') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
function confirmRecord(id, name, duration) {
    document.getElementById('modal_sequence_id').value = id;
    document.getElementById('modal_sequence_name').innerText = name;
    document.getElementById('modal_duration').value = duration;
    new bootstrap.Modal(document.getElementById('recordModal')).show();
}
</script>
@endsection
