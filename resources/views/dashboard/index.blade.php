@extends('layouts.app')

@section('content')
<div class="row g-4">
    <!-- Statistics Cards -->
    <div class="col-md-3">
        <div class="card bg-primary text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0">Total de Reservas</h6>
                        <h2 class="mt-2 mb-0">{{ $totalBookings }}</h2>
                        <p class="mb-0"><small>{{ $pendingBookings }} pendentes</small></p>
                    </div>
                    <i class="fas fa-calendar-alt fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0">Veículos Ativos</h6>
                        <h2 class="mt-2 mb-0">{{ $activeVehicles }}</h2>
                        <p class="mb-0"><small>{{ $totalVehicles }} no total</small></p>
                    </div>
                    <i class="fas fa-car fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0">Motoristas Disponíveis</h6>
                        <h2 class="mt-2 mb-0">{{ $availableDrivers }}</h2>
                        <p class="mb-0"><small>{{ $totalDrivers }} no total</small></p>
                    </div>
                    <i class="fas fa-user fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0">Faturamento Mensal</h6>
                        <h2 class="mt-2 mb-0">R$ {{ number_format($monthlyRevenue, 2, ',', '.') }}</h2>
                        <p class="mb-0"><small>{{ $completedBookingsThisMonth }} reservas</small></p>
                    </div>
                    <i class="fas fa-dollar-sign fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Bookings -->
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Reservas Recentes</h5>
                <a href="{{ route('bookings.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Nova Reserva
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Cliente</th>
                                <th>Data</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentBookings as $booking)
                            <tr>
                                <td>#{{ $booking->id }}</td>
                                <td>{{ $booking->client->name }}</td>
                                <td>{{ $booking->pickup_date }}</td>
                                <td>
                                    <span class="badge bg-{{ $booking->status_color }}">
                                        {{ $booking->status_text }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('bookings.show', $booking->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráficos -->
    <div class="row mt-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Reservas por Status</h5>
                </div>
                <div class="card-body">
                    <canvas id="bookingsByStatusChart" height="300"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Próximas Reservas</h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        @forelse($upcomingBookings as $booking)
                        <div class="list-group-item">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">{{ $booking->client->name }}</h6>
                                <small>{{ $booking->start_date->format('d/m/Y') }}</small>
                            </div>
                            <p class="mb-1">{{ $booking->service_type }} - {{ $booking->vehicle->model }}</p>
                            <small class="text-muted">
                                <i class="fas fa-map-marker-alt"></i> {{ Str::limit($booking->pickup_location, 30) }}
                            </small>
                        </div>
                        @empty
                        <div class="text-center py-3">
                            <p class="mb-0 text-muted">Nenhuma reserva próxima</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const chartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    padding: 20,
                    usePointStyle: true
                }
            }
        }
    };

    // Bookings by Status Chart
    new Chart(document.getElementById('bookingsByStatusChart'), {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($bookingsByStatus->pluck('status_text')) !!},
            datasets: [{
                data: {!! json_encode($bookingsByStatus->pluck('count')) !!},
                backgroundColor: ['#0d6efd', '#198754', '#dc3545', '#ffc107']
            }]
        },
        options: chartOptions
    });
</script>
@endpush
