@extends('layouts.app')

@push('styles')
<style>
    /* Cabeçalho fixo da tabela */
    .table-sticky-header {
        position: sticky;
        top: 0;
        background-color: white;
        z-index: 10;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    /* Estilos para status dos veículos */
    .vehicle-status {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
        font-size: 0.8rem;
    }
    .vehicle-status i {
        margin-right: 0.25rem;
    }
    .vehicle-status-active { 
        background-color: rgba(25, 135, 84, 0.1); 
        color: #198754; 
    }
    .vehicle-status-maintenance { 
        background-color: rgba(255, 193, 7, 0.1); 
        color: #ffc107; 
    }
    .vehicle-status-inactive { 
        background-color: rgba(220, 53, 69, 0.1); 
        color: #dc3545; 
    }

    /* Hover para linhas da tabela */
    .table-hover tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.05);
        transition: background-color 0.3s ease;
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
                            <h4 class="card-title mb-3">Gerenciamento de Veículos</h4>
                        </div>
                        <div class="col-md-6 text-end">
                            <a href="{{ route('vehicles.create') }}" class="btn btn-primary mb-3">
                                <i class="fas fa-plus me-2"></i>Adicionar Veículo
                            </a>
                        </div>
                    </div>
                    <form action="{{ route('vehicles.index') }}" method="GET" id="filterForm">
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <input type="text" name="search" class="form-control" placeholder="Buscar por placa, modelo ou marca" 
                                       value="{{ request('search') }}">
                            </div>
                            <div class="col-md-2">
                                <select name="status" class="form-select">
                                    <option value="">Status</option>
                                    <option value="Ativo" {{ request('status') == 'Ativo' ? 'selected' : '' }}>Ativo</option>
                                    <option value="Manutenção" {{ request('status') == 'Manutenção' ? 'selected' : '' }}>Manutenção</option>
                                    <option value="Inativo" {{ request('status') == 'Inativo' ? 'selected' : '' }}>Inativo</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="year" class="form-select">
                                    <option value="">Ano</option>
                                    @php
                                        $currentYear = date('Y');
                                        $startYear = $currentYear - 20;
                                    @endphp
                                    @for($year = $currentYear; $year >= $startYear; $year--)
                                        <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-3">
                                <div class="input-group">
                                    <button type="submit" class="btn btn-outline-primary">
                                        <i class="fas fa-search me-2"></i>Filtrar
                                    </button>
                                    <a href="{{ route('vehicles.index') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-sync me-2"></i>Limpar
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tabela de Veículos -->
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" id="vehiclesTable">
                            <thead class="table-light table-sticky-header">
                                <tr>
                                    <th class="sortable" data-sort="plate" data-direction="{{ request('sort') == 'plate' && request('direction') == 'asc' ? 'desc' : 'asc' }}">
                                        Placa 
                                        <i class="fas fa-sort {{ 
                                            request('sort') == 'plate' 
                                                ? (request('direction') == 'asc' ? 'fa-sort-up' : 'fa-sort-down') 
                                                : 'text-muted' 
                                        }}"></i>
                                    </th>
                                    <th class="sortable" data-sort="model" data-direction="{{ request('sort') == 'model' && request('direction') == 'asc' ? 'desc' : 'asc' }}">
                                        Modelo 
                                        <i class="fas fa-sort {{ 
                                            request('sort') == 'model' 
                                                ? (request('direction') == 'asc' ? 'fa-sort-up' : 'fa-sort-down') 
                                                : 'text-muted' 
                                        }}"></i>
                                    </th>
                                    <th class="sortable" data-sort="year" data-direction="{{ request('sort') == 'year' && request('direction') == 'asc' ? 'desc' : 'asc' }}">
                                        Ano 
                                        <i class="fas fa-sort {{ 
                                            request('sort') == 'year' 
                                                ? (request('direction') == 'asc' ? 'fa-sort-up' : 'fa-sort-down') 
                                                : 'text-muted' 
                                        }}"></i>
                                    </th>
                                    <th class="sortable" data-sort="brand" data-direction="{{ request('sort') == 'brand' && request('direction') == 'asc' ? 'desc' : 'asc' }}">
                                        Marca 
                                        <i class="fas fa-sort {{ 
                                            request('sort') == 'brand' 
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
                                @forelse($vehicles as $vehicle)
                                    <tr>
                                        <td>{{ $vehicle->plate }}</td>
                                        <td>{{ $vehicle->model }}</td>
                                        <td>{{ $vehicle->year }}</td>
                                        <td>{{ $vehicle->brand }}</td>
                                        <td>
                                            <span class="vehicle-status vehicle-status-{{ strtolower($vehicle->status) }}">
                                                <i class="fas {{ $vehicle->status === 'Ativo' ? 'fa-check-circle' : ($vehicle->status === 'Manutenção' ? 'fa-wrench' : 'fa-times-circle') }}"></i>
                                                {{ $vehicle->status }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('vehicles.edit', $vehicle->id) }}" 
                                                   class="btn btn-sm btn-outline-primary" 
                                                   data-bs-toggle="tooltip" 
                                                   data-bs-placement="top" 
                                                   title="Editar Veículo">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" 
                                                        class="btn btn-sm btn-outline-danger" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#deleteModal"
                                                        data-vehicle-id="{{ $vehicle->id }}"
                                                        data-bs-toggle="tooltip" 
                                                        data-bs-placement="top" 
                                                        title="Excluir Veículo">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5">
                                            <div class="d-flex flex-column align-items-center justify-content-center">
                                                <i class="fas fa-car-alt fa-4x text-muted mb-3" style="font-size: 4rem; opacity: 1;"></i>
                                                <h5 class="text-muted mb-2">Nenhum veículo encontrado</h5>
                                                <p class="text-muted mb-3">Não existem veículos que correspondam aos filtros selecionados.</p>
                                                <a href="{{ route('vehicles.create') }}" class="btn btn-primary mt-2">
                                                    <i class="fas fa-plus me-2"></i>Adicionar Veículo
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
                            Mostrando {{ $vehicles->firstItem() }} - {{ $vehicles->lastItem() }} de {{ $vehicles->total() }} veículos
                        </div>
                        {{ $vehicles->appends(request()->query())->links() }}
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

        // Tratamento de mensagens de feedback
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Sucesso!',
                text: '{{ session('success') }}',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Erro!',
                text: '{{ session('error') }}',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
        @endif

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
                const vehicleId = button.getAttribute('data-vehicle-id');
                const deleteForm = deleteModal.querySelector('#deleteForm');
                deleteForm.action = `/vehicles/${vehicleId}`;
            });
        }
    });
</script>
@endpush

@endsection
