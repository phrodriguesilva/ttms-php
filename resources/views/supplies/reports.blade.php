@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Relatórios de Consumo</h1>

    <!-- Period Filter -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('supplies.reports') }}" class="row align-items-center">
                <div class="col-md-4">
                    <label for="period" class="form-label">Período:</label>
                    <select name="period" id="period" class="form-select" onchange="this.form.submit()">
                        <option value="week" {{ request('period') == 'week' ? 'selected' : '' }}>Última Semana</option>
                        <option value="month" {{ request('period') == 'month' ? 'selected' : '' }}>Último Mês</option>
                        <option value="quarter" {{ request('period') == 'quarter' ? 'selected' : '' }}>Último Trimestre</option>
                        <option value="year" {{ request('period') == 'year' ? 'selected' : '' }}>Último Ano</option>
                    </select>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <!-- Consumption by Category -->
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-pie me-1"></i>
                    Consumo por Categoria
                </div>
                <div class="card-body">
                    <canvas id="consumptionByCategory" width="100%" height="50"></canvas>
                </div>
            </div>
        </div>

        <!-- Top Consumed Items -->
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-bar me-1"></i>
                    Itens Mais Consumidos
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>SKU</th>
                                    <th>Categoria</th>
                                    <th>Consumo Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($report['top_consumed_items'] as $item)
                                <tr>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->sku }}</td>
                                    <td>{{ $item->category }}</td>
                                    <td>{{ number_format($item->total_consumption, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed Category Report -->
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Detalhamento por Categoria
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Categoria</th>
                            <th>Consumo Total</th>
                            <th>Custo Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($report['consumption_by_category'] as $category)
                        <tr>
                            <td>{{ $category->category }}</td>
                            <td>{{ number_format($category->total_consumption, 2) }}</td>
                            <td>R$ {{ number_format($category->total_cost, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Prepare data for charts
    const categoryData = @json($report['consumption_by_category']);
    
    // Consumption by Category Chart
    const ctxCategory = document.getElementById('consumptionByCategory');
    new Chart(ctxCategory, {
        type: 'pie',
        data: {
            labels: categoryData.map(item => item.category),
            datasets: [{
                data: categoryData.map(item => item.total_consumption),
                backgroundColor: [
                    '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b',
                    '#858796', '#5a5c69', '#2e59d9', '#17a673', '#2c9faf'
                ],
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                }
            }
        }
    });
</script>
@endsection
