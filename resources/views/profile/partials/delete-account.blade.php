<div class="card bg-danger bg-opacity-10 border border-danger mt-4">
    <div class="card-body">
        <h6 class="text-danger">Bīstama zona</h6>

        <form method="POST" action="{{ route('profile.destroy') }}">
            @csrf
            @method('DELETE')

            <input type="password" name="password"
                class="form-control mb-3"
                placeholder="Ievadi paroli apstiprināšanai" required>

            <button class="btn btn-danger w-100">
                Dzēst profilu
            </button>
        </form>
    </div>
</div>