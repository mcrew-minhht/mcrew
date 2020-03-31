<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRegist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ProjectUpdate;

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
        return view('projects.search');
    }

    public function search(Request $request)
    {
        $name = $request->input('nameSearch');

        $project  = DB::table('projects')
                    ->where('name', 'LIKE', "%{$name}%")
                    ->get();

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

        return view('projects.update', [
            'projectInfo' => $projectInfo,'users'=>$users
        ]);
    }

    public function update(ProjectUpdate $request)
    {
        $data = [
            'name' => $request->input('name')
        ];

        DB::table('projects')->where('id', $request->id)->update(
            $data
        );

        $projectInfo = DB::table('projects')->select(
            'id',
            'name'
        )->where('id', '=', $request->id)->get()[0];

        $users = DB::table('users')->get();

        $request->session()->flash('success', 'Update has been completed.');

        return view('projects.update', ['projectInfo'=>$projectInfo,
            'users' => $users
        ]);

    }
}
