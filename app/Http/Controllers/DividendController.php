<?php

namespace App\Http\Controllers;

use App\Http\Requests\Dividend\CreateDividendRequest;
use App\Http\Resources\DividendResource;
use App\Models\Dividend;
use App\Models\Portfolio;

class DividendController extends Controller
{
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

    public function update()
    {

    }
}
