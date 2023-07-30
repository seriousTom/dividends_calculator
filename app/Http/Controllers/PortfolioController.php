<?php

namespace App\Http\Controllers;

use App\Http\Requests\Portfolio\CreatePortfolioRequest;
use App\Http\Requests\Portfolio\EditPortfolioRequest;
use App\Http\Resources\DividendResource;
use App\Http\Resources\PortfolioResource;
use App\Models\Dividend;
use App\Models\Portfolio;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    public function index(Request $request)
    {
        $portfolios = Portfolio::with('platform')->get();

        return PortfolioResource::collection($portfolios);
    }

    public function show(Portfolio $portfolio)
    {
        $this->authorize('show', $portfolio);

        return new PortfolioResource($portfolio);
    }

    public function store(CreatePortfolioRequest $request)
    {
        $portfolio = Portfolio::create($request->validated());

        return new PortfolioResource($portfolio);
    }

    public function update(Portfolio $portfolio, EditPortfolioRequest $request)
    {
        $portfolio->update($request->validated());

        return new PortfolioResource($portfolio);
    }

    public function delete(Portfolio $portfolio)
    {
        $this->authorize('delete', $portfolio);

        $portfolio->delete();

        return response()->json(['success' => true, 'message' => 'Deleted']);
    }
}
