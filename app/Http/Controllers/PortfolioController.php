<?php

namespace App\Http\Controllers;

use App\Http\Requests\Portfolio\CreatePortfolioRequest;
use App\Http\Resources\PortfolioResource;
use App\Models\Portfolio;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    public function index()
    {
        $portfolios = Portfolio::byUserId(auth()->id())->get();

        return PortfolioResource::collection($portfolios);
    }

    public function store(CreatePortfolioRequest $request)
    {
        $portfolio = Portfolio::create($request->validated());

        return new PortfolioResource($portfolio);
    }
}
