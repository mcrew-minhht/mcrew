<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use PDF;

class WorkTimeController extends Controller
{
    public function index(){
        return view('work_time.work_time');
    }
    
    public function search(Request $request, $monthYear = ''){

        //stupid -> remove it
        $user = Auth::user();

        $con1 = [
            0 => 'Sunday',
            1 => 'Monday',
            2 => 'Tuesday',
            3 => 'Wednesday',
            4 => 'Thursday',
            5 => 'Friday',
            6 => 'Saturday',
        ];

        $timeGroup = explode('-', $request->month);

        if($monthYear){
            $timeGroup = explode('-', $monthYear);
        }else{
            $monthYear = $request->month;
        }
        
        $monthOfYear = $timeGroup[1];
        $year = $timeGroup[0];

        $totalDay = cal_days_in_month(CAL_GREGORIAN, $monthOfYear, $year);

        $rResult = DB::table('work_time')
        ->leftJoin('projects', 'work_time.project', '=', 'projects.id')
        ->select('work_time.id', 'work_time.date', 'work_time.user_id', 'work_time.work_time', 'work_time.project as projectID', 'projects.name as projectName')
        ->where([
            ['date', 'like', $monthYear . '%'],
            ['user_id', '=', $user->id],
        ])->get();
        

        $result = [];

        $totalWorkTime = 0;
        foreach($rResult as $i0){
            $totalWorkTime += $i0->work_time;
        }
        
        for($i = 1; $i <= $totalDay; $i++){
            $item = [
                'day' => $i,
                'dayOfWeek' => $con1[date('w', strtotime($monthYear . '-' . $i))],
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
                'name' => $user->name,
            ]);
            return $pdf->download($monthYear.'_work_time.pdf');
        }
        
        return view('work_time.work_time', [
            'result' => $result,
            'totalWorkTime' => $totalWorkTime,
            'projects' => $projects,
            'month' => $monthYear,
        ]);
    }

    public function save(Request $request){
        $userID = Auth::user()->id;
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
