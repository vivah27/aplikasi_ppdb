<!-- Data Table Card Component -->
<div class="card">
    <!-- Table Header -->
    @if(isset($title) || isset($actions))
        <div class="card-header d-print-none">
            <div class="row align-items-center">
                @if(isset($title))
                    <div class="col">
                        <h3 class="card-title">{{ $title }}</h3>
                    </div>
                @endif
                @if(isset($actions))
                    <div class="col-auto">
                        <div class="btn-list">
                            {!! $actions !!}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @endif

    <!-- Table -->
    <div class="table-responsive">
        <table class="table table-vcenter card-table">
            <thead>
                <tr>
                    {{ $thead }}
                </tr>
            </thead>
            <tbody>
                {{ $tbody }}
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if(isset($pagination))
        <div class="card-footer d-flex align-items-center">
            {{ $pagination }}
        </div>
    @endif
</div>
