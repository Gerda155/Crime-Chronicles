<section id="evidence-section">
    <h3 class="mb-4 border-bottom pb-2">Pierādījumi</h3>
    <div class="row g-4">
        @foreach($evidence as $index => $item)
        <div class="col-md-4" data-evidence-index="{{ $index }}">
            <div class="card bg-secondary text-light evidence-card h-100 p-3">
                <button type="button" class="btn btn-outline-light btn-sm reveal-btn mb-2" data-evidence-btn="{{ $index }}">
                    Atvērt pierādījumu
                </button>
                <div class="evidence-content d-none">
                    <p>{{ $item->description }}</p>
                    @php
                    $extension = pathinfo($item->image_path, PATHINFO_EXTENSION);
                    @endphp

                    @if(in_array($extension, ['jpg', 'jpeg', 'png', 'webp']))
                    <div class="evidence-img-wrapper mb-2 position-relative"
                        style="width:100%; height:200px; overflow:hidden; border-radius:8px; cursor:zoom-in;">

                        <img src="{{ asset($item->image_path) }}"
                            class="w-100 h-100 evidence-img"
                            style="object-fit:contain;"
                            data-key-area="{{ $item->key_object_area }}">
                    </div>

                    @elseif($item->image_path === null)

                    @else
                    <a href="{{ asset($item->image_path) }}"
                        target="_blank"
                        class="btn btn-outline-light">
                        Atvērt failu
                    </a>

                    @endif

                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>