@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>{{ isset($driver) ? 'Editar' : 'Novo' }} Motorista</h2>
            <a href="{{ route('drivers.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Voltar
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ isset($driver) ? route('drivers.update', $driver->id) : route('drivers.store') }}" 
                      method="POST" id="driverForm">
                    @csrf
                    @if(isset($driver))
                        @method('PUT')
                    @endif

                    <div class="row">
                        <!-- Informações Pessoais -->
                        <div class="col-md-6 mb-4">
                            <h4 class="mb-3">Informações Pessoais</h4>
                            
                            <div class="mb-3">
                                <label for="name" class="form-label">Nome Completo*</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name', $driver->name ?? '') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="email" class="form-label">Email*</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email', $driver->email ?? '') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="phone" class="form-label">Telefone*</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                       id="phone" name="phone" value="{{ old('phone', $driver->phone ?? '') }}" required>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="address" class="form-label">Endereço*</label>
                                <input type="text" class="form-control @error('address') is-invalid @enderror" 
                                       id="address" name="address" value="{{ old('address', $driver->address ?? '') }}" required>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Informações da CNH e Emergência -->
                        <div class="col-md-6 mb-4">
                            <h4 class="mb-3">Informações da CNH e Emergência</h4>
                            
                            <div class="mb-3">
                                <label for="license_number" class="form-label">Número da CNH*</label>
                                <input type="text" class="form-control @error('license_number') is-invalid @enderror" 
                                       id="license_number" name="license_number" 
                                       value="{{ old('license_number', $driver->license_number ?? '') }}" required>
                                @error('license_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="license_expiry" class="form-label">Validade da CNH*</label>
                                <input type="date" class="form-control @error('license_expiry') is-invalid @enderror" 
                                       id="license_expiry" name="license_expiry" 
                                       value="{{ old('license_expiry', isset($driver) ? $driver->license_expiry->format('Y-m-d') : '') }}" required>
                                @error('license_expiry')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="emergency_contact" class="form-label">Contato de Emergência</label>
                                <input type="text" class="form-control @error('emergency_contact') is-invalid @enderror" 
                                       id="emergency_contact" name="emergency_contact" 
                                       value="{{ old('emergency_contact', $driver->emergency_contact ?? '') }}">
                                @error('emergency_contact')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="emergency_phone" class="form-label">Telefone de Emergência</label>
                                <input type="text" class="form-control @error('emergency_phone') is-invalid @enderror" 
                                       id="emergency_phone" name="emergency_phone" 
                                       value="{{ old('emergency_phone', $driver->emergency_phone ?? '') }}">
                                @error('emergency_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Status e Observações -->
                        <div class="col-12">
                            <h4 class="mb-3">Status e Observações</h4>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="status" class="form-label">Status*</label>
                                    <select class="form-select @error('status') is-invalid @enderror" 
                                            id="status" name="status" required>
                                        <option value="active" {{ (old('status', $driver->status ?? '') == 'active') ? 'selected' : '' }}>
                                            Ativo
                                        </option>
                                        <option value="inactive" {{ (old('status', $driver->status ?? '') == 'inactive') ? 'selected' : '' }}>
                                            Inativo
                                        </option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="notes" class="form-label">Observações</label>
                                    <textarea class="form-control @error('notes') is-invalid @enderror" 
                                              id="notes" name="notes" rows="3">{{ old('notes', $driver->notes ?? '') }}</textarea>
                                    @error('notes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Salvar
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
    // Phone masks
    const phoneMask = IMask(document.getElementById('phone'), {
        mask: '(00) 00000-0000'
    });
    
    const emergencyPhoneMask = IMask(document.getElementById('emergency_phone'), {
        mask: '(00) 00000-0000'
    });
});
</script>
@endpush
