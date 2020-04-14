<?php

namespace App\Http\Controllers;

use App\Http\Requests\DayOffRegist;
use App\Http\Requests\DayOffSearch;
use App\Http\Requests\DayOffUpdate;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class DayOffController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        return view('day_off.regist');
    }

    public function store(DayOffRegist $request)
    {
        $data = [
            'date' => $request->date,
            'created_at' => date(Config::get('constants.DATETIME_FORMAT_MYSQL')),
            'created_by' => Auth::user()->id
        ];
        $exists = DB::table('day_offs')->where('date','=',$request->date)->exists();

        $totalRegistYearOld = DB::table('day_offs')
        ->where('day_offs.created_by', Auth::user()->id)
        ->whereBetween('date',[date('Y-01-01', strtotime('-1 year')),date('Y-12-31', strtotime('-1 year'))])
        ->count();

        $totalRegistYear = DB::table('day_offs')
        ->where('day_offs.created_by', Auth::user()->id)
        ->whereBetween('date',[date('Y-01-01'),date('Y-12-31')])
        ->count();

        $surplus = 12 - $totalRegistYearOld;

        if (!$exists) {

            if($surplus > 0){

                if ($totalRegistYear < (12 + $surplus) && date('Y-m-d') < date('Y-04-01')) {
                    DB::table('day_offs')->insert(
                        $data
                    );
                    return redirect('dayoff/regist')->with('success', 'Registration has been completed.');
                } else if($totalRegistYear < 12){
                    DB::table('day_offs')->insert(
                        $data
                    );
                    return redirect('dayoff/regist')->with('success', 'Registration has been completed.');
                }
            }else{
                if ($totalRegistYear < 12 ) {

                    DB::table('day_offs')->insert(
                        $data
                    );

                    return redirect('dayoff/regist')->with('success', 'Registration has been completed.');
                }
            }
        }
        return redirect('dayoff/regist')->with('error', 'The day already exists.');
    }

    public function searchView()
    {
        if(empty(session('errors'))){
            session()->forget('_old_input');
        }
        return view('day_off.search');
    }

    public function search(DayOffSearch $request)
    {

        $name = $request->input('name');

        $searchUsers = DB::table('day_offs')
        ->join('users', 'users.id', '=', 'day_offs.created_by')
        ->where('users.name', $name)
        ->select('day_offs.date', 'day_offs.status', 'day_offs.id','users.name as name')
        ->get();

        $searchUser = DB::table('day_offs')
        ->join('users', 'users.id', '=', 'day_offs.created_by')
        ->where('users.name', $name)
        ->select('day_offs.date', 'day_offs.status','users.name as name')
        ->first();

        $totalRegistYearOld = DB::table('day_offs')
        ->where('day_offs.created_by', Auth::user()->id)
        ->whereBetween('date',[date('Y-01-01', strtotime('-1 year')),date('Y-12-31', strtotime('-1 year'))])
        ->count();

        $totalRegistYear = DB::table('day_offs')
        ->where('day_offs.created_by', Auth::user()->id)
        ->whereBetween('date',[date('Y-01-01'),date('Y-12-31')])
        ->count();

        $user = DB::table('users')->where('name',$name)->first();

        $surplus = 12 - $totalRegistYearOld;

        if($surplus > 0){
            if (date('Y-m-d') < date('Y-04-01')) {
                $total = 12 - $totalRegistYear + $surplus;
            }else{
                $total = 12 - $totalRegistYear;
            }
        }else{
            $total = 12 - $totalRegistYear;
        }
        session()->flash('_old_input', $_POST);

        return view('day_off.search',[
            'lists'=>$searchUsers,
            'listUsers'=>$searchUser,
            'totalDay' => $total,
            'totalRegistYear' => $totalRegistYear,
            'user' => $user
        ]);
    }

    public function detailView(Request $request, $id)
    {
        $dateOff = DB::table('day_offs')
        ->where('id', $id)
        ->first();

        return view('day_off.update',[
            'dateOff'=>$dateOff
        ]);
    }

    public function update(DayOffUpdate $request, $id)
    {
        $dateOff = DB::table('day_offs')
        ->where('id', $id)
        ->first();

        $data = [
            'date' => $request->date,
            'updated_by' => Auth::user()->id,
            'updated_at' => date(Config::get('constants.DATETIME_FORMAT_MYSQL'))
        ];

        $exists = DB::table('day_offs')->where('date','=',$request->date)->exists();

        if (!$exists) {
            DB::table('day_offs')->where('id', $id)->update(
                $data
            );
            $request->session()->flash('success', 'Update has been completed.');
            return view('day_off.update',[
                'dateOff'=>$dateOff
            ]);
        }

        $request->session()->flash('error', 'The day already exists.');
        return view('day_off.update',[
            'dateOff'=>$dateOff
        ]);
    }
}
