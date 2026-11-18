<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandingService extends Model
{
    use HasFactory;

    protected $table = 'landing_services';

    protected $fillable = [
        'judul',
        'deskripsi',
        'icon',
        'link_text',
        'link_url',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
