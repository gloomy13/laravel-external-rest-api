@extends('layout')

@section('content')

    @if (session('message'))
        <div class="font-semibold text-lg mb-2 dark:text-green-400">{{ session('message') }}</div>
    @endif

    <x-search-form />

@endsection
