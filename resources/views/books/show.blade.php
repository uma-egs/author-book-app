@extends('layouts.app')

@section('content')
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="p-4 bg-gray-50 border-b border-gray-200 flex justify-between items-center">
        <h2 class="text-xl font-semibold text-gray-800">Book Details</h2>
        <div class="space-x-2">
            <a href="{{ route('books.edit', $book->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg transition duration-200">
                Edit
            </a>
            <form action="{{ route('books.destroy', $book->id) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition duration-200" onclick="return confirm('Are you sure?')">
                    Delete
                </button>
            </form>
        </div>
    </div>
    
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div>
                <h3 class="text-lg font-medium text-gray-900">Book Information</h3>
                <div class="mt-4 space-y-2">
                    <p><span class="font-medium">Title:</span> {{ $book->title }}</p>
                    <p><span class="font-medium">Description:</span> {{ $book->description ?? 'N/A' }}</p>
                    <p><span class="font-medium">Published Date:</span> {{ $book->published_date->format('M d, Y') }}</p>
                </div>
            </div>
            <div>
                <h3 class="text-lg font-medium text-gray-900">Author Information</h3>
                <div class="mt-4 space-y-2">
                    <p><span class="font-medium">Name:</span> {{ $book->author->name }}</p>
                    <p><span class="font-medium">Email:</span> {{ $book->author->email }}</p>
                    <p><span class="font-medium">Bio:</span> {{ $book->author->bio ?? 'N/A' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection