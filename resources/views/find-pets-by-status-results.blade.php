@extends('layout')

@section('content')

    <h1 class="text-4xl font-extrabold mb-4">Showing {{ $status }} pets</h1>
    <p>Limit: 10</p>

    @if (isset($message))
            <div class="font-semibold text-lg mb-2 dark:text-green-400">{{ $message }}</div>
        @endif

    @if ($pets)
        @php
            $i = 0;
            $limit = 10;
        @endphp

        @foreach ($pets as $pet)
            <x-pet-info :pet="$pet" />

            <div class="mb-6">
                <a href="{{ route('pets.edit', ['id' => $pet->id]) }}"
                    class="rounded py-2 px-4 bg-black cursor-pointer text-white">Edit Pet</a>
            </div>

            <div class="mb-6">
                <a href="{{ route('pets.showUploadImageForm', ['id' => $pet->id]) }}"
                    class="rounded py-2 px-4 bg-black cursor-pointer text-white">Upload Image</a>
            </div>

            @php
                $i++;

                if($i == $limit){
                    break;
                }
            @endphp
        @endforeach
    @elseif (isset($error))
        <div class="font-semibold text-lg mb-2 dark:text-red-400">{{ $error }}</div>
    @else
        <div>No results</div>
    @endif

@endsection
