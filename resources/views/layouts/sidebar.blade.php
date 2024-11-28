<div class="d-flex flex-column h-100">
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" 
               href="{{ route('dashboard') }}">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('bookings.*') ? 'active' : '' }}" 
               href="{{ route('bookings.index') }}">
                <i class="fas fa-calendar-alt"></i>
                <span>Reservas</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('vehicles.*') ? 'active' : '' }}" 
               href="{{ route('vehicles.index') }}">
                <i class="fas fa-car"></i>
                <span>Veículos</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('drivers.*') ? 'active' : '' }}" 
               href="{{ route('drivers.index') }}">
                <i class="fas fa-user"></i>
                <span>Motoristas</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('clients.*') ? 'active' : '' }}" 
               href="{{ route('clients.index') }}">
                <i class="fas fa-users"></i>
                <span>Clientes</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('supplies.*') ? 'active' : '' }}" 
               href="{{ route('supplies.index') }}">
                <i class="fas fa-boxes"></i>
                <span>Suprimentos</span>
            </a>
        </li>
    </ul>
</div>
