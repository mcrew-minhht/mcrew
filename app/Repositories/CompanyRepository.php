<?php

namespace App\Repositories;

use App\Models\Company;

class CompanyRepository
{

    protected $company;

    public function __construct(Company $company)
    {
        $this->company = $company;
    }

    public function search(array $param)
    {
        $com = $this->company->newQuery();
        if (!empty($param['name']))
            $com->where('name', 'LIKE', '%' . $param['name'] . '%');
        if (!empty($param['phone']))
            $com->where('phone', '=', $param['phone']);
        if (!empty($param['address']))
            $com->where('address', 'LIKE', '%' . $param['address'] . '%');
        if (!empty($param['email']))
            $com->where('email', '=', $param['email']);
        return $com->get()->toArray();
    }

    public function create(array $attributes)
    {
        $this->company->fill($attributes);
        $this->company->save();
    }
}
