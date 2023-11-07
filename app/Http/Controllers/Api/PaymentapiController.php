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

                //quantidade de funcionários importados
                $i++;
            }
        //Log::debug("PaymentapiController.storage - quantidade de funcionarios " . $i);    
        return response()->json([
            'status' => true,
            'title' => 'Sucesso!',
            'message' => 'Arquivo importado com sucesso! <br> Quantidade de funcionários importados:' . $i,
            'quantidade' => $i,
        ], Response::HTTP_OK);
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
                    'cpf' => $linha->cpf
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
                    'cpf' => $insert_xmldb->cpf
                ];
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
