<?php

namespace App\Http\Controllers;

use App\Http\Resources\{InvoiceResource,ProductResource};
use App\{Invoice,Product};
use App\Http\Requests\InvoiceRequest;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoice = Invoice::all();
        return response()->json([
          'invoice_count' => $invoice->count(),
          'total_invoice_amount' => '$'.$invoice->sum('invoice_amount'),
          'data' => InvoiceResource::collection($invoice), 
        ],200);
    }

    public function store(InvoiceRequest $request)
    {
        $ref = 'REF'.time();
        $total = $this->calcTotal($request->data);
        $taxed = $this->calculateTax($total);

        $invoice = new Invoice;
        $invoice->invoice_name = $request->data['invoice_name'];
        $invoice->invoice_number = $request->data['invoice_number'];
        $invoice->invoice_amount = $total;
        $invoice->amount_taxed = $taxed;
        $invoice->reference = $ref;
        $invoice->save();

        foreach($request->data['products'] as $product){
            Product::create([
                'invoice_id' => $invoice->id,
                'name' => $product['product_name'],
                'price' => $product['price'],
                'quantity' => $product['quantity']

            ]);
        }

        return response([
            'status' => 200,
            'message' => "new record added"
        ]);

    }
    public function displayProducts(Invoice $invoice)
    {
        return ProductResource::collection($invoice->products);
    }

    private function calculateTax($amount)
    {
        $tax = 0.05;
        $deduct = $amount * $tax;
        return $deduct;
    }

    private function calcTotal(array $data)
    {
        foreach($data['products'] as $amount ){
            $total[]= $amount['price'] * $amount['quantity'];
        }

        return array_sum($total);
    }

}
