<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $title
 * @property string $ISBN
 * @property int $publication_year
 * @property float $price
 * @property string $genre
 * @property string $subgenre
 * @property int $sort_order
 * @property int $stock_amount
 * @property int $writer_id
 * @property int $publisher_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Book extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $attributes = [
        'sort_order' => -1,
    ];

    /**
     * Get the writer associated with the book.
     */
    public function writer()
    {
        return $this->belongsTo(Writer::class);
    }

    /**
     * Get the publisher associated with the book.
     */
    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }

}
