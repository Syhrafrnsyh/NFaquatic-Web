<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Customer;

class CustomerController extends Controller
{
    //
    public function login(Request $request){
        // request
        // dd($requset->all());die();
        $customer = Customer::where('email', $request->email)->first();

        if($customer){

            $customer->update([
                'fcm' => $request->fcm
            ]);

            if(password_verify($request->password, $customer->password)){
                return response()->json([
                    'success' => 1,
                    'message' => 'Selamat datang '.$customer->name,
                    'customer' => $customer
                ]);
            }
            return $this->error('Password Salah');
        }
        return $this->error('Email tidak terdaftar');
    }

    public function register(Request $request){
        //nama, email, password
        $validasi = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:customers',
            'phone' => 'required|unique:customers',
            'password' => 'required|min:6'
        ]);

        if($validasi->fails()){
            $val = $validasi->errors()->all();
            return $this->error($val[0]);
        }

        $customer = Customer::create(array_merge($request->all(), [
            'password' => bcrypt($request->password)
        ]));

        if($customer){
            return response()->json([
                'success' => 1,
                'message' => 'Selamat datang Register Berhasil',
                'customer' => $customer
            ]);
        }

        return $this->error('Registrasi gagal');

    }

    public function error($pesan){
        return response()->json([
            'success' => 0,
            'message' => $pesan
        ]);
    }
    
}
