{{-- Campo de Telefone Principal (não obrigatório) --}}
<div class="col-md-6">
    <label for="phone" class="form-label">Telefone Principal</label>
    <input type="text" name="phone" id="phone" 
           class="form-control phone-mask @error('phone') is-invalid @enderror"
           value="{{ old('phone', $client->phone ?? '') }}">
    @error('phone')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

{{-- Campos de Endereço (não obrigatórios) --}}
<div class="row mb-3">
    <div class="col-md-3">
        <label for="postal_code" class="form-label">CEP</label>
        <input type="text" name="postal_code" id="postal_code" 
               class="form-control @error('postal_code') is-invalid @enderror"
               value="{{ old('postal_code', $client->postal_code ?? '') }}">
        @error('postal_code')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-7">
        <label for="address" class="form-label">Endereço</label>
        <input type="text" name="address" id="address" 
               class="form-control @error('address') is-invalid @enderror"
               value="{{ old('address', $client->address ?? '') }}">
        @error('address')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-2">
        <label for="number" class="form-label">Número</label>
        <input type="text" name="number" id="number" 
               class="form-control @error('number') is-invalid @enderror"
               value="{{ old('number', $client->number ?? '') }}">
        @error('number')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-4">
        <label for="neighborhood" class="form-label">Bairro</label>
        <input type="text" name="neighborhood" id="neighborhood" 
               class="form-control @error('neighborhood') is-invalid @enderror"
               value="{{ old('neighborhood', $client->neighborhood ?? '') }}">
        @error('neighborhood')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label for="city" class="form-label">Cidade</label>
        <input type="text" name="city" id="city" 
               class="form-control @error('city') is-invalid @enderror"
               value="{{ old('city', $client->city ?? '') }}">
        @error('city')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
