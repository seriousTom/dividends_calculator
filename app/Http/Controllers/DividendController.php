<?php

namespace App\Http\Controllers;

use App\Http\Requests\Dividend\CreateDividendRequest;
use App\Http\Resources\DividendResource;
use App\Models\Dividend;

class DividendController extends Controller
{
    public function store(CreateDividendRequest $request)
    {
        $dividend = Dividend::create(array_merge([
            'user_id' => auth()->id()
        ], $request->validated()));

        return new DividendResource($dividend);
    }
}
