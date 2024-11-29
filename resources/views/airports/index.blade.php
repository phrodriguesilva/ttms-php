@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Cabeçalho e Filtros -->
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h4 class="card-title mb-3">Gerenciamento de Aeroportos</h4>
                        </div>
                        <div class="col-md-6 text-end">
                            <a href="{{ route('airports.create') }}" class="btn btn-primary mb-3">
                                <i class="fas fa-plus me-2"></i>Adicionar Aeroporto
                            </a>
                        </div>
                    </div>
                    <form action="{{ route('airports.index') }}" method="GET" id="filterForm">
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <input type="text" name="search" class="form-control" placeholder="Buscar por nome ou código" 
                                       value="{{ request('search') }}">
                            </div>
                            <div class="col-md-2">
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
                            <div class="col-md-2">
                                <select name="status" class="form-select">
                                    <option value="">Status</option>
                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Ativo</option>
                                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inativo</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <div class="input-group">
                                    <button type="submit" class="btn btn-outline-primary">
                                        <i class="fas fa-search me-2"></i>Filtrar
                                    </button>
                                    <a href="{{ route('airports.index') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-sync me-2"></i>Limpar
                                    </a>
                                </div>
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
                                        <i class="fas fa-sort {{ 
                                            request('sort') == 'name' 
                                                ? (request('direction') == 'asc' ? 'fa-sort-up' : 'fa-sort-down') 
                                                : 'text-muted' 
                                        }}"></i>
                                    </th>
                                    <th class="sortable" data-sort="code" data-direction="{{ request('sort') == 'code' && request('direction') == 'asc' ? 'desc' : 'asc' }}">
                                        Código 
                                        <i class="fas fa-sort {{ 
                                            request('sort') == 'code' 
                                                ? (request('direction') == 'asc' ? 'fa-sort-up' : 'fa-sort-down') 
                                                : 'text-muted' 
                                        }}"></i>
                                    </th>
                                    <th class="sortable" data-sort="city" data-direction="{{ request('sort') == 'city' && request('direction') == 'asc' ? 'desc' : 'asc' }}">
                                        Cidade 
                                        <i class="fas fa-sort {{ 
                                            request('sort') == 'city' 
                                                ? (request('direction') == 'asc' ? 'fa-sort-up' : 'fa-sort-down') 
                                                : 'text-muted' 
                                        }}"></i>
                                    </th>
                                    <th class="sortable" data-sort="state" data-direction="{{ request('sort') == 'state' && request('direction') == 'asc' ? 'desc' : 'asc' }}">
                                        Estado 
                                        <i class="fas fa-sort {{ 
                                            request('sort') == 'state' 
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
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('airports.edit', $airport->id) }}" class="btn btn-sm btn-outline-primary" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-outline-danger delete-airport" data-id="{{ $airport->id }}" data-bs-toggle="modal" data-bs-target="#deleteModal" title="Excluir">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5">
                                            <div class="d-flex flex-column align-items-center justify-content-center">
                                                <i class="fas fa-plane-slash fa-4x text-muted mb-3"></i>
                                                <h5 class="text-muted mb-2">Nenhum aeroporto encontrado</h5>
                                                <p class="text-muted mb-3">Adicione um novo aeroporto para começar</p>
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
                            Mostrando {{ $airports->firstItem() }} - {{ $airports->lastItem() }} de {{ $airports->total() }} aeroportos
                        </div>
                        <div>
                            {{ $airports->appends(request()->query())->links('vendor.pagination.bootstrap-5') }}
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
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja excluir o aeroporto <strong id="deleteAirportName"></strong>?</p>
                <p class="text-danger"><small>Esta ação não pode ser desfeita.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form id="deleteForm" method="POST" action="">
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
        const deleteForm = document.getElementById('deleteForm');
        const deleteAirportName = document.getElementById('deleteAirportName');

        // Configuração de ordenação de colunas
        const sortableHeaders = document.querySelectorAll('.sortable');
        sortableHeaders.forEach(header => {
            header.addEventListener('click', function() {
                const sort = this.dataset.sort;
                const direction = this.dataset.direction;
                window.location.href = '{{ route('airports.index') }}?sort=' + sort + '&direction=' + direction;
            });
        });

        document.querySelectorAll('.delete-airport').forEach(btn => {
            btn.addEventListener('click', function() {
                const airportId = this.dataset.id;
                const airportName = this.closest('tr').querySelector('td:first-child').textContent;
                
                deleteForm.action = `/airports/${airportId}`;
                deleteAirportName.textContent = airportName;
            });
        });
    });
</script>
@endpush
@endsection
