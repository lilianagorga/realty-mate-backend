<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Log;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

/**
 * @method static whereEmail(mixed $email)
 * @method static create(string[] $array)
 */

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, HasRoles;

    /**
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'email_verified_at',
    ];

    /**
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function properties(): HasMany
    {
        return $this->hasMany(Property::class);
    }

    protected function getDefaultGuardName(): string {
        return 'web';
    }

    public function isAdmin(): bool
    {
        return $this->hasRole('admin', 'web');
    }

    public function isTeam(): bool
    {
        return $this->hasRole('team', 'web' );
    }

    public function canAccessDashboard(): bool
    {
        return $this->isAdmin() || $this->hasPermissionTo('dashboard', 'web');
    }

    public function canManageProperties(): bool
    {
        return $this->isAdmin() || $this->isTeam() || $this->hasPermissionTo('manageProperties', 'web');
    }

    public function canManageTeam(): bool
    {
        return $this->isAdmin() || $this->hasPermissionTo('teamManagement', 'web');
    }
}
