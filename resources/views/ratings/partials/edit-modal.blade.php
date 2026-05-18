<div class="modal fade" id="editRatingModal{{ $rating->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content bg-dark text-light border border-warning">

            <div class="modal-header border-bottom-0">
                <h5 class="modal-title">Rediģēt vērtējumu</h5>
            </div>

            <div class="modal-body text-center">

                <form action="{{ route('ratings.update', $rating->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3 rating-stars d-flex justify-content-center gap-1" style="font-size:2rem;">
                        @for($i = 1; $i <= 5; $i++)
                            <label class="star"
                            data-value="{{ $i }}"
                            style="cursor:pointer; color: {{ $i <= $rating->rating ? '#ffc107' : '#555' }};">
                            <input type="radio"
                                name="rating"
                                value="{{ $i }}"
                                style="display:none;"
                                {{ $i == $rating->rating ? 'checked' : '' }}>
                            &#9733;
                            </label>
                            @endfor
                    </div>

                    <textarea name="comment"
                        class="form-control mb-3 bg-secondary text-light border-0"
                        placeholder="Komentārs...">{{ $rating->comment }}</textarea>

                    <button type="submit" class="btn btn-warning w-100">
                        Saglabāt
                    </button>

                </form>

            </div>

        </div>

    </div>
</div>