@extends('layouts.app')

@push('styles')
<style>
    /* Estilos para cartões de configuração */
    .settings-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        cursor: pointer;
    }
    .settings-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
    .settings-card .card-body {
        display: flex;
        align-items: center;
    }
    .settings-card-icon {
        font-size: 2.5rem;
        margin-right: 1rem;
        color: #007bff;
    }
    .settings-card-content {
        flex-grow: 1;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h4 class="card-title mb-3">Configurações Gerais</h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card settings-card" onclick="window.location.href='#system-settings'">
                        <div class="card-body">
                            <i class="fas fa-cogs settings-card-icon"></i>
                            <div class="settings-card-content">
                                <h5 class="card-title">Configurações do Sistema</h5>
                                <p class="card-text text-muted">Gerencie configurações gerais do sistema</p>
                            </div>
                            <i class="fas fa-chevron-right text-muted"></i>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card settings-card" onclick="window.location.href='#notifications'">
                        <div class="card-body">
                            <i class="fas fa-bell settings-card-icon"></i>
                            <div class="settings-card-content">
                                <h5 class="card-title">Notificações</h5>
                                <p class="card-text text-muted">Configure preferências de notificação</p>
                            </div>
                            <i class="fas fa-chevron-right text-muted"></i>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card settings-card" onclick="window.location.href='#security'">
                        <div class="card-body">
                            <i class="fas fa-lock settings-card-icon"></i>
                            <div class="settings-card-content">
                                <h5 class="card-title">Segurança</h5>
                                <p class="card-text text-muted">Gerencie senhas e permissões</p>
                            </div>
                            <i class="fas fa-chevron-right text-muted"></i>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card settings-card" onclick="window.location.href='#integrations'">
                        <div class="card-body">
                            <i class="fas fa-plug settings-card-icon"></i>
                            <div class="settings-card-content">
                                <h5 class="card-title">Integrações</h5>
                                <p class="card-text text-muted">Configurar integrações externas</p>
                            </div>
                            <i class="fas fa-chevron-right text-muted"></i>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card settings-card" onclick="window.location.href='#appearance'">
                        <div class="card-body">
                            <i class="fas fa-palette settings-card-icon"></i>
                            <div class="settings-card-content">
                                <h5 class="card-title">Aparência</h5>
                                <p class="card-text text-muted">Personalize a interface</p>
                            </div>
                            <i class="fas fa-chevron-right text-muted"></i>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card settings-card" onclick="window.location.href='#backup'">
                        <div class="card-body">
                            <i class="fas fa-database settings-card-icon"></i>
                            <div class="settings-card-content">
                                <h5 class="card-title">Backup</h5>
                                <p class="card-text text-muted">Gerenciar backups do sistema</p>
                            </div>
                            <i class="fas fa-chevron-right text-muted"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Adicionar efeitos de hover e clique nos cartões de configuração
        const settingsCards = document.querySelectorAll('.settings-card');
        settingsCards.forEach(card => {
            card.addEventListener('click', function() {
                const href = this.getAttribute('onclick').match(/'([^']+)'/)[1];
                
                // Verificar se é um link de âncora
                if (href.startsWith('#')) {
                    // Mostrar um alerta informativo
                    Swal.fire({
                        icon: 'info',
                        title: 'Em Desenvolvimento',
                        text: 'Esta funcionalidade ainda está em desenvolvimento.',
                        confirmButtonText: 'Ok, entendi'
                    });
                } else {
                    // Navegar para a rota
                    window.location.href = href;
                }
            });
        });
    });
</script>
@endpush
