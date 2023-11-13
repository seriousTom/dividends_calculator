<?php

namespace App\Http\Controllers;

use App\Services\Statistic\StatisticService;
use Illuminate\Http\Request;

class StatisticController extends Controller
{
    public function __construct(Private StatisticService $statisticService)
    {
    }

    public function show(Request $request)
    {
        return response()->json($this->statisticService->getStatistic(auth()->user(), $request->year, $request->portfolio_id, $request->company_id));
    }
}
