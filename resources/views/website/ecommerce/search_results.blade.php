
@section('content')
<div class="container mt-4">
    <h3>Search Results for: "{{ $query }}"</h3>

    @if($crops->count() > 0)
        <div class="row">
            @foreach($crops as $crop)
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <img src="{{ asset('storage/'.$crop->image) }}" class="card-img-top" alt="{{ $crop->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $crop->name }}</h5>
                            <p>{{ $crop->price }} $</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p>No crops found.</p>
    @endif
</div>
@endsection
