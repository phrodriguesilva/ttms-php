@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="card-title mb-0">Novo Item</h4>
                    </div>
                    <div>
                        <span class="badge bg-primary">SKU: {{ $sku }}</span>
                        <button type="button" class="btn btn-outline-primary btn-sm ms-2" id="generateNewSku">
                            Gerar Novo Código
                        </button>
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{ route('supplies.store') }}" method="POST" enctype="multipart/form-data" id="createSupplyForm">
                        @csrf
                        <input type="hidden" name="sku" id="skuInput" value="{{ $sku }}">
                        
                        <!-- Abas de Navegação -->
                        <ul class="nav nav-tabs mb-3" id="supplyTabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="general-tab" data-bs-toggle="tab" href="#general" role="tab">
                                    Informações Gerais
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="stock-tab" data-bs-toggle="tab" href="#stock" role="tab">
                                    Detalhes de Estoque
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="other-tab" data-bs-toggle="tab" href="#other" role="tab">
                                    Outras Informações
                                </a>
                            </li>
                        </ul>

                        <!-- Conteúdo das Abas -->
                        <div class="tab-content" id="supplyTabsContent">
                            <!-- Aba de Informações Gerais -->
                            <div class="tab-pane fade show active" id="general" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="name" class="form-label">Nome do Item *</label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                                   id="name" name="name" value="{{ old('name') }}" 
                                                   placeholder="Digite o nome do item" required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="category" class="form-label">Categoria *</label>
                                            <div class="input-group">
                                                <select class="form-select @error('category') is-invalid @enderror" 
                                                        id="category" name="category" required>
                                                    <option value="">Selecione uma categoria</option>
                                                    @foreach($categories as $category)
                                                        <option value="{{ $category }}" {{ old('category') == $category ? 'selected' : '' }}>
                                                            {{ $category }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <button class="btn btn-outline-secondary" type="button" 
                                                        data-bs-toggle="modal" data-bs-target="#newCategoryModal">
                                                    Nova
                                                </button>
                                            </div>
                                            @error('category')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="supplier" class="form-label">Fornecedor</label>
                                            <div class="input-group">
                                                <select class="form-select @error('supplier') is-invalid @enderror" 
                                                        id="supplier" name="supplier">
                                                    <option value="">Selecione um fornecedor</option>
                                                    @foreach($suppliers as $supplier)
                                                        <option value="{{ $supplier }}" {{ old('supplier') == $supplier ? 'selected' : '' }}>
                                                            {{ $supplier }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <button class="btn btn-outline-secondary" type="button" 
                                                        data-bs-toggle="modal" data-bs-target="#newSupplierModal">
                                                    Novo
                                                </button>
                                            </div>
                                            @error('supplier')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="unit_price" class="form-label">Preço Unitário *</label>
                                            <div class="input-group">
                                                <span class="input-group-text">R$</span>
                                                <input type="number" step="0.01" min="0" 
                                                       class="form-control @error('unit_price') is-invalid @enderror" 
                                                       id="unit_price" name="unit_price" 
                                                       value="{{ old('unit_price') }}" required>
                                            </div>
                                            @error('unit_price')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Aba de Detalhes de Estoque -->
                            <div class="tab-pane fade" id="stock" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="stock_quantity" class="form-label">Quantidade em Estoque *</label>
                                            <div class="input-group">
                                                <input type="number" step="0.01" min="0" 
                                                       class="form-control @error('stock_quantity') is-invalid @enderror" 
                                                       id="stock_quantity" name="stock_quantity" 
                                                       value="{{ old('stock_quantity', 0) }}" required>
                                                <span class="input-group-text stock-unit">UN</span>
                                            </div>
                                            @error('stock_quantity')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="minimum_stock" class="form-label">Estoque Mínimo *</label>
                                            <div class="input-group">
                                                <input type="number" step="0.01" min="0" 
                                                       class="form-control @error('minimum_stock') is-invalid @enderror" 
                                                       id="minimum_stock" name="minimum_stock" 
                                                       value="{{ old('minimum_stock', 0) }}" required>
                                                <span class="input-group-text stock-unit">UN</span>
                                            </div>
                                            <small class="text-muted">
                                                Alerta será exibido quando o estoque atingir este valor
                                            </small>
                                            @error('minimum_stock')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="unit" class="form-label">Unidade de Medida *</label>
                                            <select class="form-select @error('unit') is-invalid @enderror" 
                                                    id="unit" name="unit" required>
                                                <option value="">Selecione uma unidade</option>
                                                @foreach($units as $value => $label)
                                                    <option value="{{ $value }}" {{ old('unit') == $value ? 'selected' : '' }}>
                                                        {{ $label }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('unit')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="location" class="form-label">Localização no Estoque</label>
                                            <input type="text" class="form-control @error('location') is-invalid @enderror" 
                                                   id="location" name="location" value="{{ old('location') }}"
                                                   placeholder="Ex: Prateleira A1, Gaveta 2">
                                            <small class="text-muted">
                                                Indique onde o item está armazenado
                                            </small>
                                            @error('location')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Aba de Outras Informações -->
                            <div class="tab-pane fade" id="other" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="description" class="form-label">Descrição do Item</label>
                                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                                      id="description" name="description" rows="4"
                                                      placeholder="Adicione uma descrição detalhada do item">{{ old('description') }}</textarea>
                                            @error('description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="notes" class="form-label">Observações</label>
                                            <textarea class="form-control @error('notes') is-invalid @enderror" 
                                                      id="notes" name="notes" rows="4"
                                                      placeholder="Adicione informações importantes sobre o item">{{ old('notes') }}</textarea>
                                            <small class="text-muted">
                                                Ex: Instruções especiais de manuseio, armazenamento ou outras observações relevantes
                                            </small>
                                            @error('notes')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="photos" class="form-label">Fotos do Item</label>
                                            <div class="input-group mb-3">
                                                <input type="file" class="form-control @error('photos.*') is-invalid @enderror" 
                                                       id="photos" name="photos[]" multiple accept="image/*">
                                            </div>
                                            <small class="text-muted d-block mb-2">
                                                Você pode selecionar múltiplas fotos. Formatos aceitos: JPG, PNG, GIF
                                            </small>
                                            <div id="photoPreviewContainer" class="d-flex flex-wrap gap-2">
                                                <!-- As previews das fotos aparecerão aqui -->
                                            </div>
                                            @error('photos.*')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Botões de Ação -->
                        <div class="row mt-4">
                            <div class="col-12 text-end">
                                <a href="{{ route('supplies.index') }}" class="btn btn-secondary">Cancelar</a>
                                <button type="submit" class="btn btn-primary" id="submitButton">Salvar Item</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Nova Categoria -->
<div class="modal fade" id="newCategoryModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nova Categoria</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="newCategory" class="form-label">Nome da Categoria</label>
                    <input type="text" class="form-control" id="newCategory">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="addNewCategory">Adicionar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Novo Fornecedor -->
<div class="modal fade" id="newSupplierModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Novo Fornecedor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="newSupplier" class="form-label">Nome do Fornecedor</label>
                    <input type="text" class="form-control" id="newSupplier">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="addNewSupplier">Adicionar</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Gerar novo SKU
document.getElementById('generateNewSku').addEventListener('click', function() {
    fetch('{{ route("supplies.generate-sku") }}')
        .then(response => response.json())
        .then(data => {
            document.getElementById('skuInput').value = data.sku;
            document.querySelector('.badge').textContent = 'SKU: ' + data.sku;
        });
});

// Atualizar unidade de medida nos campos de estoque
document.getElementById('unit').addEventListener('change', function() {
    const unit = this.value || 'UN';
    document.querySelectorAll('.stock-unit').forEach(el => {
        el.textContent = unit;
    });
});

// Adicionar nova categoria
document.getElementById('addNewCategory').addEventListener('click', function() {
    const newCategory = document.getElementById('newCategory').value;
    if (newCategory) {
        const select = document.getElementById('category');
        const option = new Option(newCategory, newCategory, true, true);
        select.appendChild(option);
        bootstrap.Modal.getInstance(document.getElementById('newCategoryModal')).hide();
        document.getElementById('newCategory').value = '';
    }
});

// Adicionar novo fornecedor
document.getElementById('addNewSupplier').addEventListener('click', function() {
    const newSupplier = document.getElementById('newSupplier').value;
    if (newSupplier) {
        const select = document.getElementById('supplier');
        const option = new Option(newSupplier, newSupplier, true, true);
        select.appendChild(option);
        bootstrap.Modal.getInstance(document.getElementById('newSupplierModal')).hide();
        document.getElementById('newSupplier').value = '';
    }
});

// Validação do formulário e navegação entre abas
document.getElementById('createSupplyForm').addEventListener('submit', function(e) {
    const requiredFields = this.querySelectorAll('[required]');
    let isValid = true;
    let firstErrorTab = null;

    // Remove todas as marcações de erro das abas
    document.querySelectorAll('.nav-link').forEach(tab => {
        tab.classList.remove('text-danger');
    });

    requiredFields.forEach(field => {
        if (!field.value) {
            isValid = false;
            field.classList.add('is-invalid');
            
            // Encontra a aba que contém o campo com erro
            const tabPane = field.closest('.tab-pane');
            if (tabPane) {
                const tabId = tabPane.id;
                const tab = document.querySelector(`[href="#${tabId}"]`);
                tab.classList.add('text-danger');
                
                if (!firstErrorTab) {
                    firstErrorTab = tab;
                }
            }
        } else {
            field.classList.remove('is-invalid');
        }
    });

    if (!isValid) {
        e.preventDefault();
        if (firstErrorTab) {
            // Ativa a primeira aba com erro
            bootstrap.Tab.getOrCreateInstance(firstErrorTab).show();
        }
        alert('Por favor, preencha todos os campos obrigatórios marcados com *');
    }
});

// Preview das fotos com barra de progresso
document.getElementById('photos').addEventListener('change', function(e) {
    const container = document.getElementById('photoPreviewContainer');
    container.innerHTML = '';
    
    const totalFiles = this.files.length;
    let loadedFiles = 0;
    
    // Adiciona barra de progresso
    const progressDiv = document.createElement('div');
    progressDiv.className = 'progress mb-3 w-100';
    progressDiv.innerHTML = '<div class="progress-bar" role="progressbar" style="width: 0%"></div>';
    container.appendChild(progressDiv);
    const progressBar = progressDiv.querySelector('.progress-bar');

    // Grid para as imagens
    const gridDiv = document.createElement('div');
    gridDiv.className = 'd-flex flex-wrap gap-2';
    container.appendChild(gridDiv);

    for (const file of this.files) {
        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            const preview = document.createElement('div');
            preview.className = 'position-relative';
            
            reader.onload = function(e) {
                loadedFiles++;
                const progress = (loadedFiles / totalFiles) * 100;
                progressBar.style.width = progress + '%';
                progressBar.textContent = Math.round(progress) + '%';
                
                preview.innerHTML = `
                    <div class="position-relative" style="width: 150px; height: 150px;">
                        <img src="${e.target.result}" class="img-thumbnail" 
                             style="width: 100%; height: 100%; object-fit: cover;">
                        <button type="button" class="btn-close position-absolute top-0 end-0 m-1" 
                                style="background-color: white;" aria-label="Remove"></button>
                    </div>
                `;
                
                // Adiciona evento para remover a imagem
                preview.querySelector('.btn-close').addEventListener('click', function() {
                    preview.remove();
                });
            }
            
            reader.readAsDataURL(file);
            gridDiv.appendChild(preview);
        }
    }
});

// Navegação entre abas com botões
document.querySelectorAll('.nav-link').forEach(tab => {
    tab.addEventListener('click', function(e) {
        e.preventDefault();
        const currentTab = this.getAttribute('href');
        const currentIndex = Array.from(this.parentElement.parentElement.children)
                                .indexOf(this.parentElement);
        
        // Atualiza a classe ativa
        document.querySelectorAll('.nav-link').forEach(t => t.classList.remove('active'));
        this.classList.add('active');
        
        // Mostra a aba atual
        document.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('show', 'active'));
        document.querySelector(currentTab).classList.add('show', 'active');
    });
});
</script>
@endpush
