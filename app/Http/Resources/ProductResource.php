<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'product_name' => $this->name,
            'price' => $this->price,
            'quantity_bought' => $this->quantity,
            'total'=> $this->price * $this->quantity
        ];
    }
}
