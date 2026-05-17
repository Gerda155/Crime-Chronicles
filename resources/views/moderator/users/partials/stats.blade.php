@php
$isAdmin = Auth::user()->role === 'admin';
$isModerator = Auth::user()->role === 'moderator';
$cols = Auth::user()->role === 'admin' ? 4 : 3;
@endphp

<div class="row row-cols-1 row-cols-md-2 row-cols-lg-{{ $cols }} g-3 mb-4">

    <div class="col-md-2">
        <div class="card rounded p-3 h-100">
            <div class="d-flex justify-content-between align-items-center">

                <div>
                    <div class="card-text">Kopā lietotāji</div>
                    <div class="card-title">{{ $users->total() }}</div>
                </div>

                <i class="fa-solid fa-users card-title"></i>

            </div>
        </div>
    </div>

    <div class="col-md-2">
        <div class="card rounded p-3 h-100">
            <div class="d-flex justify-content-between align-items-center">

                <div>
                    <div class="card-text">Aktīvie</div>
                    <div class="card-title">
                        {{ $users->where('status','active')->count() }}
                    </div>
                </div>

                <i class="fa-solid fa-user-check card-title text-success"></i>

            </div>
        </div>
    </div>

    <div class="col-md-2">
        <div class="card rounded p-3 h-100">
            <div class="d-flex justify-content-between align-items-center">

                <div>
                    <div class="card-text">Neaktīvie</div>
                    <div class="card-title">
                        {{ $users->where('status','inactive')->count() }}
                    </div>
                </div>

                <i class="fa-solid fa-user-xmark card-title text-danger"></i>

            </div>
        </div>
    </div>

    @if(Auth::user()->role === 'admin')
    <div class="col-md-2">
        <div class="card rounded p-3 h-100">
            <div class="d-flex justify-content-between align-items-center">

                <div>
                    <div class="card-text">Moderatori</div>
                    <div class="card-title">
                        {{ $users->where('role','moderator')->count() }}
                    </div>
                </div>

                <i class="fa-solid fa-user-shield card-title text-warning"></i>

            </div>
        </div>
    </div>
    @endif

</div>