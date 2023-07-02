<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;

class Profile extends Model
{
    use HasFactory;
    protected $fillable = [
        "nama",
        "nim",
        "prodi_id",
        "ipk",
        "tahun_masuk",
        "tahun_lulus",
        "status_bekerja",
        "saran_prodi",
        "alamat_perusahaan",
        "jabatan",
        "lama_bekerja",
        "gaji",
        "deskripsi",
        "photo"
    ];

    public function photo(): Attribute
    {
        return new Attribute(
            get: fn ($value) => url($value),
        );
    }

    public function scopeStatusBekerja(Builder $query, String $statusBekerja): Builder
    {
        return $query->where('status_bekerja', '=', $statusBekerja);
    }

    /**
     * Get the prodi that owns the Profile
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function prodi(): BelongsTo
    {
        return $this->belongsTo(Prodi::class, 'prodi_id', 'id');
    }

    /**
     * Get all of the users for the Profile
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'profile_id', 'id');
    }
}
