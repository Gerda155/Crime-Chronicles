<div class="row g-3 mb-4">

    <div class="col-md-3">
        <div class="card rounded p-3 h-100">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="card-text">Kopā sasniegumu</div>
                    <div class="card-title">{{ $achievements->count() }}</div>
                </div>

                <i class="fa-solid fa-trophy card-title text-warning"></i>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card rounded p-3 h-100">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="card-text">Aktīvi</div>
                    <div class="card-title">
                        {{ $achievements->where('status', 'active')->count() }}
                    </div>
                </div>

                <i class="fa-solid fa-circle-check card-title text-success"></i>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card rounded p-3 h-100">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="card-text">Neaktīvi</div>
                    <div class="card-title">
                        {{ $achievements->where('status', 'inactive')->count() }}
                    </div>
                </div>

                <i class="fa-solid fa-circle-xmark card-title text-danger"></i>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card rounded p-3 h-100">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="card-text">Grūtākais</div>

                    <div class="card-title fs-6">
                        {{ $achievements->sortByDesc('required_cases')->first()->title ?? 'Nav datu' }}
                    </div>
                </div>

                <i class="fa-solid fa-fire card-title text-danger"></i>
            </div>
        </div>
    </div>

</div>