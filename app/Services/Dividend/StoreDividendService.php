<?php

namespace App\Services\Dividend;

use App\Models\Dividend;
use App\Models\Portfolio;
use Illuminate\Database\Eloquent\Collection;

class StoreDividendService
{
    public function storeMultiple(Portfolio $portfolio, array $dividends): Collection
    {
        $createdDividends = new Collection();

        foreach ($dividends['dividends'] as $dividend) {
            $dividend['portfolio_id'] = $portfolio->id;
            $dividend['user_id'] = $portfolio->user_id;
            $createdDividends->push(Dividend::create($dividend));
        }

        return $createdDividends;
    }
}
