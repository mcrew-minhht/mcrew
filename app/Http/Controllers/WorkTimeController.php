<?php

namespace App\Http\Controllers;
use App\Constants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use PDF;
use File;
use ZipArchive;

class WorkTimeController extends Controller
{
    public function index(){
        if(empty(session('errors'))){
            session()->forget('_old_input');
        }
        $targetSelectData = [
            Constants::WT_TARGET_0 => 'Me',
            Constants::WT_TARGET_1 => 'Other guys',
        ];
        $date = getdate();
        $month = $date['year'].'-'.str_pad($date['mon'], 2, '0', STR_PAD_LEFT );
        return view('work_time.work_time', [
            'targetSelectData' => $targetSelectData,
            'monthDefault' => $month
        ]);
    }

    public function search(Request $request, $monthYear = ''){
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
            $searchName = $request->name;
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

            $listUID =  [];
            foreach($grandResult as $y1){
                array_push($listUID, $y1->user_id);
            }
            session()->flash('_old_input', $_POST);
            return view('work_time.work_time', [
                'grandResult' => $grandResult,
                'searchName' => $searchName,
                'listUID' => implode('-', $listUID),
                'month' => $monthYear,
                'targetSelectData' => $targetSelectData,
            ]);
        }
        $monthOfYear = $timeGroup[1];
        $year = $timeGroup[0];
        $totalDay = cal_days_in_month(CAL_GREGORIAN, $monthOfYear, $year);
        $userId = $request->userId ? $request->userId : $user->id;
        $userId = explode('-', $userId);
        $userName = $request->userName ? $request->userName : $user->name;
        $rResult = DB::table('work_time')
        ->leftJoin('projects', 'work_time.project', '=', 'projects.id')
        ->select('work_time.date', 'work_time.status', 'work_time.id','work_time.user_id', 'work_time.work_time', 'work_time.project as projectID', 'projects.name as projectName')
        ->where('work_time.date', 'like', $monthYear . '%')
        ->whereIn('work_time.user_id', $userId)
        ->get();
        $resultGroup = [];
        foreach($userId as $i3){
            $resultGroup[$i3] = [];
        }
        foreach($rResult as $i => $v){
            array_push($resultGroup[$v->user_id], $v);
        }
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
                if (!isset($v0[$i-1])){
                    $status = '';
                    $id = '';
                    $project = '';
                }else{
                    $id = $v0[$i-1]->id;
                    $status = $v0[$i-1]->status;
                    $projectId = json_decode($v0[$i-1]->projectID);
                    if(is_array($projectId)){
                        $project = DB::table('projects')
                        ->select('name')
                        ->WhereIn('id', ['1','2'])
                        ->get();
                    }else{
                        $project = DB::table('projects')
                        ->select('name')
                        ->Where('id', $projectId)
                        ->get();
                    }

                }
                $item = [
                    'id' => $id,
                    'day' => $i,
                    'dayOfWeek' => Constants::WEEKDAYS_GROUP[date('w', strtotime($monthYear . '-' . $i))],
                    'time' => 8.00,
                    'projectID' => '',
                    'projectName' => $project,
                    'userId' => Auth::user()->role,
                    'status' => $status
                ];
                for($i1 = 0, $l1 = count($v0); $i1 < $l1; $i1++){
                    if( $i == explode('-', $v0[$i1]->date)[2] ){
                        $item['time'] = $v0[$i1]->work_time;
                        $item['projectID'] = $v0[$i1]->projectID;
                    }
                }

                $totalWorkTime += $item['time'];
                array_push($result[$i0]['data'], $item);
            }

            $result[$i0]['totalWorkTime'] = $totalWorkTime;
        }

        $projects = DB::table('projects')
        ->select('id', 'name')
        ->get();

        if($request->isDownloadPdf){
            if( !file_exists( public_path('pdfs') ) ){
                mkdir(public_path('pdfs'));
            }else{
                $files = glob( public_path('pdfs/*') );
                foreach($files as $file){
                    if(is_file($file))
                        unlink($file);
                }
            };
            foreach($result as $i1){
                $pdf = PDF::loadView('work_time/work_time_pdf', [
                    'result' => $i1['data'],
                    'totalWorkTime' => $i1['totalWorkTime'],
                    'month' => $monthYear,
                    'name' => $i1['userName'],
                ]);
                $pdfFileName = public_path('pdfs/').$monthYear.'_'.$i1['userName'].'.pdf';
                $pdf->save( $pdfFileName );
            }

            if(count($result) > 1){
                $zip = new ZipArchive;
                $zipFileName = $monthYear.'.zip';
                $downloadFilePath = public_path($zipFileName);
                if ($zip->open(public_path($zipFileName), ZipArchive::CREATE) === TRUE)
                {
                    $pdfFiles = File::files( public_path('pdfs') );
                    foreach ($pdfFiles as $key => $value) {
                        $relativeNameInZipFile = basename($value);
                        $zip->addFile($value, $relativeNameInZipFile);
                    }
                }
                $zip->close();
                $files = glob( public_path('pdfs/*') );
                foreach($files as $file){
                    if(is_file($file))
                        unlink($file);
                }
            }else{
                $files = glob( public_path('pdfs/*') );
                $downloadFilePath = $files[0];
            }

            return response()->download($downloadFilePath)->deleteFileAfterSend();
        }else{
            $k2 = '';
            foreach($result as $i2 => $v2){
                $k2 = $i2;
            }
            session()->flash('_old_input', $_POST);
            return view('work_time.work_time', [
                'result' => $result[$k2]['data'],
                'totalWorkTime' => $result[$k2]['totalWorkTime'],
                'projects' => $projects,
                'month' => $monthYear,
                'targetSelectData' => $targetSelectData,
                'userName' => $userName,
                'userId' => $userId[0],
            ]);
        }
    }

    public function save(Request $request){
        $userID = $request->userId;
        $time = $request->time;
        $projects = $request->projects;
        $monthYear = $request->monthYear;
        $status = $request->status;
        $project = explode(',',$request->project);
        $id = $request->id;
        if(isset($time)){
            foreach($time as $index => $value){
                if(!$value){
                    unset($time[$index]);
                    unset($status[$index]);
                }else{
                    DB::table('work_time')
                    ->updateOrInsert(
                        [
                            'user_id' => $userID,
                            'date' => $monthYear.'-'.str_pad($index+1, 2, "0", STR_PAD_LEFT),
                        ],
                        [
                            'work_time' => $value,
                            'status' => $status[$index]
                        ]
                    );
                    if (isset($project) || isset($id)) {
                        $data = [
                            'project' => $project
                        ];
                        DB::table('work_time')->where('id', $id)->update(
                            $data
                        );
                    }
                }
            }
        }else{
            foreach($status as $index => $value){
                if(!$value){
                    unset($status[$index]);
                }else{
                    DB::table('work_time')
                    ->updateOrInsert(
                        [
                            'user_id' => $userID,
                            'date' => $monthYear.'-'.str_pad($index+1, 2, "0", STR_PAD_LEFT),
                        ],
                        [
                            'status' => $status[$index]
                        ]
                    );

                }
            }
        }
        $request->session()->flash('success', 'Save was successful!');
        return $this->search($request, $monthYear);
    }

}
