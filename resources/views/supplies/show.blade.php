@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <!-- Supply Details -->
            <div class="card mb-4">
                <div class="card-header">
                    <h3 class="card-title">Detalhes do Suprimento</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <dl class="row">
                                <dt class="col-sm-4">Nome:</dt>
                                <dd class="col-sm-8">{{ $supply->name }}</dd>

                                <dt class="col-sm-4">Código:</dt>
                                <dd class="col-sm-8">{{ $supply->code }}</dd>

                                <dt class="col-sm-4">Categoria:</dt>
                                <dd class="col-sm-8">{{ $supply->category }}</dd>

                                <dt class="col-sm-4">Fornecedor:</dt>
                                <dd class="col-sm-8">{{ $supply->supplier ?: 'Não informado' }}</dd>
                            </dl>
                        </div>
                        <div class="col-md-6">
                            <dl class="row">
                                <dt class="col-sm-4">Estoque:</dt>
                                <dd class="col-sm-8">{{ $supply->stock_quantity }} {{ $supply->unit }}</dd>

                                <dt class="col-sm-4">Estoque Mínimo:</dt>
                                <dd class="col-sm-8">{{ $supply->minimum_stock }} {{ $supply->unit }}</dd>

                                <dt class="col-sm-4">Preço Unit.:</dt>
                                <dd class="col-sm-8">R$ {{ number_format($supply->unit_price, 2, ',', '.') }}</dd>

                                <dt class="col-sm-4">Localização:</dt>
                                <dd class="col-sm-8">{{ $supply->location ?: 'Não informada' }}</dd>
                            </dl>
                        </div>
                    </div>

                    @if($supply->description)
                        <div class="row mt-3">
                            <div class="col-12">
                                <h5>Descrição</h5>
                                <p>{{ $supply->description }}</p>
                            </div>
                        </div>
                    @endif

                    @if($supply->notes)
                        <div class="row mt-3">
                            <div class="col-12">
                                <h5>Observações</h5>
                                <p>{{ $supply->notes }}</p>
                            </div>
                        </div>
                    @endif

                    <div class="row mt-3">
                        <div class="col-12">
                            <a href="{{ route('supplies.index') }}" class="btn btn-secondary">Voltar</a>
                            <a href="{{ route('supplies.edit', $supply) }}" class="btn btn-warning">Editar</a>
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addStockModal">
                                <i class="fas fa-plus"></i> Adicionar Estoque
                            </button>
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#removeStockModal">
                                <i class="fas fa-minus"></i> Remover Estoque
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stock Movement History -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Histórico de Movimentações</h3>
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs mb-3" id="movementTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="entries-tab" data-bs-toggle="tab" data-bs-target="#entries" type="button" role="tab" aria-controls="entries" aria-selected="true">
                                Entradas
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="exits-tab" data-bs-toggle="tab" data-bs-target="#exits" type="button" role="tab" aria-controls="exits" aria-selected="false">
                                Saídas
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content" id="movementTabsContent">
                        <!-- Stock Entries -->
                        <div class="tab-pane fade show active" id="entries" role="tabpanel" aria-labelledby="entries-tab">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Data</th>
                                            <th>Quantidade</th>
                                            <th>Observações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($supply->stockEntries()->orderBy('created_at', 'desc')->get() as $entry)
                                            <tr>
                                                <td>{{ $entry->created_at->format('d/m/Y H:i') }}</td>
                                                <td>+{{ $entry->quantity }} {{ $supply->unit }}</td>
                                                <td>{{ $entry->notes ?: '-' }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center">Nenhuma entrada registrada.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Stock Exits -->
                        <div class="tab-pane fade" id="exits" role="tabpanel" aria-labelledby="exits-tab">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Data</th>
                                            <th>Quantidade</th>
                                            <th>Observações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($supply->stockExits()->orderBy('created_at', 'desc')->get() as $exit)
                                            <tr>
                                                <td>{{ $exit->created_at->format('d/m/Y H:i') }}</td>
                                                <td>-{{ $exit->quantity }} {{ $supply->unit }}</td>
                                                <td>{{ $exit->notes ?: '-' }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center">Nenhuma saída registrada.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stock Status Card -->
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h3 class="card-title">Status do Estoque</h3>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <h4>Quantidade Atual</h4>
                        <h2 class="mb-0">{{ $supply->stock_quantity }} {{ $supply->unit }}</h2>
                        @if($supply->isLowStock())
                            <div class="alert alert-warning mt-3">
                                <i class="fas fa-exclamation-triangle"></i>
                                Estoque abaixo do mínimo ({{ $supply->minimum_stock }} {{ $supply->unit }})
                            </div>
                        @endif
                    </div>

                    <div class="progress mb-3" style="height: 20px;">
                        @php
                            $percentage = $supply->minimum_stock > 0 ? ($supply->stock_quantity / $supply->minimum_stock) * 100 : 100;
                            $progressClass = $percentage <= 100 ? 'bg-warning' : 'bg-success';
                        @endphp
                        <div class="progress-bar {{ $progressClass }}" role="progressbar" style="width: {{ min($percentage, 100) }}%">
                            {{ number_format($percentage, 1) }}%
                        </div>
                    </div>

                    <dl class="row mt-4">
                        <dt class="col-sm-8">Valor em Estoque:</dt>
                        <dd class="col-sm-4 text-end">R$ {{ number_format($supply->stock_quantity * $supply->unit_price, 2, ',', '.') }}</dd>

                        <dt class="col-sm-8">Última Entrada:</dt>
                        <dd class="col-sm-4 text-end">
                            {{ $supply->stockEntries()->latest()->first()?->created_at?->format('d/m/Y') ?: '-' }}
                        </dd>

                        <dt class="col-sm-8">Última Saída:</dt>
                        <dd class="col-sm-4 text-end">
                            {{ $supply->stockExits()->latest()->first()?->created_at?->format('d/m/Y') ?: '-' }}
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Stock Modal -->
<div class="modal fade" id="addStockModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('supplies.add-stock', $supply) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Adicionar Estoque</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="add_quantity" class="form-label">Quantidade ({{ $supply->unit }})</label>
                        <input type="number" class="form-control" id="add_quantity" name="quantity" min="0.01" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label for="add_notes" class="form-label">Observações</label>
                        <textarea class="form-control" id="add_notes" name="notes" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Adicionar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Remove Stock Modal -->
<div class="modal fade" id="removeStockModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('supplies.remove-stock', $supply) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Remover Estoque</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="remove_quantity" class="form-label">Quantidade ({{ $supply->unit }})</label>
                        <input type="number" class="form-control" id="remove_quantity" name="quantity" min="0.01" step="0.01" max="{{ $supply->stock_quantity }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="remove_notes" class="form-label">Observações</label>
                        <textarea class="form-control" id="remove_notes" name="notes" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Remover</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
