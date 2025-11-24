<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('berita', function (Blueprint $table) {
            $table->id();

            $table->string('judul');            // Judul berita
            $table->string('slug')->unique();   // URL friendly title
            $table->string('gambar')->nullable(); // Thumbnail berita
            $table->text('isi');                // Isi berita lengkap
            $table->string('kategori')->nullable(); // kategori berita
            $table->string('penulis')->nullable();  // nama penulis

            $table->timestamps();               // created_at + updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('berita');
    }
};
