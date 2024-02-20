@extends('layout')

@section('content')
    <h1 class="text-4xl font-extrabold mb-4">Finding form</h1>

    <form action="{{ route('search') }}" method="GET">
        <div class="mb-6">
            <label for="status" class="inline-block text-lg mb-2 font-bold">Status:</label>
            <select class="border border-gray-200 rounded p-2 w-full" name="status" value="{{ old('status') }}">
                <option value="available">Available</option>
                <option value="pending">Pending</option>
                <option value="sold">Sold</option>
            </select>
        </div>

        <div class="mb-6">
            <input type="submit" class="rounded py-2 px-4 bg-black cursor-pointer text-white" value="Find Pets" />
        </div>
    </form>
@endsection
