<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Auth;
use App\Constants;
use App\Http\Requests\SalaryCalcSearch;

class SalaryController extends Controller
{
    public function calcView()
    {
        $user = Auth::user();
        $data = [
            "adFeature" => $user->role == Constants::USER_ROLE_ADMIN,
        ];
        return view('salary.calc', $data);
    }

    public function calcSearch(SalaryCalcSearch $request)
    {
        $user = Auth::user();
        if(!isset($_POST['name'])){
            $userId = $user->id;
        }else{
            $userName = $_POST['name'];
        }

        $monthYear = $request->monthYear;
        $timeGroup = explode('-', $monthYear);
        $monthOfYear = $timeGroup[1];
        $year = $timeGroup[0];
        $totalDay = cal_days_in_month(CAL_GREGORIAN, $monthOfYear, $year);
        $totalDayNotWeekend = $totalDay;
        $dayGroup = [];
        for($z1 = 1;$z1 <= $totalDay; $z1++){
            array_push($dayGroup, $monthOfYear.'/'.str_pad($z1, 2, '0', STR_PAD_LEFT ));
        }
        $rResult = DB::table('work_time')
        ->select('work_time.date', 'work_time.user_id', 'work_time.work_time')
        ->where('work_time.date', 'like', $monthYear . '%');
        if(isset($userId)){
            $rResult = $rResult->where('work_time.user_id', $userId);
        }else{
            $rResult = $rResult->join('users', 'users.id', '=', 'work_time.user_id')->where('users.name', 'like', '%' . $userName . '%');
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
        $returnData = [
            'workTime' => $result,
            "adFeature" => $user->role == Constants::USER_ROLE_ADMIN,
            "totalDay" => $totalDay,
            "totalDayNotWeekend" => $totalDayNotWeekend,
            "dayGroup" => $dayGroup,
        ];
        return view('salary.calc', $returnData);
    }
}
