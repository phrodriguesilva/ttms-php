@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Detalhes da Reserva #{{ $booking->id }}</h3>
                        <div>
                            @if($booking->status != 'cancelled' && $booking->status != 'completed')
                                <a href="{{ route('bookings.edit', $booking) }}" class="btn btn-warning">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                            @endif
                            <a href="{{ route('bookings.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Voltar
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Status Cards -->
                        <div class="col-md-12 mb-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card bg-light">
                                        <div class="card-body">
                                            <h5 class="card-title">Status da Reserva</h5>
                                            @php
                                                $statusClasses = [
                                                    'pending' => 'bg-warning',
                                                    'confirmed' => 'bg-info',
                                                    'in_progress' => 'bg-primary',
                                                    'completed' => 'bg-success',
                                                    'cancelled' => 'bg-danger'
                                                ];
                                                $statusLabels = [
                                                    'pending' => 'Pendente',
                                                    'confirmed' => 'Confirmada',
                                                    'in_progress' => 'Em Andamento',
                                                    'completed' => 'Concluída',
                                                    'cancelled' => 'Cancelada'
                                                ];
                                            @endphp
                                            <span class="badge {{ $statusClasses[$booking->status] }} fs-6">
                                                {{ $statusLabels[$booking->status] }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card bg-light">
                                        <div class="card-body">
                                            <h5 class="card-title">Status do Pagamento</h5>
                                            @php
                                                $paymentClasses = [
                                                    'pending' => 'bg-warning',
                                                    'paid' => 'bg-success',
                                                    'partially_paid' => 'bg-info',
                                                    'refunded' => 'bg-secondary'
                                                ];
                                                $paymentLabels = [
                                                    'pending' => 'Pendente',
                                                    'paid' => 'Pago',
                                                    'partially_paid' => 'Parcial',
                                                    'refunded' => 'Reembolsado'
                                                ];
                                            @endphp
                                            <span class="badge {{ $paymentClasses[$booking->payment_status] }} fs-6">
                                                {{ $paymentLabels[$booking->payment_status] }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Main Information -->
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-header">
                                    <h5 class="card-title">Informações Principais</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <tr>
                                            <th style="width: 150px;">Cliente:</th>
                                            <td>{{ $booking->client->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Veículo:</th>
                                            <td>{{ $booking->vehicle->model }} ({{ $booking->vehicle->plate }})</td>
                                        </tr>
                                        <tr>
                                            <th>Motorista:</th>
                                            <td>{{ $booking->driver->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Data de Início:</th>
                                            <td>{{ $booking->start_date->format('d/m/Y H:i') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Data de Fim:</th>
                                            <td>{{ $booking->end_date->format('d/m/Y H:i') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Valor Total:</th>
                                            <td>R$ {{ number_format($booking->total_amount, 2, ',', '.') }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Pricing Details -->
<div class="col-md-6">
    <div class="card h-100">
        <div class="card-header">
            <h5 class="card-title">Detalhes do Preço</h5>
        </div>
        <div class="card-body">
            @if($booking->priceDetails)
                @if($booking->priceDetails->calculation_type === 'auto')
                    <table class="table table-borderless">
                        <tr>
                            <th style="width: 150px;">Tipo de Cálculo:</th>
                            <td><span class="badge bg-info">Automático</span></td>
                        </tr>
                        <tr>
                            <th>Tipo de Serviço:</th>
                            <td>{{ $booking->priceDetails->service_type }}</td>
                        </tr>
                        @if($booking->priceDetails->distance)
                        <tr>
                            <th>Distância:</th>
                            <td>{{ $booking->priceDetails->distance }} km</td>
                        </tr>
                        @endif
                        @if($booking->priceDetails->hours)
                        <tr>
                            <th>Horas:</th>
                            <td>{{ $booking->priceDetails->hours }}</td>
                        </tr>
                        @endif
                        @if($booking->priceDetails->days)
                        <tr>
                            <th>Dias:</th>
                            <td>{{ $booking->priceDetails->days }}</td>
                        </tr>
                        @endif
                        <tr>
                            <th>Passageiros:</th>
                            <td>{{ $booking->priceDetails->passengers }}</td>
                        </tr>
                    </table>
                @else
                    <table class="table table-borderless">
                        <tr>
                            <th style="width: 150px;">Tipo de Cálculo:</th>
                            <td><span class="badge bg-warning text-dark">Manual</span></td>
                        </tr>
                        <tr>
                            <th>Valor Base:</th>
                            <td>R$ {{ number_format($booking->priceDetails->base_rate, 2, ',', '.') }}</td>
                        </tr>
                        @if($booking->priceDetails->additional_charges > 0)
                        <tr>
                            <th>Taxas Adicionais:</th>
                            <td>R$ {{ number_format($booking->priceDetails->additional_charges, 2, ',', '.') }}</td>
                        </tr>
                        @endif
                        @if($booking->priceDetails->discount > 0)
                        <tr>
                            <th>Desconto:</th>
                            <td>R$ {{ number_format($booking->priceDetails->discount, 2, ',', '.') }}</td>
                        </tr>
                        @endif
                    </table>
                @endif
            @else
                <p class="text-muted">Detalhes do preço não disponíveis</p>
            @endif
        </div>
    </div>
</div>

                        <!-- Location Information -->
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-header">
                                    <h5 class="card-title">Informações de Localização</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <tr>
                                            <th style="width: 150px;">Local de Retirada:</th>
                                            <td>{{ $booking->pickup_location }}</td>
                                        </tr>
                                        <tr>
                                            <th>Local de Devolução:</th>
                                            <td>{{ $booking->dropoff_location }}</td>
                                        </tr>
                                        <tr>
                                            <th>Requisitos Especiais:</th>
                                            <td>{{ $booking->special_requirements ?: 'Nenhum' }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Additional Information -->
                        <div class="col-md-12 mt-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Informações Adicionais</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h6>Observações:</h6>
                                            <p class="mb-0">{{ $booking->notes ?: 'Nenhuma observação registrada.' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Nova Timeline de Status -->
                        <div class="col-md-12 mt-4">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <x-booking-timeline :booking="$booking" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.timeline {
    position: relative;
    padding: 20px 0;
}

.timeline-item {
    position: relative;
    padding-left: 40px;
    margin-bottom: 20px;
}

.timeline-marker {
    position: absolute;
    left: 0;
    top: 0;
    width: 15px;
    height: 15px;
    border-radius: 50%;
}

.timeline-content {
    padding-bottom: 20px;
    border-bottom: 1px solid #eee;
}

.timeline-title {
    margin-bottom: 5px;
}

.timeline-text {
    color: #666;
    margin-bottom: 0;
}
</style>

@endsection