<?php

namespace App\Repositories;

use App\Models\Company;
use Illuminate\Support\Facades\DB;

class CompanyRepository
{

    protected $company;

    public function __construct(Company $company)
    {
        $this->company = $company;
    }

    public function search(array $param)
    {
        $company = DB::table('companies');
        if (!empty($param['name']))
            $company->where('name', 'LIKE', '%' . $param['name'] . '%');
        if (!empty($param['phone']))
            $company->where('phone', '=', $param['phone']);
        if (!empty($param['address']))
            $company->where('address', 'LIKE', '%' . $param['address'] . '%');
        if (!empty($param['email']))
            $company->where('email', '=', $param['email']);
        return $company->get()->toArray();
    }

    public function create(array $attributes)
    {
        $this->company->fill($attributes);
        $this->company->save();
    }
}
