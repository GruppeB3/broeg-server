<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BrewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => ($this->local_id != null) ? $this->local_id : 0,
            'user_id' => $this->user_id,
            'name' => $this->name,
            'grind_size' => $this->grind_size,
            'brewing_temperature' => $this->brewing_temperature,
            'ground_coffee_amount' => $this->ground_coffee_amount,
            'bloom_water_amount' => $this->bloom_water_amount,
            'coffee_water_ratio' => $this->coffee_water_ratio,
            'bloom_time' => $this->bloom_time,
            'total_brew_time' => $this->total_brew_time,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
