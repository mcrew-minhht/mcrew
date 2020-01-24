<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Repositories\CompanyRepository;
use Illuminate\Support\Facades\Config;

class CompanyService
{
    protected $companyRepository;

    public function __construct(CompanyRepository $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    public function search(Request $request)
    {
        $request->flash();
        $param['name'] = $request->input('name');
        $param['phone'] = $request->input('phone');
        $param['address'] = $request->input('address');
        $param['email'] = $request->input('email');
        return $this->companyRepository->search($param);
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required'
        ]);

        $attributes['name'] = $request->input('name');
        $attributes['phone'] = $request->input('phone');
        $attributes['address'] = $request->input('address');
        $attributes['email'] = $request->input('email');
        $attributes['bank_name'] = $request->input('bank_name');
        $attributes['bank_number'] = $request->input('bank_number');
        $attributes['bank_account_name'] = $request->input('bank_account_name');
        $attributes['created_at'] = date(Config::get('constants.DATETIME_FORMAT_MYSQL'));
        $attributes['updated_at'] = date(Config::get('constants.DATETIME_FORMAT_MYSQL'));

        $this->companyRepository->create($attributes);
    }
}
