@extends('layouts.app')

@section('content')
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="p-4 bg-gray-50 border-b border-gray-200 flex justify-between items-center">
        <h2 class="text-xl font-semibold text-gray-800">Books</h2>
        <a href="{{ route('books.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-200">
            Add New Book
        </a>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Author</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Published Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($books as $book)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ $book->title }}</div>
                        <div class="text-sm text-gray-500">{{ Str::limit($book->description, 50) }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $book->author->name }}</div>
                        <div class="text-sm text-gray-500">{{ $book->author->email }}</div>
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
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">No books found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if ($books->hasPages())
    <div class="p-4 bg-gray-50 border-t border-gray-200">
        {{ $books->links() }}
    </div>
    @endif
</div>
@endsection