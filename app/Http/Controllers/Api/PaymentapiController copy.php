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
        //Log::info("esta aqui no store");
        $xml_file = new Shipping_payments();
        $xml_file->title = $request->title;
        $xml_file->description = $request->description;
        $xml_file->xml_file = $request->file->store('public/uploads');
        $xml_file->original_name = $request->file->getClientOriginalName();
        $xml_file->save();
        $payment_shipping_id = $xml_file->id;
        // if(is_numeric($xml_file->id))
        // {
        //      $xmlfile = file_get_contents($_FILES['file']['tmp_name']);
        //      $new = simplexml_load_string($xmlfile);
        //      $newArr = json_decode(json_encode($new), TRUE);

        //      if(array_key_exists(0, $newArr["FormattedAreaPair"]["FormattedAreaPair"]["FormattedArea"]["FormattedSections"]["FormattedSection"]["FormattedReportObjects"]["FormattedReportObject"]) == True)
        //      {
        //         foreach ($newArr["FormattedAreaPair"]["FormattedAreaPair"]["FormattedArea"]["FormattedSections"]["FormattedSection"]["FormattedReportObjects"]["FormattedReportObject"] as $sessoes)
        //         {
        //             foreach ($sessoes["FormattedAreaPair"]["FormattedAreaPair"]["FormattedAreaPair"]["FormattedAreaPair"]["FormattedAreaPair"]["FormattedAreaPair"] as $dados) 
        //             {
        //                 // ----- emplyes and company data ----- //
        //                 foreach ($dados["FormattedArea"][0]["FormattedSections"]["FormattedSection"][2]["FormattedReportObjects"]["FormattedReportObject"] as $dempresa){
        //                     switch ($dempresa["ObjectName"]) {
        //                         case 'Text1':
        //                                 $recibo = $dempresa["TextValue"];
        //                             break;
        //                         case 'EMPRESA1':
        //                             $codigoNomeEmpresa = $this->verificarsearray($dempresa["FormattedValue"]);
        //                             break;
        //                         case 'Text2':
        //                                 $recibo1 = $dempresa["TextValue"];
        //                             break;
        //                         case 'SETOR1':
        //                                 $setor = $this->verificarsearray($dempresa["FormattedValue"]);
        //                             break;
        //                         case 'ENDEREÇO1':
        //                                 $endereco = $dempresa["FormattedValue"];
        //                             break;
        //                         case 'CNPJ1':
        //                                 $cnpj = $dempresa["FormattedValue"];
        //                             break;
        //                         case 'TÍTULO11':
        //                                 $funcionario = $dempresa["FormattedValue"];
        //                             break;
        //                         case 'TÍTULO21':
        //                                 $dataadm = $dempresa["FormattedValue"];
        //                             break;
        //                         case 'TÍTULO31':
        //                                 $ferias = $dempresa["FormattedValue"];
        //                                 $cpfTemp = explode(" - ", $ferias);
        //                                 foreach ($cpfTemp as $dadosTemp){
        //                                     if (substr($dadosTemp, 0, 4) == "CPF:"){
        //                                         $cpf = str_replace("CPF:", "", $dadosTemp);
        //                                         $cpf = str_replace(" ", "", $cpf);
        //                                     }
        //                                 }
        //                             break;
        //                         default:
        //                         $cpf = ''; $recibo = ''; $recibo1 = ''; $empresa = ''; $setor = ''; $endereco = ''; $cnpj = ''; 
        //                         $funcionario = ''; $dataadm = ''; $ferias = ''; 
        //                         $codigoNomeEmpresa = '';
        //                             break;
        //                     }
        //                 }
        
        //                 // ----- employee company values data ----- //
        //                 foreach ($dados["FormattedArea"][1]["FormattedSections"]["FormattedSection"][1]["FormattedReportObjects"]["FormattedReportObject"] as $dvalores)
        //                 {
        //                     switch ($dvalores["ObjectName"]) 
        //                     {
        //                         case 'Vtotalc1':
        //                             $valorTC = $dvalores["FormattedValue"];
        //                             break;
        //                         case 'Vtotald1':
        //                             $valorTD = $dvalores["FormattedValue"];
        //                             break;
        //                         case 'Vliquido1':
        //                             $valorTL = $dvalores["FormattedValue"];
        //                             break;
        //                         case 'Faixair1':
        //                             $valorFa = $dvalores["FormattedValue"];
        //                             break;
        //                         case 'Mensagemcc1':
        //                             $Mensagemcc1 = $this->verificarsearray($dvalores["FormattedValue"]);
        //                             break;
        //                         case 'ValFgts1':
        //                             $valorFGTS = $dvalores["FormattedValue"];
        //                             break;
        //                         case 'MovimentoMêsdereferência2':
        //                             $mesRef = $dvalores["FormattedValue"];
        //                             break;
        //                         case 'BaseIRRF1':
        //                             $valorBaseIRRF = $dvalores["FormattedValue"];
        //                             break;
        //                         case 'SalárioBase1':
        //                             $valorSalarioBase = $dvalores["FormattedValue"];
        //                             break;
        //                         case 'BaseFGTS1':
        //                             $valorBaseFGTS = $dvalores["FormattedValue"];
        //                             break;
        //                         default:
        //                             $valorTC = ''; $valorTD = ''; $valorTL= ''; $valorFa = ''; $mensagemc1 = ''; $valorFGTS = '';
        //                             $mesRef = ''; $valorBaseIRRF = ''; $valorBaseINNS = ''; $valorSalarioBase = ''; $valorBaseFGTS = '';
        //                             break;
        //                     }
        //                 }
                        
        //                  //transforming in to array values
        //                  if(!empty($cpf))
        //                  {
        //                      $datainsertXML = [
        //                          'cpf' => $cpf, 
        //                          'mesRef' => $mesRef, 
        //                          'recibo' => $recibo, 
        //                          'empresa' => $empresa, 
        //                          'setor' => $setor, 
        //                          'endereco' => $endereco, 
        //                          'cnpj' => $cnpj, 
        //                          'funcionario' => $funcionario, 
        //                          'dataadm' => $dataadm, 
        //                          'ferias' => $ferias, 
        //                          'valorTC' => $valorTC, 
        //                          'valorTD' => $valorTD, 
        //                          'valorTL' => $valorTL, 
        //                          'valorFa' => $valorFa, 
        //                          'mensagemc1' => $mensagemc1,
        //                          'valorFGTS' => $valorFGTS, 
        //                          'valorBaseIRRF' => $valorBaseIRRF, 
        //                          'valorBaseINNS' => $valorBaseINNS, 
        //                          'valorSalarioBase' => $valorSalarioBase, 
        //                          'valorBaseFGTS' => $valorBaseFGTS, 
        //                          'payment_shipping_id' => $payment_shipping_id
        //                      ];
        //                  //insert in database and return id and document for insert in table paymentxmladditional
        //                  $returnIdCpf = $this->insertdados($datainsertXML);
        //                  }
        //                 // ----- Descritivos ----- //
        
        //                 if(array_key_exists(0, $dados["FormattedAreaPair"]) == True)
        //                 {
        //                     foreach($dados["FormattedAreaPair"] as $ddescaux)
        //                     {
        //                         if(array_key_exists(0, $ddescaux["FormattedAreaPair"]) == True)
        //                         {
        //                             foreach($ddescaux["FormattedAreaPair"] as $ddescaux1)
        //                             {
        //                                 if(array_key_exists(0, $ddescaux1["FormattedAreaPair"]) == True)
        //                                 {
        //                                     foreach($ddescaux1["FormattedAreaPair"] as $ddescaux3)
        //                                     {
        //                                         foreach($ddescaux3["FormattedArea"]["FormattedSections"]["FormattedSection"]["FormattedReportObjects"]["FormattedReportObject"] as $ddescaux2)
        //                                         {
        //                                             switch ($ddescaux2["ObjectName"]) 
        //                                             {
        //                                                 case 'DESCRIÇÃODAVERBA1':
        //                                                     $descricaoverba1 = $ddescaux2["FormattedValue"];
        //                                                     break;
        //                                                 case 'Valor1':
        //                                                     $valor1 = $this->verificarsearray($ddescaux2["FormattedValue"]);
        //                                                     break;
        //                                                 case 'Valor2':
        //                                                     $percentual1 = $this->verificarsearray($ddescaux2["FormattedValue"]);
        //                                                     break;
        //                                                 case 'Percentual1':
        //                                                     $percentual1 = $this->verificarsearray($ddescaux2["FormattedValue"]);
        //                                                     break;
        //                                                 case 'Basecálculo1':
        //                                                     $basecalculo1 = $this->verificarsearray($ddescaux2["FormattedValue"]);
        //                                                     break;
        //                                                 default:
        //                                                     $descricaoverba1 = ''; $valor1 = ''; $percentual1 = ''; $basecalculo1 = '';
        //                                                     break;
        //                                             }
        //                                         }//final do foreach decaux2
        //                                         $this->insertdadoscomp($returnIdCpf, $descricaoverba1, $valor1, $percentual1, $basecalculo1);
        //                                     }//final do foreach decaux1
        //                                 }else{            
        //                                     foreach($ddescaux1["FormattedAreaPair"]["FormattedArea"]["FormattedSections"]["FormattedSection"]["FormattedReportObjects"]["FormattedReportObject"] as $ddescaux2){
        //                                         switch ($ddescaux2["ObjectName"]) 
        //                                         {
        //                                             case 'DESCRIÇÃODAVERBA1':
        //                                                 $descricaoverba1 = $ddescaux2["FormattedValue"];
        //                                                 break;
        //                                             case 'Valor1':
        //                                                 $valor1 = $this->verificarsearray($ddescaux2["FormattedValue"]);
        //                                                 break;
        //                                             case 'Valor2':
        //                                                 $percentual1 = $this->verificarsearray($ddescaux2["FormattedValue"]);
        //                                                 break;
        //                                             case 'Percentual1':
        //                                                 $percentual1 = $this->verificarsearray($ddescaux2["FormattedValue"]);
        //                                                 break;
        //                                             case 'Basecálculo1':
        //                                                 $basecalculo1 = $this->verificarsearray($ddescaux2["FormattedValue"]);
        //                                                 break;
        //                                             default:
        //                                                 $descricaoverba1 = ''; $valor1 = ''; $percentual1 = ''; $basecalculo1 = '';
        //                                                 break;
        //                                         }
        //                                     }//final do foreach ddescaux1
        //                                     $this->insertdadoscomp($returnIdCpf, $descricaoverba1, $valor1, $percentual1, $basecalculo1);
        //                                 }//final do else do: if(array_key_exists(0, $ddescaux1["FormattedAreaPair"]) == True)
        //                             }//final do foreach ddescaux : foreach($ddescaux["FormattedAreaPair"] as $ddescaux1)
        //                         }else{
        //                             foreach($ddescaux["FormattedAreaPair"]["FormattedAreaPair"]["FormattedArea"]["FormattedSections"]["FormattedSection"]["FormattedReportObjects"]["FormattedReportObject"] as $ddescaux2){
        //                                 switch ($ddescaux2["ObjectName"]) 
        //                                 {
        //                                     case 'DESCRIÇÃODAVERBA1':
        //                                         $descricaoverba1 = $ddescaux2["FormattedValue"];
        //                                         break;
        //                                     case 'Valor1':
        //                                         $valor1 = $this->verificarsearray($ddescaux2["FormattedValue"]);
        //                                         break;
        //                                     case 'Valor2':
        //                                         $percentual1 = $this->verificarsearray($ddescaux2["FormattedValue"]);
        //                                         break;
        //                                     case 'Percentual1':
        //                                         $percentual1 = $this->verificarsearray($ddescaux2["FormattedValue"]);
        //                                         break;
        //                                     case 'Basecálculo1':
        //                                         $basecalculo1 = $this->verificarsearray($ddescaux2["FormattedValue"]);
        //                                         break;
        //                                     default:
        //                                         $descricaoverba1 = ''; $valor1 = ''; $percentual1 = ''; $basecalculo1 = '';
        //                                         break;
        //                                 }
        //                             }
        //                             $this->insertdadoscomp($returnIdCpf, $descricaoverba1, $valor1, $percentual1, $basecalculo1);
        //                         }
        //                     }
        //                 }else{
        //                     if(array_key_exists(0, $dados["FormattedAreaPair"]["FormattedAreaPair"]) == True){
        //                         foreach($dados["FormattedAreaPair"]["FormattedAreaPair"] as $ddescaux){
        //                             foreach($ddescaux["FormattedAreaPair"]["FormattedArea"]["FormattedSections"]["FormattedSection"]["FormattedReportObjects"]["FormattedReportObject"] as $ddescaux2){
        //                                 switch ($ddescaux2["ObjectName"]) 
        //                                 {
        //                                     case 'DESCRIÇÃODAVERBA1':
        //                                         $descricaoverba1 = $ddescaux2["FormattedValue"];
        //                                         break;
        //                                     case 'Valor1':
        //                                         $valor1 = $this->verificarsearray($ddescaux2["FormattedValue"]);
        //                                         break;
        //                                     case 'Valor2':
        //                                         $percentual1 = $this->verificarsearray($ddescaux2["FormattedValue"]);
        //                                         break;
        //                                     case 'Percentual1':
        //                                         $percentual1 = $this->verificarsearray($ddescaux2["FormattedValue"]);
        //                                         break;
        //                                     case 'Basecálculo1':
        //                                         $basecalculo1 = $this->verificarsearray($ddescaux2["FormattedValue"]);
        //                                         break;
        //                                     default:
        //                                         $descricaoverba1 = ''; $valor1 = ''; $percentual1 = ''; $basecalculo1 = '';
        //                                         break;
        //                                 }
        //                             }
        //                             $this->insertdadoscomp($returnIdCpf, $descricaoverba1, $valor1, $percentual1, $basecalculo1);
        //                         }
        //                     }else{
        //                         foreach($dados["FormattedAreaPair"]["FormattedAreaPair"]["FormattedAreaPair"]["FormattedArea"]["FormattedSections"]["FormattedSection"]["FormattedReportObjects"]["FormattedReportObject"] as $ddescaux2){
        //                             switch ($ddescaux2["ObjectName"]) 
        //                             {
        //                                 case 'DESCRIÇÃODAVERBA1':
        //                                     $descricaoverba1 = $ddescaux2["FormattedValue"];
        //                                     break;
        //                                 case 'Valor1':
        //                                     $valor1 = $this->verificarsearray($ddescaux2["FormattedValue"]);
        //                                     break;
        //                                 case 'Valor2':
        //                                     $percentual1 = $this->verificarsearray($ddescaux2["FormattedValue"]);
        //                                     break;
        //                                 case 'Percentual1':
        //                                     $percentual1 = $this->verificarsearray($ddescaux2["FormattedValue"]);
        //                                     break;
        //                                 case 'Basecálculo1':
        //                                     $basecalculo1 = $this->verificarsearray($ddescaux2["FormattedValue"]);
        //                                     break;
        //                                 default:
        //                                     $descricaoverba1 = ''; $valor1 = ''; $percentual1 = ''; $basecalculo1 = '';
        //                                     break;
        //                             }
        //                         }
        //                         $this->insertdadoscomp($returnIdCpf, $descricaoverba1, $valor1, $percentual1, $basecalculo1);
        //                     }
        //                 }
        //             }
        //         }//fim do primeiro foreach
        //         //echo "<script>location.href='page_import_xml.php';</script>";
        //         Log::info("inseridos pela primeira fase ->>>>>>>>>>>>>>>>");
        //     }else{  //fim do primeiro if que determina se tem  a chave 0 dentro do array
        //         foreach ($newArr["FormattedAreaPair"]["FormattedAreaPair"]["FormattedArea"]["FormattedSections"]["FormattedSection"]["FormattedReportObjects"]["FormattedReportObject"]["FormattedAreaPair"]["FormattedAreaPair"]["FormattedAreaPair"]["FormattedAreaPair"]["FormattedAreaPair"]["FormattedAreaPair"] as $dados) 
        //         {
        //             // ----- emplyes and company data ----- //
        //             foreach ($dados["FormattedArea"][0]["FormattedSections"]["FormattedSection"][2]["FormattedReportObjects"]["FormattedReportObject"] as $dempresa)
        //             {
        //                 switch ($dempresa["ObjectName"]) 
        //                 {
        //                     case 'Text1':
        //                             $recibo = $dempresa["TextValue"];
        //                         break;
        //                     case 'EMPRESA1':
        //                         $codigoNomeEmpresa = $this->verificarsearray($dempresa["FormattedValue"]);
        //                         break;
        //                     case 'Text2':
        //                             $recibo1 = $dempresa["TextValue"];
        //                         break;
        //                     case 'SETOR1':
        //                             $setor = $this->verificarsearray($dempresa["FormattedValue"]);
        //                         break;
        //                     case 'ENDEREÇO1':
        //                             $endereco = $dempresa["FormattedValue"];
        //                         break;
        //                     case 'CNPJ1':
        //                             $cnpj = $dempresa["FormattedValue"];
        //                         break;
        //                     case 'TÍTULO11':
        //                             $funcionario = $dempresa["FormattedValue"];
        //                         break;
        //                     case 'TÍTULO21':
        //                             $dataadm = $dempresa["FormattedValue"];
        //                         break;
        //                     case 'TÍTULO31':
        //                             $ferias = $dempresa["FormattedValue"];
        //                             $cpfTemp = explode(" - ", $ferias);
        //                             foreach ($cpfTemp as $dadosTemp){
        //                                 if (substr($dadosTemp, 0, 4) == "CPF:"){
        //                                     $cpf = str_replace("CPF:", "", $dadosTemp);
        //                                     $cpf = str_replace(" ", "", $cpf);
        //                                 }
        //                             }
        //                         break;
        //                     default:
        //                     $cpf = ''; $recibo = ''; $recibo1 = ''; $empresa = ''; $setor = ''; $endereco = ''; $cnpj = ''; 
        //                     $funcionario = ''; $dataadm = ''; $ferias = ''; 
        //                     $codigoNomeEmpresa = '';
        //                         break;
        //                 }
        //             }
    
        //             // ----- employee company values data ----- //
        //             foreach ($dados["FormattedArea"][1]["FormattedSections"]["FormattedSection"][1]["FormattedReportObjects"]["FormattedReportObject"] as $dvalores)
        //             {
        //                 switch ($dvalores["ObjectName"]) 
        //                 {
        //                     case 'Vtotalc1':
        //                         $valorTC = $dvalores["FormattedValue"];
        //                         break;
        //                     case 'Vtotald1':
        //                         $valorTD = $dvalores["FormattedValue"];
        //                         break;
        //                     case 'Vliquido1':
        //                         $valorTL = $dvalores["FormattedValue"];
        //                         break;
        //                     case 'Faixair1':
        //                         $valorFa = $dvalores["FormattedValue"];
        //                         break;
        //                     case 'Mensagemcc1':
        //                         $Mensagemcc1 = $this->verificarsearray($dvalores["FormattedValue"]);
        //                         break;
        //                     case 'ValFgts1':
        //                         $valorFGTS = $dvalores["FormattedValue"];
        //                         break;
        //                     case 'MovimentoMêsdereferência2':
        //                         $mesRef = $dvalores["FormattedValue"];
        //                         break;
        //                     case 'BaseIRRF1':
        //                         $valorBaseIRRF = $dvalores["FormattedValue"];
        //                         break;
        //                     case 'SalárioBase1':
        //                         $valorSalarioBase = $dvalores["FormattedValue"];
        //                         break;
        //                     case 'BaseFGTS1':
        //                         $valorBaseFGTS = $dvalores["FormattedValue"];
        //                         break;
        //                     default:
        //                         $valorTC = ''; $valorTD = ''; $valorTL= ''; $valorFa = ''; $mensagemc1 = ''; $valorFGTS = '';
        //                         $mesRef = ''; $valorBaseIRRF = ''; $valorBaseINNS = ''; $valorSalarioBase = ''; $valorBaseFGTS = '';
        //                         break;
        //                 }
        //             }
                    
        //              //transforming in to array values
        //             if(!empty($cpf))
        //             {
        //                  $datainsertXML = [
        //                      'cpf' => $cpf, 
        //                      'mesRef' => $mesRef, 
        //                      'recibo' => $recibo, 
        //                      'empresa' => $empresa, 
        //                      'setor' => $setor, 
        //                      'endereco' => $endereco, 
        //                      'cnpj' => $cnpj, 
        //                      'funcionario' => $funcionario, 
        //                      'dataadm' => $dataadm, 
        //                      'ferias' => $ferias, 
        //                      'valorTC' => $valorTC, 
        //                      'valorTD' => $valorTD, 
        //                      'valorTL' => $valorTL, 
        //                      'valorFa' => $valorFa, 
        //                      'mensagemc1' => $mensagemc1,
        //                      'valorFGTS' => $valorFGTS, 
        //                      'valorBaseIRRF' => $valorBaseIRRF, 
        //                      'valorBaseINNS' => $valorBaseINNS, 
        //                      'valorSalarioBase' => $valorSalarioBase, 
        //                      'valorBaseFGTS' => $valorBaseFGTS, 
        //                      'payment_shipping_id' => $payment_shipping_id
        //                  ];
        //              //insert in database and return id and document for insert in table paymentxmladditional
        //              $returnIdCpf = $this->insertdados($datainsertXML);
        //             }
        //             // ----- Descritivos ----- //
        //             if(array_key_exists(0, $dados["FormattedAreaPair"]) == True){
        //                 foreach($dados["FormattedAreaPair"] as $ddescaux){
        //                     if(array_key_exists(0, $ddescaux["FormattedAreaPair"]) == True){
        //                         foreach($ddescaux["FormattedAreaPair"] as $ddescaux1){
        //                             if(array_key_exists(0, $ddescaux1["FormattedAreaPair"]) == True){
        //                                 foreach($ddescaux1["FormattedAreaPair"] as $ddescaux3){
        //                                     foreach($ddescaux3["FormattedArea"]["FormattedSections"]["FormattedSection"]["FormattedReportObjects"]["FormattedReportObject"] as $ddescaux2){
        //                                         switch ($ddescaux2["ObjectName"]) 
        //                                         {
        //                                             case 'DESCRIÇÃODAVERBA1':
        //                                                 $descricaoverba1 = $ddescaux2["FormattedValue"];
        //                                                 break;
        //                                             case 'Valor2':
        //                                                 $percentual1 = $this->verificarsearray($ddescaux2["FormattedValue"]);
        //                                                 break;
        //                                             case 'Valor1':
        //                                                 $valor1 = $this->verificarsearray($ddescaux2["FormattedValue"]);
        //                                                 break;
        //                                             case 'Percentual1':
        //                                                 $percentual1 = $this->verificarsearray($ddescaux2["FormattedValue"]);
        //                                                 break;
        //                                             case 'Basecálculo1':
        //                                                 $basecalculo1 = $this->verificarsearray($ddescaux2["FormattedValue"]);
        //                                                 break;
        //                                             default:
        //                                                 $descricaoverba1 = ''; $valor1 = ''; $percentual1 = ''; $basecalculo1 = '';
        //                                                 break;
        //                                         }
        //                                     }
        //                                     $this->insertdadoscomp($returnIdCpf, $descricaoverba1, $valor1, $percentual1, $basecalculo1);
        //                                 }
        //                             }else{
        //                                 foreach($ddescaux1["FormattedAreaPair"]["FormattedArea"]["FormattedSections"]["FormattedSection"]["FormattedReportObjects"]["FormattedReportObject"] as $ddescaux2){
        //                                     switch ($ddescaux2["ObjectName"]) 
        //                                     {
        //                                         case 'DESCRIÇÃODAVERBA1':
        //                                             $descricaoverba1 = $ddescaux2["FormattedValue"];
        //                                             break;
        //                                         case 'Valor2':
        //                                             $percentual1 = $this->verificarsearray($ddescaux2["FormattedValue"]);
        //                                             break;
        //                                         case 'Valor1':
        //                                             $valor1 = $this->verificarsearray($ddescaux2["FormattedValue"]);
        //                                             break;
        //                                         case 'Percentual1':
        //                                             $percentual1 = $this->verificarsearray($ddescaux2["FormattedValue"]);
        //                                             break;
        //                                         case 'Basecálculo1':
        //                                             $basecalculo1 = $this->verificarsearray($ddescaux2["FormattedValue"]);
        //                                             break;
        //                                         default:
        //                                             $descricaoverba1 = ''; $valor1 = ''; $percentual1 = ''; $basecalculo1 = '';
        //                                             break;
        //                                     }
        //                                 }
        //                                 $this->insertdadoscomp($returnIdCpf, $descricaoverba1, $valor1, $percentual1, $basecalculo1);
        //                             }
        //                         }
        //                     }else{
        //                         foreach($ddescaux["FormattedAreaPair"]["FormattedAreaPair"]["FormattedArea"]["FormattedSections"]["FormattedSection"]["FormattedReportObjects"]["FormattedReportObject"] as $ddescaux2){
        //                             switch ($ddescaux2["ObjectName"]) 
        //                             {
        //                                 case 'DESCRIÇÃODAVERBA1':
        //                                     $descricaoverba1 = $ddescaux2["FormattedValue"];
        //                                     break;
        //                                 case 'Valor2':
        //                                     $percentual1 = $this->verificarsearray($ddescaux2["FormattedValue"]);
        //                                     break;
        //                                 case 'Valor1':
        //                                     $valor1 = $this->verificarsearray($ddescaux2["FormattedValue"]);
        //                                     break;
        //                                 case 'Percentual1':
        //                                     $percentual1 = $this->verificarsearray($ddescaux2["FormattedValue"]);
        //                                     break;
        //                                 case 'Basecálculo1':
        //                                     $basecalculo1 = $this->verificarsearray($ddescaux2["FormattedValue"]);
        //                                     break;
        //                                 default:
        //                                     $descricaoverba1 = ''; $valor1 = ''; $percentual1 = ''; $basecalculo1 = '';
        //                                     break;
        //                             }
        //                         }
        //                         $this->insertdadoscomp($returnIdCpf, $descricaoverba1, $valor1, $percentual1, $basecalculo1);
        //                     }
        //                 }
        //             }else{
        //                 if(array_key_exists(0, $dados["FormattedAreaPair"]["FormattedAreaPair"]) == True){
        //                     foreach($dados["FormattedAreaPair"]["FormattedAreaPair"] as $ddescaux){
        //                         foreach($ddescaux["FormattedAreaPair"]["FormattedArea"]["FormattedSections"]["FormattedSection"]["FormattedReportObjects"]["FormattedReportObject"] as $ddescaux2){
        //                             switch ($ddescaux2["ObjectName"]) 
        //                             {
        //                                 case 'DESCRIÇÃODAVERBA1':
        //                                     $descricaoverba1 = $ddescaux2["FormattedValue"];
        //                                     break;
        //                                 case 'Valor2':
        //                                     $percentual1 = $this->verificarsearray($ddescaux2["FormattedValue"]);
        //                                     break;
        //                                 case 'Valor1':
        //                                     $valor1 = $this->verificarsearray($ddescaux2["FormattedValue"]);
        //                                     break;
        //                                 case 'Percentual1':
        //                                     $percentual1 = $this->verificarsearray($ddescaux2["FormattedValue"]);
        //                                     break;
        //                                 case 'Basecálculo1':
        //                                     $basecalculo1 = $this->verificarsearray($ddescaux2["FormattedValue"]);
        //                                     break;
        //                                 default:
        //                                     $descricaoverba1 = ''; $valor1 = ''; $percentual1 = ''; $basecalculo1 = '';
        //                                     break;
        //                             }
        //                         }
        //                         $this->insertdadoscomp($returnIdCpf, $descricaoverba1, $valor1, $percentual1, $basecalculo1);
        //                     }
        //                 }else{
        //                     foreach($dados["FormattedAreaPair"]["FormattedAreaPair"]["FormattedAreaPair"]["FormattedArea"]["FormattedSections"]["FormattedSection"]["FormattedReportObjects"]["FormattedReportObject"] as $ddescaux2){
        //                         switch ($ddescaux2["ObjectName"]) 
        //                         {
        //                             case 'DESCRIÇÃODAVERBA1':
        //                                 $descricaoverba1 = $ddescaux2["FormattedValue"];
        //                                 break;
        //                             case 'Valor2':
        //                                 $percentual1 = $this->verificarsearray($ddescaux2["FormattedValue"]);
        //                                 break;
        //                             case 'Valor1':
        //                                 $valor1 = $this->verificarsearray($ddescaux2["FormattedValue"]);
        //                                 break;
        //                             case 'Percentual1':
        //                                 $percentual1 = $this->verificarsearray($ddescaux2["FormattedValue"]);
        //                                 break;
        //                             case 'Basecálculo1':
        //                                 $basecalculo1 = $this->verificarsearray($ddescaux2["FormattedValue"]);
        //                                 break;
        //                             default:
        //                                 $descricaoverba1 = ''; $valor1 = ''; $percentual1 = ''; $basecalculo1 = '';
        //                                 break;
        //                         }
        //                     }
        //                     $this->insertdadoscomp($returnIdCpf, $descricaoverba1, $valor1, $percentual1, $basecalculo1);
        //                 }
        //             }
        //         }
        //         //echo "<script>location.href='page_import_xml.php';</script>";
        //         Log::info("inseridos pela segunda fase");
        
        //     } 

            
        // }    
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

    function insertdados($datainsertXML)
    {
        
        $linha = Paymentxml::where('cpf', $datainsertXML['cpf'])->where('mesRef', $datainsertXML['mesRef'])->first();
        if(!empty($linha)){
            
                $userLogged = Auth::user();
                $insert_xmldb = Paymentxml::find($linha->id);
                $insert_xmldb->update([
                    'user_id' => $userLogged->id,
                    'payment_shipping' => $payment_shipping_id,
                    'cpf' =>  $datainsertXML['cpf'],
                    'mes_ref' => $datainsertXML['mesRef'],
                    'recibo' => $datainsertXML['recibo'],
                    'empresa' => $datainsertXML['empresa'],
                    'setor' => $datainsertXML['setor'],
                    'endereco' => $datainsertXML['endereco'],
                    'cnpj' => $datainsertXML['cnpj'],
                    'funcionario' => $datainsertXML['funcionario'],
                    'dataadm' => $datainsertXML['dataadm'],
                    'ferias' => $datainsertXML['ferias'],
                    'valorTC' => $datainsertXML['valorTC'],
                    'valorTD' => $datainsertXML['valorTD'],
                    'valorTL' => $datainsertXML['valorTL'],
                    'valorFa' => $datainsertXML['valorFa'],
                    'mensagemc1' => $datainsertXML['mensagemc1'],
                    'valorFGTS' => $datainsertXML['valorFGTS'],
                    'valorBaseIRRF' => $datainsertXML['valorBaseIRRF'],
                    'valorBaseINNS' => $datainsertXML['valorBaseINNS'],
                    'valorSalarioBase' => $datainsertXML['valorSalarioBase'],
                    'valorBaseFGTS' => $datainsertXML['valorBaseFGTS'],
                ]);

                Paymentxmladditional::where('id_paymentxmls', $linha->id)->where('aditional_cpf', $linha->cpf)->delete();
                return $linha->id . '=' .$linha->cpf;
        }else{
                $userLogged = Auth::user();
                $insert_xmldb = new Paymentxml();
                $insert_xmldb->user_id = $userLogged->id;
                $insert_xmldb->payment_shipping = $payment_shipping_id;
                $insert_xmldb->cpf = $datainsertXML['cpf'];
                $insert_xmldb->mesRef = $datainsertXML['mesRef'];
                $insert_xmldb->recibo = $datainsertXML['recibo'];
                $insert_xmldb->empresa = $datainsertXML['empresa'];
                $insert_xmldb->setor = $datainsertXML['setor'];
                $insert_xmldb->endereco = $datainsertXML['endereco'];
                $insert_xmldb->cnpj = $datainsertXML['cnpj'];
                $insert_xmldb->funcionario = $datainsertXML['funcionario'];
                $insert_xmldb->dataadm = $datainsertXML['dataadm'];
                $insert_xmldb->ferias = $datainsertXML['ferias'];
                $insert_xmldb->valorTC = $datainsertXML['valorTC'];
                $insert_xmldb->valorTD = $datainsertXML['valorTD'];
                $insert_xmldb->valorTL = $datainsertXML['valorTL'];
                $insert_xmldb->valorFa = $datainsertXML['valorFa'];
                $insert_xmldb->mensagemc1 = $datainsertXML['mensagemc1'];
                $insert_xmldb->valorFGTS = $datainsertXML['valorFGTS'];
                $insert_xmldb->valorBaseIRRF = $datainsertXML['valorBaseIRRF'];
                $insert_xmldb->valorBaseINNS = $datainsertXML['valorBaseINNS'];
                $insert_xmldb->valorSalarioBase = $datainsertXML['valorSalarioBase'];
                $insert_xmldb->valorBaseFGTS = $datainsertXML['valorBaseFGTS'];
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
