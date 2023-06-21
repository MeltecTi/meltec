<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

// Spatie
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable implements AuditableContract
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, Auditable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'image',
        'api_token',
        'avatar',
        'external_id',
        'external_auth',
        'google_access_token',
        'google_refresh_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $guard_name = 'api';

    public function blogs(): HasMany
    {
        return $this->hasMany(Blog::class);
    }

    public function isAdmin(): bool
    {
        return $this->hasRole(['Administrador', 'SuperAdministrador']);
    }

    public function isGerente(): bool
    {
        return $this->hasRole(['Gerencial']);
    }

    public function kpiViewAuthorization(): bool
    {
        return $this->hasRole(['Administrador', 'SuperAdministrador', 'Gerencial']);
    }
}