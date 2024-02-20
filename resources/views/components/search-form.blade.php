<h1 class="text-4xl font-extrabold mb-4">Finding form</h1>

<form action="{{ route('search') }}" method="GET">
    <div class="mb-6">
        <label for="id" class="inline-block text-lg mb-2">Pet ID:</label>
        <input type="number" class="border border-gray-200 rounded p-2 w-full" name="id" value="{{ old('id') }}" /></div>

    <div class="mb-6">
        <input type="submit" class="rounded py-2 px-4 bg-black cursor-pointer text-white" value="Find Pet" />
    </div>
</form>
