<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
    Schema::create('pesanan', function (Blueprint $table) {
        $table->id();
        $table->string('kode_pesanan')->unique();
        $table->string('nama_pelanggan');
        $table->string('no_hp')->nullable();
        $table->text('alamat')->nullable();

        $table->decimal('subtotal', 15, 2);
        $table->decimal('ppn', 15, 2);
        $table->decimal('total', 15, 2);

        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanan');
    }
};
