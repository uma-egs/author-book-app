<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Author;
use App\Models\Book;

class ChatbotController extends Controller
{
    public function handleQuery(Request $request)
    {
        $query = strtolower($request->input('query'));

        if (str_contains($query, 'how many authors')) {
            $count = Author::count();
            return response()->json(['response' => "There are {$count} authors in the system."]);
        }

        if (str_contains($query, 'how many books')) {
            $count = Book::count();
            return response()->json(['response' => "There are {$count} books available."]);
        }

        if (str_contains($query, 'list top 5 authors')) {
            $authors = Author::withCount('books')
                ->orderByDesc('books_count')
                ->limit(5)
                ->get();

            if ($authors->isEmpty()) {
                return response()->json(['response' => 'No authors found.']);
            }

            $response = "Top 5 authors with most books:\n";
            foreach ($authors as $author) {
                $response .= "- {$author->name} ({$author->books_count} books)\n";
            }

            return response()->json(['response' => $response]);
        }

        return response()->json(['response' => "I'm sorry, I didn't understand that query. I can answer questions about authors and books."]);
    }
}
