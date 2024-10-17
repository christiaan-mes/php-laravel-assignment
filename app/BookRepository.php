<?php

namespace App;

use App\Models\Book;
use App\Models\Publisher;
use App\Models\Writer;

class BookRepository
{
    /**
     * Store a new book with its relations in the database.
     *
     * @param array $requestData
     *
     * @return \App\Models\Book
     */
    public function storeBookWithRelations(array $requestData)
    {
        $writer = $this->findOrCreateWriter($requestData);
        $publisher = $this->findOrCreatePublisher($requestData);

        return Book::create([
            'title' => $requestData['title'],
            'ISBN' => $requestData['ISBN'],
            'publication_year' => $requestData['publication_year'],
            'price' => $requestData['price'],
            'genre' => $requestData['genre'],
            'subgenre' => $requestData['subgenre'],
            'writer_id' => $writer->id,
            'publisher_id' => $publisher->id,
        ]);
    }

    /**
     * Find or create a writer.
     *
     * @param array $requestData
     *
     * @return \App\Models\Writer
     */
    protected function findOrCreateWriter(array $requestData)
    {
        if ($requestData['writer_id']) {
            return Writer::find($requestData['writer_id']);
        }

        return Writer::create([
            'name' => $requestData['writer_name'],
        ]);
    }

    /**
     * Find or create a publisher.
     *
     * @param array $requestData
     *
     * @return \App\Models\Publisher
     */
    protected function findOrCreatePublisher(array $requestData)
    {
        if ($requestData['publisher_id']) {
            return Publisher::find($requestData['publisher_id']);
        }

        return Publisher::create([
            'name' => $requestData['publisher_name'],
            'location' => $requestData['publisher_location'],
        ]);
    }
}
