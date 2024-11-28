@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Menu</h5>
                    <div class="list-group">
                        <a href="{{ route('dashboard') }}" class="list-group-item list-group-item-action active">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                        <a href="{{ route('vehicles.index') }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-car"></i> Veículos
                        </a>
                        <a href="{{ route('bookings.index') }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-calendar-alt"></i> Reservas
                        </a>
                        <a href="{{ route('drivers.index') }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-user"></i> Motoristas
                        </a>
                        <a href="{{ route('clients.index') }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-users"></i> Clientes
                        </a>
                        <a href="{{ route('parts.index') }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-cogs"></i> Peças
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-9">
            <div class="row">
                <!-- Statistics Cards -->
                <div class="col-md-4 mb-4">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <h5 class="card-title">Veículos Ativos</h5>
                            <h2 class="card-text">{{ $activeVehicles ?? 0 }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <h5 class="card-title">Reservas do Mês</h5>
                            <h2 class="card-text">{{ $monthlyBookings ?? 0 }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card bg-info text-white">
                        <div class="card-body">
                            <h5 class="card-title">Motoristas Disponíveis</h5>
                            <h2 class="card-text">{{ $availableDrivers ?? 0 }}</h2>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activities -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Atividades Recentes</h5>
                </div>
                <div class="card-body">
                    @if(isset($recentActivities) && count($recentActivities) > 0)
                        <ul class="list-group">
                            @foreach($recentActivities as $activity)
                                <li class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong>{{ $activity->type }}</strong>
                                            <p class="mb-0">{{ $activity->description }}</p>
                                        </div>
                                        <small class="text-muted">{{ $activity->created_at->diffForHumans() }}</small>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted mb-0">Nenhuma atividade recente.</p>
                    @endif
                </div>
            </div>

            <!-- Notifications -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Notificações</h5>
                </div>
                <div class="card-body">
                    @if(isset($notifications) && count($notifications) > 0)
                        <ul class="list-group">
                            @foreach($notifications as $notification)
                                <li class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong>{{ $notification->title }}</strong>
                                            <p class="mb-0">{{ $notification->message }}</p>
                                        </div>
                                        <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted mb-0">Nenhuma notificação.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
    .card {
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .list-group-item {
        border-left: none;
        border-right: none;
    }
    .list-group-item:first-child {
        border-top: none;
    }
    .list-group-item:last-child {
        border-bottom: none;
    }
</style>
@endpush
