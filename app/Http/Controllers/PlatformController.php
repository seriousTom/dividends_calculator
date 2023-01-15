<?php

namespace App\Http\Controllers;

use App\Http\Requests\Platform\CreatePlatformRequest;
use App\Http\Resources\PlatformResource;
use App\Models\Platform;
use Illuminate\Http\Request;

class PlatformController extends Controller
{
    public function store(CreatePlatformRequest $request)
    {
        $platform = Platform::create($request->validated());

        return new PlatformResource($platform);
    }
}
