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
          'total_invoice_amount' => $invoice->sum('invoice_amount'),
          'data' => InvoiceResource::collection($invoice), 
        ],200);
    }

    public function store(InvoiceRequest $request)
    {
        //
        $taxed = $this->calculateTax($request->invoice_amount);

        $invoice = new Invoice;
        $invoice->invoice = $request->invoice;
        $invoice->invoice_amount = $request->invoice_amount;
        $invoice->invoice = $taxed;
        $invoice->save();

        return InvoiceResource::collection($invoice);

    }

    private function calculateTax($amount){
        $tax = 0.05;
        $deduct = $amount * $tax;
        return $deduct;
    }

}
