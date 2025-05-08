@extends('layouts.app')

@section('content')
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="p-4 bg-gray-50 border-b border-gray-200 flex justify-between items-center">
        <h2 class="text-xl font-semibold text-gray-800">Author Details</h2>
        <div class="space-x-2">
            <a href="{{ route('authors.edit', $author->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg transition duration-200">
                Edit
            </a>
            <form action="{{ route('authors.destroy', $author->id) }}" method="POST" class="inline">
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
                <h3 class="text-lg font-medium text-gray-900">Personal Information</h3>
                <div class="mt-4 space-y-2">
                    <p><span class="font-medium">Name:</span> {{ $author->name }}</p>
                    <p><span class="font-medium">Email:</span> {{ $author->email }}</p>
                    <p><span class="font-medium">Bio:</span> {{ $author->bio ?? 'N/A' }}</p>
                </div>
            </div>
            <div>
                <h3 class="text-lg font-medium text-gray-900">Statistics</h3>
                <div class="mt-4 space-y-2">
                    <p><span class="font-medium">Total Books:</span> {{ $author->books->count() }}</p>
                    <p><span class="font-medium">Joined:</span> {{ $author->created_at->format('M d, Y') }}</p>
                </div>
            </div>
        </div>
        
        <div class="border-t border-gray-200 pt-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900">Books</h3>
                <a href="{{ route('books.create') }}?author_id={{ $author->id }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-200">
                    Add New Book
                </a>
            </div>
            
            @if ($author->books->isEmpty())
                <p class="text-gray-500">No books found for this author.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Published Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($author->books as $book)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $book->title }}</div>
                                    <div class="text-sm text-gray-500">{{ Str::limit($book->description, 50) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500">{{ $book->published_date->format('M d, Y') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('books.show', $book->id) }}" class="text-blue-600 hover:text-blue-900 mr-3">View</a>
                                    <a href="{{ route('books.edit', $book->id) }}" class="text-yellow-600 hover:text-yellow-900 mr-3">Edit</a>
                                    <form action="{{ route('books.destroy', $book->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection