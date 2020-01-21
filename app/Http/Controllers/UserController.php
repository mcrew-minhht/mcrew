<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRegist;
use App\Http\Requests\UserSearch;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function registView()
    {
        return view('users.regist');
    }

    public function regist(UserRegist $request)
    {
        $data = [
            'name' => $request->input('name'), 
            'email' => $request->input('email'),
            'email_verified_at' => $request->input('email_verified_at'),
            'password' => Hash::make($request->input('password')),
            'birthday' => $request->input('birthday'),
            'identity' => $request->input('identity'),
            'identity_date' => $request->input('identity_date'),
            'identity_place' => $request->input('identity_place'),
            'phone_number' => $request->input('phone_number'),
            'current_address' => $request->input('current_address'),
            'regularly_address' => $request->input('regularly_address'),
            'join_company_date' => $request->input('join_company_date'),
            'company_staff_date' => $request->input('company_staff_date'),
            'role' => $request->input('role'),
        ];
        DB::table('users')->insert(
            $data
        );

        return redirect('users/regist')->with('success', 'regist success!');
    }

    public function searchView()
    {
        return view('users.search');
    }

    
    public function search(UserSearch $request)
    {
       $searchData = [
        'name' => $request->input('name'), 
        'email' => $request->input('email'),
        'email_verified_at' => $request->input('email_verified_at'),
        'birthday' => $request->input('birthday'),
        'identity' => $request->input('identity'),
        'identity_date' => $request->input('identity_date'),
        'identity_place' => $request->input('identity_place'),
        'phone_number' => $request->input('phone_number'),
        'current_address' => $request->input('current_address'),
        'regularly_address' => $request->input('regularly_address'),
        'join_company_date' => $request->input('join_company_date'),
        'company_staff_date' => $request->input('company_staff_date'),
        'role' => $request->input('role'),
        ];
        $users = DB::table('users');
        foreach($searchData as $k => $i){
            if($i !== null){
                $users->where($k, $i);
            }
        }
        $users = $users->get();

        return view('users.search', [
            'list' => $users
        ]);

    }
}
