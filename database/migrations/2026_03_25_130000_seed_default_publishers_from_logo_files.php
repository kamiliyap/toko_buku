<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('penerbit')) {
            return;
        }

        $now = now();

        $publishers = [
            [
                'nama' => 'Arya',
                'alamat' => null,
                'kontak' => null,
                'logo' => 'arya.jpg',
            ],
            [
                'nama' => 'Hera',
                'alamat' => null,
                'kontak' => null,
                'logo' => 'logoSIBI.png',
            ],
            [
                'nama' => 'Yudistira',
                'alamat' => null,
                'kontak' => null,
                'logo' => 'yudistira.jpg',
            ],
        ];

        foreach ($publishers as $publisher) {
            $exists = DB::table('penerbit')
                ->where('nama', $publisher['nama'])
                ->exists();

            if ($exists) {
                DB::table('penerbit')
                    ->where('nama', $publisher['nama'])
                    ->update([
                        'alamat' => $publisher['alamat'],
                        'kontak' => $publisher['kontak'],
                        'logo' => $publisher['logo'],
                        'updated_at' => $now,
                    ]);

                continue;
            }

            DB::table('penerbit')->insert([
                'nama' => $publisher['nama'],
                'alamat' => $publisher['alamat'],
                'kontak' => $publisher['kontak'],
                'logo' => $publisher['logo'],
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('penerbit')) {
            return;
        }

        DB::table('penerbit')
            ->whereIn('nama', ['Arya', 'Hera', 'Yudistira'])
            ->delete();
    }
};
