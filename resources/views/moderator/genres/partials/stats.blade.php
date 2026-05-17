<div class="row g-3 mb-4">

    <div class="col-md-3">
        <div class="card rounded p-3 h-100">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="card-text">Kopā žanru</div>
                    <div class="card-title">{{ $genres->count() }}</div>
                </div>

                <i class="fa-solid fa-masks-theater card-title"></i>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card rounded p-3 h-100">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="card-text">Aktīvie</div>
                    <div class="card-title">
                        {{ $genres->where('status', 'active')->count() }}
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
                    <div class="card-text">Neaktīvie</div>
                    <div class="card-title">
                        {{ $genres->where('status', 'inactive')->count() }}
                    </div>
                </div>

                <i class="fa-solid fa-ban card-title text-danger"></i>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card rounded p-3 h-100">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="card-text">Pēdējais žanrs</div>

                    <div class="card-title fs-6">
                        {{ $genres->first()->name ?? 'Nav datu' }}
                    </div>
                </div>

                <i class="fa-solid fa-clock-rotate-left card-title text-warning"></i>
            </div>
        </div>
    </div>

</div>