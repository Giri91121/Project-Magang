<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

class StrukturOrganisasi extends Model
{
    protected $fillable = [
        'parent_id',
        'jabatan',
        'nama_pejabat',
        'nip',
        'foto',
        'tipe_garis',
        'warna_badge',
        'deskripsi',
        'sort_order',
        'is_active',
        'is_parent',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_parent' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')
            ->orderBy('sort_order')
            ->orderBy('id');
    }

    /**
     * Bangun struktur pohon (nested tree) dalam 1 query tanpa N+1.
     */
    public static function getTree(bool $onlyActive = false): Collection
    {
        $query = self::query()->orderBy('sort_order')->orderBy('id');
        if ($onlyActive) {
            $query->where('is_active', true);
        }

        $nodes = $query->get();
        $byId = $nodes->keyBy('id');

        foreach ($nodes as $node) {
            $node->setRelation('childrenRecursive', collect());
        }

        $roots = collect();
        foreach ($nodes as $node) {
            if ($node->parent_id !== null && $byId->has($node->parent_id)) {
                $byId->get($node->parent_id)->childrenRecursive->push($node);
            } else {
                $roots->push($node);
            }
        }

        return $roots;
    }
}
