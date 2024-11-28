<div class="position-sticky pt-3">
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" 
               href="{{ route('dashboard') }}">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('vehicles.*') ? 'active' : '' }}" 
               href="{{ route('vehicles.index') }}">
                <i class="fas fa-car"></i> Veículos
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('bookings.*') ? 'active' : '' }}" 
               href="{{ route('bookings.index') }}">
                <i class="fas fa-calendar-alt"></i> Reservas
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('drivers.*') ? 'active' : '' }}" 
               href="{{ route('drivers.index') }}">
                <i class="fas fa-user"></i> Motoristas
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('clients.*') ? 'active' : '' }}" 
               href="{{ route('clients.index') }}">
                <i class="fas fa-users"></i> Clientes
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('supplies.*') ? 'active' : '' }}" 
               href="{{ route('supplies.index') }}">
                <i class="fas fa-boxes"></i> Suprimentos
            </a>
        </li>
    </ul>
</div>
