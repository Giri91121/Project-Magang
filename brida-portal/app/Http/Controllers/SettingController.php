<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    /**
     * Tampilkan halaman pengaturan profil instansi & kontak portal
     */
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key');
        return view('dashboard.settings.index', compact('settings'));
    }

    /**
     * Simpan pembaruan pengaturan instansi
     */
    public function update(Request $request)
    {
        $data = $request->except(['_token', '_method']);

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        ActivityLog::log('update_settings', "Pengaturan profil & kontak instansi diperbarui oleh " . Auth::user()->name);

        return back()->with('success', 'Pengaturan profil instansi dan kontak berhasil disimpan.');
    }
}
