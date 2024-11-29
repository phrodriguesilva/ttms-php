@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Aeroportos</h2>
            <a href="{{ route('airports.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Novo Aeroporto
            </a>
        </div>

        <!-- Search and filters -->
        <div class="card mb-4">
            <div class="card-body">
                <form action="{{ route('airports.index') }}" method="GET" class="row g-3">
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control" placeholder="Buscar aeroportos..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <select name="state" class="form-select">
                            <option value="">Todos os estados</option>
                            <option value="AC" {{ request('state') == 'AC' ? 'selected' : '' }}>Acre</option>
                            <option value="AL" {{ request('state') == 'AL' ? 'selected' : '' }}>Alagoas</option>
                            <option value="AP" {{ request('state') == 'AP' ? 'selected' : '' }}>Amapá</option>
                            <option value="AM" {{ request('state') == 'AM' ? 'selected' : '' }}>Amazonas</option>
                            <option value="BA" {{ request('state') == 'BA' ? 'selected' : '' }}>Bahia</option>
                            <option value="CE" {{ request('state') == 'CE' ? 'selected' : '' }}>Ceará</option>
                            <option value="DF" {{ request('state') == 'DF' ? 'selected' : '' }}>Distrito Federal</option>
                            <option value="ES" {{ request('state') == 'ES' ? 'selected' : '' }}>Espírito Santo</option>
                            <option value="GO" {{ request('state') == 'GO' ? 'selected' : '' }}>Goiás</option>
                            <option value="MA" {{ request('state') == 'MA' ? 'selected' : '' }}>Maranhão</option>
                            <option value="MT" {{ request('state') == 'MT' ? 'selected' : '' }}>Mato Grosso</option>
                            <option value="MS" {{ request('state') == 'MS' ? 'selected' : '' }}>Mato Grosso do Sul</option>
                            <option value="MG" {{ request('state') == 'MG' ? 'selected' : '' }}>Minas Gerais</option>
                            <option value="PA" {{ request('state') == 'PA' ? 'selected' : '' }}>Pará</option>
                            <option value="PB" {{ request('state') == 'PB' ? 'selected' : '' }}>Paraíba</option>
                            <option value="PR" {{ request('state') == 'PR' ? 'selected' : '' }}>Paraná</option>
                            <option value="PE" {{ request('state') == 'PE' ? 'selected' : '' }}>Pernambuco</option>
                            <option value="PI" {{ request('state') == 'PI' ? 'selected' : '' }}>Piauí</option>
                            <option value="RJ" {{ request('state') == 'RJ' ? 'selected' : '' }}>Rio de Janeiro</option>
                            <option value="RN" {{ request('state') == 'RN' ? 'selected' : '' }}>Rio Grande do Norte</option>
                            <option value="RS" {{ request('state') == 'RS' ? 'selected' : '' }}>Rio Grande do Sul</option>
                            <option value="RO" {{ request('state') == 'RO' ? 'selected' : '' }}>Rondônia</option>
                            <option value="RR" {{ request('state') == 'RR' ? 'selected' : '' }}>Roraima</option>
                            <option value="SC" {{ request('state') == 'SC' ? 'selected' : '' }}>Santa Catarina</option>
                            <option value="SP" {{ request('state') == 'SP' ? 'selected' : '' }}>São Paulo</option>
                            <option value="SE" {{ request('state') == 'SE' ? 'selected' : '' }}>Sergipe</option>
                            <option value="TO" {{ request('state') == 'TO' ? 'selected' : '' }}>Tocantins</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="status" class="form-select">
                            <option value="">Todos os status</option>
                            <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Ativo</option>
                            <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Inativo</option>
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

        <!-- Airports list -->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Código</th>
                                <th>Cidade</th>
                                <th>Estado</th>
                                <th>Status</th>
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
                                        <span class="badge bg-{{ $airport->is_active ? 'success' : 'danger' }}">
                                            {{ $airport->is_active ? 'Ativo' : 'Inativo' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('airports.edit', $airport) }}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-airport-id="{{ $airport->id }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <div class="d-flex flex-column align-items-center">
                                            <i class="fas fa-plane fa-3x text-muted mb-3"></i>
                                            <p class="h5 text-muted">Nenhum aeroporto encontrado</p>
                                            <p class="text-muted">Clique no botão "Novo Aeroporto" para adicionar um aeroporto</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-end mt-3">
                    {{ $airports->links() }}
                </div>
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
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja excluir este aeroporto?</p>
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

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteModal = document.getElementById('deleteModal');
        if (deleteModal) {
            deleteModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const airportId = button.getAttribute('data-airport-id');
                const form = this.querySelector('#deleteForm');
                form.action = `/airports/${airportId}`;
            });
        }
    });
</script>
@endpush
@endsection
