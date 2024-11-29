@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Veículos</h2>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createVehicleModal">
                <i class="fas fa-plus"></i> Novo Veículo
            </button>
        </div>

        <!-- Search and filters -->
        <div class="card mb-4">
            <div class="card-body">
                <form action="{{ route('vehicles.index') }}" method="GET" class="row g-3">
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control" placeholder="Buscar veículos..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <select name="status" class="form-select">
                            <option value="">Todos os status</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Ativo</option>
                            <option value="maintenance" {{ request('status') == 'maintenance' ? 'selected' : '' }}>Em Manutenção</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inativo</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="type" class="form-select">
                            <option value="">Todos os tipos</option>
                            <option value="car" {{ request('type') == 'car' ? 'selected' : '' }}>Carro</option>
                            <option value="van" {{ request('type') == 'van' ? 'selected' : '' }}>Van</option>
                            <option value="bus" {{ request('type') == 'bus' ? 'selected' : '' }}>Ônibus</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-secondary w-100">
                            <i class="fas fa-search"></i> Filtrar
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Vehicles list -->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Placa</th>
                                <th>Modelo</th>
                                <th>Tipo</th>
                                <th>Status</th>
                                <th>Última Manutenção</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($vehicles as $vehicle)
                                <tr>
                                    <td>{{ $vehicle->plate }}</td>
                                    <td>{{ $vehicle->model }}</td>
                                    <td>{{ ucfirst($vehicle->type) }}</td>
                                    <td>
                                        <span class="badge bg-{{ $vehicle->status_color }}">
                                            {{ $vehicle->status_text }}
                                        </span>
                                    </td>
                                    <td>{{ $vehicle->last_maintenance ? $vehicle->last_maintenance->format('d/m/Y') : 'N/A' }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('vehicles.show', $vehicle->id) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('vehicles.edit', $vehicle->id) }}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-vehicle-id="{{ $vehicle->id }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <div class="d-flex flex-column align-items-center">
                                            <i class="fas fa-car fa-3x text-muted mb-3"></i>
                                            <p class="h5 text-muted">Nenhum veículo encontrado</p>
                                            <p class="text-muted">Clique no botão "Novo Veículo" para adicionar um veículo</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-end mt-3">
                    {{ $vehicles->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete confirmation modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmar Exclusão</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja excluir este veículo?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Excluir</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para criar novo veículo -->
<div class="modal fade" id="createVehicleModal" tabindex="-1" aria-labelledby="createVehicleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createVehicleModalLabel">Novo Veículo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <div id="createVehicleForm"></div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Modal de criação de veículo
        const modal = document.getElementById('createVehicleModal');
        const formContainer = document.getElementById('createVehicleForm');
        let formLoaded = false;

        modal.addEventListener('show.bs.modal', function() {
            if (!formLoaded) {
                fetch('{{ route('vehicles.create') }}')
                    .then(response => response.text())
                    .then(html => {
                        // Extrair apenas o conteúdo do formulário do HTML retornado
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');
                        const form = doc.querySelector('#vehicleForm');
                        
                        if (form) {
                            formContainer.innerHTML = form.outerHTML;
                            
                            // Reinicializar os componentes do Bootstrap
                            const tooltipTriggerList = [].slice.call(formContainer.querySelectorAll('[data-bs-toggle="tooltip"]'));
                            tooltipTriggerList.map(function (tooltipTriggerEl) {
                                return new bootstrap.Tooltip(tooltipTriggerEl);
                            });

                            // Atualizar o action do formulário e adicionar handler de submit
                            const vehicleForm = formContainer.querySelector('#vehicleForm');
                            if (vehicleForm) {
                                vehicleForm.addEventListener('submit', function(e) {
                                    e.preventDefault();
                                    
                                    const formData = new FormData(this);
                                    fetch('{{ route('vehicles.store') }}', {
                                        method: 'POST',
                                        headers: {
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                        },
                                        body: formData
                                    })
                                    .then(response => response.json())
                                    .then(data => {
                                        if (data.success) {
                                            // Fechar o modal e recarregar a página
                                            const bsModal = bootstrap.Modal.getInstance(modal);
                                            bsModal.hide();
                                            window.location.reload();
                                        } else {
                                            // Mostrar erros de validação
                                            Object.keys(data.errors).forEach(field => {
                                                const input = vehicleForm.querySelector(`[name="${field}"]`);
                                                if (input) {
                                                    input.classList.add('is-invalid');
                                                    const feedback = input.nextElementSibling;
                                                    if (feedback && feedback.classList.contains('invalid-feedback')) {
                                                        feedback.textContent = data.errors[field][0];
                                                    }
                                                }
                                            });
                                        }
                                    })
                                    .catch(error => {
                                        console.error('Error:', error);
                                        alert('Ocorreu um erro ao salvar o veículo. Por favor, tente novamente.');
                                    });
                                });
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        formContainer.innerHTML = '<div class="alert alert-danger">Erro ao carregar o formulário</div>';
                    });
                formLoaded = true;
            }
        });

        // Limpar o formulário quando o modal for fechado
        modal.addEventListener('hidden.bs.modal', function() {
            formContainer.innerHTML = '';
            formLoaded = false;
        });
    });

    // Modal de exclusão
    const deleteModal = document.getElementById('deleteModal');
    if (deleteModal) {
        deleteModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const vehicleId = button.getAttribute('data-vehicle-id');
            const deleteForm = deleteModal.querySelector('#deleteForm');
            deleteForm.action = `/vehicles/${vehicleId}`;
        });
    }
</script>
@endpush
