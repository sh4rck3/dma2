<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Sendsms;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\SendsmsResource;

class SmsadmapiContrroller extends Controller
{
    public function sendsms(Request $request)
    {
        $numerber = str_replace('(', '', $request->phone);
        $numerber = str_replace(')', '', $numerber);
        $numerber = str_replace('-', '', $numerber);

        
        Log::info('SmsadmapiContrroller.sendsms: ' . $numerber);

        $strUrl= 'http://10.9.0.142/API/SendSMS';
        $strPost = '{
            "event":"txsms",
            "userid":"0",
            "num":"0'.$numerber.'",
            "encoding":"0",
            "smsinfo":"'.$request->message.'"
        }';
        Log::info('SmsadmapiContrroller.sendsms: ' . print_r($strPost, true));
        $headerArray =array(
            "Content-type:application/json",
            "Accept:*/*",
            "Acept-Encoding:gzip,deflate",
            "Conction:Keep-Alive"
        );
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_ENCODING, "");
        curl_setopt($curl, CURLOPT_MAXREDIRS, "10");
        curl_setopt($curl, CURLOPT_TIMEOUT, "0");
        curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($curl, CURLOPT_URL, $strUrl);
        curl_setopt($curl, CURLOPT_USERPWD, "ApiUserAdmin:35788484");
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST,FALSE);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $strPost);
        curl_setopt($curl,CURLOPT_HTTPHEADER,$headerArray);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        Log::debug('SmsadmapiContrroller.sendsms: ' . print_r($code, true));
        
        if($code == 200){

            $userLogado = auth()->user();

            $jsonResponse = json_decode($response);
            Log::info('SmsadmapiContrroller.sendsms: ' . print_r($jsonResponse, true));

            $sendsms = new Sendsms();
            $sendsms->phone = $numerber;
            $sendsms->message = $request->message;
            $sendsms->status = '1';
            $sendsms->result = $jsonResponse->result;
            $sendsms->user_id = $userLogado->id;
            $sendsms->document = $request->document;
            $sendsms->content = $jsonResponse->content;
            $sendsms->save();

            //teste
           
            return response()->json([
                'status' => true,
                'title' => 'Sucesso',
                'message' => 'Mensagem está na fila para envio!',
                'returnData' => '0'
            ], Response::HTTP_OK);
        }else{
            return response()->json([
                'status' => false,
                'title' => 'Erro',
                'message' => 'Erro ao enviar mensagem!',
                'returnData' => '0'
            ], Response::HTTP_OK);
        }
        
    }
    /**
     * Display a listing of the resource.
     */
    public function statusresult()
    {
        $statusSms = Sendsms::where('status', '1')->where('result', '!=', 'error')->get();

        foreach ($statusSms as $status) {
            $this->verifisms($status->id);
          Log::info('Verificado->>>>>>>>>: ' . print_r($status->id, true));
        }
        Log::info('Concluido verificação ');
    }

    public function verifisms($id){
        //The URL of the POST request
        $return = Sendsms::find($id);
        $taskid = explode(':', $return->content);
        Log::info('Sendsmsapi::sendsms::return: taskID'.$taskid[1]);

        $strUrl= 'http://10.9.0.142/API/QueryTxSMS';
        $strPost = '{
            "event":"querytxsms",
            "taskid":"'.$taskid[1].'"
        }';
        
        $headerArray =array(
            "Content-type:application/json",
            "Accept:*/*",
            "Acept-Encoding:gzip,deflate",
            "Conction:Keep-Alive"
        );
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_ENCODING, "");
        curl_setopt($curl, CURLOPT_MAXREDIRS, "10");
        curl_setopt($curl, CURLOPT_TIMEOUT, "0");
        curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($curl, CURLOPT_URL, $strUrl);
        curl_setopt($curl, CURLOPT_USERPWD, "ApiUserAdmin:35788484");
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST,FALSE);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $strPost);
        curl_setopt($curl,CURLOPT_HTTPHEADER,$headerArray);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        
        if($code == 200){
           
            $returncurl = json_decode($response);
            $explodecontent = explode(';', $returncurl->content);
            $statusenviosendsms = explode(':', $explodecontent[1]);
            $returnVerifisms = Sendsms::find($id);
            $returnVerifisms->update([
                'port' => $statusenviosendsms[0],
                'status' => $statusenviosendsms[2],
            ]);
            
        }
    }

    
    public function responsesms()
    {
        
        $responseSms = Sendsms::select('sendsms.*', 'users.name')
            ->join('users', 'users.id', '=', 'sendsms.user_id')
            ->when(request('search_global'), function ($query) {
                $query->where(function($q) {
                    $q->where('phone', 'like', '%'.request('search_global').'%')
                        ->orWhere('document', 'like', '%'.request('search_global').'%');

                });
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

            return SendsmsResource::collection($responseSms);
        // when(request('search_global'), function ($query) {
        //         $query->where(function($q) {
        //             $q->where('phone', 'like', '%'.request('search_global').'%')
        //                 ->orWhere('document', 'like', '%'.request('search_global').'%');

        //         });
        //     })
        //     ->orderBy('id', 'desc')
        //     ->paginate(10);

           // return SendsmsResource::collection($responseSms);
    }

}
