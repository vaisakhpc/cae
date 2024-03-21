<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Events extends Model
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'events'; // Specify the correct table name here
    
    protected $fillable = [
        // Other fillable attributes...
        'checkin',
    ];

    use HasFactory;
}
