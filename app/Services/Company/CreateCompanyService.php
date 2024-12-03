<?php

namespace App\Services\Company;

use App\Models\Company;
use App\Models\Industry;
use App\Models\Sector;
use App\Services\Api\CompanyApiService;

class CreateCompanyService
{
    public function __construct(private CompanyApiService $companyApiService)
    {
    }

    public function storeCompany(array $company, int $userId): Company
    {
        $company = Company::firstOrCreate([
            'user_id' => $userId,
            'ticker' => $company['ticker']
        ], [
            'name' => $company['name']
        ]);

        $result = $this->storeCompanySectorAndIndustry($company->ticker);
        if($result['success']) {
            $company->update([
                'sector_id' => $result['sector']->id,
                'industry_id' => $result['industry']->id
            ]);
        }

        return $company;
    }

    public function storeCompanySectorAndIndustry(string $ticker): array
    {
        $data = $this->companyApiService->getCompanyData($ticker);

        if(!$data['success']) {
            return ['success' => false, 'message' => __('Couldn`t fetch company data from API')];
        }

        $sector = Sector::firstOrCreate([
            'name' => $data['data']['Sector']
        ]);

        $industry = Industry::firstOrCreate([
            'name' => $data['data']['Industry'],
            'sector_id' => $sector->id
        ]);

        return ['success' => true, 'sector' => $sector, 'industry' => $industry];
    }
}
