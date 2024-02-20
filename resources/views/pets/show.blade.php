@extends('layout')

@section('content')

    <x-search-form />
    
    @if ($pet)

        @if(isset($message))
            <div class="font-semibold text-lg mb-2 dark:text-green-400">{{ $message }}</div>
        @endif

        <div class="pet mb-6">
            <div><span class="font-bold">Pet ID:</span> {{$pet->id}}</div>
            <div><span class="font-bold">Pet name:</span> {{$pet->name ?? ''}}</div>
            <ul><span class="font-bold">Pet category:</span>
                <li>ID: {{$pet->category->id ?? ''}}</li>
                <li>Name: {{$pet->category->name ?? ''}}</li>
            </ul>
            <ul><span class="font-bold">Pet photo URLs:</span>
                @foreach ($pet->photoUrls as $photoUrl)
                    <li>{{$photoUrl}}</li>
                @endforeach
            </ul>
            <ul><span class="font-bold">Pet tags:</span> 
                @foreach ($pet->tags as $tag)
                    <li>ID: {{$tag->id}}</li>
                    <li>Name: {{$tag->name}}</li>
                @endforeach
            </ul>
            <div><span class="font-bold">Pet status:</span> {{$pet->status ?? ''}}</div>
        </div>

        <div class="mb-6">
            <a href="{{ route('pets.edit', ['id' => $pet->id]) }}" class="rounded py-2 px-4 bg-black cursor-pointer text-white">Edit Pet</a>
        </div>

    @elseif (isset($error))
        <div class="font-semibold text-lg mb-2 dark:text-red-400">{{$error}}</div>
    @endif



@endsection
