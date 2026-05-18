@if (session('success'))
<div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
</div>
@endif

@if ($errors->any())
<div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
    <strong>Kļūda!</strong>
    <ul class="mb-0 mt-2 ps-3">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>

    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
</div>
@endif