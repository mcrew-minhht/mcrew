<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class CustomController extends Controller
{
    public function notFound()
    {
        abort(404);
    }

}
