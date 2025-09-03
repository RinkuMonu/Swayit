<div>
    <h4>{{ $gig->title }}</h4>
    <p><strong>Price:</strong> ${{ $gig->price }}</p>
    <p><strong>Description:</strong> {!! $gig->description !!}</p>
    <p><strong>Industry:</strong> {{ $gig->industry->name ?? 'N/A' }}</p>
   
</div>