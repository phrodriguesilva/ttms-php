@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-2 bg-light sidebar">
            <div class="position-sticky pt-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('dashboard') }}">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('vehicles.index') }}">
                            <i class="fas fa-car"></i> Veículos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('bookings.index') }}">
                            <i class="fas fa-calendar-alt"></i> Reservas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('drivers.index') }}">
                            <i class="fas fa-user"></i> Motoristas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('clients.index') }}">
                            <i class="fas fa-users"></i> Clientes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('supplies.index') }}">
                            <i class="fas fa-boxes"></i> Suprimentos
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Main content -->
        <div class="col-md-10">
            <div class="container-fluid">
                <!-- Statistics Cards -->
                <div class="row mt-4">
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-primary text-white mb-4">
                            <div class="card-body">
                                <h5 class="card-title">Veículos Ativos</h5>
                                <h2 class="mb-0">{{ $activeVehicles ?? 0 }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-success text-white mb-4">
                            <div class="card-body">
                                <h5 class="card-title">Reservas do Mês</h5>
                                <h2 class="mb-0">{{ $monthlyBookings ?? 0 }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-warning text-white mb-4">
                            <div class="card-body">
                                <h5 class="card-title">Motoristas Disponíveis</h5>
                                <h2 class="mb-0">{{ $availableDrivers ?? 0 }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-info text-white mb-4">
                            <div class="card-body">
                                <h5 class="card-title">Suprimentos em Estoque</h5>
                                <h2 class="mb-0">{{ $suppliesInStock ?? 0 }}</h2>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Bookings -->
                <div class="row mt-4">
                    <div class="col-xl-6">
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-calendar-alt me-1"></i>
                                Reservas Recentes
                            </div>
                            <div class="card-body">
                                @if(isset($recentBookings) && count($recentBookings) > 0)
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Cliente</th>
                                                    <th>Veículo</th>
                                                    <th>Data</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($recentBookings as $booking)
                                                    <tr>
                                                        <td>{{ $booking->client->name }}</td>
                                                        <td>{{ $booking->vehicle->model }}</td>
                                                        <td>{{ $booking->start_date->format('d/m/Y') }}</td>
                                                        <td>
                                                            <span class="badge bg-{{ $booking->status_color }}">
                                                                {{ $booking->status }}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <p class="text-muted mb-0">Nenhuma reserva recente.</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Vehicle Status -->
                    <div class="col-xl-6">
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-car me-1"></i>
                                Status dos Veículos
                            </div>
                            <div class="card-body">
                                @if(isset($vehicleStatus) && count($vehicleStatus) > 0)
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Veículo</th>
                                                    <th>Placa</th>
                                                    <th>Status</th>
                                                    <th>Última Atualização</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($vehicleStatus as $vehicle)
                                                    <tr>
                                                        <td>{{ $vehicle->model }}</td>
                                                        <td>{{ $vehicle->plate }}</td>
                                                        <td>
                                                            <span class="badge bg-{{ $vehicle->status_color }}">
                                                                {{ $vehicle->status }}
                                                            </span>
                                                        </td>
                                                        <td>{{ $vehicle->updated_at->diffForHumans() }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <p class="text-muted mb-0">Nenhum veículo cadastrado.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
    .sidebar {
        min-height: calc(100vh - 56px);
        box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
    }

    .sidebar .nav-link {
        color: #333;
        padding: .5rem 1rem;
    }

    .sidebar .nav-link.active {
        color: #007bff;
    }

    .sidebar .nav-link:hover {
        color: #007bff;
    }

    .card {
        border-radius: .5rem;
    }

    .card-header {
        background-color: rgba(0, 0, 0, .03);
    }
</style>
@endpush
