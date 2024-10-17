<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Publisher;
use App\Models\Writer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::query()->orderByDesc('sort_order')->get();
        return view('books.index', compact('books'));
    }

    /**
     * Show the form for creating a new book.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $writers = Writer::all();
        $publishers = Publisher::all();

        return view('books.create', compact('writers', 'publishers'));
    }

    /**
     * Store a newly created book in the database.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'ISBN' => 'required|string|max:255',
            'publication_year' => 'required|integer|min:1900|max:' . date('Y'),
            'price' => 'required|numeric|min:0',
            'genre' => 'required|string|max:255',
            'stock_amount' => 'required|integer|min:0',
            'subgenre' => 'required|string|max:255',
            'writer_id' => 'required|exists:writers,id',
            'publisher_id' => 'required|exists:publishers,id',
        ]);

        Book::create([
            'title' => $request->input('title'),
            'ISBN' => $request->input('ISBN'),
            'publication_year' => $request->input('publication_year'),
            'price' => $request->input('price'),
            'genre' => $request->input('genre'),
            'sort_order' => -1,
            'stock_amount' => $request->input('stock_amount'),
            'subgenre' => $request->input('subgenre'),
            'writer_id' => $request->input('writer_id'),
            'publisher_id' => $request->input('publisher_id'),
        ]);

        return redirect()->route('books.index');
    }

    /**
     * Show the form for editing the specified book.
     *
     * @param \App\Models\Book $book
     * @return \Illuminate\View\View
     */
    public function edit(Book $book)
    {
        $writers = Writer::all();
        $publishers = Publisher::all();

        return view('books.edit', compact('book', 'writers', 'publishers'));
    }

    /**
     * Update the specified book in the database.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Book $book
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'ISBN' => 'required|string|max:255',
            'publication_year' => 'required|integer|min:1900|max:' . date('Y'),
            'price' => 'required|numeric|min:0',
            'genre' => 'required|string|max:255',
            'subgenre' => 'required|string|max:255',
            'stock_amount' => 'required|integer|min:0',
            'writer_id' => 'required|exists:writers,id',
            'publisher_id' => 'required|exists:publishers,id',
        ]);

        $book->update([
            'title' => $request->input('title'),
            'ISBN' => $request->input('ISBN'),
            'publication_year' => $request->input('publication_year'),
            'price' => $request->input('price'),
            'genre' => $request->input('genre'),
            'subgenre' => $request->input('subgenre'),
            'sort_order' => -1,
            'stock_amount' => $request->input('stock_amount'),
            'writer_id' => $request->input('writer_id'),
            'publisher_id' => $request->input('publisher_id'),
        ]);

        return redirect()->route('books.index');
    }

    /**
     * Reorder the books.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Book $book
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reOrder(Request $request, Book $book)
    {
        if($book->stock_amount < 1)
        {
            return redirect()->back();
        }

        $request->validate([
            'up' => 'nullable|integer|min:1',
            'down' => 'nullable|integer|min:1',
        ]);

        $up = $request->input('up');
        $down = $request->input('down');

        $direction = $request->input('up') !== null ? 'up' : 'down';

        if ($direction === 'up') {
            $newRank = $book->sort_order + $up;

            $book->sort_order = $newRank;
            $book->save();
        }

        if ($direction === 'down') {
            $newRank = $book->sort_order - $down;

            $book->sort_order = $newRank;
            $book->save();
        }

        return redirect()->back()->with('success', 'Book sorted successfully.');
    }
}
