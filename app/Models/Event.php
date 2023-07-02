<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Event extends Model
{
    use HasFactory;
    protected $fillable = [
        "user_id",
        "nama",
        "url",
        "image",
        "type"
    ];


    public function image(): Attribute
    {
        return new Attribute(
            get: fn ($value) => url($value),
        );
    }

    public function scopeUserId(Builder $query, String $userId)
    {
        return $query->where('user_id', '=', $userId);
    }

    public function scopeType(Builder $query, String $type)
    {
        return $query->where('type', '=', $type);
    }

    /**
     * Get the user that owns the Event
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Get all of the visits for the Event
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function visits(): HasMany
    {
        return $this->hasMany(Visit::class, 'event_id', 'id');
    }
}
