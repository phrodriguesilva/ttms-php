@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Editar Reserva #{{ $booking->id }}</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('bookings.update', $booking) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="client_id" class="form-label">Cliente</label>
                                <select class="form-select @error('client_id') is-invalid @enderror" id="client_id" name="client_id" required>
                                    <option value="">Selecione um cliente...</option>
                                    @foreach($clients as $client)
                                        <option value="{{ $client->id }}" {{ old('client_id', $booking->client_id) == $client->id ? 'selected' : '' }}>
                                            {{ $client->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('client_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="vehicle_id" class="form-label">Veículo</label>
                                <select class="form-select @error('vehicle_id') is-invalid @enderror" id="vehicle_id" name="vehicle_id" required>
                                    <option value="">Selecione um veículo...</option>
                                    @foreach($vehicles as $vehicle)
                                        <option value="{{ $vehicle->id }}" {{ old('vehicle_id', $booking->vehicle_id) == $vehicle->id ? 'selected' : '' }}>
                                            {{ $vehicle->model }} ({{ $vehicle->plate }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('vehicle_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="driver_id" class="form-label">Motorista</label>
                                <select class="form-select @error('driver_id') is-invalid @enderror" id="driver_id" name="driver_id" required>
                                    <option value="">Selecione um motorista...</option>
                                    @foreach($drivers as $driver)
                                        <option value="{{ $driver->id }}" {{ old('driver_id', $booking->driver_id) == $driver->id ? 'selected' : '' }}>
                                            {{ $driver->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('driver_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label for="start_date" class="form-label">Data de Início</label>
                                <input type="datetime-local" class="form-control @error('start_date') is-invalid @enderror" 
                                       id="start_date" name="start_date" 
                                       value="{{ old('start_date', $booking->start_date->format('Y-m-d\TH:i')) }}" required>
                                @error('start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label for="end_date" class="form-label">Data de Fim</label>
                                <input type="datetime-local" class="form-control @error('end_date') is-invalid @enderror" 
                                       id="end_date" name="end_date" 
                                       value="{{ old('end_date', $booking->end_date->format('Y-m-d\TH:i')) }}" required>
                                @error('end_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                    <option value="pending" {{ old('status', $booking->status) == 'pending' ? 'selected' : '' }}>Pendente</option>
                                    <option value="confirmed" {{ old('status', $booking->status) == 'confirmed' ? 'selected' : '' }}>Confirmada</option>
                                    <option value="in_progress" {{ old('status', $booking->status) == 'in_progress' ? 'selected' : '' }}>Em Andamento</option>
                                    <option value="completed" {{ old('status', $booking->status) == 'completed' ? 'selected' : '' }}>Concluída</option>
                                    <option value="cancelled" {{ old('status', $booking->status) == 'cancelled' ? 'selected' : '' }}>Cancelada</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label for="payment_status" class="form-label">Status do Pagamento</label>
                                <select class="form-select @error('payment_status') is-invalid @enderror" id="payment_status" name="payment_status" required>
                                    <option value="pending" {{ old('payment_status', $booking->payment_status) == 'pending' ? 'selected' : '' }}>Pendente</option>
                                    <option value="paid" {{ old('payment_status', $booking->payment_status) == 'paid' ? 'selected' : '' }}>Pago</option>
                                    <option value="partially_paid" {{ old('payment_status', $booking->payment_status) == 'partially_paid' ? 'selected' : '' }}>Parcialmente Pago</option>
                                    <option value="refunded" {{ old('payment_status', $booking->payment_status) == 'refunded' ? 'selected' : '' }}>Reembolsado</option>
                                </select>
                                @error('payment_status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="pickup_location" class="form-label">Local de Retirada</label>
                                <input type="text" class="form-control @error('pickup_location') is-invalid @enderror" 
                                       id="pickup_location" name="pickup_location" 
                                       value="{{ old('pickup_location', $booking->pickup_location) }}" required>
                                @error('pickup_location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="dropoff_location" class="form-label">Local de Devolução</label>
                                <input type="text" class="form-control @error('dropoff_location') is-invalid @enderror" 
                                       id="dropoff_location" name="dropoff_location" 
                                       value="{{ old('dropoff_location', $booking->dropoff_location) }}" required>
                                @error('dropoff_location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="total_amount" class="form-label">Valor Total</label>
                                <div class="input-group">
                                    <span class="input-group-text">R$</span>
                                    <input type="number" class="form-control @error('total_amount') is-invalid @enderror" 
                                           id="total_amount" name="total_amount" 
                                           value="{{ old('total_amount', $booking->total_amount) }}" 
                                           min="0" step="0.01" required>
                                </div>
                                @error('total_amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-8">
                                <label for="special_requirements" class="form-label">Requisitos Especiais</label>
                                <input type="text" class="form-control @error('special_requirements') is-invalid @enderror" 
                                       id="special_requirements" name="special_requirements" 
                                       value="{{ old('special_requirements', $booking->special_requirements) }}">
                                @error('special_requirements')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="notes" class="form-label">Observações</label>
                                <textarea class="form-control @error('notes') is-invalid @enderror" 
                                          id="notes" name="notes" rows="3">{{ old('notes', $booking->notes) }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <a href="{{ route('bookings.index') }}" class="btn btn-secondary">Cancelar</a>
                                <button type="submit" class="btn btn-primary">Atualizar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Update end_date minimum when start_date changes
    document.getElementById('start_date').addEventListener('change', function() {
        document.getElementById('end_date').min = this.value;
        if (document.getElementById('end_date').value < this.value) {
            document.getElementById('end_date').value = this.value;
        }
    });
});
</script>
@endpush

@endsection
