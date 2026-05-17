<div class="d-flex flex-wrap gap-2 mb-3 align-items-center">

    <form method="GET" class="d-flex gap-2 flex-grow-1">

        <span class="input-group-text bg-secondary border-0 text-light">
            <i class="fa-solid fa-magnifying-glass"></i>
        </span>

        <input type="text"
            name="search"
            value="{{ request('search') }}"
            class="form-control bg-secondary text-light border-0 rounded"
            placeholder="Meklēt paziņojumos">

        <button type="submit" class="btn btn-primary rounded">
            Meklēt
        </button>
    </form>

    <form method="GET" class="d-flex gap-2">

        <input type="hidden" name="search" value="{{ request('search') }}">

        <select name="sort"
            class="form-select bg-secondary text-light border-0 rounded">

            <option value="newest" @selected(request('sort')=='newest' )>
                Jaunākie
            </option>

            <option value="oldest" @selected(request('sort')=='oldest' )>
                Vecākie
            </option>

            <option value="unread" @selected(request('sort')=='unread' )>
                Neizlasītie
            </option>

        </select>

        <button type="submit" class="btn btn-primary rounded">
            Kārtot
        </button>
    </form>

    <form action="{{ route('notifications.readAll') }}" method="POST">
        @csrf
        @method('PATCH')

        <button class="btn btn-success rounded">
            <i class="fa-solid fa-check-double"></i>
        </button>
    </form>

    <form action="{{ route('notifications.deleteAll') }}" method="POST"
        onsubmit="return confirm('Tiešām dzēst visus paziņojumus?')">

        @csrf
        @method('DELETE')

        <button type="submit" class="btn btn-danger rounded">
            <i class="fa-solid fa-trash"></i>
        </button>

    </form>

</div>