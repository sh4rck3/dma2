<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Financial;
use App\Models\Filecsv;
use App\Imports\FinancialImport;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class FinancialapiController extends Controller
{
    /**
     * Criado por Luccas Woiciechoski
     * email: sh4rck3@gmail.com
     */
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $financials = Financial::when($request->name, function($query) use ($request) {
            return $query->where('num_gcpj', 'like', "%{$request->name}%");
        })->orderBy('num_remessa', 'desc')
          ->paginate(15);

        $financialsSum = Financial::when($request->name, function($query) use ($request) {
            return $query->where('num_gcpj', 'like', "%{$request->name}%");
        })->orderBy('num_remessa', 'desc')                 
            ->sum('valor');
            
        return response()->json([
            'financials' => $financials,
            'financialsSum' => $financialsSum
        ], Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $csv_file = new Filecsv();
        $csv_file->title = $request->title;
        $csv_file->description = $request->description;
        $csv_file->csv_file = $request->file->store('public/uploads');
        $csv_file->original_name = $request->file->getClientOriginalName();
        $csv_file->save();
        //$csv_file = $csv_file->id;

        Log::debug("File path \r\n" . $request->file('file'));
        $file = $request->file('file');

        Excel::import(new FinancialImport, $file);

        return response()->json([
            'status' => true,
            'title' => $request->file->getClientOriginalName(),
            'message' => 'Importado com sucesso!',
            //'returnData' => $data
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
        $financial = Financial::where('num_remessa', $id)->get();
        if($financial->count() == 0) {
            return response()->json([
                'status' => false,
                'title' => 'Erro',
                'message' => 'Não existe remessa!',
                //'returnData' => $data
            ], Response::HTTP_OK);
        }else{
            $financial = Financial::where('num_remessa', $id);
            $financial->delete();
            return response()->json([
                'status' => true,
                'title' => 'Apagado',
                'message' => 'Removido com sucesso!',
            ], Response::HTTP_OK);
        }
       
       
    }
}
