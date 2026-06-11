<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Activity extends Model
{
    use HasUuids;

    protected $fillable = [
        'title',
        'description',
        'event_date',
        'lat',
        'long',
        'location',
        'max_participants',
        'required_age',
        'category_id',
        'creator_id',
    ];

    protected $casts = [
        'event_date' => 'date',
        'lat' => 'decimal:8',
        'long' => 'decimal:8',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function participations(): HasMany
    {
        return $this->hasMany(Participation::class);
    }

    public function participants(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'participations');
    }

    public function reports(): HasMany
    {
        return $this->hasMany(ActivityReport::class);
    }

    public function getAvailableSpotsAttribute(): int
    {
        return $this->max_participants - ($this->confirmed_count ?? 0);
    }
}
