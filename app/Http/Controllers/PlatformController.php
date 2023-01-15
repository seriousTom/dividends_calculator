<?php

namespace App\Http\Controllers;

use App\Http\Requests\Platform\CreatePlatformRequest;
use App\Http\Requests\Platform\EditPlatformRequest;
use App\Http\Resources\PlatformResource;
use App\Models\Platform;
use Illuminate\Http\Request;

class PlatformController extends Controller
{
    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $platforms = Platform::byUserId(auth()->id())->get();

        return PlatformResource::collection($platforms);
    }

    /**
     * @param CreatePlatformRequest $request
     * @return PlatformResource
     */
    public function store(CreatePlatformRequest $request)
    {
        $platform = Platform::create($request->validated());

        return new PlatformResource($platform);
    }

    /**
     * @param Platform $platform
     * @param EditPlatformRequest $request
     * @return PlatformResource
     */
    public function update(Platform $platform, EditPlatformRequest $request)
    {
        $platform->update($request->validated());

        return new PlatformResource($platform);
    }
}
