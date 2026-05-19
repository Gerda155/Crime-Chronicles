<div class="d-flex flex-wrap gap-2 mb-4 align-items-center">

    <form method="GET" class="d-flex gap-2 flex-grow-1">

        <span class="input-group-text bg-secondary border-0 text-light">
            <i class="fa-solid fa-magnifying-glass"></i>
        </span>

        <input type="text"
            name="search"
            value="{{ request('search') }}"
            class="form-control bg-secondary text-light border-0 rounded"
            placeholder="Meklēt pēc lietotāja vai darbības">

        <button type="submit"
            class="btn btn-primary rounded">

            Meklēt
        </button>

    </form>

    <form method="GET" class="d-flex gap-2">

        <input type="hidden"
            name="search"
            value="{{ request('search') }}">

        <select name="sort"
            class="form-select bg-secondary text-light border-0 rounded">

            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>
                Jaunākie
            </option>

            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>
                Vecākie
            </option>

            <option value="login" {{ request('sort') == 'login' ? 'selected' : '' }}>
                Login darbības
            </option>

            <option value="logout" {{ request('sort') == 'logout' ? 'selected' : '' }}>
                Logout darbības
            </option>

            <option value="delete" {{ request('sort') == 'delete' ? 'selected' : '' }}>
                Dzēšanas darbības
            </option>

            <option value="approve" {{ request('sort') == 'approve' ? 'selected' : '' }}>
                Apstiprināšanas darbības
            </option>

            <option value="case" {{ request('sort') == 'case' ? 'selected' : '' }}>
                Lietas
            </option>

            <option value="user" {{ request('sort') == 'user' ? 'selected' : '' }}>
                Lietotāji
            </option>

        </select>

        <button type="submit"
            class="btn btn-primary rounded">

            Kārtot
        </button>

    </form>

</div>
