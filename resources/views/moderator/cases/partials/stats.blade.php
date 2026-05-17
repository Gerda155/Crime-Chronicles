<div class="row g-3 mb-4">

    <div class="col-md-2">
        <div class="card rounded p-3 h-100">
            <div class="d-flex justify-content-between align-items-center">

                <div>
                    <div class="card-text">Kopā lietu</div>
                    <div class="card-title">{{ $cases->count() }}</div>
                </div>

                <i class="fa-solid fa-folder card-title"></i>

            </div>
        </div>
    </div>

    <div class="col-md-2">
        <div class="card rounded p-3 h-100">
            <div class="d-flex justify-content-between align-items-center">

                <div>
                    <div class="card-text">Aktīvas</div>
                    <div class="card-title">
                        {{ $cases->where('status', 'active')->count() }}
                    </div>
                </div>

                <i class="fa-solid fa-circle-check card-title text-success"></i>

            </div>
        </div>
    </div>

    <div class="col-md-2">
        <div class="card rounded p-3 h-100">
            <div class="d-flex justify-content-between align-items-center">

                <div>
                    <div class="card-text">Neaktīvas</div>
                    <div class="card-title">
                        {{ $cases->where('status', 'inactive')->count() }}
                    </div>
                </div>

                <i class="fa-solid fa-circle-xmark card-title text-danger"></i>

            </div>
        </div>
    </div>

    <div class="col-md-2">
        <div class="card rounded p-3 h-100">
            <div class="d-flex justify-content-between align-items-center">

                <div>
                    <div class="card-text">Tutorial</div>
                    <div class="card-title">
                        {{ $cases->where('is_tutorial', true)->count() }}
                    </div>
                </div>

                <i class="fa-solid fa-graduation-cap card-title"></i>

            </div>
        </div>
    </div>

    <div class="col-md-2">
        <div class="card rounded p-3 h-100">
            <div class="d-flex justify-content-between align-items-center">

                <div>
                    <div class="card-text">Vidējais reitings</div>
                    <div class="card-title">
                        {{ number_format($cases->avg('rating') ?? 0, 1) }}
                    </div>
                </div>

                <i class="fa-solid fa-star card-title text-warning"></i>

            </div>
        </div>
    </div>

    <div class="col-md-2">
        <div class="card rounded p-3 h-100">
            <div class="d-flex justify-content-between align-items-center">

                <div>
                    <div class="card-text">TOP lieta</div>

                    <div class="card-title fs-6">
                        {{ $cases->sortByDesc('rating')->first()->title ?? 'Nav datu' }}
                    </div>
                </div>

                <i class="fa-solid fa-crown card-title text-warning"></i>

            </div>
        </div>
    </div>

</div>