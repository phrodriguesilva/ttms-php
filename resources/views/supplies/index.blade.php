@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Suprimentos</h2>
        <a href="{{ route('supplies.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Novo Item
        </a>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('supplies.index') }}" class="row g-3">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Buscar por nome, código..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="category" class="form-select">
                        <option value="">Todas as categorias</option>
                        <option value="Peças" {{ request('category') == 'Peças' ? 'selected' : '' }}>Peças</option>
                        <option value="Fluídos" {{ request('category') == 'Fluídos' ? 'selected' : '' }}>Fluídos</option>
                        <option value="Ferramentas" {{ request('category') == 'Ferramentas' ? 'selected' : '' }}>Ferramentas</option>
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

    <!-- Supply List -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Nome</th>
                            <th>Categoria</th>
                            <th>Estoque</th>
                            <th>Estoque Mínimo</th>
                            <th>Preço Unit.</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($supplies as $supply)
                            <tr class="{{ $supply->isLowStock() ? 'table-warning' : '' }}">
                                <td>{{ $supply->code }}</td>
                                <td>{{ $supply->name }}</td>
                                <td>{{ $supply->category }}</td>
                                <td>{{ $supply->stock_quantity }} {{ $supply->unit }}</td>
                                <td>{{ $supply->minimum_stock }} {{ $supply->unit }}</td>
                                <td>R$ {{ number_format($supply->unit_price, 2, ',', '.') }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('supplies.show', $supply) }}" class="btn btn-sm btn-info" title="Detalhes">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('supplies.edit', $supply) }}" class="btn btn-sm btn-warning" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('supplies.destroy', $supply) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Excluir" onclick="return confirm('Tem certeza que deseja excluir este suprimento?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="fas fa-box fa-3x text-muted mb-3"></i>
                                        <p class="h5 text-muted">Nenhum item encontrado</p>
                                        <p class="text-muted">Clique no botão "Novo Item" para adicionar um item</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-end mt-3">
                {{ $supplies->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
