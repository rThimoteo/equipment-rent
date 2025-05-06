<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    use HasFactory;

    protected $table = 'rentals';

    protected $fillable = [
        'equipment_id',
        'start_date',
        'end_date',
        'value',
    ];
    
    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }
}