<?php

namespace App\Http\Controllers;

use App\Models\TheCao;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiConTroller extends Controller
{
    public function mbbank()
    {
        return view('Client.Api.Mbbank.mb');
    }
    function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data)
            )
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        //execute post
        $result = curl_exec($ch);
        //close connection
        curl_close($ch);
        return $result;
    }
    public function autoTheCao(Request $request){
        $type = $request->input('type');
        $menhgia = $request->input('menhgia');
        $seri = $request->input('seri');
        $pin = $request->input('pin');
        $apiKey = 'rxzdwbyRqWvAOHTDfPgmEkYGcilhLQBasFSenKMXJNUVutjZoICp';
        // $callback = "/callback-thecao";
        $content = Auth::guard('khach')->user()->id;
        $apiUrl = "https://nhanthecao.vn/api/card-auto.php?type=$type&menhgia=$menhgia&seri=$seri&pin=$pin&APIKey=$apiKey&callback=https://binctp.com/callback-thecao&content=$content";
        $client = new Client();
        $response = $client->get($apiUrl);

        $data = json_decode($response->getBody()->getContents(), true);
        if($data['data']['status']==="success"){
            TheCao::create([
                'serial' => $seri,
                'pin'    => $pin,
                'money'  => $menhgia,
                'type'   => $type,
                'user_id'=> $content,
                'messages'=> $data['data']['msg'],
                'status' => 1,
            ]);
            return response()->json([
                'status' => true,
                'message'=>$data['data']['msg'],
            ]);
        }else{
            TheCao::create([
                'serial' => $seri,
                'pin'    => $pin,
                'money'  => $menhgia,
                'type'   => $type,
                'user_id'=> $content,
                'messages'=> $data['data']['msg'],
                'status' => 0,
            ]);
            return response()->json([
                'status' => false,
                'message'=>$data['data']['msg'],
            ]);
        }
    }

}
