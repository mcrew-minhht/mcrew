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

        // dd($monthYear, $userId, $userId != 'false');
        
        $rResult = DB::table('work_time')
        ->leftJoin('projects', 'work_time.project', '=', 'projects.id')
        ->select('work_time.date', 'work_time.user_id', 'work_time.work_time', 'work_time.project as projectID', 'projects.name as projectName')
        ->when($userId != 'false', function ($query, $userId) use($monthYear) {
            return $query->where([
                ['date', 'like', $monthYear . '%'],
                ['user_id', '=', $userId],
            ]);
        }, function ($query) use($monthYear) {
            return $query->where([
                ['date', 'like', $monthYear . '%'],
            ]);
        })
        ->get();
        
        // dd($rResult);



        
        $resultGroup = [];
        foreach($rResult as $i => $v){
            $resultGroup[$v->user_id] = [];
        }
        foreach($rResult as $i => $v){
            array_push($resultGroup[$v->user_id], $v);
        }
        
        // dd($resultGroup);
        $result = [];
        foreach($resultGroup as $i0 => $v0){
            $userName = DB::table('users')->select('name')->where('id', '=', $i0)->first();
            $userName = !empty($userName) ? $userName->name : '';
            $result[$i0] = [
                'data' => [],
                'totalWorkTime' => 0,
                'userName' => $userName,
            ];
            $totalWorkTime = 0;
            for($i = 1; $i <= $totalDay; $i++){
                $item = [
                    'day' => $i,
                    'dayOfWeek' => Constants::WEEKDAYS_GROUP[date('w', strtotime($monthYear . '-' . $i))],
                    'time' => 0.00,
                    'projectID' => '',
                    'projectName' => '',
                ];
                for($i1 = 0, $l1 = count($v0); $i1 < $l1; $i1++){
                    if( $i == explode('-', $rResult[$i1]->date)[2] ){
                        $item['time'] = $rResult[$i1]->work_time;
                        $item['projectID'] = $rResult[$i1]->projectID;
                        $item['projectName'] = $rResult[$i1]->projectName;
                        break;
                    }
                }
    
                $totalWorkTime += $item['time'];
                array_push($result[$i0]['data'], $item);
            }

            $result[$i0]['totalWorkTime'] = $totalWorkTime;
        }
        // dd($result);
        
        $projects = DB::table('projects')
        ->select('id', 'name')
        ->get();

        if($request->isDownloadPdf){
            if( !file_exists( public_path('pdfs') ) ){
                mkdir(public_path('pdfs'));
            }
            $pathList = [];
            foreach($result as $i1){
                $pdf = PDF::loadView('work_time/work_time_pdf', [
                    'result' => $i1['data'],
                    'totalWorkTime' => $i1['totalWorkTime'],
                    'month' => $monthYear,
                    'name' => $i1['userName'],
                ]);
                // To be continue
                $pdf->save( public_path('pdfs/').'/'.$monthYear.'_'.$i1['userName'].'.pdf' );
                array_push($pathList, public_path('pdfs/').'/'.$monthYear.'_'.$i1['userName'].'.pdf');
            }

            // return $pdf->download($monthYear.'_'.$userName.'.pdf');
        }else{
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
