<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PortfolioResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'user' => new UserResource($this->whenLoaded('user')),
            'platform' => new PlatformResource($this->whenLoaded('platform')),
            'created_at' => $this->created_at->format('Y-m-d'),
            'updated_at' => $this->updated ? $this->updated_at->format('Y-m-d') : null,
        ];
    }
}
