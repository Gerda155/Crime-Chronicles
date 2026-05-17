<div class="d-flex flex-wrap gap-2 mb-3">
    <form method="GET" class="d-flex gap-2 flex-grow-1">
        <span class="input-group-text bg-secondary border-0 text-light">
            <i class="fa-solid fa-magnifying-glass"></i>
        </span>
        <input type="text" name="search" value="{{ request('search') }}" class="form-control bg-secondary text-light border-0 rounded" placeholder="Meklēt pēc nosaukuma">
        <button type="submit" class="btn btn-primary rounded">Meklēt</button>
    </form>
    <form method="GET" class="d-flex gap-2">
        <select name="sort" class="form-select bg-secondary text-light border-0 rounded">

            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>
                Jaunākās lietas
            </option>

            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>
                Vecākās lietas
            </option>

            <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>
                Augstākais vērtējums
            </option>

            <option value="alphabet" {{ request('sort') == 'alphabet' ? 'selected' : '' }}>
                Nosaukums A-Z
            </option>

            <option value="alphabet_desc" {{ request('sort') == 'alphabet_desc' ? 'selected' : '' }}>
                Nosaukums Z-A
            </option>

            <option value="tutorials" {{ request('sort') == 'tutorials' ? 'selected' : '' }}>
                Apmācības lietas
            </option>

        </select>
        <button type="submit" class="btn btn-primary rounded">Kārtot</button>
    </form>

    <a href="{{ route('user.cases.create') }}" class="btn btn-success rounded">Izveidot jaunu lietu</a>
</div>