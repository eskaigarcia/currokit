<?php

namespace App\Observers;

use App\Models\Company;

class CompanyObserver
{
    public function deleted(Company $company): void
    {
        $company->sponsoredContent()->update(['sponsor_id' => null]);
    }
}
