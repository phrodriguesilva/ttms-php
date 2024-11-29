@extends('layouts.app')

@push('styles')
<style>
    /* Estilos para tabela de motoristas */
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
                            <h4 class="card-title mb-3">Gerenciamento de Motoristas</h4>
                        </div>
                        <div class="col-md-6 text-end">
                            <a href="{{ route('drivers.create') }}" class="btn btn-primary mb-3">
                                <i class="fas fa-plus me-2"></i>Novo Motorista
                            </a>
                        </div>
                    </div>
                    <form action="{{ route('drivers.index') }}" method="GET" id="filterForm">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" placeholder="Buscar por nome, CNH, email ou telefone" 
                                       value="{{ request('search') }}">
                            </div>
                            <div class="col-md-2">
                                <select name="status" class="form-select">
                                    <option value="">Todos os Status</option>
                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Ativo</option>
                                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inativo</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <div class="input-group">
                                    <button type="submit" class="btn btn-outline-primary">
                                        <i class="fas fa-search me-2"></i>Filtrar
                                    </button>
                                    <a href="{{ route('drivers.index') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-sync me-2"></i>Limpar
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tabela de Motoristas -->
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light table-sticky-header">
                                <tr>
                                    <th class="sortable" data-sort="name" data-direction="{{ request('sort') == 'name' && request('direction') == 'asc' ? 'desc' : 'asc' }}">
                                        Nome
                                        <i class="fas fa-sort {{ 
                                            request('sort') == 'name' 
                                                ? (request('direction') == 'asc' ? 'fa-sort-up' : 'fa-sort-down') 
                                                : 'text-muted' 
                                        }}"></i>
                                    </th>
                                    <th class="sortable" data-sort="license_number" data-direction="{{ request('sort') == 'license_number' && request('direction') == 'asc' ? 'desc' : 'asc' }}">
                                        CNH
                                        <i class="fas fa-sort {{ 
                                            request('sort') == 'license_number' 
                                                ? (request('direction') == 'asc' ? 'fa-sort-up' : 'fa-sort-down') 
                                                : 'text-muted' 
                                        }}"></i>
                                    </th>
                                    <th class="sortable" data-sort="license_expiry" data-direction="{{ request('sort') == 'license_expiry' && request('direction') == 'asc' ? 'desc' : 'asc' }}">
                                        Validade CNH
                                        <i class="fas fa-sort {{ 
                                            request('sort') == 'license_expiry' 
                                                ? (request('direction') == 'asc' ? 'fa-sort-up' : 'fa-sort-down') 
                                                : 'text-muted' 
                                        }}"></i>
                                    </th>
                                    <th>Telefone</th>
                                    <th class="sortable" data-sort="email" data-direction="{{ request('sort') == 'email' && request('direction') == 'asc' ? 'desc' : 'asc' }}">
                                        Email
                                        <i class="fas fa-sort {{ 
                                            request('sort') == 'email' 
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
                                @forelse($drivers as $driver)
                                    <tr>
                                        <td>{{ $driver->name }}</td>
                                        <td>{{ $driver->license_number }}</td>
                                        <td>{{ $driver->license_expiry->format('d/m/Y') }}</td>
                                        <td>{{ $driver->phone }}</td>
                                        <td>{{ $driver->email }}</td>
                                        <td>
                                            <span class="badge bg-{{ $driver->status_color }}">
                                                {{ $driver->status_text }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('drivers.edit', $driver->id) }}" 
                                                   class="btn btn-sm btn-outline-warning" 
                                                   data-bs-toggle="tooltip" 
                                                   data-bs-placement="top" 
                                                   title="Editar Motorista">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" 
                                                        class="btn btn-sm btn-outline-danger" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#deleteModal"
                                                        data-driver-id="{{ $driver->id }}"
                                                        data-bs-toggle="tooltip" 
                                                        data-bs-placement="top" 
                                                        title="Excluir Motorista">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-5">
                                            <div class="d-flex flex-column align-items-center">
                                                <i class="fas fa-user-slash fa-4x text-muted mb-3 empty-list-icon"></i>
                                                <h4 class="text-muted mb-2 empty-list-title">Nenhum motorista encontrado</h4>
                                                <p class="text-muted mb-3 empty-list-description">Não existem motoristas que correspondam aos filtros selecionados.</p>
                                                <a href="{{ route('drivers.create') }}" class="btn btn-primary">
                                                    <i class="fas fa-plus me-2"></i>Adicionar Novo Motorista
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
                            Mostrando {{ $drivers->firstItem() }} - {{ $drivers->lastItem() }} de {{ $drivers->total() }} motoristas
                        </div>
                        {{ $drivers->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Exclusão -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmar Exclusão</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja excluir este motorista?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Excluir</button>
                </form>
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
                const driverId = button.getAttribute('data-driver-id');
                const deleteForm = deleteModal.querySelector('#deleteForm');
                deleteForm.action = `/drivers/${driverId}`;
            });
        }
    });
</script>
@endpush
@endsection
