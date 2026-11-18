<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    protected $table = 'activity_logs';

    protected $fillable = [
        'user_id',
        'action',
        'subject_type',
        'subject_id',
        'description',
        'ip_address',
        'user_agent',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Helper untuk log aktivitas sistem secara cepat
     */
    public static function log($action, $description, $subject = null)
    {
        return self::create([
            'user_id' => auth()->id(),
            'action' => $action,
            'subject_type' => $subject ? get_class($subject) : null,
            'subject_id' => $subject ? $subject->id : null,
            'description' => $description,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    /**
     * Helper icon & styling berdasarkan action
     */
    public function getActionBadgeAttribute()
    {
        return match($this->action) {
            'create_riset' => ['color' => 'bg-emerald-100 text-emerald-800 border-emerald-300', 'icon' => 'fa-file-circle-plus'],
            'update_status' => ['color' => 'bg-amber-100 text-amber-800 border-amber-300', 'icon' => 'fa-pen-to-square'],
            'create_inovasi' => ['color' => 'bg-indigo-100 text-indigo-800 border-indigo-300', 'icon' => 'fa-lightbulb'],
            'change_role' => ['color' => 'bg-rose-100 text-rose-800 border-rose-300', 'icon' => 'fa-shield-halved'],
            default => ['color' => 'bg-slate-100 text-slate-800 border-slate-300', 'icon' => 'fa-clock-rotate-left'],
        };
    }
}
