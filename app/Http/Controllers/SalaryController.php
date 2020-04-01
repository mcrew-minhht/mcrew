<?php

namespace App\Http\Controllers;

use App\Http\Requests\SalaryRegist;
use App\Http\Requests\SalarySearch;
use App\Http\Requests\SalaryUpdate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SalaryController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
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
