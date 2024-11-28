@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Clientes</h2>
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#importModal">
                    <i class="fas fa-file-import"></i> Importar CSV
                </button>
                <a href="{{ route('clients.export') }}" class="btn btn-info text-white">
                    <i class="fas fa-file-export"></i> Exportar CSV
                </a>
                <a href="{{ route('clients.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Novo Cliente
                </a>
            </div>
        </div>

        <!-- Search and filters -->
        <div class="card mb-4">
            <div class="card-body">
                <form action="{{ route('clients.index') }}" method="GET" class="row g-3">
                    <div class="col-md-8">
                        <input type="text" name="search" class="form-control" 
                               placeholder="Buscar por nome, documento, email..." 
                               value="{{ request('search') }}">
                    </div>
                    <div class="col-md-2">
                        <select name="type" class="form-select">
                            <option value="">Todos os tipos</option>
                            <option value="individual" {{ request('type') == 'individual' ? 'selected' : '' }}>Pessoa Física</option>
                            <option value="corporate" {{ request('type') == 'corporate' ? 'selected' : '' }}>Pessoa Jurídica</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-secondary w-100">
                            <i class="fas fa-search"></i> Filtrar
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Clients List -->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Tipo</th>
                                <th>Documento</th>
                                <th>Email</th>
                                <th>Telefone</th>
                                <th>Status</th>
                                <th width="120px">Ações</th>
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
                                    <span class="badge bg-{{ $client->is_active ? 'success' : 'danger' }}">
                                        {{ $client->is_active ? 'Ativo' : 'Inativo' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('clients.edit', $client->id) }}" 
                                           class="btn btn-sm btn-info text-white" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger" 
                                                onclick="confirmDelete({{ $client->id }})" title="Excluir">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="fas fa-users fa-3x text-muted mb-2"></i>
                                        <h5 class="text-muted">Nenhum cliente encontrado</h5>
                                        <p class="text-muted mb-0">Comece adicionando um novo cliente</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-end mt-3">
                    {{ $clients->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Import Modal -->
<div class="modal fade" id="importModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Importar Clientes</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('clients.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="file" class="form-label">Arquivo CSV</label>
                        <input type="file" name="file" id="file" class="form-control" accept=".csv" required>
                    </div>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        O arquivo CSV deve conter as seguintes colunas:
                        <ul class="mb-0">
                            <li>nome</li>
                            <li>tipo (individual ou corporate)</li>
                            <li>documento</li>
                            <li>telefone</li>
                            <li>email</li>
                            <li>endereço (opcional)</li>
                            <li>pessoa_de_contato (opcional)</li>
                            <li>telefone_de_contato (opcional)</li>
                            <li>método_de_pagamento (opcional)</li>
                            <li>prazo_de_pagamento (opcional)</li>
                            <li>status (ativo ou inativo)</li>
                            <li>observações (opcional)</li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Importar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete confirmation modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmar Exclusão</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja excluir este cliente?</p>
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

@section('scripts')
<script>
    function confirmDelete(id) {
        const modal = document.getElementById('deleteModal');
        const form = document.getElementById('deleteForm');
        form.action = `/clients/${id}`;
        new bootstrap.Modal(modal).show();
    }
</script>
@endsection
