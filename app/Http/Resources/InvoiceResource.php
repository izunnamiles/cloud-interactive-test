<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
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
            'invoice_name' => $this->invoice_name,
            'invoice_number' => $this->invoice_number,
            'invoice_amount' => $this->invoice_amount,
            'amount_taxed' => $this->amount_taxed,
            'reference' => $this->reference,
            'date_added' => date('Y-m-d', strtotime($this->created_at)),
            'link' => [
                'products' => route('products.index',$this->id),
            ]
        ];
    }
}
