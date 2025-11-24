<?php

namespace App\Http\Middleware;


use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsAdmin
{
    public function handle(Request $request, Closure $next)
    {   
        $user = $request->user();

        // jika belum login => redirect ke login
        if (! $user) {
            return redirect()->route('login');
        }

        // 1) Jika model users punya kolom is_admin => cek langsung
        if (isset($user->is_admin)) {
            if ($user->is_admin) {
                return $next($request);
            }
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        // 2) Jika tidak ada kolom is_admin, cek tabel `admin`
        // Mencoba cek berdasarkan user_id, jika tidak ada, cek berdasarkan email
        $isAdmin = false;

        // cek ada kolom user_id di table admin dan ada record
        try {
            if (DB::getSchemaBuilder()->hasTable('admin')) {
                // cek user_id
                if (DB::getSchemaBuilder()->hasColumn('admin', 'user_id')) {
                    $isAdmin = DB::table('admin')->where('user_id', $user->id)->exists();
                }

                // jika masih false, coba cek berdasarkan email
                if (! $isAdmin && DB::getSchemaBuilder()->hasColumn('admin', 'email')) {
                    $isAdmin = DB::table('admin')->where('email', $user->email)->exists();
                }
            }
        } catch (\Exception $e) {
            // jika terjadi error skema (mis. DB belum siap), tolak akses aman
            abort(403, 'Tidak dapat memverifikasi hak akses admin.');
        }

        if (! $isAdmin) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
