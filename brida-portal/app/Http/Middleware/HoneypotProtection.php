<?php

namespace App\Http\Middleware;

use App\Models\ActivityLog;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HoneypotProtection
{
    /**
     * Proteksi Form Honeypot Anti-Spam (Tanpa CAPTCHA):
     * 1. Cek apakah kolom jebakan tersembunyi ('website_hp_url') diisi oleh bot.
     * 2. Cek apakah form dikirim terlalu cepat (< 2 detik) oleh skrip otomatis.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->isMethod('post')) {
            // 1. Cek kolom jebakan tersembunyi
            if ($request->filled('website_hp_url')) {
                ActivityLog::log(
                    'honeypot_blocked',
                    "Bot Spam terdeteksi & diblokir (mengisi kolom jebakan Honeypot) pada URL: " . $request->path()
                );

                return back()->with('error', 'Permintaan ditolak oleh sistem keamanan anti-spam.');
            }

            // 2. Cek waktu pengisian form (jika ada token timestamp terenkripsi)
            if ($request->filled('hp_timestamp')) {
                try {
                    $renderedAt = (int) decrypt($request->input('hp_timestamp'));
                    $elapsedSeconds = now()->timestamp - $renderedAt;

                    if ($elapsedSeconds < 2) {
                        ActivityLog::log(
                            'honeypot_blocked',
                            "Aktivitas mencurigakan diblokir (pengiriman form terlalu cepat: {$elapsedSeconds} detik) pada URL: " . $request->path()
                        );

                        return back()->with('error', 'Pengiriman terlalu cepat. Mohon periksa kembali isian Anda.');
                    }
                } catch (\Throwable $e) {
                    // Jika token dimanipulasi oleh bot
                    ActivityLog::log(
                        'honeypot_blocked',
                        "Token keamanan Honeypot tidak valid / dimanipulasi pada URL: " . $request->path()
                    );

                    return back()->with('error', 'Sesi formulir tidak valid. Silakan muat ulang halaman.');
                }
            }
        }

        return $next($request);
    }
}
