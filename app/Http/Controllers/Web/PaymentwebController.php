<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Paymentxml;
use Faker\Provider\ar_EG\Payment;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PaymentwebController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Payment/Paymentindex');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //return 'ok';
        return Inertia::render('Payment/Paymentimport');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        return Inertia::render('Payment/Paymentresult');
    }

    public function paymentshow($id)
    {
        //return 'ok'.$id;
        return Inertia::render('Payment/Paymentshow', [
            'dataPaymentsid' => $id,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
