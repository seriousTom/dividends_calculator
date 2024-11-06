<?php

namespace App\Services\Company;

use App\Models\Company;
use App\Services\Api\CompanyApiService;
use Illuminate\Database\Eloquent\Collection;

class SearchCompanyService
{
    public function __construct(
        private CompanyApiService $companyApiService
    )
    {
    }

    public function searchCompanies(string $keyword): Collection
    {
        $companies = Company::byRequest(['name' => $keyword])->orderBy('name', 'asc')->limit(10)->get();
        if ($companies->count() > 0) {
            return $companies;
        }

        return $this->searchExternalApi($keyword);
    }

    public function searchExternalApi(string $keyword): Collection
    {
        $result = $this->companyApiService->searchCompanies($keyword);
        $companies = new Collection();

        if(!$result['success']) {
            return $companies;
        }

        foreach($result['data']['bestMatches'] as $company) {
            $companies->push([
                'name' => $company['2. name'],
                'ticker' => $company['1. symbol']
            ]);
        }

        return $companies;
    }
}
