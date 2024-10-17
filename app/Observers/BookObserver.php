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

        if (is_null($book->sort_order)) {
            $book->sort_order = Book::query()->max('sort_order');
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

        $lowerPositionBooks = Book::query()->where('id', '!=', $book->id)
            ->whereBetween('sort_order', $sortOrderRange)
            ->get();

        foreach ($lowerPositionBooks as $lowerPositionBook) {
            if ($book->getOriginal('sort_order') < $book->sort_order) {
                $lowerPositionBook->sort_order--;
            } else {
                $lowerPositionBook->sort_order++;
            }
            $lowerPositionBook->saveQuietly();
        }
    }
}
