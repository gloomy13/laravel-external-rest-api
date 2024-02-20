<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>REST API - Laravel</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <nav class="p-8 bg-black">
        <ul class="flex space-x-6 mr-6 text-white font-semibold text-lg justify-evenly">
            <li><a href="/">Find (and edit) pet by ID</a></li>
            <li><a href="{{ route('pets.create') }}">Add a new pet to the store</a></li>
            <li><a href="{{ route('showFindPetsByStatusForm') }}">Find pets by status</a></li>
        </ul>
    </nav>
    <main class="container max-w-7xl mx-4 mx-auto py-10">
        @yield('content')
    </main>
    <footer>

    </footer>
</body>

</html>
