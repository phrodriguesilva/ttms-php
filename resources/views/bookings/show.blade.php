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

                        <!-- Timeline -->
                        <div class="col-md-12 mt-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Linha do Tempo</h5>
                                </div>
                                <div class="card-body">
                                    <div class="timeline">
                                        <div class="timeline-item">
                                            <div class="timeline-marker bg-success"></div>
                                            <div class="timeline-content">
                                                <h6 class="timeline-title">Reserva Criada</h6>
                                                <p class="timeline-text">{{ $booking->created_at->format('d/m/Y H:i') }}</p>
                                            </div>
                                        </div>
                                        @if($booking->updated_at != $booking->created_at)
                                            <div class="timeline-item">
                                                <div class="timeline-marker bg-info"></div>
                                                <div class="timeline-content">
                                                    <h6 class="timeline-title">Última Atualização</h6>
                                                    <p class="timeline-text">{{ $booking->updated_at->format('d/m/Y H:i') }}</p>
                                                </div>
                                            </div>
                                        @endif
                                        <!-- Add more timeline items based on booking history -->
                                    </div>
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
