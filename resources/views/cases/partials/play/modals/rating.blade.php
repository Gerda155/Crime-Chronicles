@if(session('last_attempt_correct') === true && !auth()->user()->hasRatedCase($case->id))
<div class="modal fade" id="ratingModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-light border border-warning">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title">Novērtē lietu</h5>
            </div>
            <div class="modal-body text-center">
                <form id="ratingForm" action="{{ route('ratings.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="case_id" value="{{ $case->id }}">

                    <div class="mb-3 rating-stars d-flex justify-content-center gap-1" style="font-size:2rem;">
                        @for($i = 1; $i <= 5; $i++)
                            <label class="star" data-value="{{ $i }}" style="cursor:pointer; color: #555;">
                            <input type="radio" name="rating" value="{{ $i }}" required style="display:none;">
                            &#9733;
                            </label>
                            @endfor
                    </div>

                    <textarea name="comment" class="form-control mb-3" placeholder="Komentārs..."></textarea>
                    <button type="submit" class="btn btn-warning w-100">Saglabāt</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif