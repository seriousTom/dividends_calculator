<?php

namespace App\Services\Statistic;

use App\Helpers\GeneralHelper;
use App\Models\Company;
use App\Models\Dividend;
use App\Models\User;
use Carbon\Carbon;

class StatisticService
{
    public function getStatistic(?User $user = null, ?int $year = null, ?int $portfolioId = null, ?int $companyId = null): array
    {
        if (empty($year)) {
            $year = Carbon::now()->year;
        }

        if (empty($user)) {
            $user = auth()->user();
        }

        return [
            'year' => $year,
            'oldest_year' => $this->getOldestYear(),
            'all_time_total_dividends_received' => $this->getTotalDividendsReceived(),
            'all_time_most_dividends_received_from_company' => $this->getCompanyWithMostDividendsReceived($user->id),
            'monthly_dividends' => $this->getMonthlyDividends($user->id, $year, $portfolioId, $companyId)
        ];
    }

    public function getOldestYear(): int
    {
        $dividend = Dividend::orderBy('date', 'asc')->first();
        if (!$dividend) {
            return Carbon::now()->year;
        }
        return Carbon::parse($dividend->date)->year;
    }

    public function getTotalDividendsReceived()
    {
        return Dividend::sum('amount');
    }

    public function getCompanyWithMostDividendsReceived(int $userId)
    {
        return Company::withDividendSum($userId)->orderBy('dividends_sum', 'desc')->first();
    }

    public function getMonthlyDividends(int $userId, ?int $year = null, ?int $portfolioId = null, ?int $companyId = null)
    {
        $dividends = Dividend::byFilters([
            'user_id' => $userId,
            'year' => $year,
            'portfolio_id' => $portfolioId,
            'company_id' => $companyId
        ])->orderBy('date', 'asc')->get();

        $statistic = $this->monthlyStatisticArray();

        foreach ($dividends as $dividend) {
            $month = date('n', strtotime($dividend->date));

            $statistic[$month]['amount'] += $dividend->amount;
            $statistic[$month]['taxes_amount'] += $dividend->taxes_amount;
            $statistic[$month]['amount_after_taxes'] += $dividend->amount_after_taxes;
        }

        return $statistic;
    }

    private function monthlyStatisticArray()
    {
        $statistic = [];

        for($i = 1; $i <= 12; $i++) {
            $statistic[$i] = [
                'month' => $i,
                'month_string' => GeneralHelper::monthString($i),
                'amount' => 0,
                'taxes_amount' => 0,
                'amount_after_taxes' => 0
            ];
        }

        return $statistic;
    }
}
