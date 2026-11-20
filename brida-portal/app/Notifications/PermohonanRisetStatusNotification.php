<?php

namespace App\Notifications;

use App\Models\PermohonanRiset;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PermohonanRisetStatusNotification extends Notification
{
    use Queueable;

    public $permohonan;
    public $keterangan;

    /**
     * Create a new notification instance.
     */
    public function __construct(PermohonanRiset $permohonan, string $keterangan = '')
    {
        $this->permohonan = $permohonan;
        $this->keterangan = $keterangan;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'permohonan_id' => $this->permohonan->id,
            'nomor_registrasi' => $this->permohonan->nomor_registrasi,
            'judul_penelitian' => $this->permohonan->judul_penelitian,
            'status' => $this->permohonan->status,
            'keterangan' => $this->keterangan ?: "Status permohonan {$this->permohonan->nomor_registrasi} telah diubah menjadi {$this->permohonan->status}.",
            'url' => route('dashboard.riset.show', $this->permohonan->id),
            'icon' => match($this->permohonan->status) {
                'Disetujui' => 'fa-circle-check text-emerald-500',
                'Sedang Ditelaah' => 'fa-hourglass-half text-blue-500',
                'Ditolak' => 'fa-circle-xmark text-rose-500',
                default => 'fa-bell text-amber-500',
            },
        ];
    }
}
