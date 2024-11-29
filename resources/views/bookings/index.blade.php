@extends('layouts.app')

@push('styles')
<style>
    /* Estilos para tabela de reservas */
    .table-sticky-header {
        position: sticky;
        top: 0;
        background-color: white;
        z-index: 10;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    /* Estilos para ordenação de colunas */
    .sortable {
        cursor: pointer;
        user-select: none;
        transition: background-color 0.2s ease;
    }
    .sortable:hover {
        background-color: rgba(0, 123, 255, 0.05);
    }
    .sortable i {
        margin-left: 0.5rem;
        opacity: 0.5;
        transition: opacity 0.2s ease;
    }
    .sortable:hover i {
        opacity: 0.8;
    }
    .sortable i.fa-sort-up,
    .sortable i.fa-sort-down {
        opacity: 1;
        color: #007bff;
    }

    /* Hover para linhas da tabela */
    .table-hover tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.05);
        transition: background-color 0.3s ease;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Cabeçalho e Filtros -->
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h4 class="card-title mb-3">Gerenciamento de Reservas</h4>
                        </div>
                        <div class="col-md-6 text-end">
                            <a href="{{ route('bookings.create') }}" class="btn btn-primary mb-3">
                                <i class="fas fa-plus me-2"></i>Nova Reserva
                            </a>
                        </div>
                    </div>
                    <form action="{{ route('bookings.index') }}" method="GET" id="filterForm">
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <input type="text" name="search" class="form-control" placeholder="Buscar por cliente, veículo ou motorista" 
                                       value="{{ request('search') }}">
                            </div>
                            <div class="col-md-2">
                                <select name="status" class="form-select">
                                    <option value="">Todos os Status</option>
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
                            <div class="col-md-3">
                                <div class="input-group">
                                    <button type="submit" class="btn btn-outline-primary">
                                        <i class="fas fa-search me-2"></i>Filtrar
                                    </button>
                                    <a href="{{ route('bookings.index') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-sync me-2"></i>Limpar
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tabela de Reservas -->
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light table-sticky-header">
                                <tr>
                                    <th class="sortable" data-sort="id" data-direction="{{ request('sort') == 'id' && request('direction') == 'asc' ? 'desc' : 'asc' }}">
                                        ID
                                        <i class="fas fa-sort {{ 
                                            request('sort') == 'id' 
                                                ? (request('direction') == 'asc' ? 'fa-sort-up' : 'fa-sort-down') 
                                                : 'text-muted' 
                                        }}"></i>
                                    </th>
                                    <th>Cliente</th>
                                    <th>Veículo</th>
                                    <th>Motorista</th>
                                    <th class="sortable" data-sort="start_date" data-direction="{{ request('sort') == 'start_date' && request('direction') == 'asc' ? 'desc' : 'asc' }}">
                                        Data Início
                                        <i class="fas fa-sort {{ 
                                            request('sort') == 'start_date' 
                                                ? (request('direction') == 'asc' ? 'fa-sort-up' : 'fa-sort-down') 
                                                : 'text-muted' 
                                        }}"></i>
                                    </th>
                                    <th class="sortable" data-sort="end_date" data-direction="{{ request('sort') == 'end_date' && request('direction') == 'asc' ? 'desc' : 'asc' }}">
                                        Data Fim
                                        <i class="fas fa-sort {{ 
                                            request('sort') == 'end_date' 
                                                ? (request('direction') == 'asc' ? 'fa-sort-up' : 'fa-sort-down') 
                                                : 'text-muted' 
                                        }}"></i>
                                    </th>
                                    <th class="sortable" data-sort="status" data-direction="{{ request('sort') == 'status' && request('direction') == 'asc' ? 'desc' : 'asc' }}">
                                        Status
                                        <i class="fas fa-sort {{ 
                                            request('sort') == 'status' 
                                                ? (request('direction') == 'asc' ? 'fa-sort-up' : 'fa-sort-down') 
                                                : 'text-muted' 
                                        }}"></i>
                                    </th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bookings as $booking)
                                    <tr>
                                        <td>{{ $booking->id }}</td>
                                        <td>{{ $booking->client->name }}</td>
                                        <td>{{ $booking->vehicle->model }} ({{ $booking->vehicle->plate }})</td>
                                        <td>{{ $booking->driver ? $booking->driver->name : 'Sem motorista' }}</td>
                                        <td>{{ $booking->start_date->format('d/m/Y H:i') }}</td>
                                        <td>{{ $booking->end_date->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <span class="badge bg-{{ $booking->status_color }}">
                                                {{ $booking->status_text }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('bookings.show', $booking->id) }}" 
                                                   class="btn btn-sm btn-outline-info" 
                                                   data-bs-toggle="tooltip" 
                                                   data-bs-placement="top" 
                                                   title="Visualizar Reserva">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('bookings.edit', $booking->id) }}" 
                                                   class="btn btn-sm btn-outline-warning" 
                                                   data-bs-toggle="tooltip" 
                                                   data-bs-placement="top" 
                                                   title="Editar Reserva">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" 
                                                        class="btn btn-sm btn-outline-danger" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#deleteModal"
                                                        data-booking-id="{{ $booking->id }}"
                                                        data-bs-toggle="tooltip" 
                                                        data-bs-placement="top" 
                                                        title="Cancelar Reserva">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4">
                                            <div class="d-flex flex-column align-items-center">
                                                <i class="fas fa-calendar-alt text-muted mb-3" style="font-size: 3rem;"></i>
                                                <h5 class="text-muted">Nenhuma reserva encontrada</h5>
                                                <p class="text-muted">Adicione uma nova reserva para começar</p>
                                                <a href="{{ route('bookings.create') }}" class="btn btn-primary mt-2">
                                                    <i class="fas fa-plus me-2"></i>Nova Reserva
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginação -->
                    <div class="card-footer d-flex justify-content-between align-items-center">
                        <div class="text-muted">
                            Mostrando {{ $bookings->firstItem() }} - {{ $bookings->lastItem() }} de {{ $bookings->total() }} reservas
                        </div>
                        {{ $bookings->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inicializar tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });

        // Ordenação de colunas
        const headers = document.querySelectorAll('.sortable');
        headers.forEach(header => {
            header.addEventListener('click', function() {
                const sortField = this.dataset.sort;
                const direction = this.dataset.direction;
                const currentUrl = new URL(window.location.href);
                currentUrl.searchParams.set('sort', sortField);
                currentUrl.searchParams.set('direction', direction);
                window.location.href = currentUrl.toString();
            });
        });

        // Modal de exclusão
        const deleteModal = document.getElementById('deleteModal');
        if (deleteModal) {
            deleteModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const bookingId = button.getAttribute('data-booking-id');
                const deleteForm = deleteModal.querySelector('#deleteForm');
                deleteForm.action = `/bookings/${bookingId}`;
            });
        }
    });
</script>
@endpush
@endsection
