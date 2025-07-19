<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Stephenjude\FilamentTwoFactorAuthentication\TwoFactorAuthenticatable;
use Spatie\LaravelPasskeys\Models\Concerns\HasPasskeys;

class User extends Authenticatable implements FilamentUser, HasPasskeys
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, TwoFactorAuthenticatable;

    /**
     * Determine if the user can access the Filament admin panel.
     *
     * @param  \Filament\Panel  $panel
     * @return bool
     */
    public function canAccessPanel(\Filament\Panel $panel): bool
    {
        // Allow all users to access the panel; adjust logic as needed.
        return true;
    }

    /** 
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
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

        public function staff()
    {
        return $this->hasOne(Staff::class);
    }

    public function lecturer()
    {
        return $this->hasOne(Lecturer::class);
    }
}
