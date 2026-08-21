<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CleaningRequest extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'email',
        'service',
        'address',
        'message',
    ];
}
