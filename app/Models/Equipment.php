<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;

    protected $table = 'equipments';

    protected $fillable = [
        'name',
        'description',
        'daily_value',
        'available',
    ];

    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }

    public function calculate($start_date, $end_date)
    {
        $start = Carbon::parse($start_date);
        $end = Carbon::parse($end_date);
        $days = $start->diffInDays($end);
        return $this->daily_value * $days;
    }
}
