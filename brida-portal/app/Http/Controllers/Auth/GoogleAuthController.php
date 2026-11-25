<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class GoogleAuthController extends Controller
{
    /**
     * Arahkan pengguna ke halaman OAuth 2.0 Google (atau Halaman Pilih Akun Google Simulasi Lokal jika GOOGLE_CLIENT_ID belum diisi)
     */
    public function redirectToGoogle()
    {
        $clientId = config('services.google.client_id');
        $redirectUri = config('services.google.redirect');

        // Jika GOOGLE_CLIENT_ID belum diisi di .env, tampilkan Halaman Pemilih Akun Google (Hanya Mode Lokal)
        if (empty($clientId)) {
            if (app()->environment('production')) {
                abort(500, 'Konfigurasi Google OAuth belum diatur di server produksi.');
            }
            $demoUsers = User::with('roles')->get();
            return view('auth.google-simulator', compact('demoUsers'));
        }

        $state = Str::random(40);
        session(['google_oauth_state' => $state]);

        $query = http_build_query([
            'client_id' => $clientId,
            'redirect_uri' => $redirectUri,
            'response_type' => 'code',
            'scope' => 'openid profile email',
            'access_type' => 'online',
            'state' => $state,
            'prompt' => 'select_account',
        ]);

        return redirect('https://accounts.google.com/o/oauth2/v2/auth?' . $query);
    }

    /**
     * Tangani Callback Resmi dari Google OAuth 2.0
     */
    public function handleGoogleCallback(Request $request)
    {
        if ($request->has('error')) {
            return redirect()->route('login')->with('error', 'Autentikasi Google dibatalkan.');
        }

        $clientId = config('services.google.client_id');
        $clientSecret = config('services.google.client_secret');
        $redirectUri = config('services.google.redirect');

        // Tukarkan Authorization Code dengan Access Token
        $tokenResponse = Http::asForm()->post('https://oauth2.googleapis.com/token', [
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'redirect_uri' => $redirectUri,
            'grant_type' => 'authorization_code',
            'code' => $request->code,
        ]);

        if (!$tokenResponse->successful()) {
            return redirect()->route('login')->with('error', 'Gagal memverifikasi token Google OAuth.');
        }

        $accessToken = $tokenResponse->json('access_token');

        // Ambil Profil Pengguna dari Google UserInfo API
        $userResponse = Http::withToken($accessToken)->get('https://www.googleapis.com/oauth2/v3/userinfo');

        if (!$userResponse->successful()) {
            return redirect()->route('login')->with('error', 'Gagal mengambil profil akun Google Anda.');
        }

        $googleUser = $userResponse->json();

        return $this->loginOrRegisterGoogleUser(
            $googleUser['sub'],
            $googleUser['name'] ?? explode('@', $googleUser['email'])[0],
            $googleUser['email'],
            $googleUser['picture'] ?? null
        );
    }

    /**
     * Tangani Login / Registrasi Akun Google dari Pemilih Akun (Mode Lokal / Tanpa Kredensial Cloud)
     */
    public function handleSimulatedGoogleLogin(Request $request)
    {
        if (app()->environment('production')) {
            abort(404);
        }

        $request->validate([
            'email' => 'required|email',
            'name' => 'nullable|string|max:255',
        ]);

        $email = strtolower(trim($request->email));
        $name = $request->filled('name') ? $request->name : ucwords(str_replace(['.', '_'], ' ', explode('@', $email)[0]));
        $fakeGoogleId = 'google_' . md5($email);

        return $this->loginOrRegisterGoogleUser($fakeGoogleId, $name, $email, null);
    }

    /**
     * Logika Inti: Buat Akun Baru (Register) jika belum ada, atau Login jika sudah ada
     */
    protected function loginOrRegisterGoogleUser($googleId, $name, $email, $avatar = null)
    {
        $user = User::where('google_id', $googleId)
                    ->orWhere('email', $email)
                    ->first();

        $isNewUser = false;

        if (!$user) {
            $isNewUser = true;
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'google_id' => $googleId,
                'avatar' => $avatar,
                'password' => Hash::make(Str::random(32)),
                'email_verified_at' => now(),
            ]);

            // Pastikan Role default 'User' diberikan kepada pendaftar Google baru
            Role::firstOrCreate(['name' => 'User']);
            $user->assignRole('User');
        } else {
            $user->update([
                'google_id' => $googleId,
                'avatar' => $avatar ?? $user->avatar,
                'email_verified_at' => $user->email_verified_at ?? now(),
            ]);

            // Jika user belum memiliki role sama sekali, beri role User
            if ($user->roles()->count() === 0) {
                Role::firstOrCreate(['name' => 'User']);
                $user->assignRole('User');
            }
        }

        Auth::login($user, true);

        $actionMsg = $isNewUser
            ? "Registrasi & Login akun Google baru berhasil! Selamat datang di Portal BRIDA Makassar, {$user->name}."
            : "Berhasil masuk dengan akun Google sebagai {$user->name}.";

        ActivityLog::log(
            $isNewUser ? 'register_google' : 'login_google',
            "{$user->name} ({$user->email}) masuk menggunakan autentikasi Google",
            $user
        );

        return redirect()->intended(route('dashboard'))
            ->with('success', $actionMsg);
    }
}
