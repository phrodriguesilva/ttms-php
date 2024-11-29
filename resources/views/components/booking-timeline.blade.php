@props(['booking'])

<div class="booking-timeline">
    <div class="timeline-header mb-3">
        <h5 class="mb-0">
            <i class="fas fa-history me-2"></i>
            Histórico da Reserva
        </h5>
    </div>

    <div class="timeline">
        @php
            $statuses = [
                'pending' => [
                    'icon' => 'clock',
                    'color' => 'warning',
                    'label' => 'Pendente'
                ],
                'confirmed' => [
                    'icon' => 'check-circle',
                    'color' => 'success',
                    'label' => 'Confirmada'
                ],
                'in_progress' => [
                    'icon' => 'car',
                    'color' => 'info',
                    'label' => 'Em Andamento'
                ],
                'completed' => [
                    'icon' => 'flag-checkered',
                    'color' => 'success',
                    'label' => 'Concluída'
                ],
                'cancelled' => [
                    'icon' => 'times-circle',
                    'color' => 'danger',
                    'label' => 'Cancelada'
                ]
            ];
        @endphp

        <div class="timeline-items">
            @foreach($booking->statusHistory()->orderBy('created_at', 'desc')->get() as $history)
                <div class="timeline-item">
                    <div class="timeline-marker bg-{{ $statuses[$history->status]['color'] }}">
                        <i class="fas fa-{{ $statuses[$history->status]['icon'] }}"></i>
                    </div>
                    <div class="timeline-content">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <h6 class="mb-0">{{ $statuses[$history->status]['label'] }}</h6>
                            <small class="text-muted">{{ $history->created_at->format('d/m/Y H:i') }}</small>
                        </div>
                        @if($history->comment)
                            <p class="mb-0 small">{{ $history->comment }}</p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<style>
.booking-timeline {
    padding: 1rem;
    background-color: #fff;
    border-radius: 0.5rem;
}

.timeline {
    position: relative;
    padding: 1rem 0;
}

.timeline-items {
    position: relative;
}

.timeline-items::before {
    content: '';
    position: absolute;
    left: 0.85rem;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #e9ecef;
}

.timeline-item {
    display: flex;
    margin-bottom: 1.5rem;
    position: relative;
}

.timeline-item:last-child {
    margin-bottom: 0;
}

.timeline-marker {
    width: 2rem;
    height: 2rem;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    margin-right: 1rem;
    z-index: 1;
}

.timeline-marker i {
    color: white;
    font-size: 0.875rem;
}

.timeline-content {
    flex: 1;
    min-width: 0;
    background: #f8f9fa;
    padding: 0.75rem;
    border-radius: 0.375rem;
}

.bg-warning { background-color: #ffc107; }
.bg-success { background-color: #28a745; }
.bg-info { background-color: #17a2b8; }
.bg-danger { background-color: #dc3545; }
</style>
