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

    public function create(array $attributes)
    {
        $this->company->fill($attributes);
        $this->company->save();
    }
}
