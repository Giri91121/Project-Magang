<?php

namespace App\Services;

use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class InstagramFeedService
{
    /**
     * Ambil 3 postingan terbaru dari Instagram @bridakotamakassar secara otomatis
     * Mendukung 2 jalur resmi:
     * 1. Instagram Graph API Access Token (resmi Meta)
     * 2. Behold.so JSON Feed URL (paling praktis & otomatis)
     * Serta Fallback aman jika keduanya belum dikonfigurasi.
     */
    public function getLatestPosts(int $limit = 3): array
    {
        return Cache::remember('brida_instagram_latest_posts', 3600, function () use ($limit) {
            $accessToken = Setting::get('ig_access_token') ?: env('INSTAGRAM_ACCESS_TOKEN');
            $beholdUrl = Setting::get('ig_behold_url') ?: env('INSTAGRAM_BEHOLD_URL');

            // Jalur 1: Instagram Graph API Resmi (Meta)
            if (!empty($accessToken)) {
                $posts = $this->fetchFromGraphApi($accessToken, $limit);
                if (!empty($posts)) {
                    return $posts;
                }
            }

            // Jalur 2: Behold.so JSON Feed URL Otomatis
            if (!empty($beholdUrl)) {
                $posts = $this->fetchFromBeholdJson($beholdUrl, $limit);
                if (!empty($posts)) {
                    return $posts;
                }
            }

            // Fallback Aman jika token/feed belum dikonfigurasi
            return $this->getFallbackPosts();
        });
    }

    /**
     * Hapus cache agar feed langsung sinkronisasi ulang dari Instagram
     */
    public function clearCache(): void
    {
        Cache::forget('brida_instagram_latest_posts');
    }

    /**
     * Ambil dari Instagram Graph API (graph.instagram.com)
     */
    protected function fetchFromGraphApi(string $token, int $limit): array
    {
        try {
            $response = Http::timeout(8)->get('https://graph.instagram.com/me/media', [
                'fields' => 'id,caption,media_type,media_url,thumbnail_url,permalink,timestamp',
                'access_token' => $token,
                'limit' => $limit,
            ]);

            if (!$response->successful()) {
                return [];
            }

            $items = $response->json('data', []);
            $results = [];

            foreach (array_slice($items, 0, $limit) as $item) {
                $imageUrl = ($item['media_type'] ?? '') === 'VIDEO'
                    ? ($item['thumbnail_url'] ?? $item['media_url'] ?? '')
                    : ($item['media_url'] ?? '');

                $results[] = [
                    'image' => $imageUrl,
                    'caption' => $item['caption'] ?? 'Dokumentasi kegiatan resmi BRIDA Kota Makassar.',
                    'url' => $item['permalink'] ?? 'https://www.instagram.com/bridakotamakassar/',
                    'date' => isset($item['timestamp'])
                        ? Carbon::parse($item['timestamp'])->locale('id')->diffForHumans()
                        : 'Terbaru',
                    'media_type' => $item['media_type'] ?? 'IMAGE',
                    'is_live' => true,
                ];
            }

            return $results;
        } catch (\Throwable $e) {
            return [];
        }
    }

    /**
     * Ambil dari Behold.so JSON Feed URL (Gratis & Auto-Sync tanpa Meta Developer App)
     */
    protected function fetchFromBeholdJson(string $url, int $limit): array
    {
        try {
            $response = Http::timeout(8)->get($url);

            if (!$response->successful()) {
                return [];
            }

            $data = $response->json();
            $items = isset($data['posts']) && is_array($data['posts']) ? $data['posts'] : (is_array($data) ? $data : []);
            $results = [];

            foreach (array_slice($items, 0, $limit) as $item) {
                $imageUrl = $item['sizes']['medium']['mediaUrl']
                    ?? $item['thumbnailUrl']
                    ?? $item['mediaUrl']
                    ?? '';

                $results[] = [
                    'image' => $imageUrl,
                    'caption' => $item['caption'] ?? $item['prunedCaption'] ?? 'Dokumentasi kegiatan resmi BRIDA Kota Makassar.',
                    'url' => $item['permalink'] ?? 'https://www.instagram.com/bridakotamakassar/',
                    'date' => isset($item['timestamp'])
                        ? Carbon::parse($item['timestamp'])->locale('id')->diffForHumans()
                        : 'Terbaru',
                    'media_type' => $item['mediaType'] ?? 'IMAGE',
                    'is_live' => true,
                ];
            }

            return $results;
        } catch (\Throwable $e) {
            return [];
        }
    }

    /**
     * Data cadangan aman jika belum ada token/URL yang dihubungkan
     */
    protected function getFallbackPosts(): array
    {
        return [
            [
                'image' => 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?auto=format&fit=crop&w=600&q=80',
                'caption' => 'Rapat Koordinasi Penyusunan Peta Jalan Riset & Inovasi Daerah Kota Makassar bersama BRIN RI dan Perguruan Tinggi. #BRIDAKotaMakassar',
                'url' => 'https://www.instagram.com/bridakotamakassar/',
                'date' => 'Terbaru di Instagram',
                'media_type' => 'IMAGE',
                'is_live' => false,
            ],
            [
                'image' => 'https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&fit=crop&w=600&q=80',
                'caption' => 'Bimbingan Teknis Penginputan Indeks Inovasi Daerah (IID) bagi seluruh Operator SKPD lingkup Pemerintah Kota Makassar menuju IGA 2026.',
                'url' => 'https://www.instagram.com/bridakotamakassar/',
                'date' => 'Terbaru di Instagram',
                'media_type' => 'IMAGE',
                'is_live' => false,
            ],
            [
                'image' => 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&w=600&q=80',
                'caption' => 'Klinik Fasilitasi HKI & Paten Sederhana bagi Inovator Muda, UMKM, dan ASN Kota Makassar. Daftarkan karya inovasi Anda secara gratis!',
                'url' => 'https://www.instagram.com/bridakotamakassar/',
                'date' => 'Terbaru di Instagram',
                'media_type' => 'IMAGE',
                'is_live' => false,
            ],
        ];
    }
}
