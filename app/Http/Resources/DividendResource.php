<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DividendResource extends JsonResource
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
            'amount' => $this->amount,
            'taxes_amount' => $this->taxes_amount,
            'amount_after_taxes' => $this->amount - $this->taxes_amount,
            'currency' => new CurrencyResource($this->currency),
            'date' => $this->date,
            'portfolio_id' => $this->portfolio_id,
            'company' => new CompanyResource($this->company),
            'portfolio' => new PortfolioResource($this->whenLoaded($this->portfolio))
        ];
    }
}
