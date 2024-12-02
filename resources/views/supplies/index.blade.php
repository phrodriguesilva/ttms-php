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
                            <h4 class="card-title mb-3">Gerenciamento de Produtos</h4>
                        </div>
                        <div class="col-md-6 text-end">
                            <a href="{{ route('supplies.create') }}" class="btn btn-primary mb-3">
                                <i class="fas fa-plus me-2"></i>Novo Produto
                            </a>
                        </div>
                    </div>
                    <form action="{{ route('supplies.index') }}" method="GET" id="filterForm">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" placeholder="Buscar por nome, código ou categoria" 
                                       value="{{ request('search') }}">
                            </div>
                            <div class="col-md-2">
                                <select name="category" class="form-select">
                                    <option value="">Todas as Categorias</option>
                                    <option value="Peças" {{ request('category') == 'Peças' ? 'selected' : '' }}>Peças</option>
                                    <option value="Fluídos" {{ request('category') == 'Fluídos' ? 'selected' : '' }}>Fluídos</option>
                                    <option value="Ferramentas" {{ request('category') == 'Ferramentas' ? 'selected' : '' }}>Ferramentas</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <div class="input-group">
                                    <button type="submit" class="btn btn-outline-primary">
                                        <i class="fas fa-search me-2"></i>Filtrar
                                    </button>
                                    <a href="{{ route('supplies.index') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-sync me-2"></i>Limpar
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tabela de Produtos -->
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light table-sticky-header">
                                <tr>
                                    <th class="sortable" data-sort="code" data-direction="{{ request('sort') == 'code' && request('direction') == 'asc' ? 'desc' : 'asc' }}">
                                        Código
                                        <i class="fas fa-sort {{ 
                                            request('sort') == 'code' 
                                                ? (request('direction') == 'asc' ? 'fa-sort-up' : 'fa-sort-down') 
                                                : '' }}"></i>
                                    </th>
                                    <th class="sortable" data-sort="name" data-direction="{{ request('sort') == 'name' && request('direction') == 'asc' ? 'desc' : 'asc' }}">
                                        Nome
                                        <i class="fas fa-sort {{ 
                                            request('sort') == 'name' 
                                                ? (request('direction') == 'asc' ? 'fa-sort-up' : 'fa-sort-down') 
                                                : '' }}"></i>
                                    </th>
                                    <th class="sortable" data-sort="category" data-direction="{{ request('sort') == 'category' && request('direction') == 'asc' ? 'desc' : 'asc' }}">
                                        Categoria
                                        <i class="fas fa-sort {{ 
                                            request('sort') == 'category' 
                                                ? (request('direction') == 'asc' ? 'fa-sort-up' : 'fa-sort-down') 
                                                : '' }}"></i>
                                    </th>
                                    <th>Estoque</th>
                                    <th>Estoque Mínimo</th>
                                    <th>Preço Unit.</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($supplies as $supply)
                                    <tr>
                                        <td>{{ $supply->code }}</td>
                                        <td>{{ $supply->name }}</td>
                                        <td>{{ $supply->category }}</td>
                                        <td>{{ $supply->stock_quantity }} {{ $supply->unit }}</td>
                                        <td>{{ $supply->minimum_stock }} {{ $supply->unit }}</td>
                                        <td>R$ {{ number_format($supply->unit_price, 2, ',', '.') }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('supplies.show', $supply) }}" class="btn btn-sm btn-info" title="Detalhes">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('supplies.edit', $supply) }}" class="btn btn-sm btn-warning" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('supplies.destroy', $supply) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir este produto?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Excluir">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-5">
                                            <div class="d-flex flex-column align-items-center">
                                                <i class="fas fa-box fa-4x text-muted mb-2"></i>
                                                <h5 class="text-muted mb-2">Nenhum produto encontrado</h5>
                                                <p class="text-muted mb-3">Não existem produtos que correspondam aos filtros selecionados.</p>
                                                <a href="{{ route('supplies.create') }}" class="btn btn-primary mt-2">
                                                    <i class="fas fa-plus me-2"></i>Novo Produto
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
                            Mostrando {{ $supplies->firstItem() }} - {{ $supplies->lastItem() }} de {{ $supplies->total() }} produtos
                        </div>
                        {{ $supplies->appends(request()->query())->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Adicionar lógica de ordenação se necessário
        const sortableHeaders = document.querySelectorAll('.sortable');
        sortableHeaders.forEach(header => {
            header.addEventListener('click', function() {
                const sort = this.getAttribute('data-sort');
                const currentDirection = this.getAttribute('data-direction');
                const newDirection = currentDirection === 'asc' ? 'desc' : 'asc';
                
                // Atualizar URL com parâmetros de ordenação
                const url = new URL(window.location.href);
                url.searchParams.set('sort', sort);
                url.searchParams.set('direction', newDirection);
                window.location.href = url.toString();
            });
        });
    });
</script>
@endpush
