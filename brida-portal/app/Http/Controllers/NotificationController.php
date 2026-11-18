<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Tampilkan seluruh notifikasi pengguna & riwayat log aktivitas
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Notifikasi database milik user yang sedang login
        $notifications = $user->notifications()->paginate(15);

        // Jika user adalah Admin/Staf, sertakan juga ActivityLog sistem
        $activityLogs = collect();
        if ($user->hasRole(['Admin', 'Peneliti', 'Fasilitator Inovasi'])) {
            $activityLogs = ActivityLog::with('user')->latest()->take(20)->get();
        }

        return view('dashboard.notifications.index', compact('notifications', 'activityLogs'));
    }

    /**
     * Tandai sebuah notifikasi telah dibaca
     */
    public function markAsRead($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        $redirectUrl = $notification->data['url'] ?? route('dashboard.notifications.index');
        return redirect($redirectUrl);
    }

    /**
     * Tandai semua notifikasi telah dibaca
     */
    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return back()->with('success', 'Semua notifikasi telah ditandai sebagai dibaca.');
    }
}
