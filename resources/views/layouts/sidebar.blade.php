<div class="d-flex flex-column h-100">
    <ul class="nav flex-column">
        <!-- Dashboard -->
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" 
               href="{{ route('dashboard') }}">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
            <ul class="nav flex-column ms-3">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard.reports') ? 'active' : '' }}" 
                       href="{{ route('dashboard') }}">
                        <i class="fas fa-chart-line"></i>
                        <span>Relatórios Gerais</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard.performance') ? 'active' : '' }}" 
                       href="{{ route('dashboard') }}">
                        <i class="fas fa-chart-bar"></i>
                        <span>Performance</span>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Reservas -->
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('bookings.*') ? 'active' : '' }}" 
               href="{{ route('bookings.index') }}">
                <i class="fas fa-calendar-alt"></i>
                <span>Reservas</span>
            </a>
        </li>

        <!-- Clientes -->
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('clients.*') ? 'active' : '' }}" 
               href="{{ route('clients.index') }}">
                <i class="fas fa-users"></i>
                <span>Clientes</span>
            </a>
        </li>

        <!-- Frota -->
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs(['vehicles.*', 'drivers.*']) ? 'active' : '' }}" 
               href="#">
                <i class="fas fa-truck"></i>
                <span>Frota</span>
            </a>
            <ul class="nav flex-column ms-3">
                <!-- Veículos -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('vehicles.*') ? 'active' : '' }}" 
                       href="{{ route('vehicles.index') }}">
                        <i class="fas fa-car"></i>
                        <span>Veículos</span>
                    </a>
                </li>
                <!-- Motoristas -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('drivers.*') ? 'active' : '' }}" 
                       href="{{ route('drivers.index') }}">
                        <i class="fas fa-user"></i>
                        <span>Motoristas</span>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Suprimentos -->
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('supplies.*') ? 'active' : '' }}" 
               href="{{ route('supplies.index') }}">
                <i class="fas fa-boxes"></i>
                <span>Suprimentos</span>
            </a>
            <ul class="nav flex-column ms-3">
                <!-- Produtos -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('supplies.index') ? 'active' : '' }}" 
                       href="{{ route('supplies.index') }}">
                        <i class="fas fa-box"></i>
                        <span>Produtos</span>
                    </a>
                </li>
                <!-- Entrada de Estoque -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('supplies.stock.in') ? 'active' : '' }}" 
                       href="#">
                        <i class="fas fa-arrow-down"></i>
                        <span>Entrada de Estoque</span>
                    </a>
                </li>
                <!-- Saída de Estoque -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('supplies.stock.out') ? 'active' : '' }}" 
                       href="#">
                        <i class="fas fa-arrow-up"></i>
                        <span>Saída de Estoque</span>
                    </a>
                </li>
                <!-- Pedidos -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('supplies.orders.*') ? 'active' : '' }}" 
                       href="#">
                        <i class="fas fa-shopping-cart"></i>
                        <span>Pedidos</span>
                    </a>
                </li>
                <!-- Fornecedores -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('supplies.suppliers.*') ? 'active' : '' }}" 
                       href="#">
                        <i class="fas fa-truck-loading"></i>
                        <span>Fornecedores</span>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Configurações -->
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('settings.*') ? 'active' : '' }}" 
               href="#">
                <i class="fas fa-cog"></i>
                <span>Configurações</span>
            </a>
            <ul class="nav flex-column ms-3">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('settings.general') ? 'active' : '' }}" 
                       href="#">
                        <i class="fas fa-sliders-h"></i>
                        <span>Geral</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('settings.users.*') ? 'active' : '' }}" 
                       href="#">
                        <i class="fas fa-users-cog"></i>
                        <span>Usuários</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('settings.company') ? 'active' : '' }}" 
                       href="#">
                        <i class="fas fa-building"></i>
                        <span>Empresa</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('settings.customization') ? 'active' : '' }}" 
                       href="#">
                        <i class="fas fa-paint-brush"></i>
                        <span>Personalização</span>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</div>
