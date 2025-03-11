<?php

namespace App\Models;

use App\AmountTrait;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Plank\Mediable\Mediable;
use Plank\Mediable\MediableInterface;

class Income extends Model implements MediableInterface
{
    use AmountTrait, HasFactory, HasUuids, Mediable;

    protected $table = 'incomes';

    protected $guarded = [];

    protected $casts = [
        'income_date' => 'date',
    ];

    public function Vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }
}
