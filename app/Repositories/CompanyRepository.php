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

    public function create($attributes)
    {
        return $this->company->create($attributes);
    }
}
