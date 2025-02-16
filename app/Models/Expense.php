<?php

namespace App\Models;

use App\AmountTrait;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use AmountTrait, HasFactory, HasUuids;

    protected $table = 'expenses';

    protected $guarded = [];

    protected $casts = [
        'expense_date' => 'date',
    ];

    public function Vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }
}
