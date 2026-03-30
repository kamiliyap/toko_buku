<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('penerbit') && ! Schema::hasColumn('penerbit', 'logo')) {
            Schema::table('penerbit', function (Blueprint $table) {
                $table->string('logo')->nullable()->after('kontak');
            });
        }

        if (! Schema::hasTable('penerbit')) {
            return;
        }

        $logoMap = [
            'CV Arya Duta' => 'arya.jpg',
            'Arya Duta' => 'arya.jpg',
            'SIBI' => 'logoSIBI.png',
            'Yudistira' => 'yudistira.jpg',
        ];

        foreach ($logoMap as $nama => $logo) {
            DB::table('penerbit')->where('nama', $nama)->update([
                'logo' => $logo,
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('penerbit') && Schema::hasColumn('penerbit', 'logo')) {
            Schema::table('penerbit', function (Blueprint $table) {
                $table->dropColumn('logo');
            });
        }
    }
};
