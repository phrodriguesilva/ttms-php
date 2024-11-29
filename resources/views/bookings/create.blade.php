@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Nova Reserva</h2>
            <a href="{{ route('bookings.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Voltar
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('bookings.store') }}" method="POST" id="bookingForm">
                    @csrf

                    <div class="row">
                        <!-- Informações da Corrida -->
                        <div class="col-md-6 mb-4">
                            <h4 class="mb-3">Informações da Corrida</h4>
                            
                            <div class="mb-3">
                                <label for="service_type" class="form-label">Tipo de Serviço*</label>
                                <select class="form-select @error('service_type') is-invalid @enderror" 
                                        id="service_type" name="service_type" required>
                                    <option value="">Selecione...</option>
                                    <option value="transfer_in">Transfer IN (Aeroporto → Hotel)</option>
                                    <option value="transfer_out">Transfer OUT (Hotel → Aeroporto)</option>
                                    <option value="point_to_point">Transfer Ponto a Ponto</option>
                                    <option value="hourly">Por Hora</option>
                                    <option value="event">Evento</option>
                                    <option value="tour">Tour</option>
                                </select>
                                @error('service_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="pickup_location" class="form-label">Local de Embarque*</label>
                                <input type="text" class="form-control @error('pickup_location') is-invalid @enderror" 
                                       id="pickup_location" name="pickup_location" required>
                                @error('pickup_location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="dropoff_location" class="form-label">Local de Desembarque*</label>
                                <input type="text" class="form-control @error('dropoff_location') is-invalid @enderror" 
                                       id="dropoff_location" name="dropoff_location" required>
                                @error('dropoff_location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Detalhes de Data e Tempo -->
                        <div class="col-md-6 mb-4">
                            <h4 class="mb-3">Detalhes de Data e Tempo</h4>
                            
                            <div class="mb-3">
                                <label for="pickup_datetime" class="form-label">Data e Hora de Embarque*</label>
                                <input type="datetime-local" class="form-control @error('pickup_datetime') is-invalid @enderror" 
                                       id="pickup_datetime" name="pickup_datetime" required>
                                @error('pickup_datetime')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="dropoff_datetime" class="form-label">Data e Hora de Desembarque*</label>
                                <input type="datetime-local" class="form-control @error('dropoff_datetime') is-invalid @enderror" 
                                       id="dropoff_datetime" name="dropoff_datetime" required>
                                @error('dropoff_datetime')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3" id="serviceDetails">
                                <!-- Dynamic service-specific details will be populated here -->
                            </div>
                        </div>

                        <!-- Informações do Cliente -->
                        <div class="col-md-6 mb-4">
                            <h4 class="mb-3">Informações do Cliente</h4>
                            
                            <div class="mb-3">
                                <label for="client_id" class="form-label">Cliente*</label>
                                <select class="form-select @error('client_id') is-invalid @enderror" 
                                        id="client_id" name="client_id" required>
                                    <option value="">Selecione um cliente</option>
                                    @foreach($clients as $client)
                                        <option value="{{ $client->id }}">{{ $client->name }}</option>
                                    @endforeach
                                </select>
                                @error('client_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="passenger_count" class="form-label">Número de Passageiros*</label>
                                <input type="number" class="form-control @error('passenger_count') is-invalid @enderror" 
                                       id="passenger_count" name="passenger_count" min="1" required>
                                @error('passenger_count')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Valores e Pagamento -->
                        <div class="col-md-6 mb-4">
                            <h4 class="mb-3">Valores e Pagamento</h4>
                            
                            <div class="mb-3">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="price_type" 
                                           id="price_type_auto" value="auto" checked>
                                    <label class="form-check-label" for="price_type_auto">Cálculo Automático</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="price_type" 
                                           id="price_type_manual" value="manual">
                                    <label class="form-check-label" for="price_type_manual">Definição Manual</label>
                                </div>
                            </div>
                            
                            <div id="manual_price_fields" style="display: none;">
                                <div class="mb-3">
                                    <label for="base_rate" class="form-label">Tarifa Base</label>
                                    <div class="input-group">
                                        <span class="input-group-text">R$</span>
                                        <input type="number" class="form-control" id="base_rate" 
                                               name="base_rate" step="0.01" min="0">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Status e Observações -->
                        <div class="col-12">
                            <h4 class="mb-3">Status e Observações</h4>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="booking_status" class="form-label">Status*</label>
                                    <select class="form-select @error('booking_status') is-invalid @enderror" 
                                            id="booking_status" name="booking_status" required>
                                        <option value="pending">Pendente</option>
                                        <option value="confirmed">Confirmado</option>
                                        <option value="completed">Concluído</option>
                                        <option value="cancelled">Cancelado</option>
                                    </select>
                                    @error('booking_status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="notes" class="form-label">Observações</label>
                                    <textarea class="form-control @error('notes') is-invalid @enderror" 
                                              id="notes" name="notes" rows="3"></textarea>
                                    @error('notes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Salvar Reserva
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const serviceTypeSelect = document.getElementById('service_type');
    const serviceDetails = document.getElementById('serviceDetails');
    const priceTypeRadios = document.querySelectorAll('input[name="price_type"]');
    const manualPriceFields = document.getElementById('manual_price_fields');

    // Price type toggle
    priceTypeRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            manualPriceFields.style.display = this.value === 'manual' ? 'block' : 'none';
        });
    });

    // Dynamic service details
    function updateServiceDetails() {
        const serviceType = serviceTypeSelect.value;
        serviceDetails.innerHTML = '';

        switch (serviceType) {
            case 'transfer_in':
                serviceDetails.innerHTML = `
                    <div class="mb-3">
                        <label class="form-label">Aeroporto de Origem</label>
                        <input type="text" class="form-control" name="origin_airport" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Número do Voo</label>
                        <input type="text" class="form-control" name="flight_number">
                    </div>
                `;
                break;
            
            case 'transfer_out':
                serviceDetails.innerHTML = `
                    <div class="mb-3">
                        <label class="form-label">Aeroporto de Destino</label>
                        <input type="text" class="form-control" name="destination_airport" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Horário do Voo</label>
                        <input type="time" class="form-control" name="flight_time">
                    </div>
                `;
                break;
            
            case 'point_to_point':
                serviceDetails.innerHTML = `
                    <div class="mb-3">
                        <label class="form-label">Distância Estimada (km)</label>
                        <input type="number" class="form-control" name="estimated_distance" min="0" step="0.1">
                    </div>
                `;
                break;
            
            case 'hourly':
                serviceDetails.innerHTML = `
                    <div class="mb-3">
                        <label class="form-label">Duração (horas)</label>
                        <input type="number" class="form-control" name="duration" min="1" max="12" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tipo de Roteiro</label>
                        <select class="form-select" name="route_type">
                            <option value="fixed">Roteiro Fixo</option>
                            <option value="flexible">Roteiro Flexível</option>
                        </select>
                    </div>
                `;
                break;
            
            case 'event':
                serviceDetails.innerHTML = `
                    <div class="mb-3">
                        <label class="form-label">Tipo de Evento</label>
                        <select class="form-select" name="event_type">
                            <option value="corporate">Corporativo</option>
                            <option value="wedding">Casamento</option>
                            <option value="social">Social</option>
                            <option value="other">Outro</option>
                        </select>
                    </div>
                `;
                break;
            
            case 'tour':
                serviceDetails.innerHTML = `
                    <div class="mb-3">
                        <label class="form-label">Duração (dias)</label>
                        <input type="number" class="form-control" name="tour_duration" min="1" max="14">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tipo de Tour</label>
                        <select class="form-select" name="tour_type">
                            <option value="city">City Tour</option>
                            <option value="historical">Histórico</option>
                            <option value="nature">Natureza</option>
                            <option value="custom">Personalizado</option>
                        </select>
                    </div>
                `;
                break;
            
            default:
                serviceDetails.innerHTML = `
                    <div class="mb-3">
                        <p class="text-muted">Selecione um tipo de serviço para mais detalhes.</p>
                    </div>
                `;
        }
    }

    // Datetime validation
    const pickupDatetime = document.getElementById('pickup_datetime');
    const dropoffDatetime = document.getElementById('dropoff_datetime');

    function validateDatetimes() {
        const pickup = new Date(pickupDatetime.value);
        const dropoff = new Date(dropoffDatetime.value);

        if (pickup >= dropoff) {
            dropoffDatetime.setCustomValidity('A data de desembarque deve ser posterior à data de embarque');
        } else {
            dropoffDatetime.setCustomValidity('');
        }
    }

    pickupDatetime.addEventListener('change', validateDatetimes);
    dropoffDatetime.addEventListener('change', validateDatetimes);

    // Initial setup
    updateServiceDetails();
    serviceTypeSelect.addEventListener('change', updateServiceDetails);
});
</script>
@endpush