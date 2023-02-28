<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|

Route::get('/', function () {
    return view('welcome');
});
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
*/

Route::get('/', function () {
    return redirect(route('login'));
});
Auth::routes();
Route::group(['middleware' => 'auth'], function () {


    Route::group(['middleware' => ['role:owner']], function () {

        Route::resource('/role', 'RoleController')->except([
            'create', 'show', 'edit', 'update'
        ]);
    
        Route::resource('/users', 'UserController')->except([
            'show'
        ]);
    
        Route::get('/users/status/{id}', 'UserController@status')->name('users.status');
        Route::put('/users/status/{id}', 'UserController@setStatus')->name('users.setStatus');
        Route::get('/users/roles/{id}', 'UserController@roles')->name('users.roles');
        Route::put('/users/roles/{id}', 'UserController@setRole')->name('users.set_role');
        Route::post('/users/permission', 'UserController@addPermission')->name('users.add_permission');
        Route::get('/users/role-permission', 'UserController@rolePermission')->name('users.roles_permission');
        Route::put('/users/permission/{role}', 'UserController@setRolePermission')->name('users.setRolePermission');
        
    });



    //route yang berada dalam group ini, hanya bisa diakses oleh user
    //yang memiliki permission yang telah disebutkan dibawah
    Route::group(['middleware' => ['permission:show products|create products|delete products']], function () {
        Route::resource('/kategori', 'CategoryController')->except([
            'create', 'show'
        ]);
       
    });

    Route::resource('/produk', 'ProductController');
    //route group untuk kasir
    Route::group(['middleware' => ['role:owner|kasir']], function () {
        //Route::get('/transaksis', 'TransaksiController@addTransaksi')->name('transaksi.transaksi');
        //Route::get('/checkout', 'TransaksiController@checkout')->name('transaksi.checkout');
        //Route::post('/checkout', 'TransaksiController@storeTransaksi')->name('transaksi.storeTransaksi');
        //Route::get('/checkout', 'TransaksiController@checkout')->name('transaksi.checkout');
    });

    Route::group(['middleware' => ['role:owner|admin|kasir']], function () {
        //Route::get('/transaksi', 'TransaksiController@index')->name('transaksi.index');
        //Route::get('/transaksi/pdf/{invoice}', 'TransaksiController@invoicePdf')->name('transaksi.pdf');
        //Route::get('/transaksi/excel/{invoice}', 'TransaksiController@invoiceExcel')->name('transaksi.excel');
    });

    //home kita taruh diluar group karena semua jenis user yg login bisa mengaksesnya
    Route::get('/home', 'HomeController@index')->name('home');
    //Route::post('/api/customer/search', 'CustomerController@search');
    //Route::post('/checkout', 'TransaksiController@storeTransaksi')->name('transaksi.storeTransaksi');
    //Route::get('/api/chart', 'HomeController@getChart');
    Route::resource('/transaksi', 'TransaksiController');
    Route::get('/transaksi/batal/{id}', 'TransaksiController@batal')->name('transaksiBatal');
    Route::get('/transaksi/confim/{id}', 'TransaksiController@confirm')->name('transaksiConfirm');
    Route::get('/transaksi/kirim/{id}', 'TransaksiController@kirim')->name('transaksiKirim');
    Route::get('/transaksi/selesai/{id}', 'TransaksiController@selesai')->name('transaksiSelesai');

});