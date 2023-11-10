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
        Log::info("cpf usuario logado ->>>>>>> \r\n".$userLogged->document);
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
                                                ->FormattedAreaPair as $phaseOne) 
            { 
                //Log::debug("PaymentapiController.storage - foreach phaseOne " . print_r($phaseOne, true));
                // ----- Dados da empresa ----- //
                $recibo = ''; $empresa = ''; $recibo1 = ''; $setor = ''; $endereco = ''; $cnpj = ''; 
                $funcionario = ''; $dataadm = ''; $ferias = ''; $valorTC = ''; $valorTD = ''; $valorTL = ''; 
                $valorFa = ''; $mensagemc1 = ''; $valorFGTS = ''; $valorBaseIRRF = ''; $valorBaseINNS = ''; 
                $valorSalarioBase = ''; $valorBaseFGTS = ''; $cpf = ''; $idCpf_dados_XML = ''; $mesRef = '';
               
                foreach ($phaseOne
                            ->FormattedArea
                                ->FormattedSections
                                    ->FormattedSection[2]
                                        ->FormattedReportObjects
                                            ->FormattedReportObject as $key => $dataOfCompany) 
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
                foreach ($phaseOne
                            ->FormattedArea
                                ->FormattedSections
                                    ->FormattedSection[3]
                                        ->FormattedReportObjects
                                            ->FormattedReportObject as $key => $dataOfEmployee){
                    
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
               
                // ----- Dados do pagamento ----- //
                foreach($phaseOne
                            ->FormattedArea[1]
                                ->FormattedSections
                                    ->FormattedSection[1]
                                        ->FormattedReportObjects
                                            ->FormattedReportObject as $key => $dataOfPayment){
                    switch ($dataOfPayment->ObjectName) {
                        case 'Vtotalc1':
                            $valorTC = $this->verificarsearray($dataOfPayment->FormattedValue);
                            break;
                        case 'Vtotald1':
                            $valorTD = $this->verificarsearray($dataOfPayment->FormattedValue);
                            break;
                        case 'Vliquido1':
                            $valorTL = $this->verificarsearray($dataOfPayment->FormattedValue);
                            break;
                        case 'Faixair1':
                            $valorFa = $this->verificarsearray($dataOfPayment->FormattedValue);
                            break;
                        case 'Mensagemcc1':
                            $mensagemc1 = $this->verificarsearray($dataOfPayment->FormattedValue);
                            break;
                        case 'ValFgts1':
                            $valorFGTS = $this->verificarsearray($dataOfPayment->FormattedValue);
                            break;
                        case 'MovimentoMêsdereferência2':
                            $mesRef = $this->verificarsearray($dataOfPayment->FormattedValue);
                            break;
                        case 'BaseIRRF1':
                            $valorBaseIRRF = $this->verificarsearray($dataOfPayment->FormattedValue);
                            break;
                        case 'BaseIRRF1':
                            $valorBaseINNS = $this->verificarsearray($dataOfPayment->FormattedValue);
                            break;
                        case 'BaseINSS1':
                            $valorSalarioBase = $this->verificarsearray($dataOfPayment->FormattedValue);
                            break;
                        case 'SalárioBase1':
                            $valorBaseFGTS = $this->verificarsearray($dataOfPayment->FormattedValue);
                            break;
                        case 'BaseFGTS1':
                            $valorBaseFGTS = $this->verificarsearray($dataOfPayment->FormattedValue);
                            break;
                    }

                }
                // ----- inserindo dados ----- //
               
                $data_XML = [
                    'recibo' => $recibo,
                    'empresa' => $empresa,
                    'recibo1' => $recibo1,
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
                    'cpf' => $cpf,
                    'mesRef' => $mesRef,
                    'payment_shipping' => $payment_shipping_id,
                ];
                $idCpf_dados_XML = $this->insertdados($data_XML);

                // ------Descritivos -----//
               
                foreach ($phaseOne
                            ->FormattedAreaPair as $phaseTwo) {
                    //Log::debug("foreach phaseTwo " . print_r($phaseOne, true));
                        foreach($phaseTwo->FormattedAreaPair as $phaseTree){
                            //Log ::debug("foreach phaseTree " . print_r($phaseTree, true));
                            foreach($phaseTree as $phaseFour){
                                //Log::debug("foreach phaseFour " . print_r($phaseFour, true));
                                $descricaoverba1 = '';
                                $valor1 = '';
                                $percentual1 = '';
                                $basecalculo1 = '';
                                foreach($phaseFour->FormattedArea->FormattedSections->FormattedSection->FormattedReportObjects->FormattedReportObject as $ddescaux2){
                                    //Log::debug("foreach ddescaux2 " . print_r($ddescaux2, true));
                                    switch ($ddescaux2->ObjectName) {
                                        case 'DESCRIÇÃODAVERBA1':
                                            $descricaoverba1 = $this->verificarsearray($ddescaux2->FormattedValue);
                                            break;
                                        case 'Valor2':
                                            $valor1 = $this->verificarsearray($ddescaux2->FormattedValue);
                                            break;
                                        case 'Valor1':
                                            $valor1 = $this->verificarsearray($ddescaux2->FormattedValue);
                                            break;
                                        case 'Percentual1':
                                            $percentual1 = $this->verificarsearray($ddescaux2->FormattedValue);
                                            break;
                                        case 'Basedecálculo1':
                                            $basecalculo1 = $this->verificarsearray($ddescaux2->FormattedValue);
                                            break;
                                        case 'MovimentoMêsdereferência1':
                                            $mesRef1 = $this->verificarsearray($ddescaux2->FormattedValue);
                                            break;
                                    }                                    
                                }
                                $data_compXML = [
                                    'id' => $idCpf_dados_XML['id'],
                                    'cpf' => $idCpf_dados_XML['cpf'],
                                    'descricaoverba1' => $descricaoverba1,
                                    'valor1' => $valor1,
                                    'percentual1' => $percentual1,
                                    'basecalculo1' => $basecalculo1,
                                    'payment_shipping' => $payment_shipping_id,
                                    'mesRef1' => $idCpf_dados_XML['mesRef'],
                                ];

                                $this->insertdadoscomp($data_compXML);
                                //Log::debug("PaymentapiController.data_compXML " . print_r($data_compXML, true));
                            }
                           
                        }
            }
                

                //quantidade de funcionários importados
                $i++;
            }
        Log::debug("PaymentapiController.storage - quantidade de funcionarios " . $i);    
        return Response::HTTP_NOT_FOUND;
        // return response()->json([
        //     'status' => true,
        //     'title' => 'Sucesso!',
        //     'message' => 'Arquivo importado com sucesso! <br> Quantidade de funcionários importados:' . $i,
        //     'quantidade' => $i,
        // ], Response::HTTP_OK);
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

    function insertdados($data_XML)
    {
        $linha = Paymentxml::where('cpf', $data_XML['cpf'])
                            ->where('mesRef', $data_XML['mesRef'])->first();
        if(!empty($linha)){
            
                $userLogged = Auth::user();
                $insert_xmldb = Paymentxml::find($linha->id);
                $insert_xmldb->update([
                    'user_id' => $userLogged->id,
                    'payment_shipping' =>  $data_XML['payment_shipping'],
                    'cpf' => $data_XML['cpf'],
                    'mesRef' => $data_XML['mesRef'],
                    'recibo' => $data_XML['recibo'],
                    'empresa' => $data_XML['empresa'],
                    'setor' => $data_XML['setor'],
                    'endereco' => $data_XML['endereco'],
                    'cnpj' => $data_XML['cnpj'],
                    'funcionario' => $data_XML['funcionario'],
                    'dataadm' => $data_XML['dataadm'],
                    'ferias' => $data_XML['ferias'],
                    'valorTC' => $data_XML['valorTC'],
                    'valorTD' => $data_XML['valorTD'],
                    'valorTL' => $data_XML['valorTL'],
                    'valorFa' => $data_XML['valorFa'],
                    'mensagemc1' => $data_XML['mensagemc1'],
                    'valorFGTS' => $data_XML['valorFGTS'],
                    'valorBaseIRRF' => $data_XML['valorBaseIRRF'],
                    'valorBaseINNS' => $data_XML['valorBaseINNS'],
                    'valorSalarioBase' => $data_XML['valorSalarioBase'],
                    'valorBaseFGTS' => $data_XML['valorBaseFGTS'],
                    'payment_shipping' => $data_XML['payment_shipping'],
                ]);

                Paymentxmladditional::where('id_paymentxmls', $linha->id)->delete();
                return $dataReturn = [
                    'id' => $linha->id,
                    'cpf' => $linha->cpf,
                    'mesRef' => $linha->mesRef,
                ];
        }else{
                $userLogged = Auth::user();
                $insert_xmldb = new Paymentxml();
                $insert_xmldb->user_id = $userLogged->id;
                $insert_xmldb->payment_shipping = $data_XML['payment_shipping'];
                $insert_xmldb->cpf = $data_XML['cpf'];
                $insert_xmldb->mesRef = $data_XML['mesRef'];
                $insert_xmldb->recibo = $data_XML['recibo'];
                $insert_xmldb->empresa = $data_XML['empresa'];
                $insert_xmldb->setor = $data_XML['setor'];
                $insert_xmldb->endereco = $data_XML['endereco'];
                $insert_xmldb->cnpj = $data_XML['cnpj'];
                $insert_xmldb->funcionario = $data_XML['funcionario'];
                $insert_xmldb->dataadm = $data_XML['dataadm'];
                $insert_xmldb->ferias = $data_XML['ferias'];
                $insert_xmldb->valorTC = $data_XML['valorTC'];
                $insert_xmldb->valorTD = $data_XML['valorTD'];
                $insert_xmldb->valorTL = $data_XML['valorTL'];
                $insert_xmldb->valorFa = $data_XML['valorFa'];
                $insert_xmldb->mensagemc1 = $data_XML['mensagemc1'];
                $insert_xmldb->valorFGTS = $data_XML['valorFGTS'];
                $insert_xmldb->valorBaseIRRF = $data_XML['valorBaseIRRF'];
                $insert_xmldb->valorBaseINNS = $data_XML['valorBaseINNS'];
                $insert_xmldb->valorSalarioBase = $data_XML['valorSalarioBase'];
                $insert_xmldb->valorBaseFGTS = $data_XML['valorBaseFGTS'];
                $insert_xmldb->save();

                return $dataReturn = [
                    'id' => $insert_xmldb->id,
                    'cpf' => $insert_xmldb->cpf,
                    'mesRef' => $insert_xmldb->mesRef,
                ];
        }
    }

    function insertdadoscomp($data_compXML)
    {
        

        $insert_xmldbaditional = new Paymentxmladditional();
        $insert_xmldbaditional->id_paymentxmls = $data_compXML['id'];
        $insert_xmldbaditional->aditional_cpf = $data_compXML['cpf'];
        $insert_xmldbaditional->mesRef1 = $data_compXML['mesRef1'];
        $insert_xmldbaditional->descricaoverba1 = $data_compXML['descricaoverba1'];
        $insert_xmldbaditional->valor1 = $data_compXML['valor1'];
        $insert_xmldbaditional->percentual1 = $data_compXML['percentual1'];
        $insert_xmldbaditional->basecalculo1 = $data_compXML['basecalculo1'];
        $insert_xmldbaditional->save();
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

    //store antigo XML
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
            $newArr = json_decode(json_encode($new), TRUE);

            $descricaoverba1 = '';
            $valor1 = '';
            $percentual1 = '';
            $basecalculo1 = '';

            if(!empty($newArr))
            {
                    //foi retirado daki o recorte
                    if(array_key_exists(0, $newArr["FormattedAreaPair"]["FormattedAreaPair"]["FormattedArea"]["FormattedSections"]["FormattedSection"]["FormattedReportObjects"]["FormattedReportObject"]) == True)
                    {
                        foreach ($newArr["FormattedAreaPair"]["FormattedAreaPair"]["FormattedArea"]["FormattedSections"]["FormattedSection"]["FormattedReportObjects"]["FormattedReportObject"] as $sessoes){
                            foreach ($sessoes["FormattedAreaPair"]["FormattedAreaPair"]["FormattedAreaPair"]["FormattedAreaPair"]["FormattedAreaPair"]["FormattedAreaPair"] as $dados) {
                                $cpf = ''; $recibo = ''; $recibo1 = ''; $empresa = ''; $setor = ''; $endereco = ''; $cnpj = ''; $funcionario = ''; $dataadm = ''; $ferias = ''; $valorTC = '';
                                $valorTD = ''; $valorTL= ''; $valorFa = ''; $mensagemc1 = ''; $valorFGTS = ''; $mesRef = ''; $valorBaseIRRF = ''; $valorBaseINNS = ''; $valorSalarioBase = '';
                                $valorBaseFGTS = '';

                                // ----- Dados da empresa ----- //
                                foreach ($dados["FormattedArea"][0]["FormattedSections"]["FormattedSection"][2]["FormattedReportObjects"]["FormattedReportObject"] as $dempresa){
                                    if ($dempresa["ObjectName"] == "Text1"){
                                        //$recibo = $this->verificarsearray($dempresa["FormattedValue"]);
                                        $recibo = 'Recibo de Pagamento';
                                    }
                                    elseif ($dempresa["ObjectName"] == "EMPRESA1"){$empresa = $this->verificarsearray($dempresa["FormattedValue"]);}
                                    elseif ($dempresa["ObjectName"] == "Text2"){
                                        //$recibo1 = $this->verificarsearray($dempresa["FormattedValue"]);
                                        $recibo1 = 'de Salário';
                                    }
                                    elseif ($dempresa["ObjectName"] == "SETOR1"){$setor = $this->verificarsearray($dempresa["FormattedValue"]);}
                                    elseif ($dempresa["ObjectName"] == "ENDEREÇO1"){$endereco = $this->verificarsearray($dempresa["FormattedValue"]);}
                                    elseif ($dempresa["ObjectName"] == "CNPJ1"){$cnpj = $this->verificarsearray($dempresa["FormattedValue"]);}
                                }
                    
                                // ----- Dados do Funcionario ----- //
                                foreach ($dados["FormattedArea"][0]["FormattedSections"]["FormattedSection"][3]["FormattedReportObjects"]["FormattedReportObject"] as $dfunc){
                                    if ($dfunc["ObjectName"] == "TÍTULO11"){$funcionario =  $this->verificarsearray($dfunc["FormattedValue"]);}
                                    elseif ($dfunc["ObjectName"] == "TÍTULO21"){$dataadm = $this->verificarsearray($dfunc["FormattedValue"]);}
                                    elseif ($dfunc["ObjectName"] == "TÍTULO31"){$ferias = $this->verificarsearray($dfunc["FormattedValue"]);}
                                    //if ($dfunc["ObjectName"] == "TÍTULO41"){$ferias = $dfunc["FormattedValue"];}
                                }

                                // ----- Valores ----- //
                                foreach ($dados["FormattedArea"][1]["FormattedSections"]["FormattedSection"][1]["FormattedReportObjects"]["FormattedReportObject"] as $dvalores){
                                if ($dvalores["ObjectName"] == "Vtotalc1"){$valorTC = $this->verificarsearray($dvalores["FormattedValue"]);}
                                elseif ($dvalores["ObjectName"] == "Vtotald1"){$valorTD = $this->verificarsearray($dvalores["FormattedValue"]);}
                                elseif ($dvalores["ObjectName"] == "Vliquido1"){$valorTL = $this->verificarsearray($dvalores["FormattedValue"]);}
                                elseif ($dvalores["ObjectName"] == "Faixair1"){$valorFa = $this->verificarsearray($dvalores["FormattedValue"]);}
                                elseif ($dvalores["ObjectName"] == "Mensagemcc1"){$mensagemc1 = $this->verificarsearray($dvalores["FormattedValue"]);}
                                elseif ($dvalores["ObjectName"] == "ValFgts1"){$valorFGTS =$this->verificarsearray($dvalores["FormattedValue"]);}
                                elseif ($dvalores["ObjectName"] == "MovimentoMêsdereferência2"){$mesRef = $this->verificarsearray($dvalores["FormattedValue"]);}
                                elseif ($dvalores["ObjectName"] == "BaseIRRF1"){$valorBaseIRRF = $this->verificarsearray($dvalores["FormattedValue"]);}
                                elseif ($dvalores["ObjectName"] == "BaseINSS1"){$valorBaseINNS = $this->verificarsearray($dvalores["FormattedValue"]);}
                                elseif ($dvalores["ObjectName"] == "SalárioBase1"){$valorSalarioBase = $this->verificarsearray($dvalores["FormattedValue"]);}
                                elseif ($dvalores["ObjectName"] == "BaseFGTS1"){$valorBaseFGTS = $this->verificarsearray($dvalores["FormattedValue"]);}
                                }
                    
                                    $cpfTemp = explode(" - ", $ferias);
                                    foreach ($cpfTemp as $dadosTemp){
                                        if (substr($dadosTemp, 0, 4) == "CPF:"){
                                            $cpf = str_replace("CPF:", "", $dadosTemp);
                                            $cpf = str_replace(" ", "", $cpf);
                                        }
                                    }
                                    $returnID = $this->insertdados($cpf, $mesRef, $recibo, $empresa, $setor, $endereco, $cnpj, $funcionario, $dataadm, $ferias, $valorTC, $valorTD, $valorTL, $valorFa, $mensagemc1,$valorFGTS, $valorBaseIRRF, $valorBaseINNS, $valorSalarioBase, $valorBaseFGTS, $payment_shipping_id);

                                    // ----- Descritivos ----- //
                
                                if(array_key_exists(0, $dados["FormattedAreaPair"]) == True)
                                {
                                    foreach($dados["FormattedAreaPair"] as $ddescaux){
                                        if(array_key_exists(0, $ddescaux["FormattedAreaPair"]) == True){
                                            foreach($ddescaux["FormattedAreaPair"] as $ddescaux1){
                                                if(array_key_exists(0, $ddescaux1["FormattedAreaPair"]) == True){
                                                    foreach($ddescaux1["FormattedAreaPair"] as $ddescaux3){
                                                        $descricaoverba1 = '';
                                                        $valor1 = '';
                                                        $percentual1 = '';
                                                        $basecalculo1 = '';
                    
                                                        foreach($ddescaux3["FormattedArea"]["FormattedSections"]["FormattedSection"]["FormattedReportObjects"]["FormattedReportObject"] as $ddescaux2){
                                                            if ($ddescaux2["ObjectName"] == "DESCRIÇÃODAVERBA1"){
                                                                $descricaoverba1 = $this->verificarsearray($ddescaux2["FormattedValue"]);
                                                            }elseif ($ddescaux2["ObjectName"] == "Valor2"){
                                                                $valor1 = $this->verificarsearray($ddescaux2["FormattedValue"]);
                                                            }elseif ($ddescaux2["ObjectName"] == "Valor1"){
                                                                $valor1 = $this->verificarsearray($ddescaux2["FormattedValue"]);
                                                            }elseif ($ddescaux2["ObjectName"] == "Percentual1"){
                                                                $percentual1 = $this->verificarsearray($ddescaux2["FormattedValue"]);
                                                            }elseif ($ddescaux2["ObjectName"] == "Basedecálculo1"){
                                                                $basecalculo1 = $this->verificarsearray($ddescaux2["FormattedValue"]);
                                                            }
                                                        }
                                                        $this->insertdadoscomp($returnID, $descricaoverba1, $valor1, $percentual1, $basecalculo1);
                                                    }
                                                }else{        
                                                    $descricaoverba1 = '';
                                                    $valor1 = '';
                                                    $percentual1 = '';
                                                    $basecalculo1 = '';
                    
                                                    foreach($ddescaux1["FormattedAreaPair"]["FormattedArea"]["FormattedSections"]["FormattedSection"]["FormattedReportObjects"]["FormattedReportObject"] as $ddescaux2){
                                                        if ($ddescaux2["ObjectName"] == "DESCRIÇÃODAVERBA1"){
                                                            $descricaoverba1 = $this->verificarsearray($ddescaux2["FormattedValue"]);
                                                        }elseif ($ddescaux2["ObjectName"] == "Valor2"){
                                                            $valor1 = $this->verificarsearray($ddescaux2["FormattedValue"]);
                                                        }elseif ($ddescaux2["ObjectName"] == "Valor1"){
                                                            $valor1 = $this->verificarsearray($ddescaux2["FormattedValue"]);
                                                        }elseif ($ddescaux2["ObjectName"] == "Percentual1"){
                                                            $percentual1 = $this->verificarsearray($ddescaux2["FormattedValue"]);
                                                        }elseif ($ddescaux2["ObjectName"] == "Basedecálculo1"){
                                                            $basecalculo1 = $this->verificarsearray($ddescaux2["FormattedValue"]);
                                                        }
                                                    }
                                                    $this->insertdadoscomp($returnID, $descricaoverba1, $valor1, $percentual1, $basecalculo1);
                                                }
                                            }
                                        }else{
                                            foreach($ddescaux["FormattedAreaPair"]["FormattedAreaPair"]["FormattedArea"]["FormattedSections"]["FormattedSection"]["FormattedReportObjects"]["FormattedReportObject"] as $ddescaux2){
                                                if ($ddescaux2["ObjectName"] == "DESCRIÇÃODAVERBA1"){
                                                    $descricaoverba1 = $this->verificarsearray($ddescaux2["FormattedValue"]);
                                                }elseif ($ddescaux2["ObjectName"] == "Valor2"){
                                                    $valor1 = $this->verificarsearray($ddescaux2["FormattedValue"]);
                                                }elseif ($ddescaux2["ObjectName"] == "Valor1"){
                                                    $valor1 = $this->verificarsearray($ddescaux2["FormattedValue"]);
                                                }elseif ($ddescaux2["ObjectName"] == "Percentual1"){
                                                    $percentual1 = $this->verificarsearray($ddescaux2["FormattedValue"]);
                                                }elseif ($ddescaux2["ObjectName"] == "Basedecálculo1"){
                                                    $basecalculo1 = $this->verificarsearray($ddescaux2["FormattedValue"]);
                                                }
                                            }
                                            $this->insertdadoscomp($returnID, $descricaoverba1, $valor1, $percentual1, $basecalculo1);
                                        }
                                    }
                                }else{
                                    if(array_key_exists(0, $dados["FormattedAreaPair"]["FormattedAreaPair"]) == True){
                                        foreach($dados["FormattedAreaPair"]["FormattedAreaPair"] as $ddescaux){
                                            foreach($ddescaux["FormattedAreaPair"]["FormattedArea"]["FormattedSections"]["FormattedSection"]["FormattedReportObjects"]["FormattedReportObject"] as $ddescaux2){
                                                if ($ddescaux2["ObjectName"] == "DESCRIÇÃODAVERBA1"){
                                                $descricaoverba1 = $this->verificarsearray($ddescaux2["FormattedValue"]);
                                                }elseif ($ddescaux2["ObjectName"] == "Valor2"){
                                                    $valor1 = $this->verificarsearray($ddescaux2["FormattedValue"]);
                                                }elseif ($ddescaux2["ObjectName"] == "Valor1"){
                                                    $valor1 = $this->verificarsearray($ddescaux2["FormattedValue"]);
                                                }elseif ($ddescaux2["ObjectName"] == "Percentual1"){
                                                    $percentual1 = $this->verificarsearray($ddescaux2["FormattedValue"]);
                                                }elseif ($ddescaux2["ObjectName"] == "Basedecálculo1"){
                                                    $basecalculo1 = $this->verificarsearray($ddescaux2["FormattedValue"]);
                                                }
                                            }
                                            $this->insertdadoscomp($returnID, $descricaoverba1, $valor1, $percentual1, $basecalculo1);
                                        }
                                    }else{
                                        foreach($dados["FormattedAreaPair"]["FormattedAreaPair"]["FormattedAreaPair"]["FormattedArea"]["FormattedSections"]["FormattedSection"]["FormattedReportObjects"]["FormattedReportObject"] as $ddescaux2){
                                            if ($ddescaux2["ObjectName"] == "DESCRIÇÃODAVERBA1"){
                                                $descricaoverba1 = $this->verificarsearray($ddescaux2["FormattedValue"]);
                                            }elseif ($ddescaux2["ObjectName"] == "Valor2"){
                                                $valor1 = $this->verificarsearray($ddescaux2["FormattedValue"]);
                                            }elseif ($ddescaux2["ObjectName"] == "Valor1"){
                                                $valor1 = $this->verificarsearray($ddescaux2["FormattedValue"]);
                                            }elseif ($ddescaux2["ObjectName"] == "Percentual1"){
                                                $percentual1 = $this->verificarsearray($ddescaux2["FormattedValue"]);
                                            }elseif ($ddescaux2["ObjectName"] == "Basedecálculo1"){
                                                $basecalculo1 = $this->verificarsearray($ddescaux2["FormattedValue"]);
                                            }
                                        }
                                        $this->insertdadoscomp($returnID, $descricaoverba1, $valor1, $percentual1, $basecalculo1);
                                    }
                                }
                            }
                        }
                    }else{
                        foreach ($newArr["FormattedAreaPair"]["FormattedAreaPair"]["FormattedArea"]["FormattedSections"]["FormattedSection"]["FormattedReportObjects"]["FormattedReportObject"]["FormattedAreaPair"]["FormattedAreaPair"]["FormattedAreaPair"]["FormattedAreaPair"]["FormattedAreaPair"]["FormattedAreaPair"] as $dados) {
                            // ----- Dados da empresa ----- //
                            $cpf = ''; $recibo = ''; $recibo1 = ''; $empresa = ''; $setor = ''; $endereco = ''; $cnpj = ''; $funcionario = ''; $dataadm = ''; $ferias = ''; $valorTC = '';
                                $valorTD = ''; $valorTL= ''; $valorFa = ''; $mensagemc1 = ''; $valorFGTS = ''; $mesRef = ''; $valorBaseIRRF = ''; $valorBaseINNS = ''; $valorSalarioBase = '';
                                $valorBaseFGTS = '';

                            foreach ($dados["FormattedArea"][0]["FormattedSections"]["FormattedSection"][2]["FormattedReportObjects"]["FormattedReportObject"] as $dempresa){
                                if ($dempresa["ObjectName"] == "Text1"){
                                    //$recibo = $this->verificarsearray($dempresa["FormattedValue"]);
                                    $recibo = 'Recibo de Pagamento';
                                }
                                elseif ($dempresa["ObjectName"] == "EMPRESA1"){$empresa = $this->verificarsearray($dempresa["FormattedValue"]);}
                                elseif ($dempresa["ObjectName"] == "Text2"){
                                    //$recibo1 = $this->verificarsearray($dempresa["FormattedValue"]);
                                    $recibo1 = 'de Salário';
                                }
                                elseif ($dempresa["ObjectName"] == "SETOR1"){$setor = $this->verificarsearray($dempresa["FormattedValue"]);}
                                elseif ($dempresa["ObjectName"] == "ENDEREÇO1"){$endereco = $this->verificarsearray($dempresa["FormattedValue"]);}
                                elseif ($dempresa["ObjectName"] == "CNPJ1"){$cnpj = $this->verificarsearray($dempresa["FormattedValue"]);}
                            }
                
                            // ----- Dados do Funcionario ----- //
                            foreach ($dados["FormattedArea"][0]["FormattedSections"]["FormattedSection"][3]["FormattedReportObjects"]["FormattedReportObject"] as $dfunc){
                                if ($dfunc["ObjectName"] == "TÍTULO11"){$funcionario =  $this->verificarsearray($dfunc["FormattedValue"]);}
                                elseif ($dfunc["ObjectName"] == "TÍTULO21"){$dataadm = $this->verificarsearray($dfunc["FormattedValue"]);}
                                elseif ($dfunc["ObjectName"] == "TÍTULO31"){$ferias = $this->verificarsearray($dfunc["FormattedValue"]);}
                                //if ($dfunc["ObjectName"] == "TÍTULO41"){$ferias = $dfunc["FormattedValue"];}
                            }
                
                            // ----- Valores ----- //
                            foreach ($dados["FormattedArea"][1]["FormattedSections"]["FormattedSection"][1]["FormattedReportObjects"]["FormattedReportObject"] as $dvalores){
                                if ($dvalores["ObjectName"] == "Vtotalc1"){$valorTC = $this->verificarsearray($dvalores["FormattedValue"]);}
                                elseif ($dvalores["ObjectName"] == "Vtotald1"){$valorTD = $this->verificarsearray($dvalores["FormattedValue"]);}
                                elseif ($dvalores["ObjectName"] == "Vliquido1"){$valorTL = $this->verificarsearray($dvalores["FormattedValue"]);}
                                elseif ($dvalores["ObjectName"] == "Faixair1"){$valorFa = $this->verificarsearray($dvalores["FormattedValue"]);}
                                elseif ($dvalores["ObjectName"] == "Mensagemcc1"){$mensagemc1 = $this->verificarsearray($dvalores["FormattedValue"]);}
                                elseif ($dvalores["ObjectName"] == "ValFgts1"){$valorFGTS = $this->verificarsearray($dvalores["FormattedValue"]);}
                                elseif ($dvalores["ObjectName"] == "MovimentoMêsdereferência2"){$mesRef = $this->verificarsearray($dvalores["FormattedValue"]);}
                                elseif ($dvalores["ObjectName"] == "BaseIRRF1"){$valorBaseIRRF = $this->verificarsearray($dvalores["FormattedValue"]);}
                                elseif ($dvalores["ObjectName"] == "BaseINSS1"){$valorBaseINNS = $this->verificarsearray($dvalores["FormattedValue"]);}
                                elseif ($dvalores["ObjectName"] == "SalárioBase1"){$valorSalarioBase = $this->verificarsearray($dvalores["FormattedValue"]);}
                                elseif ($dvalores["ObjectName"] == "BaseFGTS1"){$valorBaseFGTS = $this->verificarsearray($dvalores["FormattedValue"]);}
                            }
                
                            $cpfTemp = explode(" - ", $ferias);
                            foreach ($cpfTemp as $dadosTemp){
                                if (substr($dadosTemp, 0, 4) == "CPF:"){
                                    $cpf = str_replace("CPF:", "", $dadosTemp);
                                    $cpf = str_replace(" ", "", $cpf);
                                }
                            }
                            
                            $returnID = $this->insertdados($cpf, $mesRef, $recibo, $empresa, $setor, $endereco, $cnpj, $funcionario, $dataadm, $ferias, $valorTC, $valorTD, $valorTL, $valorFa, $mensagemc1,$valorFGTS, $valorBaseIRRF, $valorBaseINNS, $valorSalarioBase, $valorBaseFGTS, $payment_shipping_id);
                            
                            // ----- Descritivos ----- //
                            if(array_key_exists(0, $dados["FormattedAreaPair"]) == True){
                                foreach($dados["FormattedAreaPair"] as $ddescaux){
                                    if(array_key_exists(0, $ddescaux["FormattedAreaPair"]) == True){
                                        foreach($ddescaux["FormattedAreaPair"] as $ddescaux1){
                                            if(array_key_exists(0, $ddescaux1["FormattedAreaPair"]) == True){
                                                foreach($ddescaux1["FormattedAreaPair"] as $ddescaux3){
                                                    $descricaoverba1 = '';
                                                    $valor1 = '';
                                                    $percentual1 = '';
                                                    $basecalculo1 = '';
                
                                                    foreach($ddescaux3["FormattedArea"]["FormattedSections"]["FormattedSection"]["FormattedReportObjects"]["FormattedReportObject"] as $ddescaux2){
                                                        if ($ddescaux2["ObjectName"] == "DESCRIÇÃODAVERBA1"){
                                                            $descricaoverba1 = $this->verificarsearray($ddescaux2["FormattedValue"]);
                                                        }elseif ($ddescaux2["ObjectName"] == "Valor1"){
                                                            $valor1 = $this->verificarsearray($ddescaux2["FormattedValue"]);
                                                        }elseif ($ddescaux2["ObjectName"] == "Valor2"){
                                                            $valor1 = $this->verificarsearray($ddescaux2["FormattedValue"]);
                                                        }elseif ($ddescaux2["ObjectName"] == "Percentual1"){
                                                            $percentual1 = $this->verificarsearray($ddescaux2["FormattedValue"]);
                                                        }elseif ($ddescaux2["ObjectName"] == "Basedecálculo1"){
                                                            $basecalculo1 = $this->verificarsearray($ddescaux2["FormattedValue"]);
                                                        }
                                                    }
                                                    $this->insertdadoscomp($returnID, $descricaoverba1, $valor1, $percentual1, $basecalculo1);
                                                }
                                            }else{        
                                                $descricaoverba1 = '';
                                                $valor1 = '';
                                                $percentual1 = '';
                                                $basecalculo1 = '';
                
                                                foreach($ddescaux1["FormattedAreaPair"]["FormattedArea"]["FormattedSections"]["FormattedSection"]["FormattedReportObjects"]["FormattedReportObject"] as $ddescaux2){
                                                    if ($ddescaux2["ObjectName"] == "DESCRIÇÃODAVERBA1"){
                                                        $descricaoverba1 = $this->verificarsearray($ddescaux2["FormattedValue"]);
                                                    }elseif ($ddescaux2["ObjectName"] == "Valor1"){
                                                        $valor1 = $this->verificarsearray($ddescaux2["FormattedValue"]);
                                                    }elseif ($ddescaux2["ObjectName"] == "Valor2"){
                                                        $valor1 = $this->verificarsearray($ddescaux2["FormattedValue"]);
                                                    }elseif ($ddescaux2["ObjectName"] == "Percentual1"){
                                                        $percentual1 = $this->verificarsearray($ddescaux2["FormattedValue"]);
                                                    }elseif ($ddescaux2["ObjectName"] == "Basedecálculo1"){
                                                        $basecalculo1 = $this->verificarsearray($ddescaux2["FormattedValue"]);
                                                    }
                                                }
                                                $this->insertdadoscomp($returnID, $descricaoverba1, $valor1, $percentual1, $basecalculo1);
                                            }
                                        }
                                    }else{
                                        foreach($ddescaux["FormattedAreaPair"]["FormattedAreaPair"]["FormattedArea"]["FormattedSections"]["FormattedSection"]["FormattedReportObjects"]["FormattedReportObject"] as $ddescaux2){
                                            if ($ddescaux2["ObjectName"] == "DESCRIÇÃODAVERBA1"){
                                                $descricaoverba1 = $this->verificarsearray($ddescaux2["FormattedValue"]);
                                            }elseif ($ddescaux2["ObjectName"] == "Valor1"){
                                                $valor1 = $this->verificarsearray($ddescaux2["FormattedValue"]);
                                            }elseif ($ddescaux2["ObjectName"] == "Valor2"){
                                                $valor1 = $this->verificarsearray($ddescaux2["FormattedValue"]);
                                            }elseif ($ddescaux2["ObjectName"] == "Percentual1"){
                                                $percentual1 = $this->verificarsearray($ddescaux2["FormattedValue"]);
                                            }elseif ($ddescaux2["ObjectName"] == "Basedecálculo1"){
                                                $basecalculo1 = $this->verificarsearray($ddescaux2["FormattedValue"]);
                                            }
                                        }
                                        $this->insertdadoscomp($returnID, $descricaoverba1, $valor1, $percentual1, $basecalculo1);
                                    }
                                }
                            }else{
                                if(array_key_exists(0, $dados["FormattedAreaPair"]["FormattedAreaPair"]) == True){
                                    foreach($dados["FormattedAreaPair"]["FormattedAreaPair"] as $ddescaux){
                                        foreach($ddescaux["FormattedAreaPair"]["FormattedArea"]["FormattedSections"]["FormattedSection"]["FormattedReportObjects"]["FormattedReportObject"] as $ddescaux2){
                                            if ($ddescaux2["ObjectName"] == "DESCRIÇÃODAVERBA1"){
                                            $descricaoverba1 = $this->verificarsearray($ddescaux2["FormattedValue"]);
                                            }elseif ($ddescaux2["ObjectName"] == "Valor1"){
                                                $valor1 = $this->verificarsearray($ddescaux2["FormattedValue"]);
                                            }elseif ($ddescaux2["ObjectName"] == "Valor2"){
                                                $valor1 = $this->verificarsearray($ddescaux2["FormattedValue"]);
                                            }elseif ($ddescaux2["ObjectName"] == "Percentual1"){
                                                $percentual1 = $this->verificarsearray($ddescaux2["FormattedValue"]);
                                            }elseif ($ddescaux2["ObjectName"] == "Basedecálculo1"){
                                                $basecalculo1 = $this->verificarsearray($ddescaux2["FormattedValue"]);
                                            }
                                        }
                                        $this->insertdadoscomp($returnID, $descricaoverba1, $valor1, $percentual1, $basecalculo1);
                                    }
                                }else{
                                    foreach($dados["FormattedAreaPair"]["FormattedAreaPair"]["FormattedAreaPair"]["FormattedArea"]["FormattedSections"]["FormattedSection"]["FormattedReportObjects"]["FormattedReportObject"] as $ddescaux2){
                                        if ($ddescaux2["ObjectName"] == "DESCRIÇÃODAVERBA1"){
                                            $descricaoverba1 = $this->verificarsearray($ddescaux2["FormattedValue"]);
                                        }elseif ($ddescaux2["ObjectName"] == "Valor1"){
                                            $valor1 = $this->verificarsearray($ddescaux2["FormattedValue"]);
                                        }elseif ($ddescaux2["ObjectName"] == "Valor2"){
                                            $valor1 = $this->verificarsearray($ddescaux2["FormattedValue"]);
                                        }elseif ($ddescaux2["ObjectName"] == "Percentual1"){
                                            $percentual1 = $this->verificarsearray($ddescaux2["FormattedValue"]);
                                        }elseif ($ddescaux2["ObjectName"] == "Basedecálculo1"){
                                            $basecalculo1 = $this->verificarsearray($ddescaux2["FormattedValue"]);
                                        }
                                    }
                                    $this->insertdadoscomp($returnID, $descricaoverba1, $valor1, $percentual1, $basecalculo1);
                                }
                            }
                        }
                        
                    } 
                  
                  return response()->json([
                            'status' => true,
                            'title' => 'Eiii!',
                            'message' => 'Salvo com sucesso!',
                        ], Response::HTTP_OK);
                
            }else{
                return ["result" => "Operation Failed"];
            }
         }else{
            return ["result" => "Operation Failed"];
         }   
    }

   

     //funcoes do olerite inicio

    function verificarsearrayOLD($array)
    {
        if (is_array($array) == False){
            return $array;
        }else{
            return "";
        }
    }

    function insertdadosOLD($cpf, $mesRef, $recibo, $empresa, $setor, $endereco, $cnpj, $funcionario, $dataadm, $ferias, $valorTC, $valorTD, $valorTL, $valorFa, $mensagemc1,$valorFGTS, $valorBaseIRRF, $valorBaseINNS, $valorSalarioBase, $valorBaseFGTS, $payment_shipping_id)
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

    function insertdadoscompOLD($id_dados_XML, $descricaoverba1, $valor1, $percentual1, $basecalculo1)
    {
        $insert_xmldbaditional = new Paymentxmladditional();
        $insert_xmldbaditional->id_paymentxmls = $id_dados_XML;
        $insert_xmldbaditional->descricaoverba1 = $descricaoverba1;
        $insert_xmldbaditional->valor1 = $valor1;
        $insert_xmldbaditional->percentual1 = $percentual1;
        $insert_xmldbaditional->basecalculo1 = $basecalculo1;
        $result = $insert_xmldbaditional->save();
    }
}
