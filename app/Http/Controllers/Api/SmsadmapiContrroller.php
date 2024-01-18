<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Sendsms;

class SmsadmapiContrroller extends Controller
{
    public function sendsms(Request $request)
    {
        $numerber = str_replace('(', '', $request->phone);
        $numerber = str_replace(')', '', $numerber);
        $numerber = str_replace('-', '', $numerber);

        
        Log::info('SmsadmapiContrroller.sendsms: ' . $numerber);

        $strUrl= 'http://172.23.4.222/API/SendSMS';
        //The POST request data, which is a JSON string
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
            //"Autorization: Basic ".base64_encode("ApiUserAdmin:35788484"),
            "Acept-Encoding:gzip,deflate",
            "Conction:Keep-Alive"
        );
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_ENCODING, "");
        curl_setopt($curl, CURLOPT_MAXREDIRS, "10");
        curl_setopt($curl, CURLOPT_TIMEOUT, "0");
        curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($curl, CURLOPT_URL, $strUrl);
        //Add user authentication information (username and password) here
        curl_setopt($curl, CURLOPT_USERPWD, "ApiUserAdmin:35788484");
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST,FALSE);
        curl_setopt($curl, CURLOPT_POST, 1);
        //strPost saves POST request behavior, such as: {"event":"getportinfo"}
        curl_setopt($curl, CURLOPT_POSTFIELDS, $strPost);
        curl_setopt($curl,CURLOPT_HTTPHEADER,$headerArray);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        //Get the POST return data, find the ok keyword to determine the request verification success
        $strResponse = curl_multi_getcontent($curl) ;
        // POST return code, 200 ok success, view http for other error codes
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        
        if($code == 200){

            $userLogado = auth()->user();

            $sensms = new Sendsms();
            $sensms->phone = $numerber;
            $sensms->message = $request->message;
            $sensms->status = '1';
            $sensms->response = $strResponse;
            $sensms->user_id = $userLogado->id;
            $sensms->document = $request->document;
            $sensms->save();

           
            return response()->json([
                'status' => true,
                'title' => 'Sucesso',
                'message' => 'Mensagem está na fila para envio!',
                'returnData' => '0'
            ], 200);
        }
        
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
