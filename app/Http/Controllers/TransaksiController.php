<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Transaksi;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksiPading['listPanding'] = Transaksi::whereStatus("MENUNGGU")->get();

        $transaksiSelesai['listDone'] = Transaksi::where("Status", "NOT LIKE", "%MENUNGGU%")->get();

        return view('transaksis.index')->with($transaksiPading)->with($transaksiSelesai);
    }

    public function batal($id){
        $transaksi = Transaksi::with(['details.produk', 'user'])->where('id', $id)->first();
        $this->pushNotif('Transaksi Diproses', "Transasi produk ".$transaksi->details[0]->produk->name." sedang diproses", $transaksi->user->fcm);
        $transaksi->update([
            'status' => "BATAL"
        ]);
        return redirect()->back()->with(['status' => ' BATAL']);
        //return redirect('transaksis.index');
    }

    public function confirm($id){
        $transaksi = Transaksi::with(['details.produk', 'user'])->where('id', $id)->first();
        $this->pushNotif('Transaksi Diproses', "Transasi produk ".$transaksi->details[0]->produk->name." sedang diproses", $transaksi->user->fcm);
        $transaksi->update([
            'status' => "PROSES"
        ]);
        return redirect()->back()->with(['status' => ' PROSES']);
        //return redirect('transaksis.index');
    }

    public function kirim($id){
        $transaksi = Transaksi::with(['details.produk', 'user'])->where('id', $id)->first();
        $this->pushNotif('Transaksi Dibatalkan', "Transasi produk ".$transaksi->details[0]->produk->name." berhsil dibatalkan", $transaksi->user->fcm);
        $transaksi->update([
            'status' => "DIKIRIM"
        ]);
        return redirect()->back()->with(['status' => ' DIKIRIM']);
        //return redirect('transaksis.index');
    }

    public function selesai($id){
        $transaksi = Transaksi::with(['details.produk', 'user'])->where('id', $id)->first();

        $this->pushNotif('Transaksi Selesai', "Transasi produk ".$transaksi->details[0]->produk->name." Sudah selesai", $transaksi->user->fcm);
        $transaksi->update([
            'status' => "SELESAI"
        ]);
        return redirect()->back()->with(['status' => ' SELESAI']);
        //return redirect('transaksis.index');
    }

    public function pushNotif($title, $message, $mFcm) {

        $mData = [
            'title' => $title,
            'body' => $message
        ];

        $fcm[] = $mFcm;

        $payload = [
            'registration_ids' => $fcm,
            'notification' => $mData
        ];

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://fcm.googleapis.com/fcm/send",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTPHEADER => array(
                "Content-type: application/json",
                "Authorization: key=AAAAsOPlWnI:APA91bHMBWzjknhBl3Z9_vuwb2MNbYv8EG3-wmiGP1zRd5pgg7H-QhuM5WCyGmT8D6EZQQq_M3PJM25IIaN1S_S9WkM6b98x2JvrL5JNdGr7gWSofN5todtoKHlo94qkjIfxEnD_pVTe"
            ),
        ));
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($payload));

        $response = curl_exec($curl);
        curl_close($curl);

        $data = [
            'success' => 1,
            'message' => "Push notif success",
            'data' => $mData,
            'firebase_response' => json_decode($response)
        ];
        return $data;
    }

}
