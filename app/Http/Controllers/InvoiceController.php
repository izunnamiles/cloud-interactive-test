<?php

namespace App\Http\Controllers;

use App\Http\Resources\InvoiceResource;
use App\Invoice;
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
        //
        $ref = 'REF'.time();
        $taxed = $this->calculateTax($request->invoice_amount);

        $invoice = new Invoice;
        $invoice->invoice_name = $request->invoice_name;
        $invoice->invoice_amount = $request->invoice_amount;
        $invoice->amount_taxed = $taxed;
        $invoice->reference = $ref;
        $invoice->save();

        return response([
            'status' => 200,
            'message' => "new record added"
        ]);

    }

    private function calculateTax($amount)
    {
        $tax = 0.05;
        $deduct = $amount * $tax;
        return $deduct;
    }

}
