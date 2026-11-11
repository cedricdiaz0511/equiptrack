<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Borrowing extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'borrowings';

    protected $fillable = [

        // STUDENT INFORMATION
        'user_id',
        'user_name',
        'user_email',

        // EQUIPMENT INFORMATION
        'equipment_id',
        'equipment_name',
        'category',
        'quantity',

        // BORROWING DETAILS
        'purpose',
        'request_date',
        'expected_return_date',

        // REQUEST STATUS
        'status',

        // APPROVAL DETAILS
        'approved_by',
        'approved_at',
        'rejection_reason',

        // RELEASE DETAILS
        'released_by',
        'released_at',

        // RETURN DETAILS
        'returned_by',
        'returned_at',
        'return_condition',
        'return_notes',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
            'request_date' => 'datetime',
            'expected_return_date' => 'datetime',
            'approved_at' => 'datetime',
            'released_at' => 'datetime',
            'returned_at' => 'datetime',
        ];
    }
}
