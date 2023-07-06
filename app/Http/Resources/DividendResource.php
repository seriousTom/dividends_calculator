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
            'company_id' => $this->company_id,
            'date' => $this->date
        ];
    }
}
