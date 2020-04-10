<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyUpdate;
use App\Services\CompanyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{
    protected $companyService;

    public function __construct(CompanyService $companyService)
    {
        $this->companyService = $companyService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('companies.list');
    }

    /**
     * Search company with condition
     * @param $request
     * @return
     */
    public function search(Request $request)
    {
        $lists = $this->companyService->search($request);
        return view('companies.list', [
            'lists' => $lists
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('companies.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request
     * @return any
     */
    public function store(Request $request)
    {
        $this->companyService->create($request);

        return redirect('companies/regist')->with('success', 'Registration has been completed.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function detailView($id)
    {
        $company = DB::table('companies')->select(
            'id',
            'name',
            'phone',
            'address',
            'email',
            'bank_name',
            'bank_number',
            'bank_account_name'
        )->where('id', '=', $id)->get()[0];

        return view('companies.update', [
            'company' => $company
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CompanyUpdate $request)
    {
        $data = [
            'name' => $request->input('name'),
            'phone' => $request->input('name'),
            'address' => $request->input('name'),
            'email' => $request->input('name'),
            'bank_name' => $request->input('name'),
            'bank_number' => $request->input('name'),
            'bank_account_name' => $request->input('name'),
            'updated_at' => date(Config::get('constants.DATETIME_FORMAT_MYSQL'))
        ];

        DB::table('companies')->where('id', $request->id)->update(
            $data
        );

        $request->session()->flash('success', 'Update has been completed.');

        return redirect()->route('detailCompany', ['id' => $request->id]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

}
