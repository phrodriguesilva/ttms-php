@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>{{ isset($client) ? 'Editar Cliente' : 'Novo Cliente' }}</h2>
            <a href="{{ route('clients.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Voltar
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ isset($client) ? route('clients.update', $client->id) : route('clients.store') }}" 
                      method="POST">
                    @csrf
                    @if(isset($client))
                        @method('PUT')
                    @endif

                    <div class="row g-3">
                        <!-- Tipo de Cliente -->
                        <div class="col-md-4">
                            <label for="type" class="form-label">Tipo de Cliente *</label>
                            <select name="type" id="type" class="form-select @error('type') is-invalid @enderror" required>
                                <option value="">Selecione...</option>
                                <option value="individual" {{ old('type', $client->type ?? '') == 'individual' ? 'selected' : '' }}>
                                    Pessoa Física
                                </option>
                                <option value="corporate" {{ old('type', $client->type ?? '') == 'corporate' ? 'selected' : '' }}>
                                    Pessoa Jurídica
                                </option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Nome -->
                        <div class="col-md-8">
                            <label for="name" class="form-label">Nome *</label>
                            <input type="text" name="name" id="name" 
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name', $client->name ?? '') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Documento -->
                        <div class="col-md-4">
                            <label for="document" class="form-label">Documento *</label>
                            <input type="text" name="document" id="document" 
                                   class="form-control @error('document') is-invalid @enderror"
                                   value="{{ old('document', $client->document ?? '') }}" required>
                            @error('document')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="col-md-4">
                            <label for="email" class="form-label">Email *</label>
                            <input type="email" name="email" id="email" 
                                   class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email', $client->email ?? '') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Telefone -->
                        <div class="col-md-4">
                            <label for="phone" class="form-label">Telefone *</label>
                            <input type="tel" name="phone" id="phone" 
                                   class="form-control @error('phone') is-invalid @enderror"
                                   value="{{ old('phone', $client->phone ?? '') }}" required>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Endereço -->
                        <div class="col-12">
                            <label for="address" class="form-label">Endereço</label>
                            <input type="text" name="address" id="address" 
                                   class="form-control @error('address') is-invalid @enderror"
                                   value="{{ old('address', $client->address ?? '') }}">
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Pessoa de Contato -->
                        <div class="col-md-6">
                            <label for="contact_person" class="form-label">Pessoa de Contato</label>
                            <input type="text" name="contact_person" id="contact_person" 
                                   class="form-control @error('contact_person') is-invalid @enderror"
                                   value="{{ old('contact_person', $client->contact_person ?? '') }}">
                            @error('contact_person')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Telefone de Contato -->
                        <div class="col-md-6">
                            <label for="contact_phone" class="form-label">Telefone de Contato</label>
                            <input type="tel" name="contact_phone" id="contact_phone" 
                                   class="form-control @error('contact_phone') is-invalid @enderror"
                                   value="{{ old('contact_phone', $client->contact_phone ?? '') }}">
                            @error('contact_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Método de Pagamento -->
                        <div class="col-md-6">
                            <label for="payment_method" class="form-label">Método de Pagamento</label>
                            <select name="payment_method" id="payment_method" 
                                    class="form-select @error('payment_method') is-invalid @enderror">
                                <option value="">Selecione...</option>
                                <option value="credit_card" {{ old('payment_method', $client->payment_method ?? '') == 'credit_card' ? 'selected' : '' }}>
                                    Cartão de Crédito
                                </option>
                                <option value="bank_transfer" {{ old('payment_method', $client->payment_method ?? '') == 'bank_transfer' ? 'selected' : '' }}>
                                    Transferência Bancária
                                </option>
                                <option value="cash" {{ old('payment_method', $client->payment_method ?? '') == 'cash' ? 'selected' : '' }}>
                                    Dinheiro
                                </option>
                            </select>
                            @error('payment_method')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Prazo de Pagamento -->
                        <div class="col-md-6">
                            <label for="payment_terms" class="form-label">Prazo de Pagamento</label>
                            <select name="payment_terms" id="payment_terms" 
                                    class="form-select @error('payment_terms') is-invalid @enderror">
                                <option value="">Selecione...</option>
                                <option value="immediate" {{ old('payment_terms', $client->payment_terms ?? '') == 'immediate' ? 'selected' : '' }}>
                                    À Vista
                                </option>
                                <option value="15_days" {{ old('payment_terms', $client->payment_terms ?? '') == '15_days' ? 'selected' : '' }}>
                                    15 Dias
                                </option>
                                <option value="30_days" {{ old('payment_terms', $client->payment_terms ?? '') == '30_days' ? 'selected' : '' }}>
                                    30 Dias
                                </option>
                            </select>
                            @error('payment_terms')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="col-md-12">
                            <div class="form-check form-switch">
                                <input type="checkbox" name="is_active" id="is_active" 
                                       class="form-check-input @error('is_active') is-invalid @enderror"
                                       value="1" {{ old('is_active', $client->is_active ?? true) ? 'checked' : '' }}>
                                <label for="is_active" class="form-check-label">Cliente Ativo</label>
                                @error('is_active')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Observações -->
                        <div class="col-12">
                            <label for="notes" class="form-label">Observações</label>
                            <textarea name="notes" id="notes" rows="3" 
                                      class="form-control @error('notes') is-invalid @enderror">{{ old('notes', $client->notes ?? '') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Salvar
                        </button>
                        <a href="{{ route('clients.index') }}" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Máscara para CPF/CNPJ
    const documentInput = document.getElementById('document');
    const typeSelect = document.getElementById('type');

    typeSelect.addEventListener('change', function() {
        documentInput.value = ''; // Limpa o campo quando muda o tipo
        if (this.value === 'individual') {
            documentInput.placeholder = 'CPF (apenas números)';
            documentInput.maxLength = 11;
        } else if (this.value === 'corporate') {
            documentInput.placeholder = 'CNPJ (apenas números)';
            documentInput.maxLength = 14;
        }
    });

    documentInput.addEventListener('input', function(e) {
        // Remove tudo que não é número
        let value = this.value.replace(/\D/g, '');
        
        // Limita o tamanho baseado no tipo selecionado
        const maxLength = typeSelect.value === 'individual' ? 11 : 14;
        value = value.slice(0, maxLength);
        
        this.value = value;
    });

    // Máscara para telefone
    const phoneInputs = document.querySelectorAll('input[type="tel"]');
    phoneInputs.forEach(input => {
        input.addEventListener('input', function(e) {
            let value = this.value.replace(/\D/g, '');
            value = value.slice(0, 11);
            
            if (value.length > 2) {
                value = `(${value.slice(0,2)}) ${value.slice(2)}`;
            }
            if (value.length > 9) {
                value = `${value.slice(0,9)}-${value.slice(9)}`;
            }
            
            this.value = value;
        });
    });
</script>
@endsection
