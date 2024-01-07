<?php

namespace App\Http\Controllers;

use App\Http\Requests\Dividend\CreateDividendRequest;
use App\Http\Requests\Dividend\CreateMultipleDividendsRequest;
use App\Http\Requests\Dividend\EditDividendRequest;
use App\Http\Requests\Dividend\FetchDividendsRequest;
use App\Http\Resources\DividendResource;
use App\Models\Dividend;
use App\Models\Portfolio;
use App\Services\Dividend\StoreDividendService;
use Illuminate\Http\Request;

class DividendController extends Controller
{
    public function __construct(private StoreDividendService $storeDividendService)
    {

    }

    public function index(?Portfolio $portfolio = null, FetchDividendsRequest $fetchDividendsRequest)
    {
        $dividends = Dividend::byFilters(array_merge(['portfolio_id' => $portfolio->id], $fetchDividendsRequest->validated()))->paginate(10);
//        $dividends = Dividend::byPortfolio($portfolio, $fetchDividendsRequest->validated())->orderBy('created_at', 'desc')->paginate(10);

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

    public function update(Dividend $dividend, EditDividendRequest $request)
    {
        $dividend->update($request->validated());

        return new DividendResource($dividend);
    }

    public function delete(Dividend $dividend)
    {
        $this->authorize('delete', $dividend);

        $dividend->delete();

        return response()->json(['success' => true, 'message' => 'Deleted']);
    }
}
