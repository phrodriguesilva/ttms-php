@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-2 bg-light sidebar">
            @include('layouts.sidebar')
        </div>

        <!-- Main content -->
        <div class="col-md-10">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Editar Veículo</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('vehicles.update', $vehicle) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="make" class="form-label">Marca</label>
                                    <input type="text" class="form-control @error('make') is-invalid @enderror" 
                                           id="make" name="make" value="{{ old('make', $vehicle->make) }}" required>
                                    @error('make')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="model" class="form-label">Modelo</label>
                                    <input type="text" class="form-control @error('model') is-invalid @enderror" 
                                           id="model" name="model" value="{{ old('model', $vehicle->model) }}" required>
                                    @error('model')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="year" class="form-label">Ano</label>
                                    <input type="number" class="form-control @error('year') is-invalid @enderror" 
                                           id="year" name="year" value="{{ old('year', $vehicle->year) }}" 
                                           min="1900" max="{{ date('Y') + 1 }}" required>
                                    @error('year')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="plate" class="form-label">Placa</label>
                                    <input type="text" class="form-control @error('plate') is-invalid @enderror" 
                                           id="plate" name="plate" value="{{ old('plate', $vehicle->plate) }}" 
                                           maxlength="20" required>
                                    @error('plate')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="vin" class="form-label">VIN/Chassi</label>
                                    <input type="text" class="form-control @error('vin') is-invalid @enderror" 
                                           id="vin" name="vin" value="{{ old('vin', $vehicle->vin) }}" 
                                           maxlength="17" required>
                                    @error('vin')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select @error('status') is-invalid @enderror" 
                                            id="status" name="status" required>
                                        <option value="">Selecione...</option>
                                        <option value="active" {{ old('status', $vehicle->status) == 'active' ? 'selected' : '' }}>
                                            Ativo
                                        </option>
                                        <option value="maintenance" {{ old('status', $vehicle->status) == 'maintenance' ? 'selected' : '' }}>
                                            Em Manutenção
                                        </option>
                                        <option value="inactive" {{ old('status', $vehicle->status) == 'inactive' ? 'selected' : '' }}>
                                            Inativo
                                        </option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="mileage" class="form-label">Quilometragem</label>
                                    <input type="number" class="form-control @error('mileage') is-invalid @enderror" 
                                           id="mileage" name="mileage" value="{{ old('mileage', $vehicle->mileage) }}" 
                                           min="0" required>
                                    @error('mileage')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="fuel_type" class="form-label">Tipo de Combustível</label>
                                    <select class="form-select @error('fuel_type') is-invalid @enderror" 
                                            id="fuel_type" name="fuel_type" required>
                                        <option value="">Selecione...</option>
                                        <option value="gasoline" {{ old('fuel_type', $vehicle->fuel_type) == 'gasoline' ? 'selected' : '' }}>
                                            Gasolina
                                        </option>
                                        <option value="ethanol" {{ old('fuel_type', $vehicle->fuel_type) == 'ethanol' ? 'selected' : '' }}>
                                            Etanol
                                        </option>
                                        <option value="diesel" {{ old('fuel_type', $vehicle->fuel_type) == 'diesel' ? 'selected' : '' }}>
                                            Diesel
                                        </option>
                                        <option value="flex" {{ old('fuel_type', $vehicle->fuel_type) == 'flex' ? 'selected' : '' }}>
                                            Flex
                                        </option>
                                    </select>
                                    @error('fuel_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="last_maintenance" class="form-label">Última Manutenção</label>
                                    <input type="date" class="form-control @error('last_maintenance') is-invalid @enderror" 
                                           id="last_maintenance" name="last_maintenance" 
                                           value="{{ old('last_maintenance', $vehicle->last_maintenance?->format('Y-m-d')) }}">
                                    @error('last_maintenance')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="next_maintenance" class="form-label">Próxima Manutenção</label>
                                    <input type="date" class="form-control @error('next_maintenance') is-invalid @enderror" 
                                           id="next_maintenance" name="next_maintenance" 
                                           value="{{ old('next_maintenance', $vehicle->next_maintenance?->format('Y-m-d')) }}">
                                    @error('next_maintenance')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="notes" class="form-label">Observações</label>
                                <textarea class="form-control @error('notes') is-invalid @enderror" 
                                          id="notes" name="notes" rows="3">{{ old('notes', $vehicle->notes) }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('vehicles.index') }}" class="btn btn-secondary">Cancelar</a>
                                <button type="submit" class="btn btn-primary">Atualizar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .sidebar {
        min-height: calc(100vh - 56px);
        box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
    }
</style>
@endpush
