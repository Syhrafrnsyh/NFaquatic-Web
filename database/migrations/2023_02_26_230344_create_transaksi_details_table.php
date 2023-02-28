<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transaksi_id');
            $table->unsignedBigInteger('produk_id');
            $table->unsignedBigInteger('total_item');
            //$table->integer('qty');
            //$table->integer('price');
            $table->text('catatan')->nullable();
            $table->unsignedBigInteger('total_harga')->nullable();
            $table->timestamps();

            $table->foreign('transaksi_id')->references('id')->on('transaksis')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->foreign('produk_id')->references('id')->on('products')
            ->onUpdate('cascade')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksi_details');
    }
};
