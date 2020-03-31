<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CustomersRegist;
use App\Http\Requests\CustomersSearch;
use App\Http\Requests\CustomersDetail;
use App\Http\Requests\CustomersUpdate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class CustomersController extends Controller
{
    public function registView()
    {
        return view('customers.regist');
    }

    public function regist(CustomersRegist $request)
    {
        $data = [
            'name' => $request->input('name'),
            'created_at' => date(Config::get('constants.DATETIME_FORMAT_MYSQL')),
            'updated_at' => date(Config::get('constants.DATETIME_FORMAT_MYSQL'))
        ];
        DB::table('customers')->insert(
            $data
        );

        return redirect('customers/regist')->with('success', 'Registration has been completed.');
    }
    
    public function searchView()
    {
        return view('customers.search');
    }

    public function search(CustomersSearch $request)
    {
        $searchData = [
            'name' => $request->input('name'),
        ];
        $customers = DB::table('customers');
        foreach ($searchData as $k => $i) {
            if ($i !== null) {
                $customers->where($k, $i);
            }
        }

        $customers = $customers->get();

        return view('customers.search', [
            'list' => $customers
        ]);
    }
        
    public function detailView(CustomersDetail $request)
    {

        $userId = $request->id;
        $customerInfo = DB::table('customers')->select(
            'id',
            'name',
        )->where('id', '=', $userId)->get()[0];
        
        return view('customers.update', [
            'customerInfo' => $customerInfo
        ]);
    }
    
    public function updateError()
    {   
        return view('customers.update');
    }
        
    public function update(CustomersUpdate $request)
    {
        $data = [
            'name' => $request->input('name'),
            'updated_at' => date(Config::get('constants.DATETIME_FORMAT_MYSQL'))
        ];
        DB::table('customers')->where('id', $request->id)->update(
            $data
        );

        $customerInfo = DB::table('customers')->select(
            'id',
            'name',
        )->where('id', '=', $request->id)->get()[0];

        $request->session()->flash('success', 'Update has been completed.');
        return view('customers.update', [
            'customerInfo' => $customerInfo
        ]);
    }
}
