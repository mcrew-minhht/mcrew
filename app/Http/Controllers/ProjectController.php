<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRegist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ProjectUpdate;
use Illuminate\Support\Facades\Config;
use Auth;

class ProjectController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        //
    }

    public function registView()
    {
        return view('projects.regist');
    }

    public function regist(ProjectRegist $request)
    {

        $data = [
            'name' => $request->input('name'),
        ];

        DB::table('projects')->insert(
            $data
        );
        return redirect('projects/regist')->with('success', 'Registration has been completed.');
    }

    public function searchView()
    {
        if(empty(session('errors'))){
            session()->forget('_old_input');
        }
        
        return view('projects.search');
    }

    public function search(Request $request)
    {
        $name = $request->input('nameSearch');

        $project  = DB::table('projects')
                    ->where('name', 'LIKE', "%{$name}%")
                    ->get();

        session()->flash('_old_input', $_POST);
        
        return view('projects.search', [
            'list' => $project
        ]);
    }

    public function detailView($id)
    {
        $projectInfo = DB::table('projects')->select(
            'id',
            'name'
        )->where('id', '=', $id)->get()[0];


        $users = DB::table('users')->get();

        $userProject = DB::table('projects')
            ->join('user_projects', 'projects.id', '=', 'user_projects.project_id')
            ->join('users', 'users.id', '=', 'user_projects.user_id')
            ->where('user_projects.project_id', '=', $id)
            ->select('users.*')
            ->get();

        return view('projects.update', [
            'projectInfo' => $projectInfo,
            'users'=>$users,
            'userProject'=>$userProject
        ]);
    }

    public function update(ProjectUpdate $request)
    {
        $data = [
            'name' => $request->input('name'),
            'updated_by' => Auth::user()->id,
            'updated_at' => date(Config::get('constants.DATETIME_FORMAT_MYSQL'))
        ];

        $userId =  $request->user;

        DB::table('projects')->where('id', $request->id)->update(
            $data
        );

        if (isset($userId) && is_array($userId) && count($userId)) {
             foreach ($userId as  $vUser) {
                $data = [
                    'user_id' => $vUser,
                    'project_id'=> $request->id
                ];

                $exists = DB::table('user_projects')->where('user_id','=',$vUser)->exists();

                if (!$exists) {
                    DB::table('user_projects')->insert(
                        $data
                    );
                }
            }
        }

        $projectInfo = DB::table('projects')->select(
            'id',
            'name'
        )->where('id', '=', $request->id)->get()[0];

        $users = DB::table('users')->get();

        $userProject = DB::table('projects')
            ->join('user_projects', 'projects.id', '=', 'user_projects.project_id')
            ->join('users', 'users.id', '=', 'user_projects.user_id')
            ->select('users.*')
            ->get();
        $request->session()->flash('success', 'Update has been completed.');

        return view('projects.update', [
            'projectInfo'=>$projectInfo,
            'userProject' => $userProject,
            'users'=>$users
        ]);

    }

    public function destroy(Request $request)
    {
        DB::table('user_projects')
            ->where('user_id','=',$request->id)
            ->where('project_id','=',$request->idProject)
            ->delete();

        $request->session()->flash('success', 'Deleted has been success.');

        return $this->detailView($request->idProject);
    }
}
