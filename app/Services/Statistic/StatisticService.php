<?php

namespace App\Services\Statistic;

use App\Helpers\GeneralHelper;
use App\Models\Company;
use App\Models\Dividend;
use App\Models\User;
use Carbon\Carbon;

class StatisticService
{
    //todo: implement currency conversion. As for now works only with dollars or at least with the same currency

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
            'total_dividends_received_in_year' => $this->getTotalDividendsReceivedInYear($year),
            'all_time_most_dividends_received_from_company' => $this->getCompanyWithMostDividendsReceived($user->id),
            'most_dividends_received_from_company_in_year' => $this->getCompanyWithMostDividendsReceivedInYear($user->id, $year),
            'monthly_dividends' => $this->getMonthlyDividends($user->id, $year, $portfolioId, $companyId),
            'quarter_dividends' => $this->getQuarterDividends($user->id, $year, $portfolioId)
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

    public function getTotalDividendsReceived(): float
    {
        return Dividend::sum('amount');
    }

    public function getTotalDividendsReceivedInYear(int $year): float
    {
        return Dividend::whereYear('date', $year)->sum('amount');
    }

    public function getCompanyWithMostDividendsReceived(int $userId)
    {
        return Company::withDividendSum($userId)->orderBy('dividends_sum', 'desc')->first();
    }

    public function getCompanyWithMostDividendsReceivedInYear(int $userId, int $year)
    {
        return Company::withDividendSum($userId, $year)->orderBy('dividends_sum', 'desc')->first();
    }

    public function getMonthlyDividends(int $userId, int $year, ?int $portfolioId = null, ?int $companyId = null): array
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

    private function monthlyStatisticArray(): array
    {
        $statistic = [];

        for($i = 1; $i <= 12; $i++) {
            $statistic[$i] = [
                'month' => $i,
                'label' => GeneralHelper::monthString($i),
                'amount' => 0,
                'taxes_amount' => 0,
                'amount_after_taxes' => 0
            ];
        }

        return $statistic;
    }

    public function getQuarterDividends(int $userId, int $year, ?int $portfolioId): array
    {
        $statistics = [
            '1' => [
                'label' => '1 Quarter',
                'amount' => 0,
                'taxes_amount' => 0,
                'amount_after_taxes' => 0
            ],
            '2' => [
                'label' => '2 Quarter',
                'amount' => 0,
                'taxes_amount' => 0,
                'amount_after_taxes' => 0
            ],
            '3' => [
                'label' => '3 Quarter',
                'amount' => 0,
                'taxes_amount' => 0,
                'amount_after_taxes' => 0
            ],
            '4' => [
                'label' => '4 Quarter',
                'amount' => 0,
                'taxes_amount' => 0,
                'amount_after_taxes' => 0
            ],
        ];

        for($quarter = 1; $quarter <= 4; $quarter++) {
            $startMonth = ($quarter - 1) * 3 + 1;
            $endMonth = $quarter * 3;

            $dividends = Dividend::byFilters([
                'year' => $year,
                'start_month' => $startMonth,
                'end_month' => $endMonth,
                'user_id' => $userId,
                'portfolio_id' => $portfolioId
            ])->get();

            foreach ($dividends as $dividend) {
                $statistics[$quarter]['amount'] += $dividend->amount;
                $statistics[$quarter]['taxes_amount'] += $dividend->taxes_amount;
                $statistics[$quarter]['amount_after_taxes'] += $dividend->amount_after_taxes;
            }
        }

        return $statistics;
    }
}
