@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="card-title mb-0">Nova Reserva</h3>
                        <span class="badge bg-primary">Status: Novo</span>
                    </div>
                    <button type="submit" form="bookingForm" class="btn btn-primary">
                        <i class="fas fa-save"></i> Salvar Reserva
                    </button>
                </div>
                
                <div class="card-body">
                    <form id="bookingForm" action="{{ route('bookings.store') }}" method="POST">
                        @csrf

                        <!-- Informações da Corrida -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">Informações da Corrida</h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label for="lead_source" class="form-label">Origem do Lead</label>
                                        <select class="form-select" id="lead_source" name="lead_source">
                                            <option value="">Selecione...</option>
                                            <option value="website">Website</option>
                                            <option value="phone">Telefone</option>
                                            <option value="email">Email</option>
                                            <option value="referral">Indicação</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="service_type" class="form-label">Tipo de Serviço</label>
                                        <select class="form-select" id="service_type" name="service_type" required>
                                            <option value="">Selecione...</option>
                                            <option value="transfer">Transfer</option>
                                            <option value="hourly">Por Hora</option>
                                            <option value="daily">Diária</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="passengers_count" class="form-label">Número de Passageiros</label>
                                        <input type="number" class="form-control" id="passengers_count" name="passengers_count" min="1">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="luggage_count" class="form-label">Número de Malas</label>
                                        <input type="number" class="form-control" id="luggage_count" name="luggage_count" min="0">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Informações do Cliente -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">Informações do Cliente</h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="client_id" class="form-label">Cliente</label>
                                        <select class="form-select @error('client_id') is-invalid @enderror" id="client_id" name="client_id" required>
                                            <option value="">Selecione um cliente...</option>
                                            @foreach($clients as $client)
                                                <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>
                                                    {{ $client->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="account_type" class="form-label">Tipo de Conta</label>
                                        <select class="form-select" id="account_type" name="account_type">
                                            <option value="individual">Individual</option>
                                            <option value="corporate">Corporativo</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="account_manager" class="form-label">Gerente da Conta</label>
                                        <input type="text" class="form-control" id="account_manager" name="account_manager">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label for="client_notes" class="form-label">Observações do Cliente</label>
                                        <textarea class="form-control" id="client_notes" name="client_notes" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Detalhes da Viagem -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">Detalhes da Viagem</h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="pickup_location" class="form-label">Local de Embarque</label>
                                        <input type="text" class="form-control" id="pickup_location" name="pickup_location" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="pickup_date" class="form-label">Data de Embarque</label>
                                        <input type="date" class="form-control" id="pickup_date" name="pickup_date" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="pickup_time" class="form-label">Hora de Embarque</label>
                                        <input type="time" class="form-control" id="pickup_time" name="pickup_time" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="dropoff_location" class="form-label">Local de Desembarque</label>
                                        <input type="text" class="form-control" id="dropoff_location" name="dropoff_location" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="dropoff_date" class="form-label">Data de Desembarque</label>
                                        <input type="date" class="form-control" id="dropoff_date" name="dropoff_date" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="dropoff_time" class="form-label">Hora de Desembarque</label>
                                        <input type="time" class="form-control" id="dropoff_time" name="dropoff_time" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Veículo e Motorista -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">Veículo e Motorista</h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="vehicle_id" class="form-label">Veículo</label>
                                        <select class="form-select @error('vehicle_id') is-invalid @enderror" id="vehicle_id" name="vehicle_id" required>
                                            <option value="">Selecione um veículo...</option>
                                            @foreach($vehicles as $vehicle)
                                                <option value="{{ $vehicle->id }}" {{ old('vehicle_id') == $vehicle->id ? 'selected' : '' }}>
                                                    {{ $vehicle->model }} ({{ $vehicle->plate }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="driver_id" class="form-label">Motorista</label>
                                        <select class="form-select @error('driver_id') is-invalid @enderror" id="driver_id" name="driver_id" required>
                                            <option value="">Selecione um motorista...</option>
                                            @foreach($drivers as $driver)
                                                <option value="{{ $driver->id }}" {{ old('driver_id') == $driver->id ? 'selected' : '' }}>
                                                    {{ $driver->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="meet_greet" class="form-label">Meet & Greet</label>
                                        <select class="form-select" id="meet_greet" name="meet_greet">
                                            <option value="no">Não</option>
                                            <option value="yes">Sim</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Valores e Pagamento -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">Valores e Pagamento</h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label for="rate_type" class="form-label">Tipo de Tarifa</label>
                                        <select class="form-select" id="rate_type" name="rate_type">
                                            <option value="fixed">Fixa</option>
                                            <option value="hourly">Por Hora</option>
                                            <option value="daily">Diária</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="base_rate" class="form-label">Tarifa Base</label>
                                        <div class="input-group">
                                            <span class="input-group-text">R$</span>
                                            <input type="number" class="form-control" id="base_rate" name="base_rate" step="0.01">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="total_amount" class="form-label">Valor Total</label>
                                        <div class="input-group">
                                            <span class="input-group-text">R$</span>
                                            <input type="number" class="form-control" id="total_amount" name="total_amount" step="0.01" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="payment_status" class="form-label">Status do Pagamento</label>
                                        <select class="form-select" id="payment_status" name="payment_status" required>
                                            <option value="pending">Pendente</option>
                                            <option value="partial">Parcial</option>
                                            <option value="paid">Pago</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label for="payment_method" class="form-label">Método de Pagamento</label>
                                        <select class="form-select" id="payment_method" name="payment_method">
                                            <option value="credit_card">Cartão de Crédito</option>
                                            <option value="debit_card">Cartão de Débito</option>
                                            <option value="cash">Dinheiro</option>
                                            <option value="bank_transfer">Transferência Bancária</option>
                                            <option value="pix">PIX</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="payment_due_date" class="form-label">Data de Vencimento</label>
                                        <input type="date" class="form-control" id="payment_due_date" name="payment_due_date">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="deposit_amount" class="form-label">Valor do Depósito</label>
                                        <div class="input-group">
                                            <span class="input-group-text">R$</span>
                                            <input type="number" class="form-control" id="deposit_amount" name="deposit_amount" step="0.01">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="amount_paid" class="form-label">Valor Pago</label>
                                        <div class="input-group">
                                            <span class="input-group-text">R$</span>
                                            <input type="number" class="form-control" id="amount_paid" name="amount_paid" step="0.01">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Observações -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">Observações</h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label for="client_visible_notes" class="form-label">Observações Visíveis ao Cliente</label>
                                        <textarea class="form-control" id="client_visible_notes" name="client_visible_notes" rows="2"></textarea>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label for="driver_notes" class="form-label">Observações para o Motorista</label>
                                        <textarea class="form-control" id="driver_notes" name="driver_notes" rows="2"></textarea>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label for="internal_notes" class="form-label">Observações Internas</label>
                                        <textarea class="form-control" id="internal_notes" name="internal_notes" rows="2"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Atualizar valor total quando a tarifa base mudar
        document.getElementById('base_rate').addEventListener('change', function() {
            calculateTotal();
        });

        // Função para calcular o valor total
        function calculateTotal() {
            const baseRate = parseFloat(document.getElementById('base_rate').value) || 0;
            // Adicione aqui mais cálculos conforme necessário
            document.getElementById('total_amount').value = baseRate;
        }
    });
</script>
@endsection