<div class="row g-3 mb-4">

    <div class="col-md-3">
        <div class="card rounded p-3 h-100">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="card-text">Kopā rangu</div>
                    <div class="card-title">{{ $rangs->count() }}</div>
                </div>

                <i class="fa-solid fa-ranking-star card-title"></i>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card rounded p-3 h-100">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="card-text">Aktīvie</div>
                    <div class="card-title">
                        {{ $rangs->where('status', 'active')->count() }}
                    </div>
                </div>

                <i class="fa-solid fa-circle-check card-title text-light"></i>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card rounded p-3 h-100">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="card-text">Neaktīvie</div>
                    <div class="card-title">
                        {{ $rangs->where('status', 'inactive')->count() }}
                    </div>
                </div>

                <i class="fa-solid fa-circle-xmark card-title text-light"></i>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card rounded p-3 h-100">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="card-text">Augstākais ranks</div>

                    <div class="card-title fs-6">
                        {{ $rangs->sortByDesc('min_score')->first()->name ?? 'Nav datu' }}
                    </div>
                </div>

                <i class="fa-solid fa-crown card-title text-li"></i>
            </div>
        </div>
    </div>

</div>