@extends('layout')

@section('content')
    <div class="container">
        <h1>Create Book</h1>

        <form method="POST" action="{{ route('books.store') }}">
            @csrf

            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" name="title" id="title" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="ISBN">ISBN:</label>
                <input type="text" name="ISBN" id="ISBN" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="publication_year">Publication Year:</label>
                <input type="number" name="publication_year" id="publication_year" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="price">Price:</label>
                <input type="number" name="price" id="price" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="genre">Genre:</label>
                <input type="text" name="genre" id="genre" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="subgenre">Subgenre:</label>
                <input type="text" name="subgenre" id="subgenre" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="stock_amount">Stock Amount:</label>
                <input type="number" name="stock_amount" id="stock_amount" class="form-control" value="0">
            </div>

            <div class="form-group">
                <label for="writer_id">Writer:</label>
                <select name="writer_id" id="writer_id" class="form-control" required>
                    @foreach ($writers as $writer)
                        <option value="{{ $writer->id }}">{{ $writer->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="publisher_id">Publisher:</label>
                <select name="publisher_id" id="publisher_id" class="form-control" required>
                    @foreach ($publishers as $publisher)
                        <option value="{{ $publisher->id }}">{{ $publisher->name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Create</button>
        </form>
    </div>
@endsection
