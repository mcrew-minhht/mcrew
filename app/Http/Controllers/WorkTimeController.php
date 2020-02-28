<?php

namespace App\Http\Controllers;
use App\Constants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use PDF;

class WorkTimeController extends Controller
{
    public function index(){
        $targetSelectData = [
            Constants::WT_TARGET_0 => 'Me',
            Constants::WT_TARGET_1 => 'Other guys',
        ];
        return view('work_time.work_time', [
            'targetSelectData' => $targetSelectData,
        ]);
    }
    
    public function search(Request $request, $monthYear = ''){

        // dd($request->request);


        
        //stupid -> remove it
        $user = Auth::user();
        $targetSelectData = [
            Constants::WT_TARGET_0 => 'Me',
            Constants::WT_TARGET_1 => 'Other guys',
        ];
        $timeGroup = explode('-', $request->month);
        if($monthYear){
            $timeGroup = explode('-', $monthYear);
        }else{
            $monthYear = $request->month;
        }
        if($request->target){
            $name = $request->name;
            $grandResult = DB::table('work_time')
            ->join('users', 'work_time.user_id', '=', 'users.id')
            ->select(DB::raw('SUM(work_time.work_time) as total_time'), 'work_time.id', 'work_time.user_id', 'users.name')
            ->groupBy('user_id')
            ->when($name, function($query) use($name, $monthYear){
                return $query->where([
                    ['work_time.date', 'like', $monthYear . '%'],
                    ['users.name', 'like', '%'.$name.'%'],
                ]);
            }, function($query) use ($monthYear){
                return $query->where([
                    ['work_time.date', 'like', $monthYear . '%'],
                ]);
            })
            ->get();

            return view('work_time.work_time', [
                'grandResult' => $grandResult,
                'month' => $monthYear,
                'targetSelectData' => $targetSelectData,
            ]);
        }
        $monthOfYear = $timeGroup[1];
        $year = $timeGroup[0];
        $totalDay = cal_days_in_month(CAL_GREGORIAN, $monthOfYear, $year);
        $userId = $request->userId ? $request->userId : $user->id;
        $userName = $request->userName ? $request->userName : $user->name;

        dd($monthYear, $userId);
        
        $rResult = DB::table('work_time')
        ->leftJoin('projects', 'work_time.project', '=', 'projects.id')
        ->select('work_time.date', 'work_time.user_id', 'work_time.work_time', 'work_time.project as projectID', 'projects.name as projectName')
        ->where([
            ['date', 'like', $monthYear . '%'],
            ['user_id', '=', $userId],
        ])
        // ->when($userId, function ($query, $userId) use($monthYear) {
        //     return $query->where([
        //         ['date', 'like', $monthYear . '%'],
        //         ['user_id', '=', $userId],
        //     ]);
        // }, function ($query) use($monthYear) {
        //     return $query->where([
        //         ['date', 'like', $monthYear . '%'],
        //     ]);
        // })
        ->get();
        

        $result = [];

        $totalWorkTime = 0;
        foreach($rResult as $i0){
            $totalWorkTime += $i0->work_time;
        }
        
        for($i = 1; $i <= $totalDay; $i++){
            $item = [
                'day' => $i,
                'dayOfWeek' => Constants::WEEKDAYS_GROUP[date('w', strtotime($monthYear . '-' . $i))],
                'time' => 0.00,
                'projectID' => '',
                'projectName' => '',
            ];
            for($i1 = 0, $l1 = count($rResult); $i1 < $l1; $i1++){
                if( $i == explode('-', $rResult[$i1]->date)[2] ){
                    $item['time'] = $rResult[$i1]->work_time;
                    $item['projectID'] = $rResult[$i1]->projectID;
                    $item['projectName'] = $rResult[$i1]->projectName;

                    break;
                }
            }

            array_push($result, $item);
        }
        
        $projects = DB::table('projects')
        ->select('id', 'name')
        ->get();

        if($request->isDownloadPdf){
            $pdf = PDF::loadView('work_time/work_time_pdf', [
                'result' => $result,
                'totalWorkTime' => $totalWorkTime,
                'projects' => $projects,
                'month' => $monthYear,
                'name' => $userName,
            ]);
            return $pdf->download($monthYear.'_'.$userName.'.pdf');
        }
        
        return view('work_time.work_time', [
            'result' => $result,
            'totalWorkTime' => $totalWorkTime,
            'projects' => $projects,
            'month' => $monthYear,
            'targetSelectData' => $targetSelectData,
            'userName' => $userName,
            'userId' => $userId,
        ]);
    }

    public function save(Request $request){
        $userID = $request->userId;
        $time = $request->time;
        $projects = $request->projects;
        $monthYear = $request->monthYear;

        foreach($time as $index => $value){
            if(!$value){
                unset($time[$index]);
                unset($projects[$index]);
            }else{
                
                DB::table('work_time')
                ->updateOrInsert(
                    [
                        'user_id' => $userID, 
                        'date' => $monthYear.'-'.str_pad($index+1, 2, "0", STR_PAD_LEFT),
                    ],
                    [
                        'work_time' => $value,
                        'project' => $projects[$index],
                    ]
                );
                
            }
        }

        $request->session()->flash('success', 'Save was successful!');
        return $this->search($request, $monthYear);
    }

}
