<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Auth;
use App\Constants;
use App\Http\Requests\SalaryRegist;
use App\Http\Requests\SalarySearch;
use App\Http\Requests\SalaryUpdate;
use App\Http\Requests\SalaryCalcSearch;
use DateTime;

class SalaryController extends Controller
{
    public function calcView()
    {
        if(empty(session('errors'))){
            session()->forget('_old_input');
        }
        $date = getdate();
        $month = $date['year'].'-'.str_pad($date['mon'], 2, '0', STR_PAD_LEFT );
        $user = Auth::user();
        $member_types = DB::table('member_types')->select('id', 'name')->get();
        $data = [
            'month'=>$month,
            'member_types' => $member_types,
            "adFeature" => $user->role == Constants::USER_ROLE_ADMIN,
        ];
        return view('salary.calc', $data);
    }

    public function calcSearch(SalaryCalcSearch $request)
    {
        $user = Auth::user();
        if(!isset($_POST['name']) && !isset($_POST['member_type'])){
            $userId = $user->id;
        }else{
            $userName = $_POST['name'];
            $member_type = $_POST['member_type'];
        }
        $daytime = strtotime(date('Y-m-01', strtotime($request->monthYear)));
        $date = getdate($daytime);
        $d = $date['wday'];
        $monthYear = $request->monthYear;
        $timeGroup = explode('-', $monthYear);
        $monthOfYear = $timeGroup[1];
        $year = $timeGroup[0];
        $monthText = Constants::MONTHS_GROUP[intval($monthOfYear)];
        $totalDay = cal_days_in_month(CAL_GREGORIAN, $monthOfYear, $year);
        $totalDayNotWeekend = $totalDay;
        $dayGroup = [];
        for($z1 = 1;$z1 <= $totalDay; $z1++){
            if ($d > 6) $d = 0;
            array_push($dayGroup, array(str_pad($z1, 2, '0', STR_PAD_LEFT ),$d++));
        }
        $rResult = DB::table('work_time')
        ->select('work_time.date', 'work_time.user_id', 'work_time.work_time')
        ->where('work_time.date', 'like', $monthYear . '%');
        if(isset($userId)){
            $rResult = $rResult->where('work_time.user_id', $userId);
        }else{
            $rResult = $rResult->join('users', 'users.id', '=', 'work_time.user_id')->where('users.name', 'like', '%' . $userName . '%');
            if(!empty($member_type)){
                $rResult = $rResult->where('users.member_type', '=', $member_type);
            }
        }
        $rResult = $rResult->get();
        $query = DB::getQueryLog();
        $resultGroup = [];
        foreach($rResult as $i => $v){
            if(!isset($resultGroup[$v->user_id])){
                $resultGroup[$v->user_id] = [];
            }
            array_push($resultGroup[$v->user_id], $v);
        }
        $result = [];
        foreach($resultGroup as $i0 => $v0){
            $userInfo = DB::table('users')
            ->join('salary', 'users.id', '=', 'salary.user_id')
            ->select('users.name', 'salary.salary', 'salary.base_salary', 'salary.number_of_dependents')
            ->where('users.id', '=', $i0)
            ->first();
            $result[$i0] = [
                'data' => [],
                'totalWorkTime' => 0,
                'otTime' => 0,
                'primaryWorkDay' => 0,
                'userName' => $userInfo->name,
                'salary' => $userInfo->salary,
                'base_salary' => $userInfo->base_salary,
                'number_of_dependents' => $userInfo->number_of_dependents,
            ];
            $totalWorkTime = 0;
            $otTime = 0;
            $primaryWorkDay = 0;
            for($i = 1; $i <= $totalDay; $i++){
                $dayOfWeek = date('w', strtotime($monthYear . '-' . $i));
                if($dayOfWeek == 0 || $dayOfWeek == 6){
                    $totalDayNotWeekend--;
                }
                $item = [
                    'day' => $i,
                    'isWeekend' => $dayOfWeek == 0 || $dayOfWeek == 6,
                    'time' => 0.00,
                ];
                for($i1 = 0, $l1 = count($v0); $i1 < $l1; $i1++){
                    if( $i == explode('-', $v0[$i1]->date)[2] ){
                        $item['time'] = $v0[$i1]->work_time;
                    }
                    if( $dayOfWeek != 0 && $dayOfWeek != 6 && ($i == explode('-', $v0[$i1]->date)[2]) && $item['time'] != 0){
                        $primaryWorkDay++;
                    }
                }

                $totalWorkTime += $item['time'];
                if($item['time'] > 8){
                    $otTime += $item['time'] - 8;
                }else if($dayOfWeek == 0 || $dayOfWeek == 6){
                    $otTime += $item['time'];
                }
                array_push($result[$i0]['data'], $item);
            }

            $result[$i0]['totalWorkTime'] = $totalWorkTime;
            $result[$i0]['otTime'] = $otTime;
            $result[$i0]['primaryWorkDay'] = $primaryWorkDay;
        }
        $member_types = DB::table('member_types')->select('id', 'name')->get();
        $returnData = [
            'member_types' => $member_types,
            'workTime' => $result,
            "adFeature" => $user->role == Constants::USER_ROLE_ADMIN,
            "totalDay" => $totalDay,
            "totalDayNotWeekend" => $totalDayNotWeekend,
            "dayGroup" => $dayGroup,
            "monthText" => $monthText,
        ];
        session()->flash('_old_input', $_POST);
        return view('salary.calc', $returnData);
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        if(empty(session('errors'))){
            session()->forget('_old_input');
        }

        return view('salary.search');
    }

    public function search(SalarySearch $request)
    {
        $name = $request->input('nameSearch');

        $salary = $request->input('salarySearch');

        $searchSalary  = DB::table('salary')
            ->join('users', 'users.id', '=', 'salary.user_id')
            ->where('users.name', 'LIKE', "%{$name}%")
            ->where('salary.salary', 'LIKE', "%{$salary}%")
            ->get();

        session()->flash('_old_input', $_POST);

        return view('salary.search', [
            'list' => $searchSalary
        ]);
    }

    public function registView()
    {
        $users =  DB::table('users')->get();

        return view('salary.regist', [
            'users' => $users
        ]);
    }

    public function regist(SalaryRegist $request)
    {
        $data = [
            'user_id' => $request->input('nameSalary'),
            'base_salary'=> $request->input('baseSalary'),
            'salary'=> $request->input('salary'),
            'number_of_dependents'=> Auth::user()->id,
            'created_user' => Auth::user()->id
        ];

        $exists = DB::table('salary')->where('user_id','=',$request->input('nameSalary'))->exists();

        if (!$exists) {
            DB::table('salary')->insert(
                $data
            );

            $request->session()->flash('success', 'Registration has been completed.');

            return $this->registView();
        }

        $request->session()->flash('error', 'User already exists.');

        return $this->registView();

    }

    public function detailView($id)
    {
        $detailSalary  = DB::table('salary')
            ->join('users', 'users.id', '=', 'salary.user_id')
            ->where('users.id', '=', "$id")
            ->get()[0];

        return view('salary.update', [
            'detailSalary' => $detailSalary
        ]);
    }

    public function update(SalaryUpdate $request)
    {
        $userId = $request->userId;

        $data = [
            'base_salary' => $request->input('baseSalary'),
            'salary' => $request->input('salary'),
            'updated_user' => Auth::user()->id
        ];

        DB::table('salary')->where('id', $request->id)->update(
            $data
        );

        $request->session()->flash('success', 'Update has been completed.');

        return $this->detailView($userId);
    }

}
