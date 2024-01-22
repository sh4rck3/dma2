<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Legal;
use App\Http\Resources\LegalResource;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class LegalapiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       
         $legals = Legal::select('legals.*', 'users.name as username')
             ->join('users', 'users.id', '=', 'legals.user_id')
             ->when(request('search_global'), function ($query) {
                 $query->where(function($q) {
                     $q->where('title', 'like', '%'.request('search_global').'%');
 
                 });
             })
             ->orderBy('id', 'desc')
             ->paginate(10);
 
             return LegalResource::collection($legals);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $userLogado = auth()->user();

        $legalticket = new Legal();
        $legalticket->user_id = $userLogado->id;
        $legalticket->title = $request->title;
        $legalticket->status = $request->selected;
        $legalticket->description = $request->description;
        $legalticket->file =  $request->nameFile;
        $legalticket->path = $request->file->store('public/uploads');
        $legalticket->original_name = $request->file->getClientOriginalName();
        $legalticket->save();

        return response()->json([
            'status' => true,
            'title' => 'Sucesso',
            'message' => 'Adicionado a fila de iniciais!',
            'returnData' => '0'
        ], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
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
