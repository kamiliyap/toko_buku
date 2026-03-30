<?php

namespace App\Support;

use Illuminate\Support\Facades\File;

class StoreSettings
{
    public static function defaults(): array
    {
        return [
            'store_name' => 'Toko Buku Pintar',
            'tagline' => 'Buku pendidikan dan literatur',
            'contact_email' => 'halo@tokobukupintar.id',
            'contact_phone' => '+62 812-3456-7890',
            'address' => 'Jl. Pintar No. 1, Jakarta Selatan',
            'running_banner' => 'Selamat datang di Toko Buku Pintar! Temukan bacaan terbaik setiap hari, cek promo terbaru, dan nikmati koleksi buku pendidikan serta literatur pilihan.',
        ];
    }

    public static function all(): array
    {
        $path = self::path();

        if (! File::exists($path)) {
            return self::defaults();
        }

        $decoded = json_decode(File::get($path), true);

        if (! is_array($decoded)) {
            return self::defaults();
        }

        return array_merge(self::defaults(), $decoded);
    }

    public static function put(array $settings): array
    {
        $payload = array_merge(self::all(), self::normalize($settings));

        File::ensureDirectoryExists(dirname(self::path()));
        File::put(
            self::path(),
            json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
        );

        return $payload;
    }

    private static function normalize(array $settings): array
    {
        $normalized = [];

        foreach (self::defaults() as $key => $defaultValue) {
            $value = $settings[$key] ?? $defaultValue;
            $normalized[$key] = is_string($value) ? trim($value) : $value;
        }

        return $normalized;
    }

    private static function path(): string
    {
        return storage_path('app/settings/store.json');
    }
}
