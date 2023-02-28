<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    //
    public function login(Request $request){
        // request
        // dd($requset->all());die();
        $user = User::where('email', $request->email)->first();
    

        if($user){

            $user->update([
                'fcm' => $request->fcm
            ]);
            
            if(password_verify($request->password, $user->password)){
                return response()->json([
                    'success' => 1,
                    'message' => 'Selamat datang '.$user->name,
                    'user' => $user
                ]);
            }
            return $this->error('Password Salah');
           
        }
        return $this->error('Email tidak terdaftar');
    }

    public function register(Request $request){
        //nama, email, password
        $validasi = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users',
            'phone' => 'required|unique:users',
            'password' => 'required|min:6'
        ]);

        if($validasi->fails()){
            $val = $validasi->errors()->all();
            return $this->error($val[0]);
        }
        
        $user = User::create(array_merge($request->all(), [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
            'role' => $request->role,
            'status' => true,
            'role' => 7
        ]));

        $user->assignRole('client');

        if($user){
            return response()->json([
                'success' => 1,
                'message' => 'Selamat datang Register Berhasil',
                'user' => $user,
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
