<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
//use App\Http\Controllers\Api\Controller;
use Illuminate\Http\Request;
use App\Models\Paymentxml;
use App\Models\Paymentxmladditional;
use App\Models\Shipping_payments;
use Carbon\Carbon;
use Faker\Provider\ar_EG\Payment;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class PaymentapiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payments = Paymentxml::select('mesRef')->groupBy('mesRef')->get()->pluck('mesRef')->all();
        //$payments->orderBy();
        return response()->json([
            'payments' => $payments,
        ], Response::HTTP_OK);
    }


    public function paymentuser()
    {
        $userLogged = Auth::user();
        Log::info("cpf usuario logado ->>>>>>> \r\n".$userLogged->id);
        $payments = Paymentxml::where('cpf', $userLogged->document)->get();
        return response()->json([
            'payments' => $payments,
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
    //public function store(Request $request)
    public function store(Request $request)
    {
        //Log::debug("aki->>>>>>> \r\n".$_FILES['file']['tmp_name']);
        //return dd($request->headers->get('Content-Type'));
        // $uploaded_files = $request->file->store('public/uploads');
        // return ["result" => $uploaded_files];

        $xml_file = new Shipping_payments();
        $xml_file->title = $request->title;
        $xml_file->description = $request->description;
        $xml_file->xml_file = $request->file->store('public/uploads');
        $xml_file->original_name = $request->file->getClientOriginalName();
        $xml_file->save();
        $payment_shipping_id = $xml_file->id;
        if(is_numeric($xml_file->id))
        {
             $xmlfile = file_get_contents($_FILES['file']['tmp_name']);
             $new = simplexml_load_string($xmlfile);
             $newArr = json_decode(json_encode($new), TRUE);

            Log::info(print_r($newArr, true));

            // if(array_key_exists(0, $newArr["FormattedAreaPair"]["FormattedAreaPair"]["FormattedArea"]["FormattedSections"]["FormattedSection"]["FormattedReportObjects"]["FormattedReportObject"]) == True)
            // {
            //     $formateObjectReport = $newArr["FormattedAreaPair"]["FormattedAreaPair"]["FormattedArea"]["FormattedSections"]["FormattedSection"]["FormattedReportObjects"]["FormattedReportObject"];
            //     foreach ($formateObjectReport as $sessoes) {
            //        $array = $sessoes["FormattedAreaPair"]["FormattedAreaPair"]["FormattedAreaPair"]["FormattedAreaPair"]["FormattedAreaPair"]["FormattedAreaPair"];
            //        foreach ($array as $dados) {
            //         if ($dempresa["ObjectName"] == "Text1"){
            //             //$recibo = $this->verificarsearray($dempresa["FormattedValue"]);
            //             $recibo = 'Recibo de Pagamento';
            //             Log::info("recibo ->>>>>>> \r\n".$recibo);
            //         }
            //        } 
                    
            //     }
                
            // }

            

           

        }    
    }

    public function storeOLD(Request $request)
    {
        //Log::debug("aki->>>>>>> \r\n".$_FILES['file']['tmp_name']);
        //return dd($request->headers->get('Content-Type'));
        // $uploaded_files = $request->file->store('public/uploads');
        // return ["result" => $uploaded_files];

        $xml_file = new Shipping_payments();
        $xml_file->title = $request->title;
        $xml_file->description = $request->description;
        $xml_file->xml_file = $request->file->store('public/uploads');
        $xml_file->original_name = $request->file->getClientOriginalName();
        $xml_file->save();
        $payment_shipping_id = $xml_file->id;
        if(is_numeric($xml_file->id))
        {
            $xmlfile = file_get_contents($_FILES['file']['tmp_name']);
            $new = simplexml_load_string($xmlfile);

            Log::info("enviando dd do arquivo" . $xmlfile);

            return response()->json([
                'status' => true,
                'title' => 'Eiii!',
                'message' => 'Salvo com sucesso!',
            ], Response::HTTP_OK);
            
         }
    }

     //funcoes do olerite inicio

    function verificarsearray($array)
    {
        if (is_array($array) == False){
            return $array;
        }else{
            return "";
        }
    }

    function insertdados($cpf, $mesRef, $recibo, $empresa, $setor, $endereco, $cnpj, $funcionario, $dataadm, $ferias, $valorTC, $valorTD, $valorTL, $valorFa, $mensagemc1,$valorFGTS, $valorBaseIRRF, $valorBaseINNS, $valorSalarioBase, $valorBaseFGTS, $payment_shipping_id)
    {
        $linha = Paymentxml::where('cpf', $cpf)->where('mesRef', $mesRef)->first();
        if(!empty($linha)){
            
                $userLogged = Auth::user();
                $insert_xmldb = Paymentxml::find($linha->id);
                $insert_xmldb->update([
                    'user_id' => $userLogged->id,
                    'payment_shipping' => $payment_shipping_id,
                    'cpf' => $cpf,
                    'mes_ref' => $mesRef,
                    'recibo' => $recibo,
                    'empresa' => $empresa,
                    'setor' => $setor,
                    'endereco' => $endereco,
                    'cnpj' => $cnpj,
                    'funcionario' => $funcionario,
                    'dataadm' => $dataadm,
                    'ferias' => $ferias,
                    'valorTC' => $valorTC,
                    'valorTD' => $valorTD,
                    'valorTL' => $valorTL,
                    'valorFa' => $valorFa,
                    'mensagemc1' => $mensagemc1,
                    'valorFGTS' => $valorFGTS,
                    'valorBaseIRRF' => $valorBaseIRRF,
                    'valorBaseINNS' => $valorBaseINNS,
                    'valorSalarioBase' => $valorSalarioBase,
                    'valorBaseFGTS' => $valorBaseFGTS,
                ]);

                Paymentxmladditional::where('id_paymentxmls', $linha->id)->where('aditional_cpf', $linha->cpf)->delete();
                return $linha->id . '=' .$linha->cpf;
        }else{
                $userLogged = Auth::user();
                $insert_xmldb = new Paymentxml();
                $insert_xmldb->user_id = $userLogged->id;
                $insert_xmldb->payment_shipping = $payment_shipping_id;
                $insert_xmldb->cpf = $cpf;
                $insert_xmldb->mesRef = $mesRef;
                $insert_xmldb->recibo = $recibo;
                $insert_xmldb->empresa = $empresa;
                $insert_xmldb->setor = $setor;
                $insert_xmldb->endereco = $endereco;
                $insert_xmldb->cnpj = $cnpj;
                $insert_xmldb->funcionario = $funcionario;
                $insert_xmldb->dataadm = $dataadm;
                $insert_xmldb->ferias = $ferias;
                $insert_xmldb->valorTC = $valorTC;
                $insert_xmldb->valorTD = $valorTD;
                $insert_xmldb->valorTL = $valorTL;
                $insert_xmldb->valorFa = $valorFa;
                $insert_xmldb->mensagemc1 = $mensagemc1;
                $insert_xmldb->valorFGTS = $valorFGTS;
                $insert_xmldb->valorBaseIRRF = $valorBaseIRRF;
                $insert_xmldb->valorBaseINNS = $valorBaseINNS;
                $insert_xmldb->valorSalarioBase = $valorSalarioBase;
                $insert_xmldb->valorBaseFGTS = $valorBaseFGTS;
                $insert_xmldb->save();

                return $insert_xmldb->id . '=' . $insert_xmldb->cpf;
        }
    }

    function insertdadoscomp($id_dados_XML, $descricaoverba1, $valor1, $percentual1, $basecalculo1)
    {

        $explode = explode('=', $id_dados_XML);
        $id_dados_XML = $explode[0];
        $aditional_cpf = $explode[1];

        $insert_xmldbaditional = new Paymentxmladditional();
        $insert_xmldbaditional->id_paymentxmls = $id_dados_XML;
        $insert_xmldbaditional->aditional_cpf = $aditional_cpf;
        $insert_xmldbaditional->descricaoverba1 = $descricaoverba1;
        $insert_xmldbaditional->valor1 = $valor1;
        $insert_xmldbaditional->percentual1 = $percentual1;
        $insert_xmldbaditional->basecalculo1 = $basecalculo1;
        $result = $insert_xmldbaditional->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = Auth::user();
        $dataPayment = Paymentxml::with('paymentxmladditionalsr')
        ->where('id', $id)
        ->where('cpf', $user->document)
        // ->when($user->document, function ($query, $user) {
        //     return $query->where('aditional_cpf', $user->document);
        // })
        //->where('aditional_cpf', $user->document)
        ->first();
        Log::debug("mostra linha do arquivo XML" . $dataPayment);
        return response()->json([
            'dataPayment' => $dataPayment,
        ], Response::HTTP_OK);
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
    public function confirm($id)
    {
        
        $dataPayment = Paymentxml::findOrFail($id);
        $today = Carbon::parse(today())->format('Y-m-d');
        $dataPayment->update([
            'status' => '1',
            'dataAssinatura' => $today,
        ]);
        return response()->json([
            'status' => true,
            'title' => 'Eiii!',
            'message' => 'Assinado com sucesso!',
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
