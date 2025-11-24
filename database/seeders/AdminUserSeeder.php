<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        $adminEmail = 'admin@tokobuku.com';

        // cek apakah user dengan email itu sudah ada
        $user = User::where('email', $adminEmail)->first();

        if (! $user) {
            $user = User::create([
                'name' => 'Admin Toko Buku',
                'username' => 'admin',
                'email' => $adminEmail,
                'password' => Hash::make('admin123'),
                'is_admin' => true,
            ]);

            $this->command->info("Admin user created: {$adminEmail} / admin123");
        } else {
            // pastikan flag is_admin true
            if (isset($user->is_admin) && ! $user->is_admin) {
                $user->is_admin = true;
                $user->save();
                $this->command->info("Existing user {$adminEmail} updated to is_admin = true");
            } else {
                $this->command->info("Admin user already exists: {$adminEmail}");
            }
        }

        // Jika ada tabel admin terpisah, insert juga (jika diperlukan)
        try {
            if (\Schema::hasTable('admin')) {
                if (\Schema::hasColumn('admin', 'user_id')) {
                    if (! DB::table('admin')->where('user_id', $user->id)->exists()) {
                        DB::table('admin')->insert([
                            'user_id' => $user->id,
                            'email' => $adminEmail,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                } elseif (\Schema::hasColumn('admin', 'email')) {
                    if (! DB::table('admin')->where('email', $adminEmail)->exists()) {
                        DB::table('admin')->insert([
                            'email' => $adminEmail,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }
        } catch (\Exception $e) {
            $this->command->warn("Could not write to admin table: " . $e->getMessage());
        }
    }
}
