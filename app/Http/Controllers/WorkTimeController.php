<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WorkTimeController extends Controller
{
    public function index(){
        return view('work_time.work_time');
    }
    public function search(Request $request){
        return view('work_time.work_time');
    }

   
}
