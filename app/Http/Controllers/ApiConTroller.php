<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\KhachHang;
use App\Models\LichSuNapTien;
use App\Models\TheCao;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Exists;
use Maatwebsite\Excel\Concerns\ToArray;

class ApiConTroller extends Controller
{
    public function mbbank()
    {
        return view('Client.Api.Mbbank.mb');
    }

    public function autoTheCao(Request $request)
    {
        $type = $request->input('type');
        $menhgia = $request->input('menhgia');
        $seri = $request->input('seri');
        $pin = $request->input('pin');
        $id_nap = rand(100000, 999999);
        $apiKey = 'rxzdwbyRqWvAOHTDfPgmEkYGcilhLQBasFSenKMXJNUVutjZoICp';
        $callback = route('thecao');
        $content = Auth::guard('khach')->user()->id . "|" . $menhgia . "|" . $pin . "|" . $seri . "|" . $type . "|" . $id_nap;
        $apiUrl = "https://nhanthecao.vn/api/card-auto.php?type=$type&menhgia=$menhgia&seri=$seri&pin=$pin&APIKey=$apiKey&callback=$callback&content=$content";
        $client = new Client();
        $response = $client->get($apiUrl);
        $data = json_decode($response->getBody()->getContents(), true);
        if ($data['data']['status'] === "success") {
            TheCao::create([
                'serial' => $seri,
                'pin'    => $pin,
                'money'  => $menhgia,
                'type'   => $type,
                'user_id' => $content,
                'messages' => $data['data']['msg'],
                'status' => 1,
            ]);
            LichSuNapTien::create([
                'user_id' => Auth::guard('khach')->user()->id,
                'type'   => "THẺ CÀO",
                'total'  => $menhgia,
                'thucnhan'  => 'Chưa Có',
                'id_nap'  => $id_nap,
                'status'  => 0,
            ]);
            return response()->json([
                'status' => true,
                'message' => $data['data']['msg'],
            ]);
        } else {
            LichSuNapTien::create([
                'user_id' => Auth::guard('khach')->user()->id,
                'type'   => "THẺ CÀO",
                'total'  => $menhgia,
                'thucnhan'  => 'Chưa Có',
                'status'  => -1,
                'id_nap'  => $id_nap,
            ]);
            TheCao::create([
                'serial' => $seri,
                'pin'    => $pin,
                'money'  => $menhgia,
                'type'   => $type,
                'user_id' => $content,
                'messages' => $data['data']['msg'],
                'status' => 0,
            ]);
            return response()->json([
                'status' => false,
                'message' => $data['data']['msg'],
            ]);
        }
    }
    public function autoMB()
    {
        // BANK
        $PasswordMBBank = 'Vanty^^soishipper123';
        $AccountNumber = '0366508231';
        $TokenMBBank = 'E60A9F9C-58C4-9E67-E1BE-1BEC73275C04';
        $apiUrl = "https://api.web2m.com/historyapimbv3/$PasswordMBBank/$AccountNumber/$TokenMBBank";
        $client = new Client();
        $response = $client->get($apiUrl);
        $res = json_decode($response->getBody()->getContents(), true);
        // CONFIG
        $prefix = "CTP";
        if ($res['status']) {
            foreach ($res['transactions'] as $key => $value) {
                if ($value['type'] === "OUT")
                    continue;
                if (!strpos($value["description"], "CTP"))
                    continue;
                preg_match('/CTP(\d{1,5})/', $value["description"], $id);
                if (isset($id[1]))
                    $user_id = $id[1];
                $check = Bank::where('transactionID', $value["transactionID"])->first();
                $transaction = LichSuNapTien::get("id_nap")->ToArray();
                if (!$check) {
                    Bank::create([
                        'transactionID'     =>  $value["transactionID"],
                        'amount'            =>  $value["amount"],
                        'description'       =>  $value["description"],
                        'type'              =>  $value["type"],
                        'transactionDate'   =>  $value["transactionDate"],
                    ]);
                    if (!in_array($value["transactionID"], $transaction)) {
                        $user = KhachHang::find($user_id);
                        $user->coin = $user->coin + $value["amount"];
                        $user->save();
                        LichSuNapTien::create([
                            'user_id'       => $user->id,
                            'type'          => "NGÂN HÀNG",
                            'total'         => $value["amount"],
                            'thucnhan'      => $value["amount"],
                            'status'        => 1,
                            'id_nap'        => $value["transactionID"],
                        ]);
                    }
                }
            }
        }
        echo "CHÀO MỪNG BẠN ĐẾN VỚI BINCTP.COM";
    }
}
