@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-lg shadow overflow-hidden">
    <div class="p-4 bg-gray-50 border-b border-gray-200">
        <h2 class="text-xl font-semibold text-gray-800">Add New Book</h2>
    </div>
    
    <form action="{{ route('books.store') }}" method="POST" class="p-6">
        @csrf
        
        <div class="mb-4">
            <label for="author_id" class="block text-sm font-medium text-gray-700 mb-1">Author</label>
            <select name="author_id" id="author_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                @foreach ($authors as $author)
                    <option value="{{ $author->id }}" {{ request('author_id') == $author->id ? 'selected' : '' }}>{{ $author->name }}</option>
                @endforeach
            </select>
            @error('author_id')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-4">
            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
            <input type="text" name="title" id="title" value="{{ old('title') }}" 
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            @error('title')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-4">
            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
            <textarea name="description" id="description" rows="3" 
                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description') }}</textarea>
            @error('description')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-4">
            <label for="published_date" class="block text-sm font-medium text-gray-700 mb-1">Published Date</label>
            <input type="date" name="published_date" id="published_date" value="{{ old('published_date') }}" 
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            @error('published_date')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="flex justify-end space-x-3">
            <a href="{{ route('books.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500">
                Cancel
            </a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                Save Book
            </button>
        </div>
    </form>
</div>
@endsection