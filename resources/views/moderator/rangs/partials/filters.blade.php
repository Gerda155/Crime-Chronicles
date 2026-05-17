<div class="d-flex flex-wrap gap-2 mb-3">

    <form method="GET" class="d-flex gap-2 flex-grow-1">

        <span class="input-group-text bg-secondary border-0 text-light">
            <i class="fa-solid fa-magnifying-glass"></i>
        </span>

        <input type="text"
            name="search"
            value="{{ request('search') }}"
            class="form-control bg-secondary text-light border-0 rounded"
            placeholder="Meklēt pēc nosaukuma">

        <button type="submit" class="btn btn-primary rounded">
            Meklēt
        </button>

    </form>

    <form method="GET" class="d-flex gap-2">

        <select name="sort" class="form-select bg-secondary text-light border-0 rounded">

            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>
                Jaunākie
            </option>

            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>
                Vecākie
            </option>

            <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>
                Nosaukums A-Z
            </option>

            <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>
                Nosaukums Z-A
            </option>

            <option value="low_score" {{ request('sort') == 'low_score' ? 'selected' : '' }}>
                Zemākais punktu slieksnis
            </option>

            <option value="high_score" {{ request('sort') == 'high_score' ? 'selected' : '' }}>
                Augstākais punktu slieksnis
            </option>

            <option value="active" {{ request('sort') == 'active' ? 'selected' : '' }}>
                Aktīvie
            </option>

            <option value="inactive" {{ request('sort') == 'inactive' ? 'selected' : '' }}>
                Neaktīvie
            </option>

        </select>

        <button type="submit" class="btn btn-primary rounded">
            Kārtot
        </button>

    </form>

    <button class="btn btn-success rounded"
        data-bs-toggle="modal"
        data-bs-target="#createRankModal">

        <i class="fa-solid fa-plus me-1"></i>
        Izveidot jaunu rangu

    </button>

</div>