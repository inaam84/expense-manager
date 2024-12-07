<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuthenticationLog extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;

    protected $table = 'authentication_log';

    public function authenticatable()
    {
        return $this->morphTo();
    }
}
