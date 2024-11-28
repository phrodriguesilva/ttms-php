@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Motoristas</h2>
            <a href="{{ route('drivers.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Novo Motorista
            </a>
        </div>

        <!-- Search and filters -->
        <div class="card mb-4">
            <div class="card-body">
                <form action="{{ route('drivers.index') }}" method="GET" class="row g-3">
                    <div class="col-md-8">
                        <input type="text" name="search" class="form-control" placeholder="Buscar por nome, CNH, email..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-2">
                        <select name="status" class="form-select">
                            <option value="">Todos os status</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Ativo</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inativo</option>
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

        <!-- Drivers list -->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>CNH</th>
                                <th>Validade CNH</th>
                                <th>Telefone</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th width="120px">Ações</th>
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
                                    <span class="badge bg-{{ $driver->status === 'active' ? 'success' : 'danger' }}">
                                        {{ $driver->status === 'active' ? 'Ativo' : 'Inativo' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('drivers.edit', $driver->id) }}" class="btn btn-sm btn-info" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $driver->id }})" title="Excluir">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="fas fa-user-tie fa-3x text-muted mb-3"></i>
                                        <p class="h5 text-muted">Nenhum motorista encontrado</p>
                                        <p class="text-muted">Clique no botão "Novo Motorista" para adicionar um motorista</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($drivers->hasPages())
                <div class="d-flex justify-content-end mt-3">
                    {{ $drivers->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Delete confirmation modal -->
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
@endsection

@push('scripts')
<script>
function confirmDelete(driverId) {
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    const form = document.getElementById('deleteForm');
    form.action = `/drivers/${driverId}`;
    modal.show();
}
</script>
@endpush
