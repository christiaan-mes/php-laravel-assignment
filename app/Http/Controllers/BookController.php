<?php

namespace App\Http\Controllers;

use App\BookRepository;
use App\Models\Book;
use App\Models\Publisher;
use App\Models\Writer;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::all();
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, BookRepository $repository)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'ISBN' => 'required|string|max:255',
            'publication_year' => 'required|integer|min:1900|max:' . date('Y'),
            'price' => 'required|numeric|min:0',
            'genre' => 'required|string|max:255',
            'subgenre' => 'required|string|max:255',
            'writer_id' => 'nullable|exists:writers,id',
            'writer_name' => 'nullable|string|max:255',
            'publisher_id' => 'nullable|exists:publishers,id',
            'publisher_name' => 'nullable|string|max:255',
            'publisher_location' => 'nullable|string|max:255',
        ]);

        $repository->storeBookWithRelations($request->all());

        return redirect()->route('books.index');
    }

    /**
     * Show the form for editing the specified book.
     *
     * @param  \App\Models\Book  $book
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
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Book  $book
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
            'writer_id' => $request->input('writer_id'),
            'publisher_id' => $request->input('publisher_id'),
        ]);

        return redirect()->route('books.index');
    }
}
