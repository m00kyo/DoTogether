<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasUuids, Notifiable;

    const UPDATED_AT = null;

    protected $fillable = [
        'email',
        'password_hash',
        'nickname',
        'date_of_birth',
        'bio',
        'role',
    ];

    protected $hidden = [
        'password_hash',
    ];

    public function getAuthPasswordName(): string
    {
        return 'password_hash';
    }

    public function participations(): HasMany
    {
        return $this->hasMany(Participation::class);
    }

    public function joined_activities(): BelongsToMany
    {
        return $this->belongsToMany(Activity::class, 'participations');
    }

    public function created_activities(): HasMany
    {
        return $this->hasMany(Activity::class, 'creator_id');
    }

    public function sent_reports(): HasMany
    {
        return $this->hasMany(UserReport::class, 'reporter_id');
    }

    public function received_reports(): HasMany
    {
        return $this->hasMany(UserReport::class, 'reported_id');
    }
}
