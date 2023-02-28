<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Modes\Product;
use App\Models\Category;

class ProdukController extends Controller
{
    //
    public function index(){
        // dd($requset->all());die();
        //$type = LaundryType::orderBy('name', 'ASC')->get();
        //$produk = Product::all();
        /**
         
        return response()->json([
            'success' => 1,
            'message' => 'Get Produk Berhasil',
            'produks' => $produk
        ]);
         
         */

        $produk = Product::with('category')->orderBy('name', 'ASC')->get();
        return response()->json([
            'success' => 1,
            'message' => 'Get Produk Berhasil',
            'produks' => $produk
        ]);


    }
    
}
