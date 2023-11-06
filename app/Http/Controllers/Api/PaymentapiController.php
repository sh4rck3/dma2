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
        $i = 0;
        if(is_numeric($xml_file->id))
        {
            $xml = simplexml_load_file(base_path(). "/storage/app/" .$xml_file->xml_file);
            foreach ($xml->FormattedAreaPair->FormattedAreaPair->FormattedArea
            ->FormattedSections
                ->FormattedSection
                    ->FormattedReportObjects
                        ->FormattedReportObject
                            ->FormattedAreaPair
                                ->FormattedAreaPair
                                    ->FormattedAreaPair
                                        ->FormattedAreaPair
                                            ->FormattedAreaPair
                                                ->FormattedAreaPair as $phaseOne) {
                //Log::debug("PaymentapiController.storage - foreach phaseOne " . print_r($phaseOne, true));
                // ----- Dados da empresa ----- //
                $recibo = ''; $empresa = ''; $recibo1 = ''; $setor = ''; $endereco = ''; $cnpj = ''; 
                $funcionario = ''; $dataadm = ''; $ferias = ''; $valorTC = ''; $valorTD = ''; $valorTL = ''; 
                $valorFa = ''; $mensagemc1 = ''; $valorFGTS = ''; $valorBaseIRRF = ''; $valorBaseINNS = ''; 
                $valorSalarioBase = ''; $valorBaseFGTS = ''; $cpf = '';
               
                foreach ($phaseOne->FormattedArea->FormattedSections->FormattedSection[2]->FormattedReportObjects->FormattedReportObject as $key => $dataOfCompany) 
                {
                    switch ($dataOfCompany->ObjectName) {
                        case 'Text1':
                            $recibo = $this->verificarsearray($dataOfCompany->TextValue);
                            break;
                        case 'EMPRESA1':
                            $empresa = $this->verificarsearray($dataOfCompany->FormattedValue);
                            break;
                        case 'Text2':
                            $recibo1 = $this->verificarsearray($dataOfCompany->TextValue);
                            break;
                        case 'SETOR1':
                            $setor = $this->verificarsearray($dataOfCompany->FormattedValue);
                            break;
                        case 'ENDEREÇO1':
                            $endereco = $this->verificarsearray($dataOfCompany->FormattedValue);
                            break;
                        case 'CNPJ1':
                            $cnpj = $this->verificarsearray($dataOfCompany->FormattedValue);
                            break;
                                
                    }
                }

                // ----- Dados do funcionario ----- //
                foreach ($phaseOne->FormattedArea->FormattedSections->FormattedSection[3]->FormattedReportObjects->FormattedReportObject as $key => $dataOfEmployee) 
                {
                    
                    switch ($dataOfEmployee->ObjectName) {
                        case 'TÍTULO11':
                            $funcionario = $this->verificarsearray($dataOfEmployee->FormattedValue);
                            break;
                        case 'TÍTULO21':
                            $dataadm = $this->verificarsearray($dataOfEmployee->FormattedValue);
                            break;
                        case 'TÍTULO31':
                            $ferias = $this->verificarsearray($dataOfEmployee->FormattedValue);
                            if($this->verificarsearray($dataOfEmployee->FormattedValue) != ""){
                                $cpfTemp = explode(" - ", $ferias);
                                foreach ($cpfTemp as $dadosTemp){
                                    if (substr($dadosTemp, 0, 4) == "CPF:"){
                                        $cpf = str_replace("CPF:", "", $dadosTemp);
                                        $cpf = str_replace(" ", "", $cpf);
                                    }
                                }
                            }
                            break;
                    }
                }
                Log::debug("PaymentapiController.storage - foreach dataOfEmployee " . $cpf);
                // ----- Dados do pagamento ----- //
                $i++;
            }
           
        
        Log::debug("PaymentapiController.storage - quantidade de funcionarios " . $i);    
        }else{
        return response()->json([
            'status' => true,
            'title' => 'Falha!',
            'message' => 'Error!',
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

                Paymentxmladditional::where('id_paymentxmls', $linha->id)->delete();
                return $linha->id;
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

                return $insert_xmldb->id;
        }
    }

    function insertdadoscomp($id_dados_XML, $descricaoverba1, $valor1, $percentual1, $basecalculo1, $payment_shipping_id)
    {
        $insert_xmldbaditional = new Paymentxmladditional();
        $insert_xmldbaditional->id_paymentxmls = $id_dados_XML;
        $insert_xmldbaditional->aditional_cpf = $payment_shipping_id;
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
