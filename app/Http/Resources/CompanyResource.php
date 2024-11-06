<?php

namespace App\Http\Resources;

use App\Models\Company;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
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
            'id' => !empty($this['id']) ? $this['id'] : null,
            'name' => $this['name'],
            'ticker' => $this['ticker'],
            'sector_id' => !empty($this['sector_id']) ? $this['sector_id'] : null,
            'industry_id' => !empty($this['industry_id']) ? $this['industry_id'] : null,
            'external' => $this->resource instanceof Company ? false : true,
        ];
    }
}
