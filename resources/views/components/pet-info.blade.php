<div class="pet mb-6">
    <div><span class="font-bold">Pet ID:</span> {{ $pet->id }}</div>
    <div><span class="font-bold">Pet name:</span> {{ $pet->name ?? '' }}</div>
    <ul><span class="font-bold">Pet category:</span>
        <li>ID: {{ $pet->category->id ?? '' }}</li>
        <li>Name: {{ $pet->category->name ?? '' }}</li>
    </ul>
    <ul><span class="font-bold">Pet photo URLs:</span>
        @foreach ($pet->photoUrls as $photoUrl)
            <li>{{ $photoUrl }}</li>
        @endforeach
    </ul>
    <ul><span class="font-bold">Pet tags:</span>
        @foreach ($pet->tags as $tag)
            <li>ID: {{ $tag->id }}</li>
            <li>Name: {{ $tag->name }}</li>
        @endforeach
    </ul>
    <div><span class="font-bold">Pet status:</span> {{ $pet->status ?? '' }}</div>
</div>
