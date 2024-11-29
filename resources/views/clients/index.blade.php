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

    /* Estilos para status dos clientes */
    .client-status {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
        font-size: 0.8rem;
    }
    .client-status i {
        margin-right: 0.25rem;
    }
    .client-status-active { 
        background-color: rgba(25, 135, 84, 0.1); 
        color: #198754; 
    }
    .client-status-inactive { 
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

    /* Estilos para placeholder de lista vazia */
    .empty-list-icon {
        font-size: 3.5rem;
        color: #6c757d;
        margin-bottom: 1rem;
    }
    .empty-list-title {
        font-size: 1.25rem;
        color: #6c757d;
        margin-bottom: 0.75rem;
    }
    .empty-list-description {
        font-size: 1rem;
        color: #6c757d;
        margin-bottom: 1rem;
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
                            <h4 class="card-title mb-3">Gerenciamento de Clientes</h4>
                        </div>
                        <div class="col-md-6 text-end">
                            <a href="{{ route('clients.create') }}" class="btn btn-primary mb-3">
                                <i class="fas fa-plus me-2"></i>Adicionar Cliente
                            </a>
                        </div>
                    </div>
                    <form action="{{ route('clients.index') }}" method="GET" id="filterForm">
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <input type="text" name="search" class="form-control" placeholder="Buscar por nome, documento ou email" 
                                       value="{{ request('search') }}">
                            </div>
                            <div class="col-md-2">
                                <select name="type" class="form-select">
                                    <option value="">Tipo de Cliente</option>
                                    <option value="individual" {{ request('type') == 'individual' ? 'selected' : '' }}>Pessoa Física</option>
                                    <option value="corporate" {{ request('type') == 'corporate' ? 'selected' : '' }}>Pessoa Jurídica</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="status" class="form-select">
                                    <option value="">Status</option>
                                    <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Ativo</option>
                                    <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Inativo</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <div class="input-group">
                                    <button type="submit" class="btn btn-outline-primary">
                                        <i class="fas fa-search me-2"></i>Filtrar
                                    </button>
                                    <a href="{{ route('clients.index') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-sync me-2"></i>Limpar
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tabela de Clientes -->
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" id="clientsTable">
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
                                    <th class="sortable" data-sort="type" data-direction="{{ request('sort') == 'type' && request('direction') == 'asc' ? 'desc' : 'asc' }}">
                                        Tipo 
                                        <i class="fas fa-sort {{ 
                                            request('sort') == 'type' 
                                                ? (request('direction') == 'asc' ? 'fa-sort-up' : 'fa-sort-down') 
                                                : 'text-muted' 
                                        }}"></i>
                                    </th>
                                    <th class="sortable" data-sort="document" data-direction="{{ request('sort') == 'document' && request('direction') == 'asc' ? 'desc' : 'asc' }}">
                                        Documento 
                                        <i class="fas fa-sort {{ 
                                            request('sort') == 'document' 
                                                ? (request('direction') == 'asc' ? 'fa-sort-up' : 'fa-sort-down') 
                                                : 'text-muted' 
                                        }}"></i>
                                    </th>
                                    <th class="sortable" data-sort="email" data-direction="{{ request('sort') == 'email' && request('direction') == 'asc' ? 'desc' : 'asc' }}">
                                        Email 
                                        <i class="fas fa-sort {{ 
                                            request('sort') == 'email' 
                                                ? (request('direction') == 'asc' ? 'fa-sort-up' : 'fa-sort-down') 
                                                : 'text-muted' 
                                        }}"></i>
                                    </th>
                                    <th class="sortable" data-sort="phone" data-direction="{{ request('sort') == 'phone' && request('direction') == 'asc' ? 'desc' : 'asc' }}">
                                        Telefone 
                                        <i class="fas fa-sort {{ 
                                            request('sort') == 'phone' 
                                                ? (request('direction') == 'asc' ? 'fa-sort-up' : 'fa-sort-down') 
                                                : 'text-muted' 
                                        }}"></i>
                                    </th>
                                    <th class="sortable" data-sort="is_active" data-direction="{{ request('sort') == 'is_active' && request('direction') == 'asc' ? 'desc' : 'asc' }}">
                                        Status 
                                        <i class="fas fa-sort {{ 
                                            request('sort') == 'is_active' 
                                                ? (request('direction') == 'asc' ? 'fa-sort-up' : 'fa-sort-down') 
                                                : 'text-muted' 
                                        }}"></i>
                                    </th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($clients as $client)
                                    <tr>
                                        <td>{{ $client->name }}</td>
                                        <td>{{ $client->type === 'individual' ? 'Pessoa Física' : 'Pessoa Jurídica' }}</td>
                                        <td>{{ $client->document }}</td>
                                        <td>{{ $client->email }}</td>
                                        <td>{{ $client->phone }}</td>
                                        <td>
                                            <span class="client-status client-status-{{ $client->is_active ? 'active' : 'inactive' }}">
                                                <i class="fas {{ $client->is_active ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                                                {{ $client->is_active ? 'Ativo' : 'Inativo' }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('clients.edit', $client->id) }}" 
                                                   class="btn btn-sm btn-outline-primary" 
                                                   title="Editar cliente">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-outline-danger" 
                                                        onclick="confirmDelete({{ $client->id }})" 
                                                        title="Excluir cliente">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <div class="d-flex flex-column align-items-center">
                                                <i class="fas fa-users text-muted mb-3" style="font-size: 3rem;"></i>
                                                <h5 class="text-muted">Nenhum cliente encontrado</h5>
                                                <p class="text-muted">Adicione um novo cliente para começar</p>
                                                <a href="{{ route('clients.create') }}" class="btn btn-primary mt-2">
                                                    <i class="fas fa-plus me-2"></i>Novo Cliente
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
                            Mostrando {{ $clients->firstItem() }} a {{ $clients->lastItem() }} de {{ $clients->total() }} resultados
                        </div>
                        {{ $clients->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Confirmação de Exclusão -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmar Exclusão</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Tem certeza que deseja excluir este cliente?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form id="deleteForm" action="" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Excluir</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function confirmDelete(id) {
        const modal = document.getElementById('deleteModal');
        const form = document.getElementById('deleteForm');
        form.action = `/clients/${id}`;
        new bootstrap.Modal(modal).show();
    }
</script>
@endpush
