<?php

namespace App;

trait AmountTrait
{
    // Mutator: Transform amount before saving to the database
    public function setAmountAttribute($value)
    {
        // Multiply by 100 before saving
        $this->attributes['amount'] = $value * 100;
    }

    // Accessor: Transform amount after retrieving from the database
    public function getAmountAttribute($value)
    {
        // Divide by 100 after retrieving
        return round($value / 100, 2);
    }
}
