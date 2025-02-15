<?php

namespace App\Models\Lookups;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExpenseTypeLookup extends BaseLookup
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'lookup_expense_types';
}
