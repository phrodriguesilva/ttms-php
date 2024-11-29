@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Alertas de Estoque</h1>
    
    <div class="row mt-4">
        @forelse($alerts as $alert)
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-{{ $alert['alert_level'] }} shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $alert['name'] }}</div>
                                <div class="text-xs font-weight-bold text-uppercase mb-1">
                                    SKU: {{ $alert['sku'] }}
                                </div>
                                <div class="mt-2">
                                    <span class="badge bg-{{ $alert['alert_level'] }}">
                                        Estoque: {{ $alert['current_stock'] }} {{ $alert['unit'] }}
                                    </span>
                                </div>
                                <div class="mt-1">
                                    <small class="text-muted">
                                        Mínimo: {{ $alert['minimum_stock'] }} {{ $alert['unit'] }}
                                    </small>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-exclamation-triangle fa-2x text-{{ $alert['alert_level'] }}"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-success" role="alert">
                    <i class="fas fa-check-circle"></i> Não há alertas de estoque baixo no momento.
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Atualiza os alertas a cada 5 minutos
    setInterval(function() {
        location.reload();
    }, 300000);
</script>
@endsection
