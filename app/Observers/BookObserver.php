<?php

namespace App\Observers;

use App\Models\Book;

class BookObserver
{
    /**
     * Handle the Book "updated" event.
     *
     * @param  \App\Models\Book  $book
     * @return void
     */
    public function updated(Book $book)
    {
        if ($book->isClean('sort_order')) {
            return;
        }

        if ($book->getOriginal('sort_order') > $book->sort_order) {
            $sortOrderRange = [
                $book->sort_order, $book->getOriginal('sort_order')
            ];
        } else {
            $sortOrderRange = [
                $book->getOriginal('sort_order'), $book->sort_order
            ];
        }

        $otherBooks = Book::query()->where('id', '!=', $book->id)
            ->whereBetween('sort_order', $sortOrderRange)
            ->get();

        foreach ($otherBooks as $otherBook) {
            if ($book->getOriginal('sort_order') < $book->sort_order) {
                $otherBook->sort_order--;
            } else {
                $otherBook->sort_order++;
            }
            $otherBook->saveQuietly();
        }
    }
}
