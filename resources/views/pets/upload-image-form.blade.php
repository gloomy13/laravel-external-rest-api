@extends('layout')

@section('content')
    <h1 class="text-4xl font-extrabold mb-4">Finding form</h1>

    <form action="{{ route('pets.uploadImage', ['id' => $id]) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-6">
            <label class="inline-block text-lg mb-2 font-bold" for="additionalMetadata">Additional Metadata:</label>
            <input class="border border-gray-200 rounded p-2 w-full" type="text" id="additionalMetadata" name="additionalMetadata">
        </div>
        
        <div class="mb-6">
            <label class="inline-block text-lg mb-2 font-bold" for="file">Select image to upload:</label>
            <input class="border border-gray-200 rounded p-2 w-full" type="file" id="file" name="file">
        </div>
        
        <div class="mb-6">
            <input class="rounded py-2 px-4 bg-black cursor-pointer text-white" type="submit" value="Upload Image" />
        </div>
    </form>

@endsection