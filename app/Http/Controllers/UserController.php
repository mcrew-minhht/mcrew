<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordUpdate;
use Illuminate\Http\Request;
use App\Http\Requests\UserRegist;
use App\Http\Requests\UserSearch;
use App\Http\Requests\UserDetail;
use App\Http\Requests\UserUpdate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;
use Auth;

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
        if(empty(session('errors'))){
            session()->forget('_old_input');
        }

        $member_types = DB::table('member_types')->select('id', 'name')->get();
        $data = [
            'member_types' => $member_types
        ];
        return view('users.regist', $data );
    }

    public function regist(UserRegist $request)
    {
        $data = [
            'name' => $request->input('name'),
            'member_type' => $request->input('member_type'),
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
            'created_at' => date(Config::get('constants.DATETIME_FORMAT_MYSQL')),
            'updated_at' => date(Config::get('constants.DATETIME_FORMAT_MYSQL'))
        ];
        DB::table('users')->insert(
            $data
        );

        return redirect('users/regist')->with('success', 'Registration has been completed.');
    }

    public function searchView()
    {
        if(empty(session('errors'))){
            session()->forget('_old_input');
        }
        return view('users.search');
    }

    public function search(UserSearch $request)
    {
        $searchData = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone_number' => $request->input('phone_number'),
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
        // dd($searchData);
        $users = DB::table('users');
        foreach ($searchData as $k => $i) {
            if ($i !== null) {
                $users->where($k, 'like', '%'.$i.'%');
            }
        }

        $users = $users->get();

        session()->flash('_old_input', $_POST);

        return view('users.search', [
            'list' => $users
        ]);
    }

    public function detailView(UserDetail $request)
    {
        $userId = $request->id;
        $userInfo = DB::table('users')->select(
            'id',
            'member_type',
            'name',
            'email',
            'phone_number',
            'email_verified_at',
            'birthday',
            'identity',
            'identity_date',
            'identity_place',
            'phone_number',
            'current_address',
            'regularly_address',
            'join_company_date',
            'company_staff_date',
            'role'
        )->where('id', '=', $userId)->get()[0];
        $userInfo->birthday = !empty($userInfo->birthday) ? date('Y-m-d', strtotime($userInfo->birthday)) : '';
        $userInfo->identity_date = !empty($userInfo->identity_date) ? date('Y-m-d', strtotime($userInfo->identity_date)) : '';
        $userInfo->join_company_date = !empty($userInfo->join_company_date) ? date('Y-m-d', strtotime($userInfo->join_company_date)) : '';
        $userInfo->company_staff_date = !empty($userInfo->company_staff_date) ? date('Y-m-d', strtotime($userInfo->company_staff_date)) : '';

        $member_types = DB::table('member_types')->select('id', 'name')->get();
        $data = [
            'userInfo' => $userInfo,
            'member_types' => $member_types
        ];

        return view('users.update', $data);
    }

    public function updateError()
    {
        return view('users.update');
    }

    public function update(UserUpdate $request)
    {
        $data = [
            'name' => $request->input('name'),
            'member_type' => $request->input('member_type'),
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
            'updated_at' => date(Config::get('constants.DATETIME_FORMAT_MYSQL'))
        ];
        DB::table('users')->where('id', $request->id)->update(
            $data
        );

        $userInfo = DB::table('users')->select(
            'id',
            'name',
            'member_type',
            'email',
            'phone_number',
            'email_verified_at',
            'birthday',
            'identity',
            'identity_date',
            'identity_place',
            'phone_number',
            'current_address',
            'regularly_address',
            'join_company_date',
            'company_staff_date',
            'role'
        )->where('id', '=', $request->id)->get()[0];
        $userInfo->birthday = !empty($userInfo->birthday) ? date('Y-m-d', strtotime($userInfo->birthday)) : '';
        $userInfo->identity_date = !empty($userInfo->identity_date) ? date('Y-m-d', strtotime($userInfo->identity_date)) : '';
        $userInfo->join_company_date = !empty($userInfo->join_company_date) ? date('Y-m-d', strtotime($userInfo->join_company_date)) : '';
        $userInfo->company_staff_date = !empty($userInfo->company_staff_date) ? date('Y-m-d', strtotime($userInfo->company_staff_date)) : '';

        $member_types = DB::table('member_types')->select('id', 'name')->get();
        $data = [
            'userInfo' => $userInfo,
            'member_types' => $member_types
        ];

        $request->session()->flash('success', 'Update has been completed.');
        return view('users.update', $data);
    }

    public function editPassword()
    {

        return view('users.password');
    }

    public function updatePassword(PasswordUpdate $request)
    {

        $userPassword = Auth::user()->password;

        if(Hash::check($request->oldPassword,$userPassword)){
            $data = [
                'password' => Hash::make($request->input('password')),
            ];
            DB::table('users')->where('id', Auth::user()->id)->update(
                $data
            );
            $request->session()->flash('success', 'Update has been completed.');
            return view('users.password');
        }else{
            $request->session()->flash('error', 'Old password is incorrect.');
            return view('users.password');
        }


    }

    public function logout(){
        Auth::logout();
    }
}
