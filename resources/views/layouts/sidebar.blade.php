<div class="sidebar sidebar-dark sidebar-fixed" id="sidebar">
    <div class="sidebar-content">
        <nav class="nav flex-column">
            <!-- Dashboard -->
            <div class="nav-group" data-group="dashboard">
                <a class="nav-link nav-group-toggle {{ request()->routeIs('dashboard*') ? 'active' : '' }}" 
                   href="#dashboard-menu" 
                   data-bs-toggle="collapse" 
                   aria-expanded="{{ request()->routeIs('dashboard*') ? 'true' : 'false' }}"
                   aria-controls="dashboard-menu">
                    <i class="nav-icon fas fa-home me-2"></i>
                    <span class="nav-link-text fw-bold">Dashboard</span>
                    <i class="fas fa-chevron-down ms-auto collapse-indicator"></i>
                </a>
                <div id="dashboard-menu" 
                     class="nav-group-items collapse {{ request()->routeIs('dashboard*') ? 'show' : '' }}"
                     aria-labelledby="dashboard-menu-toggle">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" 
                               href="{{ route('dashboard') }}">
                                <i class="nav-icon fas fa-chart-pie me-2"></i>
                                <span class="nav-link-text">Visão Geral</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" 
                               href="{{ route('dashboard') }}">
                                <i class="nav-icon fas fa-chart-line me-2"></i>
                                <span class="nav-link-text">Análises</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Reservas -->
            <div class="nav-group">
                <a class="nav-link {{ request()->routeIs('bookings.*') ? 'active' : '' }}" 
                   href="{{ route('bookings.index') }}">
                    <i class="nav-icon fas fa-calendar-alt me-2"></i>
                    <span class="nav-link-text fw-bold">Reservas</span>
                    <span class="badge bg-warning ms-auto">{{ $pendingBookings ?? 0 }}</span>
                </a>
            </div>

            <!-- Clientes -->
            <div class="nav-group">
                <a class="nav-link {{ request()->routeIs('clients.*') ? 'active' : '' }}" 
                   href="{{ route('clients.index') }}">
                    <i class="nav-icon fas fa-users me-2"></i>
                    <span class="nav-link-text fw-bold">Clientes</span>
                    <span class="badge bg-success ms-auto">{{ $newClients ?? 0 }}</span>
                </a>
            </div>

            <!-- Veículos -->
            <div class="nav-group">
                <a class="nav-link {{ request()->routeIs('vehicles.*') ? 'active' : '' }}" 
                   href="{{ route('vehicles.index') }}">
                    <i class="nav-icon fas fa-car me-2"></i>
                    <span class="nav-link-text fw-bold">Veículos</span>
                    <span class="badge bg-danger ms-auto">{{ $availableVehicles ?? 0 }}</span>
                </a>
            </div>

            <!-- Aeroportos -->
            <div class="nav-group">
                <a class="nav-link {{ request()->routeIs('airports.*') ? 'active' : '' }}" 
                   href="{{ route('airports.index') }}">
                    <i class="nav-icon fas fa-plane me-2"></i>
                    <span class="nav-link-text fw-bold">Aeroportos</span>
                </a>
            </div>

            <!-- Motoristas -->
            <div class="nav-group">
                <a class="nav-link {{ request()->routeIs('drivers.*') ? 'active' : '' }}" 
                   href="{{ route('drivers.index') }}">
                    <i class="nav-icon fas fa-id-card me-2"></i>
                    <span class="nav-link-text fw-bold">Motoristas</span>
                    <span class="badge bg-secondary ms-auto">{{ $activeDrivers ?? 0 }}</span>
                </a>
            </div>

            <!-- Suprimentos -->
            <div class="nav-group" data-group="supplies">
                <a class="nav-link nav-group-toggle {{ request()->routeIs('supplies.*') ? 'active' : '' }}" 
                   href="#supplies-menu" 
                   data-bs-toggle="collapse" 
                   aria-expanded="{{ request()->routeIs('supplies.*') ? 'true' : 'false' }}"
                   aria-controls="supplies-menu">
                    <i class="nav-icon fas fa-boxes me-2"></i>
                    <span class="nav-link-text fw-bold">Suprimentos</span>
                    <i class="fas fa-chevron-down ms-auto collapse-indicator"></i>
                </a>
                <div id="supplies-menu" class="nav-group-items {{ !request()->routeIs('supplies.*') ? 'collapse' : '' }}">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('supplies.index') && !request()->has('filter') ? 'active' : '' }}" 
                           href="{{ route('supplies.index') }}">
                            <i class="fas fa-box me-2"></i>
                            <span class="nav-link-text">Produtos</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('supplies.alerts') ? 'active' : '' }}" 
                           href="{{ route('supplies.alerts') }}">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <span class="nav-link-text">Alertas de Estoque</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('supplies.reports') ? 'active' : '' }}" 
                           href="{{ route('supplies.reports') }}">
                            <i class="fas fa-chart-bar me-2"></i>
                            <span class="nav-link-text">Relatórios</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('supplies.categories') ? 'active' : '' }}" 
                           href="{{ route('supplies.categories') }}">
                            <i class="fas fa-folder me-2"></i>
                            <span class="nav-link-text">Categorias</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('supplies.providers') ? 'active' : '' }}" 
                           href="#">
                            <i class="fas fa-truck me-2"></i>
                            <span class="nav-link-text">Fornecedores</span>
                        </a>
                    </li>
                </div>
            </div>

            <!-- Configurações -->
            <div class="nav-group" data-group="settings">
                <a class="nav-link nav-group-toggle {{ request()->routeIs('settings*') ? 'active' : '' }}" 
                   href="#settings-menu" 
                   data-bs-toggle="collapse" 
                   aria-expanded="{{ request()->routeIs('settings*') ? 'true' : 'false' }}"
                   aria-controls="settings-menu">
                    <i class="nav-icon fas fa-cog me-2"></i>
                    <span class="nav-link-text fw-bold">Configurações</span>
                    <i class="fas fa-chevron-down ms-auto collapse-indicator"></i>
                </a>
                <div id="settings-menu" class="nav-group-items {{ !request()->routeIs('settings*') ? 'collapse' : '' }}">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('settings.general') ? 'active' : '' }}" 
                           href="#">
                            <i class="fas fa-sliders-h me-2"></i>
                            <span class="nav-link-text">Geral</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('settings.users.*') ? 'active' : '' }}" 
                           href="#">
                            <i class="fas fa-users-cog me-2"></i>
                            <span class="nav-link-text">Usuários</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('settings.company') ? 'active' : '' }}" 
                           href="#">
                            <i class="fas fa-building me-2"></i>
                            <span class="nav-link-text">Empresa</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('settings.customization') ? 'active' : '' }}" 
                           href="#">
                            <i class="fas fa-paint-brush me-2"></i>
                            <span class="nav-link-text">Personalização</span>
                        </a>
                    </li>
                </div>
            </div>
        </nav>
    </div>

    <!-- User Info Footer -->
    <div class="sidebar-footer border-top p-3 text-center">
        <a href="{{ route('logout') }}" 
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
           class="btn btn-danger btn-block" 
           title="Sair">
            <i class="fas fa-sign-out-alt me-2"></i> Sair
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>
</div>

