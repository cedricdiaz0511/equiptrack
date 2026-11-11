<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Equipment extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'equipment';

    protected $fillable = [
        'name',
        'category',
        'description',
        'status',
        'quantity',
        'borrowed_quantity',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
            'borrowed_quantity' => 'integer',
        ];
    }

    // COMPUTE AVAILABLE QUANTITY
    public function getAvailableQuantityAttribute(): int
    {
        $total = (int) ($this->quantity ?? 0);
        $borrowed = (int) ($this->borrowed_quantity ?? 0);

        return max(0, $total - $borrowed);
    }
}
