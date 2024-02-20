@extends('layout')

@section('content')

<h1 class="text-4xl font-extrabold mb-4">Editing form</h1>
    
    @if ($pet)

        <form action="{{ route('pets.destroy', $pet->id) }}" method="POST" style="display: inline;">
            @csrf
            @method('DELETE')
            <div class="mb-6">
                <input type="submit" onclick="return confirm('Are you sure you want to delete this resource?')" class="rounded py-2 px-4 bg-red-800 cursor-pointer text-white" value="Delete Pet" />
            </div>
        </form>

        <form method="POST" action="/pets/{{ $pet->id }}" enctype="multipart/form-data">
            @csrf

            @method('PUT')

            <div class="mb-6">
                <span class="font-bold text-lg">Pet ID:</span> {{$pet->id}}
            </div>

            <div class="mb-6">
                <div class="font-bold text-lg mb-2">Category:</div>
                <div class="mb-6">
                    <input type="number" class="border border-gray-200 rounded p-2 w-full" placeholder="ID" name="category[id]" value="{{ isset($pet->category->id) ? $pet->category->id : '' }}" />
                
                    @error('category.id')
                        <p class="text-red-500 text-xs mt-1 ">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-6">
                    <input type="text" class="border border-gray-200 rounded p-2 w-full" placeholder="Name" name="category[name]" value="{{ isset($pet->category->name) ? $pet->category->name : '' }}" />

                    @error('category.name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-6">
                <label for="name" class="inline-block text-lg mb-2 font-bold">Name:</label>
                <input type="text" class="border border-gray-200 rounded p-2 w-full" name="name" value="{{ isset($pet->name) ? $pet->name : '' }}" />

                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="photoUrls" class="inline-block text-lg mb-2 font-bold">Photo URLs:</label>
                <input type="text" class="border border-gray-200 rounded p-2 w-full" placeholder="url1, url2,..." name="photoUrls" value="{{ isset($pet->photoUrls) ? $pet->photoUrls : '' }}" />

                @error('photoUrls')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="tags" class="inline-block text-lg mb-2 font-bold">Tags:</label>
                <input type="text" class="border border-gray-200 rounded p-2 w-full" placeholder="id1, name1; id2, name2;..." name="tags" value="{{ isset($pet->tags) ? $pet->tags : '' }}" />

                @error('tags')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="status" class="inline-block text-lg mb-2 font-bold">Status:</label>
                <select class="border border-gray-200 rounded p-2 w-full" name="status" value="{{ isset($pet->status) ? $pet->status : 'available' }}">
                    <option value="available">Available</option>
                    <option value="pending">Pending</option>
                    <option value="sold">Sold</option>
                </select>

                @error('status')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <input type="submit" class="rounded py-2 px-4 bg-black cursor-pointer text-white" value="Edit Pet" />
            </div>
        </form>

    @elseif (isset($error))
        <div class="font-semibold text-lg mb-2 dark:text-red-400">{{$error}}</div>
    @endif

@endsection