@push('styles')
<style>
    /* Mobile Overlay */
    .mobile-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1040;
        display: none;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .mobile-overlay.show {
        display: block;
        opacity: 1;
    }
    /* Responsive Sidebar Adjustments */
    @media (max-width: 767.98px) {
        .sidebar {
            position: fixed;
            top: 60px;
            left: -250px;
            width: 250px;
            height: calc(100vh - 60px);
            background-color: #fff;
            z-index: 1050;
            transition: left 0.3s ease;
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
            overflow-y: auto;
        }

        .sidebar.show {
            left: 0;
        }

        /* Adjust content wrapper for mobile */
        .content-wrapper {
            margin-left: 0;
            padding-top: 60px;
        }

        /* Ensure nav links are fully clickable */
        .sidebar .nav-link {
            display: flex;
            align-items: center;
            width: 100%;
            padding: 0.75rem 1rem;
        }

        /* Improve submenu styling */
        .sidebar .nav-group-items {
            background-color: #f8f9fa;
        }

        .sidebar .nav-group-items .nav-link {
            padding-left: 2rem;
            font-size: 0.9rem;
        }
    }

    /* Accessibility Enhancements */
    .sidebar .nav-link:focus {
        outline: 2px solid #007bff;
        outline-offset: -2px;
    }

    .sidebar .nav-link:hover,
    .sidebar .nav-link:focus {
        text-decoration: underline;
    }

    /* Performance Indicator Styles */
    .sidebar .badge {
        font-size: 0.7rem;
        padding: 0.25em 0.5em;
        border-radius: 0.2rem;
    }

    /* Collapse Indicator Rotation */
    .collapse-indicator {
        transition: transform 0.3s ease;
    }

    ..rotated
        transform: rotate(180deg);
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.querySelector('.sidebar');
    const mobileOverlay = document.getElementById('mobile-overlay');
    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');

    function toggleMobileMenu() {
        // Toggle sidebar
        sidebar.classList.toggle('show');
        
        // Toggle overlay
        mobileOverlay.classList.toggle('show');
        
        // Update aria-expanded state
        const isExpanded = sidebar.classList.contains('show');
        mobileMenuToggle.setAttribute('aria-expanded', isExpanded);
        
        // Prevent body scrolling when sidebar is open
        document.body.style.overflow = isExpanded ? 'hidden' : '';
    }

    // Add event listeners
    mobileMenuToggle.addEventListener('click', toggleMobileMenu);
    mobileOverlay.addEventListener('click', toggleMobileMenu);

    // Close sidebar when a nav link is clicked on mobile
    const navLinks = sidebar.querySelectorAll('.nav-link');
    navLinks.forEach(link => {
        link.addEventListener('click', function() {
            if (window.innerWidth < 768) {
                toggleMobileMenu();
            }
        });
    });

    // Responsive handling
    function handleResponsiveness() {
        if (window.innerWidth >= 768) {
            sidebar.classList.remove('show');
            mobileOverlay.classList.remove('show');
            mobileMenuToggle.setAttribute('aria-expanded', 'false');
            document.body.style.overflow = '';
        }
    }

    // Add resize listener
    window.addEventListener('resize', handleResponsiveness);

    // Collapse group toggle functionality
    const groupToggles = sidebar.querySelectorAll('.nav-group-toggle');
    groupToggles.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            e.preventDefault(); // Prevent default link behavior
            
            const collapseIndicator = this.querySelector('.collapse-indicator');const targetId = this.getAttribute('aria-controls');
            
            const targetMenu 
                // Close other open menus= document.getElementById(targetId);
            consconst openMenus = sideb c.querySelectorAll('.nav-oroup-items.show');
                oplnMenus.forEach(menu => {
                    if (menu !== targelaenu) {
                        mpseIndicator =remove('show');
                        const o herTthile = sidebar.querySes.ctorq`[aria-controls="${menu.id}"]`);
                        if (otherToggle) {
                            otherToggle.setAttribute('aria-expanded', 'false');
                            otherToggle.querySelector('.collapse-indicator').classList.remove('rotated');
                        }
                    }
                });

                // Toggle current menu
                targetMenu.classList.toggle(uerySelector('.collapse-indicator');
            
            if (targetMenu) {);
                
                // Rotate collapse indicator
                collapseIndicator.classList.toggle('rotated'
                // Close other open menus
                const openMenus = sidebar.querySelectorAll('.nav-group-items.show');
                openMenus.forEach(menu => {
                    if (menu !== targetMenu) {
                        menu.classList.remove('show');
                        const otherToggle = sidebar.querySelector(`[aria-controls="${menu.id}"]`);
                        if (otherToggle) {
                            otherToggle.setAttribute('aria-expanded', 'false');
                            otherToggle.querySelector('.collapse-indicator').classList.remove('rotated');
                        }
                    }
                });

                // Toggle current menu
                targetMenu.classList.toggle('show');
                this.setAttribute('aria-expanded', 
                    targetMenu.classList.contains('show').toString());
                
                // Rotate collapse indicator
                collapseIndicator.classList.toggle('rotated');
            }
        });
    });
});
</script>
@endpush
