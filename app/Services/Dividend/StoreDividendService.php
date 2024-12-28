<?php

namespace App\Services\Dividend;

use App\Models\Dividend;
use App\Models\Portfolio;
use App\Services\Company\CreateCompanyService;
use Illuminate\Database\Eloquent\Collection;

class StoreDividendService
{
    public function __construct(private CreateCompanyService $createCompanyService)
    {
    }

    public function storeMultiple(Portfolio $portfolio, array $dividends): Collection
    {
        $createdDividends = new Collection();

        foreach ($dividends['dividends'] as $dividend) {
            if($dividend['company']['external']) {
                $company = $this->createCompanyService->storeCompany($dividend['company'], $portfolio->user_id);
                $dividend['company']['id'] = $company->id;
            }
            $dividend['portfolio_id'] = $portfolio->id;
            $dividend['user_id'] = $portfolio->user_id;
            $dividend['company_id'] = $dividend['company']['id'];
            $createdDividends->push(Dividend::create($dividend));
        }

        return $createdDividends;
    }
}
