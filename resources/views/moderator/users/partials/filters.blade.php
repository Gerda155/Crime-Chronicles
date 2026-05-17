<div class="d-flex flex-wrap gap-2 mb-3 align-items-center">
    <form method="GET" class="d-flex gap-2 flex-grow-1">
        <input type="text" name="search" value="{{ request('search') }}"
            class="form-control bg-secondary text-light border-0 rounded"
            placeholder="Meklēt pēc vārda vai e-pasta">
        <button type="submit" class="btn btn-primary rounded">Meklēt</button>
    </form>

    <form method="GET" class="d-flex gap-2">
        <select name="sort" class="form-select bg-secondary text-light border-0 rounded">

            <option value="newest" {{ request('sort')=='newest' ? 'selected' : '' }}>
                Jaunākie
            </option>

            <option value="oldest" {{ request('sort')=='oldest' ? 'selected' : '' }}>
                Vecākie
            </option>

            <option value="name_asc" {{ request('sort')=='name_asc' ? 'selected' : '' }}>
                Vārds A-Z
            </option>

            <option value="name_desc" {{ request('sort')=='name_desc' ? 'selected' : '' }}>
                Vārds Z-A
            </option>

            <option value="email_asc" {{ request('sort')=='email_asc' ? 'selected' : '' }}>
                E-pasts A-Z
            </option>

            <option value="role" {{ request('sort')=='role' ? 'selected' : '' }}>
                Loma
            </option>

            <option value="most_cases" {{ request('sort')=='most_cases' ? 'selected' : '' }}>
                Visvairāk lietu
            </option>

            <option value="most_achievements" {{ request('sort')=='most_achievements' ? 'selected' : '' }}>
                Visvairāk sasniegumu
            </option>

        </select>

        <select name="status" class="form-select bg-secondary text-light border-0 rounded">

            <option value="">Visi statusi</option>

            <option value="active" {{ request('status')=='active' ? 'selected' : '' }}>
                Aktīvie
            </option>

            <option value="inactive" {{ request('status')=='inactive' ? 'selected' : '' }}>
                Neaktīvie
            </option>

        </select>
        <button type="submit" class="btn btn-primary rounded">Kārtot</button>
    </form>

    @if(Auth::user()->role === 'admin')
    <button type="button" class="btn btn-success rounded" data-bs-toggle="modal" data-bs-target="#addModeratorModal">
        Pievienot jaunu moderatoru
    </button>
    @endif
</div>