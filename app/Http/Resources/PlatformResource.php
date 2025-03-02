<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PlatformResource extends JsonResource
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
            'file_path' => !empty($this->file_example_path) ? asset('examples/' . $this->file_example_path) : null,
            'file_name' => !empty($this->file_example_path) ? basename($this->file_example_path) : null
        ];
    }
}
