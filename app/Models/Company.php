<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'address',
        'email',
        'bank_name',
        'bank_number',
        'bank_account_name'
    ];
}
