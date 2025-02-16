<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'vehicles';

    protected $guarded = [];

    protected $casts = [
        'mot_due_date' => 'date',
        'tax_due_date' => 'date',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function incomes()
    {
        return $this->hasMany(Income::class, 'vehicle_id')->latest();
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class, 'vehicle_id')->latest();
    }

    public static function boot()
    {
        parent::boot();

        self::deleting(function ($vehicle) {
            $vehicle->incomes()->each(function ($income) {
                $income->delete();
            });

            $vehicle->expenses()->each(function ($expense) {
                $expense->delete();
            });

        });
    }
}
