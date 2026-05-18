<div class="modal fade" id="deleteRatingModal{{ $rating->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content bg-dark text-light border border-danger">

            <div class="modal-header border-bottom-0">
                <h5 class="modal-title text-danger">
                    Apstiprināt dzēšanu
                </h5>
            </div>

            <div class="modal-body text-center">
                Vai tiešām vēlies dzēst šo vērtējumu?
                <br>
                <span class="text-warning">Šo darbību nevar atcelt.</span>
            </div>

            <div class="modal-footer border-top-0">

                <button class="btn btn-secondary" data-bs-dismiss="modal">
                    Atcelt
                </button>

                <form action="{{ route('ratings.destroy', $rating->id) }}" method="POST">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-danger">
                        Dzēst
                    </button>

                </form>

            </div>

        </div>

    </div>
</div>