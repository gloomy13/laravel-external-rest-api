@extends('layout')

@section('content')

<h1 class="text-4xl font-extrabold mb-4">Creating form</h1>

    <form method="POST" action="/pets" enctype="multipart/form-data">
        @csrf

        <div class="mb-6">
            <div class="font-bold text-lg mb-2">Category:</div>
            <div class="mb-6">
                <input type="number" class="border border-gray-200 rounded p-2 w-full" placeholder="ID" name="category[id]" value="{{ old('category[id]') }}" />
            
                @error('category.id')
                    <p class="text-red-500 text-xs mt-1 ">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-6">
                <input type="text" class="border border-gray-200 rounded p-2 w-full" placeholder="Name" name="category[name]" value="{{ old('category[name]') }}" />

                @error('category.name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mb-6">
            <label for="name" class="inline-block text-lg mb-2 font-bold">Name:</label>
            <input type="text" class="border border-gray-200 rounded p-2 w-full" name="name" value="{{ old('name') }}" />

            @error('name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="photoUrls" class="inline-block text-lg mb-2 font-bold">Photo URLs:</label>
            <input type="text" class="border border-gray-200 rounded p-2 w-full" placeholder="url1, url2,..." name="photoUrls" value="{{ old('photoUrls') }}" />

            @error('photoUrls')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="tags" class="inline-block text-lg mb-2 font-bold">Tags:</label>
            <input type="text" class="border border-gray-200 rounded p-2 w-full" placeholder="id1, name1; id2, name2;..." name="tags" value="{{ old('tags') }}" />

            @error('tags')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="status" class="inline-block text-lg mb-2 font-bold">Status:</label>
            <select class="border border-gray-200 rounded p-2 w-full" name="status" value="{{ old('status') }}">
                <option value="available">Available</option>
                <option value="pending">Pending</option>
                <option value="sold">Sold</option>
            </select>

            @error('status')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <input type="submit" class="rounded py-2 px-4 bg-black cursor-pointer text-white" value="Create Pet" />
        </div>
    </form>

@endsection