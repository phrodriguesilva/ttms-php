@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
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
                <form id="bookingForm" action="{{ route('bookings.store') }}" method="POST" class="needs-validation" novalidate>
                    @csrf

                    <!-- Informações da Corrida -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fas fa-info-circle me-2"></i>
                                Informações da Corrida
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <label for="lead_source" class="form-label">Origem do Lead</label>
                                    <select class="form-select" id="lead_source" name="lead_source" required>
                                        <option value="">Selecione...</option>
                                        <option value="website">Website</option>
                                        <option value="phone">Telefone</option>
                                        <option value="email">Email</option>
                                        <option value="referral">Indicação</option>
                                        <option value="social">Redes Sociais</option>
                                        <option value="partner">Parceiro</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Por favor, selecione a origem do lead.
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label for="service_type" class="form-label">Tipo de Serviço</label>
                                    <select class="form-select" id="service_type" name="service_type" required>
                                        <option value="">Selecione...</option>
                                        <option value="transfer_in">Transfer IN (Aeroporto → Hotel)</option>
                                        <option value="transfer_out">Transfer OUT (Hotel → Aeroporto)</option>
                                        <option value="point_to_point">Transfer Ponto a Ponto</option>
                                        <option value="hourly">Por Hora</option>
                                        <option value="daily">Diária</option>
                                        <option value="event">Evento</option>
                                        <option value="tour">Tour</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Por favor, selecione o tipo de serviço.
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label for="start_date" class="form-label">Data Inicial</label>
                                    <input type="datetime-local" class="form-control" id="start_date" name="start_date" required 
                                           min="{{ date('Y-m-d\TH:i') }}" onchange="updateEndDateMin()">
                                    <div class="invalid-feedback">
                                        Por favor, selecione a data inicial.
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label for="end_date" class="form-label">Data Final</label>
                                    <input type="datetime-local" class="form-control" id="end_date" name="end_date" required>
                                    <div class="invalid-feedback">
                                        Por favor, selecione a data final.
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mb-3" id="serviceDetails">
                                <!-- Esta div será preenchida via JavaScript baseado no tipo de serviço -->
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
                                    <div class="input-group">
                                        <select class="form-select @error('client_id') is-invalid @enderror" id="client_id" name="client_id" required>
                                            <option value="">Selecione um cliente...</option>
                                            @foreach($clients as $client)
                                                <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>
                                                    {{ $client->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <a href="{{ route('clients.create') }}" class="btn btn-outline-primary" target="_blank">
                                            <i class="fas fa-plus"></i> Novo
                                        </a>
                                    </div>
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
                            <h5 class="mb-0">
                                <i class="fas fa-car me-2"></i>
                                Veículo e Motorista
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="vehicle_id" class="form-label">Veículo</label>
                                    <select class="form-select" id="vehicle_id" name="vehicle_id" required disabled>
                                        <option value="">Selecione a data e hora primeiro...</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Por favor, selecione um veículo.
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="driver_id" class="form-label">Motorista</label>
                                    <select class="form-select" id="driver_id" name="driver_id" required>
                                        <option value="">Selecione...</option>
                                        <!-- Será preenchido via JavaScript -->
                                    </select>
                                    <div class="invalid-feedback">
                                        Por favor, selecione um motorista.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Valores e Pagamento -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fas fa-dollar-sign me-2"></i>
                                Valores e Pagamento
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="price_type" id="price_type_auto" value="auto" checked>
                                        <label class="form-check-label" for="price_type_auto">
                                            Cálculo Automático
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="price_type" id="price_type_manual" value="manual">
                                        <label class="form-check-label" for="price_type_manual">
                                            Valores Manuais
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Campos para Cálculo Automático -->
                            <div id="auto_price_fields">
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="distance" class="form-label">Distância (km)</label>
                                        <input type="number" class="form-control" id="distance" name="distance" min="0" step="0.1">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="hours" class="form-label">Horas</label>
                                        <input type="number" class="form-control" id="hours" name="hours" min="1">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="days" class="form-label">Dias</label>
                                        <input type="number" class="form-control" id="days" name="days" min="1">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="passengers" class="form-label">Número de Passageiros</label>
                                        <input type="number" class="form-control" id="passengers" name="passengers" min="1" required>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <h6 class="card-subtitle mb-2 text-muted">Detalhes do Cálculo</h6>
                                                <div id="price-details" class="small">
                                                    Selecione o veículo e preencha os detalhes da viagem...
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Campos para Valores Manuais -->
                            <div id="manual_price_fields" style="display: none;">
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="base_rate" class="form-label">Tarifa Base</label>
                                        <div class="input-group">
                                            <span class="input-group-text">R$</span>
                                            <input type="number" class="form-control" id="base_rate" name="base_rate" step="0.01">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="additional_charges" class="form-label">Taxas Adicionais</label>
                                        <div class="input-group">
                                            <span class="input-group-text">R$</span>
                                            <input type="number" class="form-control" id="additional_charges" name="additional_charges" step="0.01">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="discount" class="form-label">Desconto</label>
                                        <div class="input-group">
                                            <span class="input-group-text">R$</span>
                                            <input type="number" class="form-control" id="discount" name="discount" step="0.01">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Campos Comuns -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="payment_method" class="form-label">Forma de Pagamento</label>
                                    <select class="form-select" id="payment_method" name="payment_method" required>
                                        <option value="">Selecione...</option>
                                        <option value="cash">Dinheiro</option>
                                        <option value="credit">Cartão de Crédito</option>
                                        <option value="debit">Cartão de Débito</option>
                                        <option value="transfer">Transferência Bancária</option>
                                        <option value="pix">PIX</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="payment_status" class="form-label">Status do Pagamento</label>
                                    <select class="form-select" id="payment_status" name="payment_status" required>
                                        <option value="pending">Pendente</option>
                                        <option value="partial">Parcial</option>
                                        <option value="paid">Pago</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card bg-light">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-baseline">
                                                <div>
                                                    <h5 class="card-title mb-0">Valor Total</h5>
                                                    <span class="h3 mb-0" id="total-price">R$ 0,00</span>
                                                </div>
                                                <div>
                                                    <button type="button" id="btn_calculate" class="btn btn-outline-primary" onclick="calculatePrice()">
                                                        <i class="fas fa-calculator"></i> Calcular
                                                    </button>
                                                    <button type="button" id="btn_update_total" class="btn btn-outline-primary" onclick="updateManualTotal()" style="display: none;">
                                                        <i class="fas fa-sync"></i> Atualizar Total
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
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
@endsection

@section('scripts')
<script>
    // Validação em tempo real
    (function () {
        'use strict'
        const forms = document.querySelectorAll('.needs-validation')
        Array.prototype.slice.call(forms).forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }
                form.classList.add('was-validated')
            }, false)
        })
    })()

    // Função para abrir modal de seleção de aeroporto
    function openAirportSelector(inputId) {
        // Aqui você pode implementar a lógica para abrir um modal com a lista de aeroportos
        const airports = [
            { id: 1, name: 'Aeroporto Internacional de Guarulhos (GRU)', address: 'Rod. Hélio Smidt, s/nº - Guarulhos, SP' },
            { id: 2, name: 'Aeroporto de Congonhas (CGH)', address: 'Av. Washington Luís, s/nº - São Paulo, SP' },
            // Adicione mais aeroportos conforme necessário
        ];

        const modalHtml = `
            <div class="modal fade" id="airportModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Selecionar Aeroporto</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="list-group">
                                ${airports.map(airport => `
                                    <button type="button" class="list-group-item list-group-item-action" 
                                            onclick="selectAirport('${inputId}', '${airport.address}')">
                                        <h6 class="mb-1">${airport.name}</h6>
                                        <small class="text-muted">${airport.address}</small>
                                    </button>
                                `).join('')}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;

        // Remover modal anterior se existir
        const oldModal = document.getElementById('airportModal');
        if (oldModal) oldModal.remove();

        // Adicionar novo modal ao documento
        document.body.insertAdjacentHTML('beforeend', modalHtml);

        // Inicializar e mostrar o modal
        const modal = new bootstrap.Modal(document.getElementById('airportModal'));
        modal.show();
    }

    // Função para selecionar o aeroporto
    function selectAirport(inputId, address) {
        document.getElementById(inputId).value = address;
        bootstrap.Modal.getInstance(document.getElementById('airportModal')).hide();
    }

    // Atualiza os campos baseado no tipo de serviço
    document.getElementById('service_type').addEventListener('change', function() {
        const serviceType = this.value;
        const serviceDetails = document.getElementById('serviceDetails');
        
        switch (serviceType) {
            case 'transfer_in':
                serviceDetails.innerHTML = `
                    <div class="col-md-6">
                        <label class="form-label">Aeroporto</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="pickup_location" name="pickup_location" required>
                            <button class="btn btn-outline-secondary" type="button" onclick="openAirportSelector('pickup_location')">
                                <i class="fas fa-plane"></i>
                            </button>
                        </div>
                        <div class="invalid-feedback">Informe o aeroporto</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Hotel</label>
                        <input type="text" class="form-control" id="dropoff_location" name="dropoff_location" required>
                        <div class="invalid-feedback">Informe o hotel</div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Data</label>
                        <input type="date" class="form-control" id="pickup_date" name="pickup_date" required>
                        <div class="invalid-feedback">Informe a data</div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Hora</label>
                        <input type="time" class="form-control" id="pickup_time" name="pickup_time" required>
                        <div class="invalid-feedback">Informe a hora</div>
                    </div>
                `;
                break;

            case 'transfer_out':
                serviceDetails.innerHTML = `
                    <div class="col-md-6">
                        <label class="form-label">Hotel</label>
                        <input type="text" class="form-control" id="pickup_location" name="pickup_location" required>
                        <div class="invalid-feedback">Informe o hotel</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Aeroporto</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="dropoff_location" name="dropoff_location" required>
                            <button class="btn btn-outline-secondary" type="button" onclick="openAirportSelector('dropoff_location')">
                                <i class="fas fa-plane"></i>
                            </button>
                        </div>
                        <div class="invalid-feedback">Informe o aeroporto</div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Data</label>
                        <input type="date" class="form-control" id="pickup_date" name="pickup_date" required>
                        <div class="invalid-feedback">Informe a data</div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Hora</label>
                        <input type="time" class="form-control" id="pickup_time" name="pickup_time" required>
                        <div class="invalid-feedback">Informe a hora</div>
                    </div>
                `;
                break;

            case 'point_to_point':
                serviceDetails.innerHTML = `
                    <div class="col-md-6">
                        <label class="form-label">Ponto de Partida</label>
                        <input type="text" class="form-control" id="pickup_location" name="pickup_location" required>
                        <div class="invalid-feedback">Informe o ponto de partida</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Destino</label>
                        <input type="text" class="form-control" id="dropoff_location" name="dropoff_location" required>
                        <div class="invalid-feedback">Informe o destino</div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Data</label>
                        <input type="date" class="form-control" id="pickup_date" name="pickup_date" required>
                        <div class="invalid-feedback">Informe a data</div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Hora</label>
                        <input type="time" class="form-control" id="pickup_time" name="pickup_time" required>
                        <div class="invalid-feedback">Informe a hora</div>
                    </div>
                    <div class="col-12 mt-3">
                        <button type="button" class="btn btn-outline-primary btn-sm" onclick="addStop()">
                            <i class="fas fa-plus"></i> Adicionar Parada
                        </button>
                    </div>
                    <div id="stops_container"></div>
                `;
                break;

            case 'hourly':
            case 'daily':
                serviceDetails.innerHTML = `
                    <div class="col-md-12">
                        <label class="form-label">Ponto de Encontro</label>
                        <input type="text" class="form-control" name="pickup_location" required>
                        <div class="invalid-feedback">Informe o ponto de encontro</div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Data Início</label>
                        <input type="date" class="form-control" id="pickup_date" name="pickup_date" required>
                        <div class="invalid-feedback">Informe a data de início</div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Hora Início</label>
                        <input type="time" class="form-control" id="pickup_time" name="pickup_time" required>
                        <div class="invalid-feedback">Informe a hora de início</div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Data Fim</label>
                        <input type="date" class="form-control" id="dropoff_date" name="dropoff_date" required>
                        <div class="invalid-feedback">Informe a data de fim</div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Hora Fim</label>
                        <input type="time" class="form-control" id="dropoff_time" name="dropoff_time" required>
                        <div class="invalid-feedback">Informe a hora de fim</div>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Descrição do Roteiro</label>
                        <textarea class="form-control" name="route_description" rows="3" required></textarea>
                        <div class="invalid-feedback">Descreva o roteiro planejado</div>
                    </div>
                `;
                break;

            default:
                serviceDetails.innerHTML = `
                    <div class="col-md-12">
                        <label class="form-label">Local do Evento</label>
                        <input type="text" class="form-control" name="pickup_location" required>
                        <div class="invalid-feedback">Informe o local do evento</div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Data Início</label>
                        <input type="date" class="form-control" id="pickup_date" name="pickup_date" required>
                        <div class="invalid-feedback">Informe a data de início</div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Hora Início</label>
                        <input type="time" class="form-control" id="pickup_time" name="pickup_time" required>
                        <div class="invalid-feedback">Informe a hora de início</div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Data Fim</label>
                        <input type="date" class="form-control" id="dropoff_date" name="dropoff_date" required>
                        <div class="invalid-feedback">Informe a data de fim</div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Hora Fim</label>
                        <input type="time" class="form-control" id="dropoff_time" name="dropoff_time" required>
                        <div class="invalid-feedback">Informe a hora de fim</div>
                    </div>
                `;
                break;
        }

        updatePriceFields();
    });

    // Função para adicionar parada
    let stopCount = 0;
    function addStop() {
        stopCount++;
        const stopHtml = `
            <div class="col-md-12 mt-2" id="stop_${stopCount}">
                <div class="input-group">
                    <span class="input-group-text">Parada ${stopCount}</span>
                    <input type="text" class="form-control" name="stops[]" required>
                    <button class="btn btn-outline-danger" type="button" onclick="removeStop(${stopCount})">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        `;
        document.getElementById('stops_container').insertAdjacentHTML('beforeend', stopHtml);
    }

    // Função para remover parada
    function removeStop(id) {
        document.getElementById(`stop_${id}`).remove();
    }
</script>
@endsection