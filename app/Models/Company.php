<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'companies';

    public static function create($attributes){
        $value=DB::table('companies')->insert($attributes);
        return $value;
    }
}
