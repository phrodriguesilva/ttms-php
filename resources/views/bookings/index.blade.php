@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Reservas</h2>
        <a href="{{ route('bookings.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nova Reserva
        </a>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('bookings.index') }}" class="row g-3">
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control" placeholder="Buscar por cliente, veículo..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-select">
                        <option value="">Todos os status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pendente</option>
                        <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmada</option>
                        <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>Em Andamento</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Concluída</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelada</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="date" name="date_from" class="form-control" placeholder="Data inicial" value="{{ request('date_from') }}">
                </div>
                <div class="col-md-2">
                    <input type="date" name="date_to" class="form-control" placeholder="Data final" value="{{ request('date_to') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-secondary w-100">
                        <i class="fas fa-search"></i> Filtrar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Bookings List -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Cliente</th>
                            <th>Veículo</th>
                            <th>Motorista</th>
                            <th>Data Início</th>
                            <th>Data Fim</th>
                            <th>Status</th>
                            <th>Pagamento</th>
                            <th>Valor Total</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookings as $booking)
                            <tr>
                                <td>{{ $booking->id }}</td>
                                <td>{{ $booking->client->name }}</td>
                                <td>{{ $booking->vehicle->model }} ({{ $booking->vehicle->plate }})</td>
                                <td>{{ $booking->driver->name }}</td>
                                <td>{{ $booking->start_date->format('d/m/Y H:i') }}</td>
                                <td>{{ $booking->end_date->format('d/m/Y H:i') }}</td>
                                <td>
                                    @php
                                        $statusClasses = [
                                            'pending' => 'bg-warning',
                                            'confirmed' => 'bg-info',
                                            'in_progress' => 'bg-primary',
                                            'completed' => 'bg-success',
                                            'cancelled' => 'bg-danger'
                                        ];
                                        $statusLabels = [
                                            'pending' => 'Pendente',
                                            'confirmed' => 'Confirmada',
                                            'in_progress' => 'Em Andamento',
                                            'completed' => 'Concluída',
                                            'cancelled' => 'Cancelada'
                                        ];
                                    @endphp
                                    <span class="badge {{ $statusClasses[$booking->status] }}">
                                        {{ $statusLabels[$booking->status] }}
                                    </span>
                                </td>
                                <td>
                                    @php
                                        $paymentClasses = [
                                            'pending' => 'bg-warning',
                                            'paid' => 'bg-success',
                                            'partially_paid' => 'bg-info',
                                            'refunded' => 'bg-secondary'
                                        ];
                                        $paymentLabels = [
                                            'pending' => 'Pendente',
                                            'paid' => 'Pago',
                                            'partially_paid' => 'Parcial',
                                            'refunded' => 'Reembolsado'
                                        ];
                                    @endphp
                                    <span class="badge {{ $paymentClasses[$booking->payment_status] }}">
                                        {{ $paymentLabels[$booking->payment_status] }}
                                    </span>
                                </td>
                                <td>R$ {{ number_format($booking->total_amount, 2, ',', '.') }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('bookings.show', $booking) }}" class="btn btn-sm btn-info" title="Detalhes">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if($booking->status != 'cancelled' && $booking->status != 'completed')
                                            <a href="{{ route('bookings.edit', $booking) }}" class="btn btn-sm btn-warning" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('bookings.destroy', $booking) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Cancelar" onclick="return confirm('Tem certeza que deseja cancelar esta reserva?')">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center">Nenhuma reserva encontrada.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-end mt-3">
                {{ $bookings->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
