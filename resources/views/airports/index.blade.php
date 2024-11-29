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

    /* Estilos para status dos aeroportos */
    .airport-status {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
        font-size: 0.8rem;
    }
    .airport-status i {
        margin-right: 0.25rem;
    }
    .airport-status-active { 
        background-color: rgba(25, 135, 84, 0.1); 
        color: #198754; 
    }
    .airport-status-inactive { 
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
</style>
@endpush

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Cabeçalho e Filtros -->
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h2 class="mb-0">Aeroportos</h2>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <a href="{{ route('airports.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Novo Aeroporto
                            </a>
                        </div>
                    </div>
                    
                    <!-- Filtros -->
                    <hr class="my-3">
                    <form action="{{ route('airports.index') }}" method="GET">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" placeholder="Buscar aeroportos..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-3">
                                <select name="state" class="form-select">
                                    <option value="">Todos os estados</option>
                                    @php
                                    $states = [
                                        'AC' => 'Acre', 'AL' => 'Alagoas', 'AP' => 'Amapá', 
                                        'AM' => 'Amazonas', 'BA' => 'Bahia', 'CE' => 'Ceará', 
                                        'DF' => 'Distrito Federal', 'ES' => 'Espírito Santo', 
                                        'GO' => 'Goiás', 'MA' => 'Maranhão', 'MT' => 'Mato Grosso', 
                                        'MS' => 'Mato Grosso do Sul', 'MG' => 'Minas Gerais', 
                                        'PA' => 'Pará', 'PB' => 'Paraíba', 'PR' => 'Paraná', 
                                        'PE' => 'Pernambuco', 'PI' => 'Piauí', 'RJ' => 'Rio de Janeiro', 
                                        'RN' => 'Rio Grande do Norte', 'RS' => 'Rio Grande do Sul', 
                                        'RO' => 'Rondônia', 'RR' => 'Roraima', 'SC' => 'Santa Catarina', 
                                        'SP' => 'São Paulo', 'SE' => 'Sergipe', 'TO' => 'Tocantins'
                                    ];
                                    @endphp
                                    @foreach($states as $code => $name)
                                        <option value="{{ $code }}" {{ request('state') == $code ? 'selected' : '' }}>
                                            {{ $name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="status" class="form-select">
                                    <option value="">Todos os status</option>
                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Ativos</option>
                                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inativos</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-filter me-2"></i>Filtrar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tabela de Aeroportos -->
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" id="airportsTable">
                            <thead class="table-light table-sticky-header">
                                <tr>
                                    <th class="sortable" data-sort="name" data-direction="{{ request('sort') == 'name' && request('direction') == 'asc' ? 'desc' : 'asc' }}">
                                        Nome 
                                        @if(request('sort') == 'name')
                                            <i class="fas fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }} ms-1"></i>
                                        @else
                                            <i class="fas fa-sort text-muted ms-1"></i>
                                        @endif
                                    </th>
                                    <th class="sortable" data-sort="code" data-direction="{{ request('sort') == 'code' && request('direction') == 'asc' ? 'desc' : 'asc' }}">
                                        Código 
                                        @if(request('sort') == 'code')
                                            <i class="fas fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }} ms-1"></i>
                                        @else
                                            <i class="fas fa-sort text-muted ms-1"></i>
                                        @endif
                                    </th>
                                    <th class="sortable" data-sort="city" data-direction="{{ request('sort') == 'city' && request('direction') == 'asc' ? 'desc' : 'asc' }}">
                                        Cidade 
                                        @if(request('sort') == 'city')
                                            <i class="fas fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }} ms-1"></i>
                                        @else
                                            <i class="fas fa-sort text-muted ms-1"></i>
                                        @endif
                                    </th>
                                    <th class="sortable" data-sort="state" data-direction="{{ request('sort') == 'state' && request('direction') == 'asc' ? 'desc' : 'asc' }}">
                                        Estado 
                                        @if(request('sort') == 'state')
                                            <i class="fas fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }} ms-1"></i>
                                        @else
                                            <i class="fas fa-sort text-muted ms-1"></i>
                                        @endif
                                    </th>
                                    <th class="sortable" data-sort="status" data-direction="{{ request('sort') == 'status' && request('direction') == 'asc' ? 'desc' : 'asc' }}">
                                        Status 
                                        @if(request('sort') == 'status')
                                            <i class="fas fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }} ms-1"></i>
                                        @else
                                            <i class="fas fa-sort text-muted ms-1"></i>
                                        @endif
                                    </th>
                                    <th class="text-center">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($airports as $airport)
                                    <tr>
                                        <td>{{ $airport->name }}</td>
                                        <td>{{ $airport->code }}</td>
                                        <td>{{ $airport->city }}</td>
                                        <td>{{ $airport->state }}</td>
                                        <td>
                                            <span class="airport-status airport-status-{{ $airport->status }}">
                                                <i class="fas fa-{{ $airport->status == 'active' ? 'check-circle' : 'times-circle' }}"></i>
                                                {{ $airport->status == 'active' ? 'Ativo' : 'Inativo' }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('airports.show', $airport->id) }}" class="btn btn-sm btn-outline-info" title="Detalhes">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('airports.edit', $airport->id) }}" class="btn btn-sm btn-outline-primary" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-outline-danger delete-btn" 
                                                    data-id="{{ $airport->id }}" 
                                                    data-name="{{ $airport->name }}"
                                                    title="Excluir">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4">
                                            <div class="d-flex flex-column align-items-center">
                                                <i class="fas fa-car text-muted mb-3" style="font-size: 3rem;"></i>
                                                <h5 class="text-muted">Nenhum aeroporto encontrado</h5>
                                                <p class="text-muted">Adicione um novo aeroporto para começar</p>
                                                <a href="{{ route('airports.create') }}" class="btn btn-primary mt-2">
                                                    <i class="fas fa-plus me-2"></i>Novo Aeroporto
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
                            Mostrando {{ $airports->firstItem() }} a {{ $airports->lastItem() }} de {{ $airports->total() }} aeroportos
                        </div>
                        <div>
                            {{ $airports->appends(request()->query())->links() }}
                        </div>
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
                Tem certeza que deseja excluir o aeroporto <strong id="deleteAirportName"></strong>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form id="deleteForm" method="POST">
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
        // Configuração de ordenação de colunas
        const sortableHeaders = document.querySelectorAll('.sortable');
        sortableHeaders.forEach(header => {
            header.addEventListener('click', function() {
                const sort = this.dataset.sort;
                const direction = this.dataset.direction;
                window.location.href = '{{ route('airports.index') }}?sort=' + sort + '&direction=' + direction;
            });
        });

        // Configuração de exclusão de aeroporto
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        const deleteForm = document.getElementById('deleteForm');
        const deleteAirportName = document.getElementById('deleteAirportName');

        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const airportId = this.dataset.id;
                const airportName = this.dataset.name;
                
                deleteAirportName.textContent = airportName;
                deleteForm.action = '{{ route('airports.index') }}/' + airportId;
                deleteModal.show();
            });
        });
    });
</script>
@endpush
