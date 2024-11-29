@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="card-title mb-0">{{ isset($airport) ? 'Editar Aeroporto' : 'Novo Aeroporto' }}</h3>
                    <span class="badge bg-primary">Status: {{ isset($airport) ? 'Editando' : 'Novo' }}</span>
                </div>
                <button type="submit" form="airportForm" class="btn btn-primary">
                    <i class="fas fa-save"></i> Salvar Aeroporto
                </button>
            </div>
            
            <div class="card-body">
                <form id="airportForm" action="{{ isset($airport) ? route('airports.update', $airport->id) : route('airports.store') }}" 
                      method="POST" class="needs-validation" novalidate>
                    @csrf
                    @if(isset($airport))
                        @method('PUT')
                    @endif

                    <!-- Informações Básicas -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fas fa-plane me-2"></i>
                                Informações Básicas
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-8">
                                    <label for="name" class="form-label">Nome do Aeroporto*</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name', $airport->name ?? '') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="code" class="form-label">Código IATA*</label>
                                    <input type="text" class="form-control @error('code') is-invalid @enderror" 
                                           id="code" name="code" value="{{ old('code', $airport->code ?? '') }}" 
                                           required maxlength="10" style="text-transform: uppercase;">
                                    @error('code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Localização -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fas fa-map-marker-alt me-2"></i>
                                Localização
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-12">
                                    <label for="address" class="form-label">Endereço*</label>
                                    <input type="text" class="form-control @error('address') is-invalid @enderror" 
                                           id="address" name="address" value="{{ old('address', $airport->address ?? '') }}" required>
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="city" class="form-label">Cidade*</label>
                                    <input type="text" class="form-control @error('city') is-invalid @enderror" 
                                           id="city" name="city" value="{{ old('city', $airport->city ?? '') }}" required>
                                    @error('city')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="state" class="form-label">Estado*</label>
                                    <select class="form-select @error('state') is-invalid @enderror" id="state" name="state" required>
                                        <option value="">Selecione...</option>
                                        <option value="AC" {{ old('state', $airport->state ?? '') == 'AC' ? 'selected' : '' }}>Acre</option>
                                        <option value="AL" {{ old('state', $airport->state ?? '') == 'AL' ? 'selected' : '' }}>Alagoas</option>
                                        <option value="AP" {{ old('state', $airport->state ?? '') == 'AP' ? 'selected' : '' }}>Amapá</option>
                                        <option value="AM" {{ old('state', $airport->state ?? '') == 'AM' ? 'selected' : '' }}>Amazonas</option>
                                        <option value="BA" {{ old('state', $airport->state ?? '') == 'BA' ? 'selected' : '' }}>Bahia</option>
                                        <option value="CE" {{ old('state', $airport->state ?? '') == 'CE' ? 'selected' : '' }}>Ceará</option>
                                        <option value="DF" {{ old('state', $airport->state ?? '') == 'DF' ? 'selected' : '' }}>Distrito Federal</option>
                                        <option value="ES" {{ old('state', $airport->state ?? '') == 'ES' ? 'selected' : '' }}>Espírito Santo</option>
                                        <option value="GO" {{ old('state', $airport->state ?? '') == 'GO' ? 'selected' : '' }}>Goiás</option>
                                        <option value="MA" {{ old('state', $airport->state ?? '') == 'MA' ? 'selected' : '' }}>Maranhão</option>
                                        <option value="MT" {{ old('state', $airport->state ?? '') == 'MT' ? 'selected' : '' }}>Mato Grosso</option>
                                        <option value="MS" {{ old('state', $airport->state ?? '') == 'MS' ? 'selected' : '' }}>Mato Grosso do Sul</option>
                                        <option value="MG" {{ old('state', $airport->state ?? '') == 'MG' ? 'selected' : '' }}>Minas Gerais</option>
                                        <option value="PA" {{ old('state', $airport->state ?? '') == 'PA' ? 'selected' : '' }}>Pará</option>
                                        <option value="PB" {{ old('state', $airport->state ?? '') == 'PB' ? 'selected' : '' }}>Paraíba</option>
                                        <option value="PR" {{ old('state', $airport->state ?? '') == 'PR' ? 'selected' : '' }}>Paraná</option>
                                        <option value="PE" {{ old('state', $airport->state ?? '') == 'PE' ? 'selected' : '' }}>Pernambuco</option>
                                        <option value="PI" {{ old('state', $airport->state ?? '') == 'PI' ? 'selected' : '' }}>Piauí</option>
                                        <option value="RJ" {{ old('state', $airport->state ?? '') == 'RJ' ? 'selected' : '' }}>Rio de Janeiro</option>
                                        <option value="RN" {{ old('state', $airport->state ?? '') == 'RN' ? 'selected' : '' }}>Rio Grande do Norte</option>
                                        <option value="RS" {{ old('state', $airport->state ?? '') == 'RS' ? 'selected' : '' }}>Rio Grande do Sul</option>
                                        <option value="RO" {{ old('state', $airport->state ?? '') == 'RO' ? 'selected' : '' }}>Rondônia</option>
                                        <option value="RR" {{ old('state', $airport->state ?? '') == 'RR' ? 'selected' : '' }}>Roraima</option>
                                        <option value="SC" {{ old('state', $airport->state ?? '') == 'SC' ? 'selected' : '' }}>Santa Catarina</option>
                                        <option value="SP" {{ old('state', $airport->state ?? '') == 'SP' ? 'selected' : '' }}>São Paulo</option>
                                        <option value="SE" {{ old('state', $airport->state ?? '') == 'SE' ? 'selected' : '' }}>Sergipe</option>
                                        <option value="TO" {{ old('state', $airport->state ?? '') == 'TO' ? 'selected' : '' }}>Tocantins</option>
                                    </select>
                                    @error('state')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
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

@push('scripts')
<script>
    // Validação em tempo real
    (function () {
        'use strict'
        const forms = document.querySelectorAll('.needs-validation')
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }
                form.classList.add('was-validated')
            }, false)
        })
    })()

    // Converter código IATA para maiúsculas
    document.getElementById('code').addEventListener('input', function(e) {
        this.value = this.value.toUpperCase()
    })
</script>
@endpush
