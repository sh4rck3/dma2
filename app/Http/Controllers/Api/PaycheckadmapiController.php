<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\UserResource;
use App\Models\Paymentxml;
use App\Http\Resources\PaymentxmlResource;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Shipping_payments;

class PaycheckadmapiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      
        $users = User::select('users.*', 'paymentxmls.status as paymentstatus', 'paymentxmls.id as paymentid')
        ->join('paymentxmls', function($join)
        {
            $join->on('paymentxmls.cpf', 'users.document');
                //->where('paymentxmls.status', '!=', NULL);
        })
        ->when(request('search_id'), function ($query) {
            $query->where('users.id', request('search_id'));
        })
            ->when(request('search_global'), function ($query) {
                $query->where(function($q) {
                    $q->where('users.name', 'like', '%'.request('search_global').'%')
                        ->orWhere('users.jobtitle', 'like', '%'.request('search_global').'%');

                });
            })
            ->where('users.status', '!=', '0')
            ->orderBy('paymentxmls.id', 'desc')
            ->paginate(10);

            //return response()->json($users);
            return UserResource::collection($users);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function paymentmesref()
    {
        $payments = Shipping_payments::all();

        return response()->json($payments);


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
    public function show(string $id)
    {
        //
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
