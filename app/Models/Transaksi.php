<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $fillable = ['user_id', 'kode_payment',
    'kode_trx', 'total_item', 'total_harga', 'kode_unik',
    'status', 'resi', 'kurir', 'name', 'phone', 'detail_lokasi', 'metode',
    'deskripsi', 'expired_at', 'jasa_pengiriaman', 'ongkir', 'total_transfer', 'bank'];

    //Model relationships ke  menggunakan hasMany
    public function transaksi_detail()
    {
        return $this->hasMany(TransaksiDetail::class);
    }

    protected $dates = ['created_at'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function details(){
        return $this->hasMany(TransaksiDetail::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
