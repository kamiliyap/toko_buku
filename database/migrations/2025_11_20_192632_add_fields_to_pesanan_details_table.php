<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pesanan_details', function (Blueprint $table) {
            // tambah kolom SETELAH id
            $table->unsignedBigInteger('pesanan_id')->after('id');
            $table->unsignedBigInteger('buku_id')->after('pesanan_id');
            $table->integer('qty')->after('buku_id');
            $table->integer('harga')->after('qty');
            $table->integer('subtotal')->after('harga');
        });
    }

    public function down(): void
    {
        Schema::table('pesanan_details', function (Blueprint $table) {
            $table->dropColumn(['pesanan_id', 'buku_id', 'qty', 'harga', 'subtotal']);
        });
    }
};
