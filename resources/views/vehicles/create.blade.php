@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-white border-bottom py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="mb-0 d-flex align-items-center gap-2">
                            <i class="fas fa-car text-secondary"></i>
                            Novo Veículo
                        </h2>
                        <div class="mt-2 d-flex gap-2">
                            <span class="badge bg-primary">
                                <i class="fas fa-plus-circle me-1"></i>
                                Novo Cadastro
                            </span>
                            <span class="badge bg-info">
                                <i class="fas fa-clock me-1"></i>
                                Pendente
                            </span>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('vehicles.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i>
                            Voltar
                        </a>
                        <button form="vehicleForm" type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>
                            Salvar Veículo
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="card-body">
                <form id="vehicleForm" action="{{ route('vehicles.store') }}" method="POST" class="needs-validation" enctype="multipart/form-data" novalidate>
                    @csrf

                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <div>
                            <p class="mb-1"><i class="fas fa-info-circle me-2"></i><strong>Campos obrigatórios:</strong> Os campos marcados com * são de preenchimento obrigatório.</p>
                            <p class="mb-0"><i class="fas fa-lightbulb me-2"></i><strong>Dica:</strong> Passe o mouse sobre os ícones <i class="fas fa-question-circle text-secondary"></i> para obter mais informações sobre cada campo.</p>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
                    </div>

                    <!-- Informações Básicas -->
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h5 class="card-title mb-0 d-flex align-items-center">
                                <i class="fas fa-car text-secondary me-2"></i>
                                Informações Básicas
                                <i class="fas fa-question-circle text-secondary ms-2" 
                                   data-bs-toggle="tooltip" 
                                   data-bs-placement="right" 
                                   title="Informações essenciais do veículo como marca, modelo, ano e cor."></i>
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="brand" class="form-label" id="brand-label">
                                        Marca*
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-industry"></i>
                                        </span>
                                        <input type="text" class="form-control @error('brand') is-invalid @enderror" 
                                               id="brand" name="brand" value="{{ old('brand') }}"
                                               placeholder="Ex: Volkswagen"
                                               aria-labelledby="brand-label"
                                               aria-describedby="brand-help"
                                               required>
                                    </div>
                                    <div id="brand-help" class="form-text">
                                        Marca do veículo
                                    </div>
                                    @error('brand')
                                        <div class="invalid-feedback" role="alert">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="model" class="form-label" id="model-label">
                                        Modelo*
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-car"></i>
                                        </span>
                                        <input type="text" class="form-control @error('model') is-invalid @enderror" 
                                               id="model" name="model" value="{{ old('model') }}"
                                               placeholder="Ex: Gol"
                                               aria-labelledby="model-label"
                                               aria-describedby="model-help"
                                               required>
                                    </div>
                                    <div id="model-help" class="form-text">
                                        Modelo do veículo
                                    </div>
                                    @error('model')
                                        <div class="invalid-feedback" role="alert">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="year" class="form-label" id="year-label">
                                        Ano*
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-calendar"></i>
                                        </span>
                                        <input type="number" class="form-control @error('year') is-invalid @enderror" 
                                               id="year" name="year" value="{{ old('year') }}"
                                               min="1900" max="{{ date('Y') + 1 }}"
                                               placeholder="Ex: {{ date('Y') }}"
                                               aria-labelledby="year-label"
                                               aria-describedby="year-help"
                                               required>
                                    </div>
                                    <div id="year-help" class="form-text">
                                        Ano de fabricação
                                    </div>
                                    @error('year')
                                        <div class="invalid-feedback" role="alert">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="color" class="form-label" id="color-label">
                                        Cor*
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-palette"></i>
                                        </span>
                                        <input type="text" class="form-control @error('color') is-invalid @enderror" 
                                               id="color" name="color" value="{{ old('color') }}"
                                               placeholder="Ex: Prata, Preto, Branco"
                                               aria-labelledby="color-label"
                                               aria-describedby="color-help"
                                               required>
                                    </div>
                                    <div id="color-help" class="form-text">
                                        Cor principal do veículo
                                    </div>
                                    @error('color')
                                        <div class="invalid-feedback" role="alert">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="vehicle_type" class="form-label" id="vehicle_type-label">
                                        Tipo do Veículo*
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-truck"></i>
                                        </span>
                                        <select class="form-select @error('vehicle_type') is-invalid @enderror" 
                                                id="vehicle_type" name="vehicle_type"
                                                aria-labelledby="vehicle_type-label"
                                                aria-describedby="vehicle_type-help"
                                                required>
                                            <option value="">Selecione...</option>
                                            <option value="car" {{ old('vehicle_type') == 'car' ? 'selected' : '' }}>Carro</option>
                                            <option value="van" {{ old('vehicle_type') == 'van' ? 'selected' : '' }}>Van</option>
                                            <option value="bus" {{ old('vehicle_type') == 'bus' ? 'selected' : '' }}>Ônibus</option>
                                            <option value="truck" {{ old('vehicle_type') == 'truck' ? 'selected' : '' }}>Caminhão</option>
                                        </select>
                                    </div>
                                    <div id="vehicle_type-help" class="form-text">
                                        Categoria do veículo
                                    </div>
                                    @error('vehicle_type')
                                        <div class="invalid-feedback" role="alert">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="capacity" class="form-label" id="capacity-label">
                                        Capacidade*
                                    </label>
                                    <div class="input-group">
                                        <input type="number" class="form-control @error('capacity') is-invalid @enderror" 
                                               id="capacity" name="capacity" value="{{ old('capacity') }}"
                                               min="1" max="100"
                                               placeholder="Ex: 5 (incluindo motorista)"
                                               aria-labelledby="capacity-label"
                                               required>
                                        <span class="input-group-text">pessoas</span>
                                        <div class="invalid-feedback" role="alert">
                                            @error('capacity')
                                                {{ $message }}
                                            @else
                                                Por favor, informe a capacidade de passageiros (1-100)
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Status e Manutenção -->
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h5 class="card-title mb-0 d-flex align-items-center">
                                <i class="fas fa-tools text-secondary me-2"></i>
                                Status e Manutenção
                                <i class="fas fa-question-circle text-secondary ms-2" 
                                   data-bs-toggle="tooltip" 
                                   data-bs-placement="right" 
                                   title="Informações sobre o estado atual e manutenção do veículo"></i>
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <!-- Status -->
                                <div class="col-md-4">
                                    <label for="status" class="form-label" id="status-label">
                                        Status*
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-check-circle"></i>
                                        </span>
                                        <select class="form-select @error('status') is-invalid @enderror" 
                                                id="status" name="status"
                                                aria-labelledby="status-label"
                                                aria-describedby="status-help"
                                                required>
                                            <option value="">Selecione...</option>
                                            <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Disponível</option>
                                            <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>Em Manutenção</option>
                                            <option value="booked" {{ old('status') == 'booked' ? 'selected' : '' }}>Reservado</option>
                                            <option value="out_of_service" {{ old('status') == 'out_of_service' ? 'selected' : '' }}>Fora de Serviço</option>
                                        </select>
                                    </div>
                                    <div id="status-help" class="form-text">
                                        Status atual de disponibilidade do veículo
                                    </div>
                                    @error('status')
                                        <div class="invalid-feedback" role="alert">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Quilometragem -->
                                <div class="col-md-4">
                                    <label for="mileage" class="form-label" id="mileage-label">
                                        Quilometragem*
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-tachometer-alt"></i>
                                        </span>
                                        <input type="number" step="0.01" class="form-control @error('mileage') is-invalid @enderror" 
                                               id="mileage" name="mileage" value="{{ old('mileage') }}"
                                               min="0" max="999999.99"
                                               placeholder="Ex: 50000.00"
                                               aria-labelledby="mileage-label"
                                               aria-describedby="mileage-help"
                                               required>
                                        <span class="input-group-text">km</span>
                                    </div>
                                    <div id="mileage-help" class="form-text">
                                        Quilometragem atual do veículo
                                    </div>
                                    @error('mileage')
                                        <div class="invalid-feedback" role="alert">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Status de Manutenção -->
                                <div class="col-md-4">
                                    <label for="maintenance_status" class="form-label" id="maintenance_status-label">
                                        Status de Manutenção
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-wrench"></i>
                                        </span>
                                        <select class="form-select @error('maintenance_status') is-invalid @enderror" 
                                                id="maintenance_status" name="maintenance_status"
                                                aria-labelledby="maintenance_status-label"
                                                aria-describedby="maintenance_status-help">
                                            <option value="">Selecione...</option>
                                            <option value="up_to_date" {{ old('maintenance_status') == 'up_to_date' ? 'selected' : '' }}>Em Dia</option>
                                            <option value="pending" {{ old('maintenance_status') == 'pending' ? 'selected' : '' }}>Pendente</option>
                                            <option value="overdue" {{ old('maintenance_status') == 'overdue' ? 'selected' : '' }}>Atrasada</option>
                                        </select>
                                    </div>
                                    <div id="maintenance_status-help" class="form-text">
                                        Situação atual da manutenção do veículo
                                    </div>
                                    @error('maintenance_status')
                                        <div class="invalid-feedback" role="alert">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <!-- Última Manutenção -->
                                <div class="col-md-4">
                                    <label for="last_maintenance" class="form-label" id="last_maintenance-label">
                                        Última Manutenção
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-history"></i>
                                        </span>
                                        <input type="date" class="form-control @error('last_maintenance') is-invalid @enderror" 
                                               id="last_maintenance" name="last_maintenance"
                                               value="{{ old('last_maintenance') }}"
                                               max="{{ date('Y-m-d') }}"
                                               aria-labelledby="last_maintenance-label"
                                               aria-describedby="last_maintenance-help">
                                    </div>
                                    <div id="last_maintenance-help" class="form-text">
                                        Data da última manutenção realizada
                                    </div>
                                    @error('last_maintenance')
                                        <div class="invalid-feedback" role="alert">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Próxima Manutenção -->
                                <div class="col-md-4">
                                    <label for="next_maintenance" class="form-label" id="next_maintenance-label">
                                        Próxima Manutenção
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-calendar-alt"></i>
                                        </span>
                                        <input type="date" class="form-control @error('next_maintenance') is-invalid @enderror" 
                                               id="next_maintenance" name="next_maintenance"
                                               value="{{ old('next_maintenance') }}"
                                               min="{{ date('Y-m-d') }}"
                                               aria-labelledby="next_maintenance-label"
                                               aria-describedby="next_maintenance-help">
                                    </div>
                                    <div id="next_maintenance-help" class="form-text">
                                        Data prevista para a próxima manutenção
                                    </div>
                                    @error('next_maintenance')
                                        <div class="invalid-feedback" role="alert">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Intervalo de Manutenção -->
                                <div class="col-md-4">
                                    <label for="maintenance_interval" class="form-label" id="maintenance_interval-label">
                                        Intervalo de Manutenção
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-clock"></i>
                                        </span>
                                        <input type="number" class="form-control @error('maintenance_interval') is-invalid @enderror" 
                                               id="maintenance_interval" name="maintenance_interval"
                                               value="{{ old('maintenance_interval') }}"
                                               min="1000" step="1000"
                                               placeholder="Ex: 10000"
                                               aria-labelledby="maintenance_interval-label"
                                               aria-describedby="maintenance_interval-help">
                                        <span class="input-group-text">km</span>
                                    </div>
                                    <div id="maintenance_interval-help" class="form-text">
                                        Quilometragem entre as manutenções
                                    </div>
                                    @error('maintenance_interval')
                                        <div class="invalid-feedback" role="alert">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Observações de Manutenção -->
                            <div class="row">
                                <div class="col-12">
                                    <label for="maintenance_notes" class="form-label" id="maintenance_notes-label">
                                        Observações de Manutenção
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-clipboard"></i>
                                        </span>
                                        <textarea class="form-control @error('maintenance_notes') is-invalid @enderror" 
                                                  id="maintenance_notes" name="maintenance_notes"
                                                  rows="3"
                                                  placeholder="Detalhes sobre manutenções realizadas ou pendentes..."
                                                  aria-labelledby="maintenance_notes-label"
                                                  aria-describedby="maintenance_notes-help">{{ old('maintenance_notes') }}</textarea>
                                    </div>
                                    <div id="maintenance_notes-help" class="form-text">
                                        Informações adicionais sobre o histórico e planejamento de manutenções
                                    </div>
                                    @error('maintenance_notes')
                                        <div class="invalid-feedback" role="alert">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Documentação e Registros -->
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h5 class="card-title mb-0 d-flex align-items-center">
                                <i class="fas fa-file-alt text-secondary me-2"></i>
                                Documentação e Registros
                                <i class="fas fa-question-circle text-secondary ms-2" 
                                   data-bs-toggle="tooltip" 
                                   data-bs-placement="right" 
                                   title="Documentos e registros importantes do veículo"></i>
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <!-- Registro/Placa -->
                                <div class="col-md-4">
                                    <label for="license_plate" class="form-label" id="license_plate-label">
                                        Registro/Placa*
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-car-rear"></i>
                                        </span>
                                        <input type="text" class="form-control @error('license_plate') is-invalid @enderror" 
                                               id="license_plate" name="license_plate"
                                               value="{{ old('license_plate') }}"
                                               placeholder="Ex: ABC-1234 ou ABC1D23"
                                               aria-labelledby="license_plate-label"
                                               aria-describedby="license_plate-help"
                                               required>
                                    </div>
                                    <div id="license_plate-help" class="form-text">
                                        Formato antigo (ABC-1234) ou novo (ABC1D23)
                                    </div>
                                    @error('license_plate')
                                        <div class="invalid-feedback" role="alert">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Renavam -->
                                <div class="col-md-4">
                                    <label for="renavam" class="form-label" id="renavam-label">
                                        Renavam*
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-file-contract"></i>
                                        </span>
                                        <input type="text" class="form-control @error('renavam') is-invalid @enderror" 
                                               id="renavam" name="renavam"
                                               value="{{ old('renavam') }}"
                                               placeholder="Ex: 00000000000"
                                               aria-labelledby="renavam-label"
                                               aria-describedby="renavam-help"
                                               required>
                                    </div>
                                    <div id="renavam-help" class="form-text">
                                        Número do RENAVAM do veículo
                                    </div>
                                    @error('renavam')
                                        <div class="invalid-feedback" role="alert">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Chassis -->
                                <div class="col-md-4">
                                    <label for="chassis" class="form-label" id="chassis-label">
                                        Chassis*
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-car-side"></i>
                                        </span>
                                        <input type="text" class="form-control @error('chassis') is-invalid @enderror" 
                                               id="chassis" name="chassis"
                                               value="{{ old('chassis') }}"
                                               placeholder="Ex: 9BWZZZ377VT004251"
                                               aria-labelledby="chassis-label"
                                               aria-describedby="chassis-help"
                                               required>
                                    </div>
                                    <div id="chassis-help" class="form-text">
                                        Número do chassis do veículo
                                    </div>
                                    @error('chassis')
                                        <div class="invalid-feedback" role="alert">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <!-- Seguro -->
                                <div class="col-md-4">
                                    <label for="insurance_number" class="form-label" id="insurance_number-label">
                                        Número do Seguro
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-shield-alt"></i>
                                        </span>
                                        <input type="text" class="form-control @error('insurance_number') is-invalid @enderror" 
                                               id="insurance_number" name="insurance_number"
                                               value="{{ old('insurance_number') }}"
                                               placeholder="Ex: 123456789"
                                               aria-labelledby="insurance_number-label"
                                               aria-describedby="insurance_number-help">
                                    </div>
                                    <div id="insurance_number-help" class="form-text">
                                        Número da apólice de seguro
                                    </div>
                                    @error('insurance_number')
                                        <div class="invalid-feedback" role="alert">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Validade do Seguro -->
                                <div class="col-md-4">
                                    <label for="insurance_expiry" class="form-label" id="insurance_expiry-label">
                                        Validade do Seguro
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-calendar-check"></i>
                                        </span>
                                        <input type="date" class="form-control @error('insurance_expiry') is-invalid @enderror" 
                                               id="insurance_expiry" name="insurance_expiry"
                                               value="{{ old('insurance_expiry') }}"
                                               aria-labelledby="insurance_expiry-label"
                                               aria-describedby="insurance_expiry-help">
                                    </div>
                                    <div id="insurance_expiry-help" class="form-text">
                                        Data de vencimento do seguro
                                    </div>
                                    @error('insurance_expiry')
                                        <div class="invalid-feedback" role="alert">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Valor do Seguro -->
                                <div class="col-md-4">
                                    <label for="insurance_value" class="form-label" id="insurance_value-label">
                                        Valor do Seguro
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-dollar-sign"></i>
                                        </span>
                                        <input type="number" step="0.01" class="form-control @error('insurance_value') is-invalid @enderror" 
                                               id="insurance_value" name="insurance_value"
                                               value="{{ old('insurance_value') }}"
                                               placeholder="Ex: 1000.00"
                                               aria-labelledby="insurance_value-label"
                                               aria-describedby="insurance_value-help">
                                    </div>
                                    <div id="insurance_value-help" class="form-text">
                                        Valor da apólice de seguro
                                    </div>
                                    @error('insurance_value')
                                        <div class="invalid-feedback" role="alert">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Galeria de Fotos -->
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h5 class="card-title mb-0 d-flex align-items-center">
                                <i class="fas fa-images text-secondary me-2"></i>
                                Galeria de Fotos
                                <i class="fas fa-question-circle text-secondary ms-2" 
                                   data-bs-toggle="tooltip" 
                                   data-bs-placement="right" 
                                   title="Adicione fotos do veículo em diferentes ângulos. Formatos aceitos: JPG, PNG. Tamanho máximo: 5MB por foto."></i>
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Foto Frontal -->
                                <div class="col-md-4 mb-4">
                                    <label for="front_photo" class="form-label" id="front_photo-label">
                                        Foto Frontal
                                    </label>
                                    <input type="file" class="form-control @error('front_photo') is-invalid @enderror" 
                                           id="front_photo" name="front_photo" 
                                           accept="image/jpeg,image/png"
                                           aria-labelledby="front_photo-label"
                                           aria-describedby="front_photo-help"
                                           onchange="previewImage(this, 'front_preview', 'front_details')">
                                    <div id="front_photo-help" class="form-text">
                                        Formatos aceitos: JPG, PNG. Tamanho máximo: 5MB
                                    </div>
                                    <img id="front_preview" class="img-preview mt-2 d-none" alt="Prévia da foto frontal" aria-hidden="true">
                                    <div id="front_details" class="file-details mt-2 d-none" role="status" aria-live="polite">
                                        <div><i class="fas fa-file-image"></i> <span class="file-name"></span></div>
                                        <div><i class="fas fa-check-circle"></i> Formatos: JPG, PNG</div>
                                        <div><i class="fas fa-weight-hanging"></i> Máximo: 5MB</div>
                                    </div>
                                    @error('front_photo')
                                        <div class="invalid-feedback" role="alert">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Foto Traseira -->
                                <div class="col-md-4 mb-4">
                                    <label for="back_photo" class="form-label" id="back_photo-label">
                                        Foto Traseira
                                    </label>
                                    <input type="file" class="form-control @error('back_photo') is-invalid @enderror" 
                                           id="back_photo" name="back_photo" 
                                           accept="image/jpeg,image/png"
                                           aria-labelledby="back_photo-label"
                                           aria-describedby="back_photo-help"
                                           onchange="previewImage(this, 'back_preview', 'back_details')">
                                    <div id="back_photo-help" class="form-text">
                                        Formatos aceitos: JPG, PNG. Tamanho máximo: 5MB
                                    </div>
                                    <img id="back_preview" class="img-preview mt-2 d-none" alt="Prévia da foto traseira" aria-hidden="true">
                                    <div id="back_details" class="file-details mt-2 d-none" role="status" aria-live="polite">
                                        <div><i class="fas fa-file-image"></i> <span class="file-name"></span></div>
                                        <div><i class="fas fa-check-circle"></i> Formatos: JPG, PNG</div>
                                        <div><i class="fas fa-weight-hanging"></i> Máximo: 5MB</div>
                                    </div>
                                    @error('back_photo')
                                        <div class="invalid-feedback" role="alert">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Foto Lateral -->
                                <div class="col-md-4 mb-4">
                                    <label for="side_photo" class="form-label" id="side_photo-label">
                                        Foto Lateral
                                    </label>
                                    <input type="file" class="form-control @error('side_photo') is-invalid @enderror" 
                                           id="side_photo" name="side_photo" 
                                           accept="image/jpeg,image/png"
                                           aria-labelledby="side_photo-label"
                                           aria-describedby="side_photo-help"
                                           onchange="previewImage(this, 'side_preview', 'side_details')">
                                    <div id="side_photo-help" class="form-text">
                                        Formatos aceitos: JPG, PNG. Tamanho máximo: 5MB
                                    </div>
                                    <img id="side_preview" class="img-preview mt-2 d-none" alt="Prévia da foto lateral" aria-hidden="true">
                                    <div id="side_details" class="file-details mt-2 d-none" role="status" aria-live="polite">
                                        <div><i class="fas fa-file-image"></i> <span class="file-name"></span></div>
                                        <div><i class="fas fa-check-circle"></i> Formatos: JPG, PNG</div>
                                        <div><i class="fas fa-weight-hanging"></i> Máximo: 5MB</div>
                                    </div>
                                    @error('side_photo')
                                        <div class="invalid-feedback" role="alert">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Foto Interior -->
                                <div class="col-md-4 mb-4">
                                    <label for="interior_photo" class="form-label" id="interior_photo-label">
                                        Foto do Interior
                                    </label>
                                    <input type="file" class="form-control @error('interior_photo') is-invalid @enderror" 
                                           id="interior_photo" name="interior_photo" 
                                           accept="image/jpeg,image/png"
                                           aria-labelledby="interior_photo-label"
                                           aria-describedby="interior_photo-help"
                                           onchange="previewImage(this, 'interior_preview', 'interior_details')">
                                    <div id="interior_photo-help" class="form-text">
                                        Formatos aceitos: JPG, PNG. Tamanho máximo: 5MB
                                    </div>
                                    <img id="interior_preview" class="img-preview mt-2 d-none" alt="Prévia da foto do interior" aria-hidden="true">
                                    <div id="interior_details" class="file-details mt-2 d-none" role="status" aria-live="polite">
                                        <div><i class="fas fa-file-image"></i> <span class="file-name"></span></div>
                                        <div><i class="fas fa-check-circle"></i> Formatos: JPG, PNG</div>
                                        <div><i class="fas fa-weight-hanging"></i> Máximo: 5MB</div>
                                    </div>
                                    @error('interior_photo')
                                        <div class="invalid-feedback" role="alert">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Foto da Placa -->
                                <div class="col-md-4 mb-4">
                                    <label for="plate_photo" class="form-label" id="plate_photo-label">
                                        Foto da Placa
                                    </label>
                                    <input type="file" class="form-control @error('plate_photo') is-invalid @enderror" 
                                           id="plate_photo" name="plate_photo" 
                                           accept="image/jpeg,image/png"
                                           aria-labelledby="plate_photo-label"
                                           aria-describedby="plate_photo-help"
                                           onchange="previewImage(this, 'plate_preview', 'plate_details')">
                                    <div id="plate_photo-help" class="form-text">
                                        Formatos aceitos: JPG, PNG. Tamanho máximo: 5MB
                                    </div>
                                    <img id="plate_preview" class="img-preview mt-2 d-none" alt="Prévia da foto da placa" aria-hidden="true">
                                    <div id="plate_details" class="file-details mt-2 d-none" role="status" aria-live="polite">
                                        <div><i class="fas fa-file-image"></i> <span class="file-name"></span></div>
                                        <div><i class="fas fa-check-circle"></i> Formatos: JPG, PNG</div>
                                        <div><i class="fas fa-weight-hanging"></i> Máximo: 5MB</div>
                                    </div>
                                    @error('plate_photo')
                                        <div class="invalid-feedback" role="alert">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Botões de Ação -->
                    <div class="row mt-4">
                        <div class="col-12 d-flex justify-content-end gap-2">
                            <a href="{{ route('vehicles.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-1"></i>
                                Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>
                                Salvar Veículo
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
   /* Estilos para os passos do formulário */
   .step {
        text-align: center;
        position: relative;
        flex: 1;
        padding: 0 10px;
        cursor: pointer;
    }

    .step:not(:last-child)::after {
        content: '';
        position: absolute;
        top: 15px;
        right: -50%;
        width: 100%;
        height: 2px;
        background-color: #dee2e6;
        z-index: 1;
    }

    .step.active:not(:last-child)::after {
        background-color: #0d6efd;
    }

    .step-icon {
        width: 32px;
        height: 32px;
        margin: 0 auto 8px;
        position: relative;
        z-index: 2;
        background-color: #fff;
    }

    .step-icon i {
        font-size: 32px;
        color: #dee2e6;
    }

    .step.active .step-icon i {
        color: #0d6efd;
    }

    .step-label {
        font-size: 0.875rem;
        color: #6c757d;
    }

    .step.active .step-label {
        color: #0d6efd;
        font-weight: 500;
    }

    /* Melhorias de acessibilidade */
    .form-control:focus,
    .form-select:focus {
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        border-color: #86b7fe;
    }

    /* Feedback visual para campos válidos/inválidos */
    .form-control.is-valid,
    .form-select.is-valid {
        border-color: #198754;
        padding-right: calc(1.5em + 0.75rem);
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%23198754' d='M2.3 6.73L.6 4.53c-.4-1.04.46-1.4 1.1-.8l1.1 1.4 3.4-3.8c.6-.63 1.6-.27 1.2.7l-4 4.6c-.43.5-.8.4-1.1.1z'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right calc(0.375em + 0.1875rem) center;
        background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
    }

    .form-control.is-invalid,
    .form-select.is-invalid {
        border-color: #dc3545;
        padding-right: calc(1.5em + 0.75rem);
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right calc(0.375em + 0.1875rem) center;
        background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
    }

    /* High contrast focus rings */
    .btn:focus,
    .btn-primary:focus,
    .btn-secondary:focus {
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.5);
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inicializar tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        const form = document.getElementById('vehicleForm');

        // Função para validação dinâmica de campos
        function validateField(field) {
            const isValid = field.checkValidity();
            field.classList.toggle('is-valid', isValid);
            field.classList.toggle('is-invalid', !isValid);
            return isValid;
        }

        // Validação específica para placa
        const plateInput = document.getElementById('license_plate');
        plateInput.addEventListener('input', function() {
            let value = this.value.toUpperCase();
            value = value.replace(/[^A-Z0-9]/g, '');
            
            if (value.length > 7) {
                value = value.slice(0, 7);
            }
            
            // Formato antigo (ABC-1234) ou novo (ABC1D23)
            if (value.length === 7) {
                const isOldFormat = !isNaN(value.slice(3));
                if (isOldFormat) {
                    value = value.slice(0, 3) + '-' + value.slice(3);
                    this.setAttribute('pattern', '[A-Z]{3}-[0-9]{4}');
                } else {
                    this.setAttribute('pattern', '[A-Z]{3}[0-9][A-Z][0-9]{2}');
                }
            }
            
            this.value = value;
            validateField(this);
        });

        // Validação específica para ano
        const yearInput = document.getElementById('year');
        yearInput.addEventListener('input', function() {
            const currentYear = new Date().getFullYear();
            const value = parseInt(this.value);
            
            if (value < 1900 || value > currentYear + 1) {
                this.setCustomValidity('O ano deve estar entre 1900 e ' + (currentYear + 1));
            } else {
                this.setCustomValidity('');
            }
            
            validateField(this);
        });

        // Validação em tempo real para campos obrigatórios
        form.querySelectorAll('input[required], select[required]').forEach(field => {
            ['input', 'change', 'blur'].forEach(event => {
                field.addEventListener(event, () => validateField(field));
            });
        });

        // Melhorar acessibilidade dos campos
        form.querySelectorAll('.form-control, .form-select').forEach(field => {
            // Adicionar aria-required para campos obrigatórios
            if (field.hasAttribute('required')) {
                field.setAttribute('aria-required', 'true');
            }

            // Adicionar aria-invalid quando o campo for inválido
            field.addEventListener('invalid', () => {
                field.setAttribute('aria-invalid', 'true');
            });

            // Remover aria-invalid quando o campo for válido
            field.addEventListener('input', () => {
                if (field.checkValidity()) {
                    field.removeAttribute('aria-invalid');
                }
            });
        });

        // Função para previsualizar imagens
        window.previewImage = function(input, previewId, detailsId) {
            const preview = document.getElementById(previewId);
            const details = document.getElementById(detailsId);
            const file = input.files[0];
            
            if (file) {
                // Verificar o tamanho do arquivo (5MB = 5 * 1024 * 1024 bytes)
                if (file.size > 5 * 1024 * 1024) {
                    alert('O arquivo é muito grande. O tamanho máximo permitido é 5MB.');
                    input.value = '';
                    preview.classList.add('d-none');
                    details.classList.add('d-none');
                    return;
                }

                // Atualizar detalhes do arquivo
                const fileName = details.querySelector('.file-name');
                fileName.textContent = file.name;
                details.classList.remove('d-none');

                // Mostrar prévia da imagem
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('d-none');
                }
                reader.readAsDataURL(file);

                // Adicionar informações de acessibilidade
                preview.setAttribute('aria-label', 'Prévia da imagem: ' + file.name);
            } else {
                preview.classList.add('d-none');
                details.classList.add('d-none');
            }
        }
    });
</script>
@endpush
