<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function regist(Request $request)
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

            $name = $request->input('name');

        $project  = DB::table('projects')
                    ->where('name', 'LIKE', "%{$name}%")
                    ->get();

        return view('projects.search', [
            'list' => $project
        ]);
    }

    public function update(Request $request)
    {

        $data = [
            'name' => $request->input('project_name')
        ];

        DB::table('projects')->where('id', $request->project_id)->update(
            $data
        );

        $project = DB::table('projects')->select(
            'id',
            'name'
        )->where('id', '=', $request->project_id)->get();

        $request->session()->flash('success', 'Update has been completed.');

        return view('projects.search', [
            'list' => $project
        ]);

    }
}
