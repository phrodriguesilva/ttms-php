@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-white border-bottom py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="mb-0 d-flex align-items-center gap-2">
                            <i class="fas fa-user text-secondary"></i>
                            {{ isset($client) ? 'Editar Cliente' : 'Novo Cliente' }}
                        </h2>
                        <div class="mt-2 d-flex gap-2">
                            <span class="badge bg-primary">
                                <i class="fas fa-plus-circle me-1"></i>
                                {{ isset($client) ? 'Editando Cadastro' : 'Novo Cadastro' }}
                            </span>
                            <span class="badge bg-info">
                                <i class="fas fa-clock me-1"></i>
                                Pendente
                            </span>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('clients.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i>
                            Voltar
                        </a>
                        <button form="clientForm" type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>
                            {{ isset($client) ? 'Atualizar' : 'Salvar' }} Cliente
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="card-body">
                <form id="clientForm" action="{{ isset($client) ? route('clients.update', $client->id) : route('clients.store') }}" 
                      method="POST" class="needs-validation" novalidate>
                    @csrf
                    @if(isset($client))
                        @method('PUT')
                    @endif

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
                                <i class="fas fa-user text-secondary me-2"></i>
                                Informações Básicas
                                <i class="fas fa-question-circle text-secondary ms-2" 
                                   data-bs-toggle="tooltip" 
                                   data-bs-placement="right" 
                                   title="Informações essenciais do cliente como nome, tipo e documentos"></i>
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="type" class="form-label" id="type-label">Tipo de Cliente*</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-user-tag"></i>
                                        </span>
                                        <select name="type" id="type" 
        class="form-select @error('type') is-invalid @enderror" 
        required
        aria-labelledby="type-label"
        aria-describedby="type-help">
    <option value="individual" {{ old('type', $client->type ?? 'individual') == 'individual' ? 'selected' : '' }}>
        Pessoa Física
    </option>
    <option value="corporate" {{ old('type', $client->type ?? '') == 'corporate' ? 'selected' : '' }}>
        Pessoa Jurídica
    </option>
</select>
                                    </div>
                                    <div id="type-help" class="form-text">
                                        Selecione se o cliente é pessoa física ou jurídica
                                    </div>
                                    @error('type')
                                        <div class="invalid-feedback" role="alert">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-8">
                                    <label for="name" class="form-label" id="name-label">
                                        <span class="individual-label">Nome Completo*</span>
                                        <span class="corporate-label" style="display: none;">Razão Social*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-user"></i>
                                        </span>
                                        <input type="text" name="name" id="name" 
                                               class="form-control @error('name') is-invalid @enderror"
                                               value="{{ old('name', $client->name ?? '') }}" 
                                               required
                                               aria-labelledby="name-label"
                                               aria-describedby="name-help">
                                    </div>
                                    <div id="name-help" class="form-text individual-label">
                                        Nome completo da pessoa física
                                    </div>
                                    <div id="name-help-corporate" class="form-text corporate-label" style="display: none;">
                                        Razão social completa da empresa
                                    </div>
                                    @error('name')
                                        <div class="invalid-feedback" role="alert">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="document" class="form-label" id="document-label">
                                        <span class="individual-label">CPF*</span>
                                        <span class="corporate-label" style="display: none;">CNPJ*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-id-card"></i>
                                        </span>
                                        <input type="text" name="document" id="document" 
                                               class="form-control @error('document') is-invalid @enderror"
                                               value="{{ old('document', $client->document ?? '') }}"
                                               required
                                               aria-labelledby="document-label"
                                               aria-describedby="document-help">
                                    </div>
                                    <div id="document-help" class="form-text individual-label">
                                        Digite apenas os números do CPF
                                    </div>
                                    <div id="document-help-corporate" class="form-text corporate-label" style="display: none;">
                                        Digite apenas os números do CNPJ
                                    </div>
                                    @error('document')
                                        <div class="invalid-feedback" role="alert">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 corporate-only" style="display: none;">
                                    <label for="trading_name" class="form-label" id="trading_name-label">Nome Fantasia</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-store"></i>
                                        </span>
                                        <input type="text" name="trading_name" id="trading_name" 
                                               class="form-control @error('trading_name') is-invalid @enderror"
                                               value="{{ old('trading_name', $client->trading_name ?? '') }}"
                                               aria-labelledby="trading_name-label"
                                               aria-describedby="trading_name-help">
                                    </div>
                                    <div id="trading_name-help" class="form-text">
                                        Nome fantasia ou nome comercial da empresa
                                    </div>
                                    @error('trading_name')
                                        <div class="invalid-feedback" role="alert">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contato -->
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h5 class="card-title mb-0 d-flex align-items-center">
                                <i class="fas fa-phone text-secondary me-2"></i>
                                Informações de Contato
                                <i class="fas fa-question-circle text-secondary ms-2" 
                                   data-bs-toggle="tooltip" 
                                   data-bs-placement="right" 
                                   title="Informações para contato com o cliente, como telefones e contatos adicionais"></i>
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="phone" class="form-label" id="phone-label">Telefone Principal*</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-phone"></i>
                                        </span>
                                        <input type="text" name="phone" id="phone" 
                                               class="form-control phone-mask @error('phone') is-invalid @enderror"
                                               value="{{ old('phone', $client->phone ?? '') }}"
                                               required
                                               placeholder="(00) 00000-0000"
                                               aria-labelledby="phone-label"
                                               aria-describedby="phone-help">
                                    </div>
                                    <div id="phone-help" class="form-text">
                                        Telefone principal para contato
                                    </div>
                                    @error('phone')
                                        <div class="invalid-feedback" role="alert">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="phone2" class="form-label" id="phone2-label">Telefone Secundário</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-phone"></i>
                                        </span>
                                        <input type="text" name="phone2" id="phone2" 
                                               class="form-control phone-mask @error('phone2') is-invalid @enderror"
                                               value="{{ old('phone2', $client->phone2 ?? '') }}"
                                               placeholder="(00) 00000-0000"
                                               aria-labelledby="phone2-label"
                                               aria-describedby="phone2-help">
                                    </div>
                                    <div id="phone2-help" class="form-text">
                                        Telefone alternativo para contato
                                    </div>
                                    @error('phone2')
                                        <div class="invalid-feedback" role="alert">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Email Principal e Secundário -->
<div class="row mb-3">
    <div class="col-md-6">
        <label for="email" class="form-label" id="email-label">Email Principal*</label>
        <div class="input-group">
            <span class="input-group-text">
                <i class="fas fa-envelope"></i>
            </span>
            <input type="email" name="email" id="email" 
                   class="form-control @error('email') is-invalid @enderror"
                   value="{{ old('email', $client->email ?? '') }}"
                   required
                   placeholder="email@exemplo.com"
                   aria-labelledby="email-label"
                   aria-describedby="email-help">
        </div>
        <div id="email-help" class="form-text">
            Email principal para contato e envio de documentos
        </div>
        @error('email')
            <div class="invalid-feedback" role="alert">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="email2" class="form-label" id="email2-label">Email Secundário</label>
        <div class="input-group">
            <span class="input-group-text">
                <i class="fas fa-envelope"></i>
            </span>
            <input type="email" name="email2" id="email2" 
                   class="form-control @error('email2') is-invalid @enderror"
                   value="{{ old('email2', $client->email2 ?? '') }}"
                   placeholder="email.alternativo@exemplo.com"
                   aria-labelledby="email2-label"
                   aria-describedby="email2-help">
        </div>
        <div id="email2-help" class="form-text">
            Email alternativo para contato
        </div>
        @error('email2')
            <div class="invalid-feedback" role="alert">{{ $message }}</div>
        @enderror
    </div>
</div>

                            <!-- Contato Adicional (visível apenas para pessoa jurídica) -->
                            <div class="row mb-3 corporate-only" style="display: none;">
                                <div class="col-md-6">
                                    <label for="contact_name" class="form-label" id="contact_name-label">Pessoa para Contato</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-user-tie"></i>
                                        </span>
                                        <input type="text" name="contact_name" id="contact_name" 
                                               class="form-control @error('contact_name') is-invalid @enderror"
                                               value="{{ old('contact_name', $client->contact_name ?? '') }}"
                                               placeholder="Nome da pessoa responsável"
                                               aria-labelledby="contact_name-label"
                                               aria-describedby="contact_name-help">
                                    </div>
                                    <div id="contact_name-help" class="form-text">
                                        Nome da pessoa responsável na empresa
                                    </div>
                                    @error('contact_name')
                                        <div class="invalid-feedback" role="alert">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="contact_role" class="form-label" id="contact_role-label">Cargo/Função</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-id-badge"></i>
                                        </span>
                                        <input type="text" name="contact_role" id="contact_role" 
                                               class="form-control @error('contact_role') is-invalid @enderror"
                                               value="{{ old('contact_role', $client->contact_role ?? '') }}"
                                               placeholder="Cargo ou função na empresa"
                                               aria-labelledby="contact_role-label"
                                               aria-describedby="contact_role-help">
                                    </div>
                                    <div id="contact_role-help" class="form-text">
                                        Cargo ou função da pessoa de contato
                                    </div>
                                    @error('contact_role')
                                        <div class="invalid-feedback" role="alert">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Endereço -->
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h5 class="card-title mb-0 d-flex align-items-center">
                                <i class="fas fa-map-marker-alt text-secondary me-2"></i>
                                Endereço
                                <i class="fas fa-question-circle text-secondary ms-2" 
                                   data-bs-toggle="tooltip" 
                                   data-bs-placement="right" 
                                   title="Informações do endereço do cliente para correspondência e visitas"></i>
                            </h5>
                        </div>
                        <div class="card-body">
                            <!-- CEP -->
                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <label for="postal_code" class="form-label" id="postal_code-label">CEP*</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-map-pin"></i>
                                        </span>
                                        <input type="text" name="postal_code" id="postal_code" 
                                               class="form-control cep-mask @error('postal_code') is-invalid @enderror"
                                               value="{{ old('postal_code', $client->postal_code ?? '') }}"
                                               required
                                               placeholder="00000-000"
                                               aria-labelledby="postal_code-label"
                                               aria-describedby="postal_code-help search_cep">
                                    </div>
                                    <div id="postal_code-help" class="form-text">
                                        Digite o CEP para autocompletar o endereço
                                    </div>
                                    @error('postal_code')
                                        <div class="invalid-feedback" role="alert">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Logradouro e Número -->
                            <div class="row mb-3">
                                <div class="col-md-9">
                                    <label for="street" class="form-label" id="street-label">Logradouro*</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-road"></i>
                                        </span>
                                        <input type="text" name="street" id="street" 
                                               class="form-control @error('street') is-invalid @enderror"
                                               value="{{ old('street', $client->street ?? '') }}"
                                               required
                                               placeholder="Nome da rua, avenida, etc"
                                               aria-labelledby="street-label"
                                               aria-describedby="street-help">
                                    </div>
                                    <div id="street-help" class="form-text">
                                        Nome da rua, avenida, praça, etc.
                                    </div>
                                    @error('street')
                                        <div class="invalid-feedback" role="alert">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <label for="number" class="form-label" id="number-label">Número*</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-hashtag"></i>
                                        </span>
                                        <input type="text" name="number" id="number" 
                                               class="form-control @error('number') is-invalid @enderror"
                                               value="{{ old('number', $client->number ?? '') }}"
                                               required
                                               placeholder="Número"
                                               aria-labelledby="number-label"
                                               aria-describedby="number-help">
                                    </div>
                                    <div id="number-help" class="form-text">
                                        Número do endereço
                                    </div>
                                    @error('number')
                                        <div class="invalid-feedback" role="alert">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Complemento e Bairro -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="complement" class="form-label" id="complement-label">Complemento</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-info-circle"></i>
                                        </span>
                                        <input type="text" name="complement" id="complement" 
                                               class="form-control @error('complement') is-invalid @enderror"
                                               value="{{ old('complement', $client->complement ?? '') }}"
                                               placeholder="Apartamento, sala, etc"
                                               aria-labelledby="complement-label"
                                               aria-describedby="complement-help">
                                    </div>
                                    <div id="complement-help" class="form-text">
                                        Apartamento, sala, bloco, etc.
                                    </div>
                                    @error('complement')
                                        <div class="invalid-feedback" role="alert">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="neighborhood" class="form-label" id="neighborhood-label">Bairro*</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-map"></i>
                                        </span>
                                        <input type="text" name="neighborhood" id="neighborhood" 
                                               class="form-control @error('neighborhood') is-invalid @enderror"
                                               value="{{ old('neighborhood', $client->neighborhood ?? '') }}"
                                               required
                                               placeholder="Nome do bairro"
                                               aria-labelledby="neighborhood-label"
                                               aria-describedby="neighborhood-help">
                                    </div>
                                    <div id="neighborhood-help" class="form-text">
                                        Nome do bairro
                                    </div>
                                    @error('neighborhood')
                                        <div class="invalid-feedback" role="alert">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Cidade e Estado -->
                            <div class="row">
                                <div class="col-md-8">
                                    <label for="city" class="form-label" id="city-label">Cidade*</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-city"></i>
                                        </span>
                                        <input type="text" name="city" id="city" 
                                               class="form-control @error('city') is-invalid @enderror"
                                               value="{{ old('city', $client->city ?? '') }}"
                                               required
                                               placeholder="Nome da cidade"
                                               aria-labelledby="city-label"
                                               aria-describedby="city-help">
                                    </div>
                                    <div id="city-help" class="form-text">
                                        Nome da cidade
                                    </div>
                                    @error('city')
                                        <div class="invalid-feedback" role="alert">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="state" class="form-label" id="state-label">Estado*</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-map-marked-alt"></i>
                                        </span>
                                        <select name="state" id="state" 
                                                class="form-select @error('state') is-invalid @enderror"
                                                required
                                                aria-labelledby="state-label"
                                                aria-describedby="state-help">
                                            <option value="">Selecione o estado...</option>
                                            @foreach(['AC', 'AL', 'AP', 'AM', 'BA', 'CE', 'DF', 'ES', 'GO', 'MA', 'MT', 'MS', 'MG', 'PA', 'PB', 'PR', 'PE', 'PI', 'RJ', 'RN', 'RS', 'RO', 'RR', 'SC', 'SP', 'SE', 'TO'] as $uf)
                                                <option value="{{ $uf }}" {{ old('state', $client->state ?? '') == $uf ? 'selected' : '' }}>
                                                    {{ $uf }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div id="state-help" class="form-text">
                                        Estado (UF)
                                    </div>
                                    @error('state')
                                        <div class="invalid-feedback" role="alert">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Observações -->
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h5 class="card-title mb-0 d-flex align-items-center">
                                <i class="fas fa-sticky-note text-secondary me-2"></i>
                                Observações
                                <i class="fas fa-question-circle text-secondary ms-2" 
                                   data-bs-toggle="tooltip" 
                                   data-bs-placement="right" 
                                   title="Informações adicionais e observações importantes sobre o cliente"></i>
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-12">
                                    <label for="notes" class="form-label" id="notes-label">
                                        Observações Gerais
                                        <i class="fas fa-info-circle text-secondary ms-1" 
                                           data-bs-toggle="tooltip"
                                           title="Adicione informações relevantes sobre o cliente, como preferências, restrições ou observações importantes"></i>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-comment"></i>
                                        </span>
                                        <textarea name="notes" id="notes" 
                                                  class="form-control @error('notes') is-invalid @enderror" 
                                                  rows="4"
                                                  aria-labelledby="notes-label"
                                                  aria-describedby="notes-help"
                                                  placeholder="Digite aqui observações importantes sobre o cliente...">{{ old('notes', $client->notes ?? '') }}</textarea>
                                    </div>
                                    <div id="notes-help" class="form-text">
                                        Use este espaço para registrar informações importantes sobre o cliente que precisam ser lembradas
                                    </div>
                                    @error('notes')
                                        <div class="invalid-feedback" role="alert">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <label for="internal_notes" class="form-label" id="internal_notes-label">
                                        Observações Internas
                                        <span class="badge bg-info">Visível apenas internamente</span>
                                        <i class="fas fa-info-circle text-secondary ms-1" 
                                           data-bs-toggle="tooltip"
                                           title="Estas observações são visíveis apenas para a equipe interna"></i>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-lock"></i>
                                        </span>
                                        <textarea name="internal_notes" id="internal_notes" 
                                                  class="form-control @error('internal_notes') is-invalid @enderror" 
                                                  rows="3"
                                                  aria-labelledby="internal_notes-label"
                                                  aria-describedby="internal_notes-help"
                                                  placeholder="Digite aqui observações internas sobre o cliente...">{{ old('internal_notes', $client->internal_notes ?? '') }}</textarea>
                                    </div>
                                    <div id="internal_notes-help" class="form-text">
                                        Observações visíveis apenas para a equipe interna (não serão exibidas ao cliente)
                                    </div>
                                    @error('internal_notes')
                                        <div class="invalid-feedback" role="alert">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Botões de Ação -->
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('clients.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times me-1"></i>
                                    Cancelar
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i>
                                    {{ isset($client) ? 'Atualizar' : 'Salvar' }} Cliente
                                </button>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<script>
    $(document).ready(function() {
        // Função para atualizar os campos baseado no tipo de cliente
        function updateClientType(type) {
            console.log('Updating client type to:', type);
            if (type === 'corporate') {
                $('.corporate-only').show();
                $('.individual-label').hide();
                $('.corporate-label').show();
                $('#document').mask('00.000.000/0000-00');
            } else {
                $('.corporate-only').hide();
                $('.individual-label').show();
                $('.corporate-label').hide();
                $('#document').mask('000.000.000-00');
            }
        }

        // Máscaras para CPF e CNPJ
        var documentMaskBehavior = function (val) {
            return val.replace(/\D/g, '').length === 14 ? '00.000.000/0000-00' : '000.000.000-00';
        };
        
        var documentOptions = {
            onKeyPress: function(val, e, field, options) {
                field.mask(documentMaskBehavior.apply({}, arguments), options);
            }
        };
        
        // Aplicar máscara ao documento
        $('#document').mask(documentMaskBehavior, documentOptions);

        // Evento de mudança do tipo de cliente
        $('#type').on('change', function() {
            updateClientType($(this).val());
        });

        // Inicializar com o valor atual do select
        updateClientType($('#type').val());

        // Outras máscaras
        $('.phone-mask').mask('(00) 00000-0000');
        $('.cep-mask').mask('00000-000');
    });
        
        // CEP
        function limpa_formulário_cep() {
            $("#street").val("");
            $("#neighborhood").val("");
            $("#city").val("");
            $("#state").val("");
        }
        
        $("#postal_code").blur(function() {
            var cep = $(this).val().replace(/\D/g, '');
            if (cep != "") {
                var validacep = /^[0-9]{8}$/;
                if(validacep.test(cep)) {
                    $("#street").val("...");
                    $("#neighborhood").val("...");
                    $("#city").val("...");
                    $("#state").val("...");
                    $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {
                        if (!("erro" in dados)) {
                            $("#street").val(dados.logradouro);
                            $("#neighborhood").val(dados.bairro);
                            $("#city").val(dados.localidade);
                            $("#state").val(dados.uf);
                        }
                        else {
                            limpa_formulário_cep();
                            alert("CEP não encontrado.");
                        }
                    });
                }
                else {
                    limpa_formulário_cep();
                    alert("Formato de CEP inválido.");
                }
            }
            else {
                limpa_formulário_cep();
            }
        });

        // Bootstrap Validation
        (function () {
            'use strict'
            var forms = document.querySelectorAll('.needs-validation')
            Array.prototype.slice.call(forms)
                .forEach(function (form) {
                    form.addEventListener('submit', function (event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }
                        form.classList.add('was-validated')
                    }, false)
                })
        })();
    });
</script>
@endpush
