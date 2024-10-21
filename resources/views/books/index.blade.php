@extends('layout')

@section('content')
    <div class="container">
        <h1>Books</h1>
        <a href="{{ route('books.create') }}" class="btn btn-primary">Add Book</a>

        <table class="table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>ISBN</th>
                    <th>Publication Year</th>
                    <th>Price</th>
                    <th>Genre</th>
                    <th>Subgenre</th>
                    <th>Stock</th>
                    <th>Writer</th>
                    <th>Publisher</th>
                    <th>Action</th>
                    <th>Sort order</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($books as $book)
                    <tr>
                        <td>{{ $book->title }}</td>
                        <td>{{ $book->ISBN }}</td>
                        <td>{{ $book->publication_year }}</td>
                        <td>{{ $book->price }}</td>
                        <td>{{ $book->genre }}</td>
                        <td>{{ $book->subgenre }}</td>
                        <td>{{ $book->stock_amount }}</td>
                        <td>{{ $book->writer->name }}</td>
                        <td>{{ $book->publisher->name }}</td>
                        @if($book->stock_amount > 0)
                            <td>
                                <a href="{{ route('books.edit', $book->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                <form action="{{ route('books.reOrder', $book) }}" method="POST">
                                    @csrf
                                    @if($book->sort_order < \App\Models\Book::query()->max('sort_order'))
                                        <input type="number" min="1" max="{{ \App\Models\Book::query()->max('sort_order') - $book->sort_order }}" name="up" placeholder="Up">
                                    @endif

                                    @if($book->sort_order > 1)
                                        <input type="number" name="down" min="1" max="{{ $book->sort_order - 1 }}" placeholder="Down">
                                    @endif

                                    <button type="submit">Move</button>
                                </form>
                            </td>
                        @endif
                        <td>{{ $book->sort_order }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
