<!-- Statistik Card Component -->
<div class="card">
    <div class="card-body">
        <div class="d-flex align-items-center">
            <div>
                <div class="text-muted">{{ $label }}</div>
                <div class="h3 mt-2">{{ $value }}</div>
                @if(isset($change))
                    <div class="text-muted mt-2">
                        @if($change > 0)
                            <span class="text-success">
                                <i class="fas fa-arrow-up"></i> {{ $change }}%
                            </span>
                        @else
                            <span class="text-danger">
                                <i class="fas fa-arrow-down"></i> {{ abs($change) }}%
                            </span>
                        @endif
                    </div>
                @endif
            </div>
            @if(isset($icon))
                <div class="ms-auto">
                    <i class="{{ $icon }}" style="font-size: 2rem; opacity: 0.3;"></i>
                </div>
            @endif
        </div>
    </div>
</div>
