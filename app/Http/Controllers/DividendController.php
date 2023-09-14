<?php

namespace App\Http\Controllers;

use App\Http\Requests\Dividend\CreateDividendRequest;
use App\Http\Requests\Dividend\CreateMultipleDividendsRequest;
use App\Http\Resources\DividendResource;
use App\Models\Dividend;
use App\Models\Portfolio;
use App\Services\Dividend\StoreDividendService;

class DividendController extends Controller
{
    public function __construct(private StoreDividendService $storeDividendService)
    {

    }

    public function index(?Portfolio $portfolio = null)
    {
        $dividends = Dividend::byPortfolio($portfolio)->orderBy('created_at', 'desc')->paginate(10);

        return DividendResource::collection($dividends);
    }

    public function store(CreateDividendRequest $request)
    {
        $dividend = Dividend::create(array_merge([
            'user_id' => auth()->id()
        ], $request->validated()));

        return new DividendResource($dividend);
    }

    public function storeMultiple(Portfolio $portfolio, CreateMultipleDividendsRequest $request)
    {
        return DividendResource::collection($this->storeDividendService->storeMultiple($portfolio, $request->validated()));
    }

    public function update()
    {

    }

    public function delete(Dividend $dividend)
    {
        $this->authorize('delete', $dividend);

        $dividend->delete();

        return response()->json(['success' => true, 'message' => 'Deleted']);
    }
}
