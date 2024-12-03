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
                $this->createCompanyService->storeCompany($dividend['company'], $portfolio->user_id);
            }
            $dividend['portfolio_id'] = $portfolio->id;
            $dividend['user_id'] = $portfolio->user_id;
            $createdDividends->push(Dividend::create($dividend));
        }

        return $createdDividends;
    }
}
