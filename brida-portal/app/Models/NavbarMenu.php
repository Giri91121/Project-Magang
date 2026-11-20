<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NavbarMenu extends Model
{
    use HasFactory;

    protected $table = 'navbar_menus';

    protected $fillable = [
        'parent_id',
        'label',
        'url',
        'icon',
        'target_blank',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'target_blank' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function parent()
    {
        return $this->belongsTo(NavbarMenu::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(NavbarMenu::class, 'parent_id')->orderBy('sort_order');
    }
}
